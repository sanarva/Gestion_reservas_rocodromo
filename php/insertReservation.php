<?php  
$path = "../views/myReservationsList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

$filterUserName        = $_GET["userName"];
$filterReservationDate = $_GET["reservationDate"];
$filterStartHour       = $_GET["startHour"];
$filterEndHour         = $_GET["endHour"];
$filterZoneName        = $_GET["zoneName"];
$idHour                = $_GET["idHour"];
$idZone                = $_GET["idZone"];

// Este código indica si se está accediendo desde la vista reservationsList.php o desde myReservationsList.php
if(isset( $_SESSION["reservationsList"])){
    $reservationsList =  $_SESSION["reservationsList"];
    unset ($_SESSION["reservationsList"]);
} else {
    $reservationsList = "";
}

//Buscamos si existe ya una reserva igual activa o pendiente (sólo para usuarios genéricos)
try {
    $sql = "SELECT COUNT(*) AS equalReservation 
              FROM reservations, users
             WHERE user_id            = id_user
               AND user_id            = :iduser
               AND reservation_Date   = :filterreservationdate
               AND hour_id            = :idhour
               AND user_type          = 'G'
               AND reservation_status IN ('A', 'P')";
    $query = $conn->prepare($sql); 
    $query->execute(array(":iduser"=>$_SESSION['sessionUserReservation'], ":filterreservationdate"=>$filterReservationDate, ":idhour"=>$idHour));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario y no creamos la reserva
    if (($result['equalReservation'] > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "Lo sentimos, no se puede crear la reserva porque ya tienes una reserva el mismo día a la misma hora." ; 

    //Si no existe, miraremos en qué zona se está intentando hacer la reserva
    } else {
        $checkZone = "";
    }
      
} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la creación de la reserva, al buscar posibles reservas duplicadas. </br> Descripción del error: " . $queryError ;  
} 

//Comprobamos si la reserva se está haciendo en la zona de vías
if (isset($checkZone)){
    include "routesControl.php";
}

if (isset($insertReserve)){
    try {
        $sql = "INSERT 
                INTO reservations (
                      reservation_date
                    , user_id
                    , hour_id
                    , zone_id
                    , reservation_status
                    , user_modification
                    )
                VALUES ( 
                  :filterreservationdate
                , :iduser
                , :idhour   
                , :idzone
                , :reservationstatus
                , :userModification
                )";
    
        $query = $conn->prepare($sql);
        $query->bindParam(":filterreservationdate", $filterReservationDate);
        $query->bindParam(":iduser", $_SESSION["sessionUserReservation"]);
        $query->bindParam(":idhour", $idHour);
        $query->bindParam(":idzone", $idZone);
        $query->bindParam(":reservationstatus", $reservationStatus);
        $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
        $query->execute();
        
        $_SESSION["sessionUserReservation"] = "";
    
        if ($query->rowCount() > 0 ){
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
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "Ha habido un problema y no se ha podido crear la reserva." ; 
        }
        
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema al crear la reserva. </br> Descripción del error: " . $queryError ; 
    } finally { 
        //Limpiamos la memoria 
        $conn = null; 
    }
}

header("Location: ../views/reservation.php?idReservation= &userName=$filterUserName&reservationDate=$filterReservationDate&startHour=$filterStartHour&endHour=$filterEndHour&zoneName=$filterZoneName");

?>
