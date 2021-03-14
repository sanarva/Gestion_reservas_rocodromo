<?php  
$path = "../views/zonesList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

//*********************************************************************************************//
// Esta parte se encarga de comprobar si existen reservas activas para la zona que se quiere   //
// eliminar. Si las hay, se enviará un mensaje al administrador para avisarle de ello y no     //
// se eliminará la zona hasta que no se hayan cancelado manualmente las reservas activas.      //
//*********************************************************************************************//
$idZone = $_GET["Id"];
$zoneName = $_GET["zoneName"];

try {
    $sql = "SELECT id_reservation  FROM reservations WHERE zone_id = :idzone AND reservation_status = 'A'";
    $query = $conn->prepare($sql); 
    $query->execute(array(":idzone"=>$idZone));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede eliminar la zona $zoneName ya que existen reservas activas asociadas a esta zona. Cancela antes las reservas activas y vuelve a intentarlo." ; 
    } else {
        
        try {
            $sql   = "DELETE FROM zones WHERE id_zone = $idZone" ;
            $count = $conn->exec($sql);  

            if ($count == 0) {
                $_SESSION['successFlag'] = "N"; 
                $_SESSION['message'] = "Ha habido un problema y no se ha podido eliminar la zona $zoneName." ; 
            } else {
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La zona $zoneName ha sido eliminada correctamente." ; 
            }
                
           

        } catch(PDOException $e) {
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de eliminar la zona $zoneName. </br> Descripción del error: " . $queryError ; 
        }
    } 

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar la zona a eliminar. </br> Descripción del error: " . $queryError ; 
   
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/zonesList.php");
    
}

 
?>
