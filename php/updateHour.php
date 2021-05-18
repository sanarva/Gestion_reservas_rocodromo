<?php  
$path = "../views/hoursList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$idHour           = $_GET["Id"];
$currentStartHour = $_GET["startHour"];
$currentEndHour   = $_GET["endHour"];
$currentWeekDay   = $_GET["weekDay"];
$startHour        = $_POST["startHour"];
$endHour          = $_POST["endHour"];
$weekDay          = $_POST["weekDay"];



try {
    //Buscamos si ya existe alguna franja horaria que empiece a la misma hora 
    $sql = "SELECT start_hour, end_hour  FROM hours WHERE start_hour = :starthour AND id_hour <> $idHour" ;
    $query = $conn->prepare($sql);
    //Estamos usando un array asociativo para los parámetros
    $query->execute(array(":starthour"=>$startHour));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario de que no se va a modificar esa franja horaria porque ya existe una que empieza a la misma hora.
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede modificar la franja horaria de $currentStartHour-$currentEndHour h a $startHour-$endHour h, porque ya existe una franja horaria con la misma hora de inicio." ;
         
    } else {
         
        try {
            //Buscamos reservas activas para la franja horaria que se quiere modificar
            $sql = "SELECT id_reservation  FROM reservations WHERE hour_id = :idhour AND reservation_status IN ('A', 'P', 'C', 'W')";
            $query = $conn->prepare($sql); 
            $query->execute(array(":idhour"=>$idHour));  
            $result = $query->fetch(PDO::FETCH_ASSOC);
           
            //Si existen reservas activas, mostramos un error al administrador y no permitimos modificar la franja horaria hasta que no cancele las reservas activas
            if (($query->rowCount() > 0 )) {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "No se puede modificar la franja horaria de $currentStartHour a $currentEndHour h ya que existen reservas activas asociadas a ella. Cancela antes las reservas activas y vuelve a intentarlo." ; 
            //Si no existen reservas activas, modificamos la franja horaria    
            } else {
                try {
                    $sql = "UPDATE hours
                               SET start_hour        = :starthour
                                 , end_hour          = :endhour
                                 , week_day          = :weeksDay
                                 , user_modification = :userModification
                                 , timestamp = current_timestamp
                             WHERE id_hour = :idhour";
                    $query = $conn->prepare($sql);
                    $query->bindParam(":starthour", $startHour);
                    $query->bindParam(":endhour", $endHour);
                    $query->bindParam(":weeksDay", $weekDay);
                    $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
                    $query->bindParam(":idhour", $idHour);
                    $query->execute();
                    
                    if ($query->rowCount() > 0 ){
                        $_SESSION['successFlag'] = "Y";
                        $_SESSION['message'] = "La franja horaria de $currentStartHour-$currentEndHour h ha sido modificado correctamente a $startHour-$endHour h."  ;
                    } else {
                        $_SESSION['successFlag'] = "N";
                        $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la franja horaria de $currentStartHour a $currentEndHour h." ; 
                    }
                
                } catch(PDOException $e){
                    $_SESSION['successFlag'] = "N";
                    $queryError = $e->getMessage();  
                    $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar la franja horaria de $currentStartHour a $currentEndHour h. </br> Descripción del error: " . $queryError ; 
                   
                }
            }
        
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas para la franja horaria de $currentStartHour a $currentEndHour h. </br> Descripción del error: " . $queryError ;  
             
        } 
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la modificación de la franja horaria de $currentStartHour a $currentEndHour h, al buscar posibles duplicados. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    if ($_SESSION['successFlag'] == "Y") {
        header("Location: ../views/hour.php?Id=$idHour&startHour=$startHour&endHour=$endHour&weekDay=$weekDay");
    } else {
        header("Location: ../views/hour.php?Id=$idHour&startHour=$currentStartHour&endHour=$currentEndHour&weekDay=$currentWeekDay");
    }
    
}


?>
