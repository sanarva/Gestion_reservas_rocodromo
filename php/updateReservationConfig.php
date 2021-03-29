<?php  
$path = "../views/reservationsList.php?dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$maxReservationsByUser = $_POST["maxReservationsByUser"];
$startFreeDate         = $_POST["startFreeDate"];
$endFreeDate           = $_POST["endFreeDate"];

try {
    //Buscamos si existe la configuración a modificar
    $sql = "SELECT id_config  FROM reservationsconfig where id_config=3";
    $query = $conn->prepare($sql); 
    $query->execute();  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe...       
    if (($query->rowCount() > 0 )) {
        //...la actualizamos...
        try {
        $sql = "UPDATE reservationsconfig 
                   SET max_reservation   = :maxreservation
                     , start_free_date   = :startfreedate
                     , end_free_date     = :endfreedate
                     , user_modification = :userModification
                 WHERE id_config = :idconfig";
        $query = $conn->prepare($sql);
        $query->bindParam(":maxreservation",$maxReservationsByUser);
        $query->bindParam(":startfreedate", $startFreeDate);
        $query->bindParam(":endfreedate", $endFreeDate);
        $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
        $query->bindParam(":idconfig",$result["id_config"]);
        $query->execute();
        
    
        if ($query->rowCount() > 0 ){
            $_SESSION['successFlag'] = "Y";
            $startFreeDate = New DateTime($startFreeDate);
            $startFreeDateFormat = $startFreeDate->format("d/m/Y");
            $endFreeDate = New DateTime($endFreeDate);
            $endFreeDateFormat = $endFreeDate->format("d/m/Y");
            $_SESSION['message'] = "La configuración ha sido modificada correctamente. A partir de este momento, el máximo de reservas por usuario será de $maxReservationsByUser y los usuarios sólo podrán hacer reservas desde el $startFreeDateFormat hasta el $endFreeDateFormat. Ten en cuenta que esto no afectará a las reservas pendientes realizadas antes de estos cambios.";
        } else {
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la configuración." ; 
        }
    
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la configuración de las reservas. </br> Descripción del error: " . $queryError ; 
        
        }
    
        
    //Si no existe, la creamos    
    } else {
        try {
            $sql = "INSERT 
                      INTO reservationsconfig ( 
                           max_reservation       
                         , start_free_date        
                         , end_free_date       
                         , user_modification
                        ) 
                    VALUES (
                           :maxreservation
                         , :startfreedate
                         , :endfreedate
                         , :userModification
                        )
                    ";
            $query = $conn->prepare($sql);
            $query->bindParam(":maxreservation", $maxReservationsByUser);
            $query->bindParam(":startfreedate", $startFreeDate);
            $query->bindParam(":endfreedate", $endFreeDate);
            $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
            $query->execute();
            
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $startFreeDate = New DateTime($startFreeDate);
                $startFreeDateFormat = $startFreeDate->format("d/m/Y");
                $endFreeDate = New DateTime($endFreeDate);
                $endFreeDateFormat = $endFreeDate->format("d/m/Y");
                $_SESSION['message'] = "La configuración ha sido añadida correctamente. A partir de este momento, el máximo de reservas por usuario será de $maxReservationsByUser y los usuarios sólo podrán hacer reservas desde el $startFreeDateFormat hasta el $endFreeDateFormat. Ten en cuenta que esto no afectará a las reservas pendientes realizadas antes de estos cambios.";
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido añadir la configuración." ; 
            }
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de añadir la configuración de las reservas. </br> Descripción del error: " . $queryError ; 
            
        }
        
    }


} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar la configuración de las reservas. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/reservationsList.php?dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation");
    
}

?>
