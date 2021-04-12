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
if(isset( $_SESSION["reservationList"])){
    $reservationList =  $_SESSION["reservationList"];
    unset ($_SESSION["reservationList"]);
} else {
    $reservationList = "";
}

//Buscamos si existe ya una reserva igual (sólo para usuarios genéricos)
try {
    $sql = "SELECT COUNT(*) AS equalReservation 
              FROM reservations, users
             WHERE user_id            = id_user
               AND user_id            = :iduser
               AND reservation_Date   = :filterreservationdate
               AND hour_id            = :idhour
               AND user_type          = 'G'
               AND reservation_status = 'A'";
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

    //Buscamos el nombre de la zona
    try {
        $sql = "SELECT zone_name 
                  FROM zones
                 WHERE id_zone  = :idzone";
        $query = $conn->prepare($sql); 
        $query->execute(array(":idzone"=>$idZone));  
        $resultzone = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($resultzone['zone_name'] == "Vía R1" || $resultzone['zone_name'] == "Vía R2" || $resultzone['zone_name'] == "Vía R3" || $resultzone['zone_name'] == "Vía R4" || $resultzone['zone_name'] == "Vía R5" ){
            try {
                $sql = "SELECT COUNT(*) AS reservationsNumberInRoutes 
                          FROM reservations, zones
                         WHERE zone_id           = id_zone
                           AND hour_id           = :idhour 
                           AND reservation_Date  = :filterreservationdate
                           AND zone_name         LIKE 'Vía R%'
                           AND reservation_status = 'A'";
                $query = $conn->prepare($sql); 
                $query->execute(array(":idhour"=>$idHour, ":filterreservationdate"=>$filterReservationDate));  
                $routes = $query->fetch(PDO::FETCH_ASSOC);
            } catch(PDOException $e){
                $_SESSION['successFlag'] = "C";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema al buscar el número total de reservas en la zona de vías. </br> Descripción del error: " . $queryError ; 
            } 
    
            try {
                $sql = "SELECT max_users_route
                          FROM reservationsconfig";
                $query = $conn->prepare($sql);
                $query->execute();
                $reservationsConfig = $query->fetch(PDO::FETCH_ASSOC);
                
                //Si no existe la configuración, damos un error
                if ($reservationsConfig == [] ){
                    $_SESSION['successFlag'] = "N";
                    $_SESSION['message'] = "No se ha encontrado la información de configuración de reservas al buscar el máximo de usuarios totales en la zona de vías.";
                }
            } catch(PDOException $e){
                $_SESSION['successFlag'] = "C";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de acceder a la configuración de las reservas. </br> Descripción del error: " . $queryError ; 
            } 
    
            if ($routes['reservationsNumberInRoutes'] == $reservationsConfig['max_users_route']){
                $maxNumUsersRoute = $reservationsConfig['max_users_route'];
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "No se puede hacer una reserva en la zona de vías porque se ha alcanzado el máximo número de usuarios totales de la zona, que es de $maxNumUsersRoute.";   
            } else {
                $insertReserve = ""; 
            }
        } else {
            $insertReserve = "";
        }

    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema en la creación de la reserva, al buscar posibles reservas duplicadas. </br> Descripción del error: " . $queryError ;  
    } 
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
                , 'A'
                , :userModification
                )";
    
        $query = $conn->prepare($sql);
        $query->bindParam(":filterreservationdate", $filterReservationDate);
        $query->bindParam(":iduser", $_SESSION["sessionUserReservation"]);
        $query->bindParam(":idhour", $idHour);
        $query->bindParam(":idzone", $idZone);
        $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
        $query->execute();
        
        $_SESSION["sessionUserReservation"] = "";
    
        if ($query->rowCount() > 0 ){
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message'] = "La reserva ha sido creada correctamente" ;
            if ($reservationList != "") {
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
