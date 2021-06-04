<?php  
$path = "../views/hoursList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

//*************************************************************************************************//
// Esta parte se encarga de comprobar si existen reservas activas para la franja horaria  que se   //
// quiere eliminar. Si las hay, se enviará un mensaje al administrador para avisarle de ello y no  //
// se eliminará la franja horaria hasta que no se hayan cancelado manualmente las reservas activas.//
//*************************************************************************************************//
$idHour    = $_GET["Id"];
$startHour = $_GET["startHour"];
$endHour   = $_GET["endHour"];

if (isset($_GET["delete"]) ){
    $delete = $_GET["delete"];
} else {
    $delete = "";
}


try {
    $sql = "SELECT id_reservation  
              FROM reservations 
             WHERE hour_id = :idhour
               AND reservation_status IN ('A', 'P', 'C', 'W')
            ";
    $query = $conn->prepare($sql); 
    $query->execute(array(":idhour"=>$idHour));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede eliminar la franja horaria de $startHour a $endHour h, ya que existen reservas activas asociadas a ella. Cancela antes las reservas activas y vuelve a intentarlo." ; 
    } else {
        if ($delete == "yes") {
            try {
                $sql   = "DELETE FROM hours WHERE id_hour = $idHour" ;
                $count = $conn->exec($sql);  

                if ($count == 0) {
                    $_SESSION['successFlag'] = "N"; 
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido eliminar la franja horaria de $startHour a $endHour h." ; 
                } else {
                    $_SESSION['successFlag'] = "Y";
                    $_SESSION['message'] = "La franja horaria de $startHour a $endHour h ha sido eliminada correctamente." ; 
                }
            
            } catch(PDOException $e) {
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de eliminar la franja horaria de $startHour a $endHour h. </br> Descripción del error: " . $queryError ; 

            } finally {
                //Una vez que se haya intentado eliminar una franja horaria, se inicializan las variables de sesión relativas a la misma
                $_SESSION['idHour']    = "" ;
                $_SESSION['startHour'] = "" ;
                $_SESSION['endHour']   = "" ;
            }
            
        } else {
            $_SESSION['confirmation'] = "";
            $_SESSION["page"]         = "hour";
            $_SESSION['idHour']       = $idHour;
            $_SESSION['startHour']    = $startHour;
            $_SESSION['endHour']      = $endHour;
            $_SESSION['message']      = "Estás a punto de eliminar la franja horaria de $startHour a $endHour h. Esto también eliminará las reservas inactivas asociadas a ella." ;
        }
    } 

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas para la franja horaria de $startHour a $endHour h. </br> Descripción del error: " . $queryError ; 
   
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/hoursList.php");
    
}

 
?>
