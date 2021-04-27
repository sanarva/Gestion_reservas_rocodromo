<?php  
// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
$idReservation = $_GET["idReservation"];

// Este código indica si se está accediendo desde la vista reservationsList.php o desde myReservationsList.php
if($_SESSION["reservationsList"] == "Y"){
    $reservationsList =  $_SESSION["reservationsList"];
    $path = "../views/reservationsList.php";
} else {
    $reservationsList = "";
    $path = "../views/myReservationsList.php";
}

//Si el usuario está intentando cancelar una reserva...
if (isset($_GET["cancelReservation"])) {
    try {
        $sql = "UPDATE reservations 
                   SET reservation_status = 'I'
                     , user_modification = :userModification
                     , timestamp = current_timestamp
                 WHERE id_reservation = :idreservation";
        $query = $conn->prepare($sql);
        $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
        $query->bindParam(":idreservation",$idReservation);
        $query->execute();
        
        if ($query->rowCount() > 0 ){
            if (isset($_GET["userId"]) && $_GET["userId"] != "" && $_GET["userId"] != $_SESSION["sessionIdUser"]){//Si es el administrador quien está cancelando la reserva de un usuario
                //Enviamos un email al usuario para avisarle que se ha cancelado una de sus reservas
                include("../php/sendEmailCancelationReservation.php");
            } else {
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La reserva ha sido cancelada correctamente.";
                $_SESSION['button2'] = 'Aceptar';
                $_SESSION['formaction2']  = '#';
                $_SESSION['colorbutton2'] = 'btn-primary';
                $_SESSION["datadismiss"]  = "Yes";
            }
        } else {
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "Ha habido un problema y no se ha podido cancelar la reserva." ; 
        }
    
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "N";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema a la hora de cancelar la reserva. </br> Descripción del error: " . $queryError ; 
       
    } finally {
        //Limpiamos la memoria 
        $conn = null;
        if (isset($_GET["userId"])) {
            header("Location: ../views/reservationsList.php?dateFrom&dateTo&userName&cardNumber&startHour&endHour&zoneName&allStatusReservation");
        } else {
            header("Location: ../views/myReservationsList.php");
        }
    }

} else {//Si el usuario está intentando modificar una reserva...
    
    $filterUserName        = $_GET["userName"];
    $filterReservationDate = $_GET["reservationDate"];
    $filterStartHour       = $_GET["startHour"];
    $filterEndHour         = $_GET["endHour"];
    $filterZoneName        = $_GET["zoneName"];
    $idHour                = $_GET["idHour"];
    $idZone                = $_GET["idZone"];


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
        //Limpiamos la memoria 
        $conn = null;

        header("Location: ../views/reservation.php?idReservation=$idReservation&userName=$filterUserName&reservationDate=$filterReservationDate&startHour=$filterStartHour&endHour=$filterEndHour&zoneName=$filterZoneName");
    }
 
} 


?>
