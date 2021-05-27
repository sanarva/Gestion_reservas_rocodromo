<?php  
// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
$idReservation = $_GET["idReservation"];

if (isset($_GET["idRelatedReservation"])){
    $idRelatedReservation = $_GET["idRelatedReservation"];
}

// Este código indica si se está accediendo desde la vista reservationsList.php o desde myReservationsList.php
if($_SESSION["reservationsList"] == "Y"){
    $reservationsList =  $_SESSION["reservationsList"];
    $path = "../views/reservationsList.php";
} else {
    $reservationsList = "";
    $path = "../views/myReservationsList.php";
}

//Comprobamos si se trata de una reserva doble
try{
    $sql = "SELECT id_related_reservation
              FROM reservations
             WHERE id_reservation  = $idReservation
               AND id_related_reservation > 0";
    $query = $conn->prepare($sql);
    $query->execute();
    $relatedReservationResult = $query->fetch(PDO::FETCH_ASSOC);
    if (($query->rowCount() > 0 )) {
        $idRelatedReservation = $relatedReservationResult["id_related_reservation"];
    } else {
        $idRelatedReservation = "nonexistent";
    }
    $relatedReservationControlOk = "Y";

} catch(PDOException $e){
    $relatedReservationControlOk = "N";
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar reservas dobles en la modificación/cancelación de reservas. </br> Descripción del error: " . $queryError ;   

} finally {
    if ($reservationsList != "") {
        header("Location: ../views/reservationsList.php?dateFrom&dateTo&userName&cardNumber&startHour&endHour&zoneName&allStatusReservation");
    } else {
        header("Location: ../views/myReservationsList.php");
    }
}


if (isset($_GET["cancel"]) ){
    $cancel = $_GET["cancel"];
} else {
    $cancel = "";
}


//Si el usuario está intentando cancelar una reserva...
if (isset($_GET["cancelReservation"]) && $relatedReservationControlOk == "Y" ) {
    if ($cancel == "yes"){
        try {
            $sql = "UPDATE reservations
                       SET reservation_status = 'I'
                         , user_modification = :userModification
                         , timestamp = current_timestamp
                     WHERE (id_reservation         = :idreservation
                        OR (id_related_reservation = :idrelatedreservation) AND (id_related_reservation <> 0))
                       AND  reservation_status   <> 'I'";
            $queryCancel = $conn->prepare($sql);
            $queryCancel->bindParam(":userModification",$_SESSION["sessionIdUser"]);
            $queryCancel->bindParam(":idreservation",$idReservation);
            $queryCancel->bindParam(":idrelatedreservation",$idRelatedReservation);
            $queryCancel->execute();

            if ($queryCancel->rowCount() > 0 ){
                //Enviamos un email al usuario para avisarle que se ha cancelado una de sus reservas
                include("../php/sendEmailCancelationReservation.php");
            
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido cancelar la reserva." ; 
            }
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de cancelar la reserva. </br> Descripción del error: " . $queryError ; 
        
        } finally {
            if ($reservationsList != "") {
                header("Location: ../views/reservationsList.php?dateFrom&dateTo&userName&cardNumber&startHour&endHour&zoneName&allStatusReservation");
            } else {
                header("Location: ../views/myReservationsList.php");
            }
        }
    } else {
        $_SESSION['confirmation'] = "";
        $_SESSION["page"]         = "cancelReservation";

        $_SESSION['cancelIdReservation']        = $idReservation;
        $_SESSION['cancelIdRelatedReservation'] = $idRelatedReservation;
        $_SESSION['cancelUserId']               = $_GET["userId"];
        $_SESSION['cancelUserName']             = $_GET["userName"];
        $_SESSION['cancelReservationDate']      = $_GET["reservationDate"];
        $_SESSION['cancelStartHour']            = $_GET["startHour"];
        $_SESSION['cancelEndHour']              = $_GET["endHour"];
        $_SESSION['cancelZoneName']             = $_GET["zoneName"];

        $_SESSION['message']  = "Estás a punto de cancelar la reserva. ¿Deseas continuar?" ;
    }
} else if (isset($_GET["confirmReservation"]) && $relatedReservationControlOk == "Y"){//Si el usuario está intentado confirmar una reserva
    try {
        $sql = "UPDATE reservations
                   SET reservation_status = 'A'
                     , user_modification = :userModification
                     , timestamp = current_timestamp
                 WHERE (id_reservation        = :idreservation
                    OR id_related_reservation = :idrelatedreservation)
                   AND  reservation_status    <> 'I'";
        $queryConfirm = $conn->prepare($sql);
        $queryConfirm->bindParam(":userModification",$_SESSION["sessionIdUser"]);
        $queryConfirm->bindParam(":idreservation",$idReservation);
        $queryConfirm->bindParam(":idrelatedreservation",$idRelatedReservation);
        $queryConfirm->execute();
        
        if ($queryConfirm->rowCount() > 0 ){
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message'] = "La reserva ha sido confirmada correctamente.";
            $_SESSION['button2'] = 'Aceptar';
            $_SESSION['formaction2']  = '#';
            $_SESSION['colorbutton2'] = 'btn-primary';
            $_SESSION["datadismiss"]  = "Yes";
        } else {
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "Ha habido un problema y no se ha podido confirmar la reserva." ; 
        }
    
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "N";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema a la hora de confirmar la reserva. </br> Descripción del error: " . $queryError ; 
       
    } finally {
        if ($reservationsList != "") {
            header("Location: ../views/reservationsList.php?dateFrom&dateTo&userName&cardNumber&startHour&endHour&zoneName&allStatusReservation");
        } else {
            header("Location: ../views/myReservationsList.php");
        }
    }


} else if ($relatedReservationControlOk == "Y"){//Si el usuario está intentando modificar una reserva...
    
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

    if (isset($_GET["reservationScreen"])){
        $reservationDate       = $_SESSION['reservationDateOriginal'];
        $startHour             = $_SESSION['startHourOriginal'];
        $endHour               = $_SESSION['endHourOriginal'];
        $zoneName              = $_SESSION['zoneNameOriginal'];
    }

    //Si se trata de la modificación de una reserva simple a otra reserva simple, modificamos la existente
    if ($idRelatedReservation == "nonexistent" && $cardNumberRopeTeam == "" && $reservationType != "autoInsurer"){
        //Antes de modificar la reserva, controlamos que no hay ninguna el mismo día a la misma hora o franja horaria sucesiva
        $checkSameReservation = "Y";
        include('reservationGeneralControls.php');
        $checkSameReservation = "";
        if (!isset($_SESSION['successFlag']) || (isset($_SESSION['successFlag']) &&  $_SESSION['successFlag'] != "C" && $_SESSION['successFlag'] != "N")){
            try {
                $sql = "UPDATE reservations
                           SET reservation_date = :filterreservationdate
                             , hour_id = :idhour
                             , zone_id = :idzone
                             , user_modification = :userModification
                             , timestamp = current_timestamp
                         WHERE id_reservation = :idreservation";
                $query = $conn->prepare($sql);
                $query->bindParam(":filterreservationdate",$filterReservationDate);
                $query->bindParam(":idhour",$idHour);
                $query->bindParam(":idzone",$idZone);
                $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
                $query->bindParam(":idreservation",$idReservation);
                $query->execute();


                if ($query->rowCount() > 0 ){
                    $_SESSION['successFlag'] = "Y";
                    $_SESSION['message'] = "La reserva ha sido modificada correctamente.";
                    if ($reservationsList != "") {
                        $_SESSION['button1'] = 'Volver a la lista';
                        $_SESSION['formaction1']  = '../views/ReservationsList.php?&dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation'; 
                    } else {
                        $_SESSION['button1'] = 'Volver a mis reservas';
                        $_SESSION['formaction1']  = '../views/myReservationsList.php';
                    }
                    $_SESSION['colorbutton1'] = 'btn-dark';
                    $_SESSION['button2'] = 'Modificar de nuevo';
                    $_SESSION['formaction2']  = '#';
                    $_SESSION['colorbutton2'] = 'btn-primary';
                    $_SESSION["datadismiss"]  = "Yes";
                } else {
                    $_SESSION['successFlag'] = "N";
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la reserva" ; 
                }

            } catch(PDOException $e){
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la reserva. </br> Descripción del error: " . $queryError ; 
            
            } finally {
                header("Location: ../views/reservation.php?idReservation=$idReservation&userName=$filterUserName&reservationDate=$filterReservationDate&startHour=$filterStartHour&endHour=$filterEndHour&zoneName=$filterZoneName");
            }
        } else {
            header("Location: ../views/reservation.php?idReservation=$idReservation&userName=$filterUserName&reservationDate=$filterReservationDate&startHour=$filterStartHour&endHour=$filterEndHour&zoneName=$filterZoneName");
        }
        
    } else {//Si se trata de una reserva simple a una doble o de una doble a otra doble, o de una doble a una simple, crearemos una reserva nueva (doble) y cancelaremos la/s que se han querido modificar
        //PASO1: Buscamos la información de las dos reservas
        try {
            if ($idRelatedReservation != "nonexistent") {
                $sql = "SELECT id_reservation, id_related_reservation, reservation_status
                          FROM reservations
                        WHERE id_related_reservation  = $idRelatedReservation";
            } else {
                $sql = "SELECT id_reservation, id_related_reservation, reservation_status
                          FROM reservations
                         WHERE id_reservation  = $idReservation";
            }
            $query = $conn->prepare($sql);
            $query->execute();
            $relatedReservationListResult = $query->fetchAll(PDO::FETCH_OBJ);

            if ($relatedReservationListResult == [] ){
                $modificationOk = "N";
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la reserva (P1)" ; 
            } else {
                $modificationOk = "Y";
            }
        } catch(PDOException $e){
            $modificationOk = "N";
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la reserva (P1). </br> Descripción del error: " . $queryError ; 
        }

        if ($modificationOk == "Y"){
            //PASO2: cambiamos el estado de las reservas que se quieren modificar para que no cuenten como pendientes 
            try {
                if ($idRelatedReservation != "nonexistent") {
                    $sql = "UPDATE reservations
                               SET reservation_status = 'I'
                                 , user_modification = :userModification
                                 , timestamp = current_timestamp
                             WHERE id_related_reservation = $idRelatedReservation";
                } else {
                    $sql = "UPDATE reservations
                               SET reservation_status = 'I'
                                 , user_modification = :userModification
                                 , timestamp = current_timestamp
                             WHERE id_reservation = $idReservation";
                }
                $query = $conn->prepare($sql);
                $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
                $query->execute();

                if ($query->rowCount() > 0 ){
                    $modificationOk = "Y";
                } else {
                    $modificationOk = "N";
                    $_SESSION['successFlag'] = "N";
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la reserva doble (P2)" ; 
                } 
                
            } catch(PDOException $e){
                $modificationOk = "N";
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la reserva doble (P2). </br> Descripción del error: " . $queryError ; 
            }
        }

        //PASO3: Insertamos la/s reserva/s nueva/s
        if ($modificationOk == "Y"){
            $modificationOk = "N";
            $backToUpdate = "";
            include('insertReservation.php');
        }
        
        //PASO4: Si ha habido algún error al crear la reserva, dejamos las reservas como estaban originalmente
        if ($modificationOk == "N" && $cardNumberRopeTeam != "") {
            foreach($relatedReservationListResult as $info) {    
                $idReservation = $info->id_reservation;

                $reservationStatus = $info->reservation_status;

                try {
                    $sql = "UPDATE reservations
                               SET reservation_status = :reservationstatus
                                 , user_modification = :userModification
                                 , timestamp = current_timestamp
                             WHERE id_reservation = :idreservation";
                    $query = $conn->prepare($sql);
                    $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
                    $query->bindParam(":reservationstatus",$reservationStatus);
                    $query->bindParam(":idreservation",$idReservation);
                    $query->execute();

                    if ($query->rowCount() > 0 ){

                    } else {
                        $_SESSION['successFlag'] = "N";
                        $_SESSION['message'] = "Ha habido un problema en la modificación de la reserva. Por favor, revisa tus reservas pendientes." ; 
                    }
                } catch(PDOException $e){
                    $_SESSION['successFlag'] = "N";
                    $queryError = $e->getMessage();  
                    $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la reserva. Por favor, revisa tus reservas pendientes.</br> Descripción del error: " . $queryError ; 
                }
            }
        }

        if (($modificationOk == "Y" || ($modificationOk == "N" && $cardNumberRopeTeam == "")) && $_SESSION['successFlag'] != "N"){
            //Enviamos un email al usuario para avisarle que se ha cancelado una de sus reservas
            $cancelationFromModification = "";
            include("../php/sendEmailCancelationReservation.php");
            
            //Independientemente de si al enviar el mail de cancelación, ha habido algún error, daremos el mensaje de que la reserva ha sido modificada
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message']     = "La reserva ha sido modificada correctamente.";

            if (isset($messageModification)){
                $_SESSION['successFlag'] = "W";
                $_SESSION['message']     = "La reserva ha sido modificada y ha quedado en estado pendiente. Se ha enviado un email a tu compañero/a de cordada para informarle que debe confirmarla antes de 24h para que se haga efectiva. De no ser así, la reserva será cancelada automáticamente."; 
            }
            if ($reservationsList != "") {
                $_SESSION['button1']     = 'Volver a la lista';
                $_SESSION['formaction1'] = '../views/ReservationsList.php?&dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation'; 
            } else {
                $_SESSION['button1']     = 'Volver a mis reservas';
                $_SESSION['formaction1'] = '../views/myReservationsList.php';
            }
            $_SESSION['colorbutton1'] = 'btn-dark';
            $_SESSION['button2']      = 'Modificar de nuevo';
            $_SESSION['formaction2']  = '#';
            $_SESSION['colorbutton2'] = 'btn-primary';
            $_SESSION["datadismiss"]  = "Yes";
        }
    }
    
} 

//Limpiamos la memoria 
$conn = null;

?>
