<?php  

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

// Este código indica si se está accediendo desde la vista reservationsList.php o desde myReservationsList.php
if($_SESSION["reservationsList"] == "Y"){
    $reservationsList =  $_SESSION["reservationsList"];
    $path = "../views/reservationsList.php";
} else {
    $reservationsList = "";
    $path = "../views/myReservationsList.php";
}

$filterUserName        = $_GET["userName"];
$filterReservationDate = $_GET["reservationDate"];
$filterStartHour       = $_GET["startHour"];
$filterEndHour         = $_GET["endHour"];
$filterZoneName        = $_GET["zoneName"];
$idHour                = $_GET["idHour"];
$idZone                = $_GET["idZone"];
$cardNumberRopeTeam    = $_GET["cardNumberRopeTeam"];
$zoneNameChoosen       = $_GET["zoneNameChoosen"];
$reservationType       = $_GET["reservationType"];
$startHourChoosen      = $_GET["startHourChoosen"];
$endHourChoosen        = $_GET["endHourChoosen"];
$freeReservations      = $_GET["freeReservations"]; 

//Control de reservas duplicadas o en horas consecutivas para el usuario que hace la reserva (Se irá haciendo el resto de controles)
$checkSameReservation = "Y";
include("../php/reservationGeneralControls.php");


//En caso de cordada se hará el control del número de tarjeta del compañero de cordada y su total de reservas
// o en franjas horarias consecutivas. 
if (isset($checkTeamRope) && $cardNumberRopeTeam != ""){
    $checkReservationsNumberUser = "Y";
    $checkSameReservation = "N";
    $checkTimeZone = "N";
    $checkZone = "N"; 
    include("../php/reservationGeneralControls.php");
} 

//En caso de cordada y de que el control anterior haya pasado correctamente, se hará el control de si existe o no una reserva para el compañero de cordada 
//el mismo día a la misma hora o en franjas horarias consecutivas. Solo dará error para usuarios genéricos. (Se irá haciendo el resto de controles)
if (isset($checkTeamRope) && $cardNumberRopeTeam != "" && $checkReservationsNumberUser == "OK"){
    $_SESSION['sessionIdUserSameReservationControl'] = $_SESSION['sessionIdUserReservationRopeTeam'];
    $checkSameReservation = "Y";
    $checkZone = "N";
    include("../php/reservationGeneralControls.php");
}

//Si se trata de una reserva en cordada o con autoasegurador, buscaremos el máximo número de id_related_reservation y le sumaremos 1 para rellenar el campo de la reserva
if (isset($insertReservation) && $reservationType != "simple"){
    try {
        $sql = "SELECT MAX(id_related_reservation) as maxRelatedReservation FROM reservations";
        $query = $conn->prepare($sql); 
        $query->execute();  
        $resultMaxIdRelatedReservation = $query->fetch(PDO::FETCH_ASSOC);
    
        //Si todavía no hubiera ninguna reserva hecha, pondremos el contador a 1
        if ($resultMaxIdRelatedReservation['maxRelatedReservation'] == null ) {
            $maxRelatedReservation = 1;

        //Si no encuentra
        } else {
            $maxRelatedReservation = $resultMaxIdRelatedReservation['maxRelatedReservation'] + 1;
        }

    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema al buscar la el id máximo de reservas relacionadas. </br> Descripción del error: " . $queryError ;  
    } 
} else {
    $maxRelatedReservation = 0;
}


//Si se pasan todos los controles, se creará la reserva (o reservas, en caso de ser una reserva doble)
if (isset($insertReservation)){
    
    $j = 1;

    do {
        //Independientemente de la zona escogida, si se trata de una reserva doble con menor, se reservarán dos plazas aunque para el usuario sólo conste como una única reserva
        if (isset($doubleReservationWithMinor)){
            $userCounterRoutes = 1;
            $reservationStatus = "A";
            $reservationStatusRopeTeam = "W";
        }

        //Si estamos insertando la segunda reserva, cambiaremos los valores de status_reservation y el id del usuario en caso de que fuese una reserva en cordada
        if ($j == 2) {
            $reservationStatus = $reservationStatusRopeTeam;
            if ($reservationStatusRopeTeam == "C"){
                $iduserReservation = $_SESSION['sessionIdUserReservationRopeTeam'];
            }
        } else {
            $iduserReservation = $_SESSION['sessionIdUserReservation']; 
        }
        
        //Si se trata de una reserva en cordada de administradores, en lugar de poner los estado en P / C pondremos ambos como A ya que no necesitan confirmación
        if ($reservationType == "ropeTeam" && $_SESSION['userType'] == "A" && $_SESSION['userTypeRopeTeam'] == "A"){
            $reservationStatus = "A";
        }

        try {
            $sql = "INSERT 
                    INTO reservations (
                          reservation_date
                        , user_id
                        , id_related_reservation
                        , hour_id
                        , zone_id
                        , reservation_status
                        , user_modification
                        )
                    VALUES ( 
                      :filterreservationdate
                    , :iduser
                    , :idrelatedreservation
                    , :idhour   
                    , :idzone
                    , :reservationstatus
                    , :userModification
                    )";
            $query = $conn->prepare($sql);
            $query->bindParam(":filterreservationdate", $filterReservationDate);
            $query->bindParam(":iduser", $iduserReservation);
            $query->bindParam(":idrelatedreservation", $maxRelatedReservation);
            $query->bindParam(":idhour", $idHour);
            $query->bindParam(":idzone", $idZone);
            $query->bindParam(":reservationstatus", $reservationStatus);
            $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
            $query->execute();
                    
                    
            if ($query->rowCount() > 0 ){
                $j++;
                $_SESSION["sessionUserReservation"] = "";
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La reserva ha sido creada correctamente" ;
                if ($reservationsList != "") {
                    $_SESSION['button1'] = 'Volver a la lista';
                    $_SESSION['formaction1']  = '../views/ReservationsList.php?&dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation'; 
                } else {
                    $_SESSION['button1'] = 'Volver a mis reservas';
                    $_SESSION['formaction1']  = '../views/myReservationsList.php';
                }  
                $_SESSION['colorbutton1'] = 'btn-dark';
                $_SESSION['button2'] = 'Crear otra reserva';
                $_SESSION['formaction2']  = '#';
                $_SESSION['colorbutton2'] = 'btn-primary';
                $_SESSION["datadismiss"]  = "Yes";
            } else {
                $j = 3;
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido crear la reserva." ; 
            }
        } catch(PDOException $e){
            $j = 3;
            $_SESSION['successFlag'] = "C";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al crear la reserva. </br> Descripción del error: " . $queryError ; 
        }  

    } while ($j <= $numberOfInserts && $query->rowCount() > 0);


    //Si se trata de una reserva doble, comprobamos que se hayan insertado las dos reservas antes de dar el mensaje de ok
    if ($numberOfInserts == 2) {
        try {
            $sql = "SELECT COUNT(*) AS counterInsertedReservations
                    FROM reservations
                    WHERE id_related_reservation = $maxRelatedReservation";   
            $query = $conn->prepare($sql);              
            $query->execute();
            $results = $query->fetch(PDO::FETCH_ASSOC);
            //Si se han insertado y se trata de una reserva en cordada, enviaremos un email al usuario que debe confirmar y mostraremos un mensaje avisando 
            if ($results['counterInsertedReservations'] == 2) {
                //Si no ha habido ningún error al insertar las reservas de la modificación, ponemos el indicador a OK
                $modificationOk = "Y";
                //Recuperamos los datos anteriores por si fuera necesario para el mail de cancelación 
                $sql = "SELECT start_hour, end_hour, zone_name
                          FROM hours, zones 
                         WHERE id_hour = $idHour
                           AND id_zone =  $idZone";   
                $query = $conn->prepare($sql);              
                $query->execute();
                $originalResults = $query->fetch(PDO::FETCH_ASSOC);

                $_SESSION['reservationDateOriginal'] = $filterReservationDate;
                $_SESSION['startHourOriginal']       = $originalResults['start_hour'];
                $_SESSION['endHourOriginal']         = $originalResults['end_hour'];
                $_SESSION['zoneNameOriginal']        = $originalResults['zone_name'];

                if ($cardNumberRopeTeam != "") {
                    //Si se trata de una reserva en cordada de dos usuarios administradores, no se enviará mail porque las reservas no quedarán pendientes de confirmar (A/A)
                    //Si se trata de una reserva doble con menor, tampoco se enviará email porque las reservas no quedarán pendintes de confirmar (A/W)
                    if (($_SESSION['userType'] == "A" && $_SESSION['userTypeRopeTeam'] == "A") || isset($doubleReservationWithMinor)){ 
                        $_SESSION['successFlag'] = "Y";
                        $_SESSION['message'] = "La reserva ha sido creada correctamente";
                    } else {
                        include('sendEmailConfirmationReservationNeeded.php');
                        $messageModification = "Y";
                    }
                } else {
                    $_SESSION['successFlag'] = "Y";
                    $_SESSION['message'] = "La reserva ha sido creada correctamente"; 
                }

            //Si no se han insertado las dos, eliminaremos la que se haya insertado, en caso de que se haya insertado alguna
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido crear la reserva." ; 
                try {
                    $sql   = "DELETE FROM reservations WHERE id_related_reservation = $maxRelatedReservation";
                    $count = $conn->exec($sql);                
                } catch(PDOException $e) {
                    $_SESSION['successFlag'] = "N";
                    $queryError              = $e->getMessage();  
                    $_SESSION['message']     = "Se ha detectado un problema y no se ha podido crear la reserva. </br> Descripción del error: " . $queryError ;           
                }
            }
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "C";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al crear la reserva. Inténtalo más tarde y, si el problema persiste, contanta con la escuela. </br> Descripción del error: " . $queryError ; 

        } 
    }
}


//Si estamos entrando desde mi lista de reservas, guardaremos el nombre del usuario
if ($reservationsList == "") {
    header("Location: ../views/reservation.php?idReservation= &userName=$filterUserName&reservationDate=&startHour=&endHour=&zoneName=");
} else {
    header("Location: ../views/reservation.php?idReservation= &userName=&reservationDate=&startHour=&endHour=&zoneName=");   
}

//Si estamos entrando desde la modificación de reservas (updateReservation.php)
if(isset($backToUpdate)){
    header("Location: ../views/reservation.php?idReservation=$idReservation&userName=$filterUserName&reservationDate=$filterReservationDate&startHour=$filterStartHour&endHour=$filterEndHour&zoneName=$filterZoneName");
}
?>
