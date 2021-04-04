<?php  
$path = "../views/zonesList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$idZone = $_GET["Id"];
$currentMaxUserNumber = $_GET["currentMaxUserNumber"];
$currentZoneStatus = $_GET["CurrentZoneStatus"];
$zoneName = $_POST["zoneName"];
$maxUserNumber = $_POST["maxUserNumber"];
$zoneStatus = $_POST["zoneStatus"];

try {
    //Buscamos reservas activas para la zona que se quiere modificar
    $sql = "SELECT id_reservation  FROM reservations WHERE zone_id = :idzone AND reservation_status = 'A'";
    $query = $conn->prepare($sql); 
    $query->execute(array(":idzone"=>$idZone));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existen reservas activas, comparamos el número máximo de usuarios actual y el estado de la zona actual para compararlos con 
    //los nuevos valores que se quieren modificar
    if (($query->rowCount() > 0 )) {
        // Si el administrador intenta reducir el número máximo de usuarios de una zona y/o intenta desactivar una zona habiendo reservas pendientes en
        // cualquiera de los dos casos, se mostrará un aviso y no se permitirá la modificación hasta que no haya cancelado las reservas pendientes
        if ($currentMaxUserNumber > $maxUserNumber) {
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "No se puede modificar la zona $zoneName para disminuir el número de usuarios máximos ya que existen reservas activas asociadas a esta zona. Cancela antes las reservas activas y vuelve a intentarlo." ; 
        } else if ($currentZoneStatus == "A" && $zoneStatus == "I" ) {
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "No se puede modificar la zona $zoneName para inactivarla ya que existen reservas activas asociadas a esta zona. Cancela antes las reservas activas y vuelve a intentarlo." ; 
        } else {
            try {
            $sql = "UPDATE zones 
                       SET zone_name         = :zonename
                         , max_users_zone    = :maxuserszone
                         , zone_status       = :zonestatus
                         , user_modification = :userModification
                         , timestamp = current_timestamp
                     WHERE id_zone = :idzone";
            $query = $conn->prepare($sql);
            $query->bindParam(":zonename",$zoneName);
            $query->bindParam(":maxuserszone", $maxUserNumber);
            $query->bindParam(":zonestatus", $zoneStatus);
            $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
            $query->bindParam(":idzone",$idZone);
            $query->execute();
            
        
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La zona $zoneName ha sido modificada correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la zona $zoneName." ; 
            }
        
            } catch(PDOException $e){
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar una zona. </br> Descripción del error: " . $queryError ; 
            
            }
        }
        
    //Si no existen reservas activas, modificamos la zona    
    } else {
        try {
            $sql = "UPDATE zones 
                       SET zone_name         = :zonename
                         , max_users_zone    = :maxuserszone
                         , zone_status       = :zonestatus
                         , user_modification = :userModification
                         , timestamp = current_timestamp
                     WHERE id_zone = :idzone";
            $query = $conn->prepare($sql);
            $query->bindParam(":zonename", $zoneName);
            $query->bindParam(":maxuserszone", $maxUserNumber);
            $query->bindParam(":zonestatus", $zoneStatus);
            $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
            $query->bindParam(":idzone", $idZone);
            $query->execute();
            
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La zona $zoneName ha sido modificada correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la zona $zoneName." ; 
            }
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar una zona. </br> Descripción del error: " . $queryError ; 
           
        }
    }


} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas en la zona a modificar. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/zonesList.php");
    
}

?>
