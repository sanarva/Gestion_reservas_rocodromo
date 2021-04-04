<?php  
$path = "../views/myReservationsList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
$idReservation = $_GET["idReservation"];

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
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message'] = "La reserva ha sido cancelada correctamente"  ;
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

        header("Location: ../views/myReservationsList.php");
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
        $_SESSION['button1'] = 'Volver a mis reservas';
        $_SESSION['formaction1']  = '../views/myReservationsList.php';
        $_SESSION['colorbutton1'] = 'btn-primary';
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
