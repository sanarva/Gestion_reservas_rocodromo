<?php  
$path = "../views/hoursList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

//*********************************************************************************************//
// Esta parte se encarga de comprobar si existen reservas activas para la zona que se quiere   //
// eliminar. Si las hay, se enviará un mensaje al administrador para avisarle de ello y no     //
// se eliminará la zona hasta que no se hayan cancelado manualmente las reservas activas.      //
//*********************************************************************************************//
$idHour = $_GET["Id"];
$startHour = $_GET["startHour"];
$endHour = $_GET["endHour"];

if (isset($_GET["delete"]) ){
    $delete = $_GET["delete"];
} else {
    $delete = "";
}


try {
    $sql = "SELECT id_reservation  FROM reservations WHERE zone_id = :idhour AND reservation_status IN ('A', 'P', 'W')";
    $query = $conn->prepare($sql); 
    $query->execute(array(":idhour"=>$idHour));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede eliminar el horario de $startHour a $endHour ya que existen reservas activas asociadas a este horario. Cancela antes las reservas activas y vuelve a intentarlo." ; 
    } else {
        if ($delete == "yes") {
            try {
                $sql   = "DELETE FROM hours WHERE id_hour = $idHour" ;
                $count = $conn->exec($sql);  

                if ($count == 0) {
                    $_SESSION['successFlag'] = "N"; 
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido eliminar el horario de $startHour a $endHour." ; 
                } else {
                    $_SESSION['successFlag'] = "Y";
                    $_SESSION['message'] = "El horario de $startHour a $endHour ha sido eliminado correctamente." ; 
                }
            
            } catch(PDOException $e) {
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de eliminar el horario de $startHour a $endHour. </br> Descripción del error: " . $queryError ; 
            } finally {
                //Una vez que se haya intentado eliminar un horario, se inicializan las variables de sesión relativas al horario
                $_SESSION['idHour'] = "" ;
                $_SESSION['startHour'] = "" ;
                $_SESSION['endHour'] = "" ;
            }
            
        } else {
            $_SESSION['confirmation'] = "";
            $_SESSION["page"] = "hour";
            $_SESSION['idHour']   = $idHour;
            $_SESSION['startHour'] = $startHour;
            $_SESSION['endHour'] = $endHour;
            $_SESSION['message']  = "Estás a punto de eliminar el horario de $startHour a $endHour. Esto también eliminará las reservas pasadas asociadas a ese horario." ;
        }
    } 

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar el horario a eliminar. </br> Descripción del error: " . $queryError ; 
   
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/hoursList.php");
    
}

 
?>
