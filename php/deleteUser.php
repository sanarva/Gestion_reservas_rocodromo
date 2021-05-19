<?php  
$path = "../views/usersList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

//*********************************************************************************************//
// Esta parte se encarga de comprobar si existen reservas activas para el usuario que se quiere//
// eliminar. Si las hay, se enviará un mensaje al administrador para avisarle de ello y no     //
// se eliminará el usuario hasta que no se hayan cancelado manualmente las reservas activas.   //
//*********************************************************************************************//
$idUser          = $_GET["Id"];
$userNameMessage = $_GET["userName"];

$filterUserName      = $_SESSION['filterUserNameShow'];
$filterCardNumber    = $_SESSION['filterCardNumberShow'] ;
$filterAllStatusUser = $_SESSION['filterAllStatusUserShow'];

if (isset($_GET["delete"]) ){
    $delete = $_GET["delete"];
} else {
    $delete = "";
}

try {
    $sql = "SELECT id_reservation  FROM reservations WHERE user_id = :iduser AND reservation_status IN ('A', 'P', 'C', 'W')";
    $query = $conn->prepare($sql); 
    $query->execute(array(":iduser"=>$idUser));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede eliminar al usuario $userNameMessage ya que existen reservas activas asociadas a ese usuario. Cancela sus reservas activas y vuelve a intentarlo." ; 
    } else {
        if ($delete == "yes") {
            try {
                $sql   = "DELETE FROM users WHERE id_user = $idUser";
                $count = $conn->exec($sql);  

                if ($count == 0) {
                    $_SESSION['successFlag'] = "N"; 
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido eliminar al usuario $userNameMessage." ; 
                } else {
                    $_SESSION['successFlag'] = "Y";
                    $_SESSION['message'] = "El usuario $userNameMessage ha sido eliminado correctamente." ; 
                }
            
            } catch(PDOException $e) {
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de eliminar al usuario $userNameMessage. </br> Descripción del error: " . $queryError ; 
            } finally {
                //Una vez se haya intentado eliminar un usuario, se inicializa la variable de sesión 
                $_SESSION['idUser'] = "" ;
                $_SESSION['userName'] = "" ;
            }
            
        } else {
            $_SESSION['confirmation'] = "";
            $_SESSION["page"] = "user";
            $_SESSION['idUser']   = $idUser;
            $_SESSION['userName'] = $userNameMessage;
            $_SESSION['message']  = "Estás a punto de eliminar al usuario $userNameMessage. Esto también eliminará las reservas pasadas asociadas a este usuario." ;
        }
    } 

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar el usuario $userNameMessage. </br> Descripción del error: " . $queryError ; 
   
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/usersList.php?userName=$filterUserName&cardNumber=$filterCardNumber&allStatusUser=$filterAllStatusUser");
    
}

?>
