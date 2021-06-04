<?php  
$path = "../views/zonesList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$idZone               = $_GET["Id"];
$currentZonaName      = $_GET["zoneName"];
$currentMaxUserNumber = $_GET["maxUserNumber"];
$currentZoneStatus    = $_GET["zoneStatus"];

$zoneName             = $_POST["zoneName"];
$maxUserNumber        = $_POST["maxUserNumber"];
$zoneStatus           = $_POST["zoneStatus"];

try {
    //Buscamos si existe alguna zona con el mismo nombre
    $sql = "SELECT zone_name FROM zones WHERE zone_name = :zonename AND id_zone <> $idZone";
    $query = $conn->prepare($sql); 
    $query->execute(array(":zonename"=>$zoneName));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario de que no se va a modificar esa zona porque ya existe una con el mismo nombre.
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede modificar el nombre de la zona $currentZonaName por $zoneName, porque ya existe una zona con ese nombre." ; 

    } else {   
        try {
            //Buscamos reservas activas para la zona que se quiere modificar
            $sql = "SELECT id_reservation  FROM reservations WHERE zone_id = :idzone AND reservation_status IN ('A', 'P', 'C')";
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
                    $_SESSION['message'] = "No se puede disminuir el número de usuarios máximos de esta zona ya que existen reservas activas asociadas a la misma. Cancela antes las reservas activas y vuelve a intentarlo." ; 
                } else if ($currentZoneStatus == "A" && $zoneStatus == "I" ) {
                    $_SESSION['successFlag'] = "N";
                    $_SESSION['message'] = "No se puede inactivar esta zona ya que existen reservas activas asociadas a la misma. Cancela antes las reservas activas y vuelve a intentarlo." ; 
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
                        $_SESSION['message'] = "La zona $currentZonaName ha sido modificada correctamente."  ;
                    } else {
                        $_SESSION['successFlag'] = "N";
                        $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la zona $currentZonaName." ; 
                    }
                
                    } catch(PDOException $e){
                        $_SESSION['successFlag'] = "N";
                        $queryError = $e->getMessage();  
                        $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la zona $currentZonaName. </br> Descripción del error: " . $queryError ; 
                    
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
                        $_SESSION['message'] = "La zona $currentZonaName ha sido modificada correctamente"  ;
                    } else {
                        $_SESSION['successFlag'] = "N";
                        $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la zona $currentZonaName." ; 
                    }
                
                } catch(PDOException $e){
                    $_SESSION['successFlag'] = "N";
                    $queryError = $e->getMessage();  
                    $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la zona $currentZonaName. </br> Descripción del error: " . $queryError ; 
                
                }
            }
        
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas en la zona $currentZonaName. </br> Descripción del error: " . $queryError ;  
        } 
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la modificación de la zona $currentZonaName, al buscar posibles zonas duplicadas. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    if ($_SESSION['successFlag'] == "Y") {
        header("Location: ../views/zone.php?Id=$idZone&zoneName=$zoneName&maxUserNumber=$maxUserNumber&zoneStatus=$zoneStatus");
    } else {
        header("Location: ../views/zone.php?Id=$idZone&zoneName=$currentZonaName&maxUserNumber=$currentMaxUserNumber&zoneStatus=$currentZoneStatus");
    }
    
}

?>
