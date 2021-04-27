<?php  
$path = "../views/hoursList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$idHour = $_GET["Id"];
$currentStartHour = $_GET["startHour"];
$currentEndHour = $_GET["endHour"];
$startHour = $_POST["startHour"];
$endHour = $_POST["endHour"];
$weekDay = $_POST["weekDay"];

try {
    //Buscamos reservas activas para la franja horaria que se quiere modificar
    $sql = "SELECT id_reservation  FROM reservations WHERE hour_id = :idhour AND reservation_status IN ('A', 'P', 'C', 'W')";
    $query = $conn->prepare($sql); 
    $query->execute(array(":idhour"=>$idHour));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existen reservas activas, mostramos un error al administrador y no permitimos modificar la franja horaria hasta que no cancele las reservas activas
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede modificar la franja horaria de $currentStartHour a $currentEndHour ya que existen reservas activas asociadas a ella. Cancela antes las reservas activas y vuelve a intentarlo." ; 
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
                $_SESSION['message'] = "El horario de $currentStartHour a $currentEndHour ha sido modificado correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar la franja horaria de $currentStartHour a $currentEndHour." ; 
            }
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar un horario. </br> Descripción del error: " . $queryError ; 
           
        }
    }


} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas en la franja horaria a modificar. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/hoursList.php");
    
}

?>
