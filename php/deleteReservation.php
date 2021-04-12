<?php  
$path = "../views/reservationsList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
//Recuperamos los valores que nos llegan a través del GET
$idReservation = $_GET["Id"];

//Recuperamos los valores del filtro que nos llegan desde reservationList.php cuando damos a eliminar una reserva
$filterDateFrom             = $_SESSION['filterDateFromShow'];
$filterDateTo               = $_SESSION['filterDateToShow'];
$filterUserName             = $_SESSION['filterUserNameShow'];
$filterCardNumber           = $_SESSION['filterCardNumberShow'];
$filterStartHour            = $_SESSION['filterStartHourShow'];
$filterEndHour              = $_SESSION['filterEndHourShow'];
$filterZoneName             = $_SESSION['filterZoneNameShow'];
$filterAllStatusReservation = $_SESSION['filterAllStatusReservationShow'];


if (isset($_GET["delete"]) ){
    $delete = $_GET["delete"];
} else {
    $delete = "";
}


//*********************************************************************************************//
// Con este código eliminaremos las reservas. No haremos ninguna comprobación ya que sólo se   //
// habilita el botón de eliminar, en caso de que la reserva esté en estado inactivo.           //
//*********************************************************************************************//
if ($delete == "yes") {
    try {
        $sql   = "DELETE FROM reservations WHERE id_reservation = $idReservation";
        $count = $conn->exec($sql);
        if ($count == 0) {
            $_SESSION['successFlag'] = "N"; 
            $_SESSION['message']     = "Ha habido un problema y no se ha podido eliminar la reserva." ; 
        } else {
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message']     = "La reserva ha sido eliminada correctamente." ; 
        }
        
    } catch(PDOException $e) {
        $_SESSION['successFlag'] = "N";
        $queryError              = $e->getMessage();  
        $_SESSION['message']     = "Se ha detectado un problema a la hora de eliminar una reserva. </br> Descripción del error: " . $queryError ;           
        
    } finally { 
        //Limpiamos la memoria 
        $conn = null;   
           
    }
} else {
    $_SESSION['confirmation']  = "";
    $_SESSION["page"]          = "reservation";
    $_SESSION['idReservation'] = $idReservation;
    $_SESSION['message']       = "Estás a punto de eliminar una reserva. Esto hará que no esté nunca más disponible para ser consultada." ;
          
}

header("Location: ../views/reservationsList.php?dateFrom=$filterDateFrom&dateTo=$filterDateTo&userName=$filterUserName&cardNumber=$filterCardNumber&startHour=$filterStartHour&endHour=$filterEndHour&zoneName=$filterZoneName&allStatusReservation=$filterAllStatusReservation");

?>
