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


//Recuperamos los filtros
$idRelatedReservation = $_GET["idRelatedReservation"];
$userNameFilter       = $_GET["userName"];
$dateFromFilter       = $_GET["dateFrom"];
$datetoFilter         = $_GET["dateto"];
$startDateFilter      = $_GET["startDate"];
$endDateFilter        = $_GET["endDate"];
$zoneFilter           = $_GET["zone"];

//Recuperamos el array de reservas seleccionadas
$reservationChoosenArray = $_POST["reservationChoosenArray"];

//iniciaremos la transacción
$conn->beginTransaction();

//En caso de que se esté accediendo desde la modificación, cancelamos la reserva a modificar para luego crear otra u otras
if ($idRelatedReservation > 0) {
    try {
        $sql = "UPDATE reservations
                   SET reservation_status = 'I'
                     , user_modification = :userModification
                     , timestamp = current_timestamp
                 WHERE id_related_reservation = :idrelatedreservation
                   AND reservation_status   <> 'I'";
        $queryCancel = $conn->prepare($sql);
        $queryCancel->bindParam(":userModification",$_SESSION["sessionIdUser"]);
        $queryCancel->bindParam(":idrelatedreservation",$idRelatedReservation);
        $queryCancel->execute();

        //Como es una reserva de la escuela, no se enviará ningún email para avisar de la cancelación
    
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "N";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema a la hora de cancelar la reserva masiva. </br> Descripción del error: " . $queryError ; 
        $conn->rollBack();
    }
}

//Recuperamos de la tabla de zonas, el id de la zona y el número máximo de usuarios por zona, para comprobar si existe ya alguna reserva de algún usuario, antes de hacer el insert de todas
try {
    $sql = "SELECT id_zone, max_users_zone
              FROM zones
             WHERE zone_status = 'A'";
    $query = $conn->prepare($sql);
    $query->execute();
    $allZones = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existen zonas, mostramos un aviso
    if ($allZones == [] ){
        $_SESSION['successFlag'] = "W";
        $_SESSION['message'] = "No existen zonas disponibles"; 
    //Si existen zonas, comprobamos el máximo número de usuarios por zona con el número de reservas disponibles por zona, para dar error si se hubiese cogido alguna zona ya ocupada.
    } else {
        $i = 0; 
        $j = 0;
        $stopMasiveReservation = "N";
        while($i < count($allZones) && $stopMasiveReservation == "N"){ 
            do { 
                $reservation = explode ( ', ', $reservationChoosenArray[$j] ); 
                //Relleno el array con todas las reservas escogidas sólo la primera vez y calculo el número de reservas totales 
                if($i == 0){
                    $totalReservations += $reservation[5];
                    //Rellenamos el array reservations con todas las reservas
                    $reservations[] = $reservation;
                }
                if ($reservation[1] == $allZones[$i]->id_zone && $reservation[5] != $allZones[$i]->max_users_zone ){
                    $stopMasiveReservation = "Y";
                } else {
                    $j++;
                }
            }
            while ($j < count($reservationChoosenArray) && $stopMasiveReservation == "N");
            if ($j == count($reservationChoosenArray)) {
                $j = 0;
                $i++;
            }
        }
        //Si hay alguna zona ocupada, daremos un error
        if ($stopMasiveReservation == "Y"){
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "No se puede hacer la reserva masiva porque alguna de las reservas que has escogido coincide con alguna reserva activa. Por favor, cancela antes las reservas activas y vuelve a intentarlo." ;
        } else {//Si no hay ninguna zona ocupada de las elegidas:
            //Desglosamos todas las reservas según el número de plazas de cada zona
            foreach($reservations as $reservation){
                for($w = 0; $w < $reservation[5]; $w++){
                    $reservationsItemize[] = $reservation; 
                }
            }
            $x = 0;
            //Guardamos el primer registro para relacionar reservas
            $previousReservation = $reservationsItemize[0];
            //Recuperamos el máximo número de id_related_reservation
            try {
                $sql = "SELECT MAX(id_related_reservation) as maxRelatedReservation FROM reservations";
                $query = $conn->prepare($sql); 
                $query->execute();  
                $resultMaxIdRelatedReservation = $query->fetch(PDO::FETCH_ASSOC);
            
                //Si todavía no hubiera ninguna reserva hecha, pondremos el contador a 1
                if ($resultMaxIdRelatedReservation['maxRelatedReservation'] == null ) {
                    $maxRelatedReservation = 1;
        
                //Si lo encuentra, se sumamos uno
                } else {
                    $maxRelatedReservation = $resultMaxIdRelatedReservation['maxRelatedReservation'] + 1;
                }
        
            } catch(PDOException $e){
                $_SESSION['successFlag'] = "C";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema al buscar la el id máximo de reservas relacionadas en reservas masivas. </br> Descripción del error: " . $queryError ;  
            } 
        }
    }
} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar las zonas para las reservas masivas. </br> Descripción del error: " . $queryError ; 
} 


//Insertamos todas las plazas de cada una de las reservas escogidas
while ($stopMasiveReservation == "N" && $x < $totalReservations) {

    foreach ($reservationsItemize as $reservation){
        if ($reservation != $previousReservation){
            $maxRelatedReservation++;
        }
        $reservationDate   = $reservation[6];
        $idHour            = $reservation[0];
        $idZone            = $reservation[1];
        $reservationStatus = "W";
    
        try {
            $sql = "INSERT 
                    INTO reservations (
                          id_related_reservation
                        , reservation_date
                        , user_id
                        , hour_id
                        , zone_id
                        , reservation_status
                        , user_modification
                        )
                    VALUES ( 
                      :idrelatedreservation
                    , :reservationdate
                    , :iduser
                    , :idhour   
                    , :idzone
                    , :reservationstatus
                    , :userModification
                    )";
            $query = $conn->prepare($sql);
            $query->bindParam(":idrelatedreservation", $maxRelatedReservation);
            $query->bindParam(":reservationdate", $reservationDate);
            $query->bindParam(":iduser", $_SESSION['sessionIdUserReservation']);
            $query->bindParam(":idhour", $idHour);
            $query->bindParam(":idzone", $idZone);
            $query->bindParam(":reservationstatus", $reservationStatus);
            $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
            $query->execute();
                    
            if ($query->rowCount() > 0 ){
                $x++;
                $previousReservation = $reservation;
                if ($x == $totalReservations) {
                    $conn->commit();
                    $_SESSION["sessionUserReservation"] = "";
                    $_SESSION['successFlag'] = "Y";
                    $_SESSION['message'] = "La reserva masiva ha sido creada correctamente" ;
                    if ($reservationsList != "") {
                        $_SESSION['button1'] = 'Volver a la lista';
                        $_SESSION['formaction1']  = '../views/reservationsList.php?&dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation'; 
                    } else {
                        $_SESSION['button1'] = 'Volver a mis reservas';
                        $_SESSION['formaction1']  = '../views/myReservationsList.php';
                    }  
                    $_SESSION['colorbutton1'] = 'btn-dark';
                    $_SESSION['button2'] = 'Crear otra reserva';
                    $_SESSION['formaction2']  = '#';
                    $_SESSION['colorbutton2'] = 'btn-primary';
                    $_SESSION["datadismiss"]  = "Yes";
                }
            } else {
                $stopMasiveReservation = "Y";
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido crear la reserva masiva para la escuela." ; 
                
            }
        } catch(PDOException $e){
            $stopMasiveReservation = "Y";
            $_SESSION['successFlag'] = "C";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al crear la reserva masiva para la escuela. </br> Descripción del error: " . $queryError ; 
            $conn->rollBack();
        }  
    }
}

//Limpiamos la memoria 
$conn = null;

//Inicializamos el id related reservation
$_SESSION['IdRelatedReservationMassive'] = 0;

//Volvemos a la página de origen
header("Location: ../views/reservation.php?idReservation&idRelatedReservation=$idRelatedReservation&userName=$userNameFilter&reservationDate=$dateFromFilter&reservationDateTo=$datetoFilter&startHour=$startDateFilter&endHour=$endDateFilter&zoneName=$zoneFilter");

?>