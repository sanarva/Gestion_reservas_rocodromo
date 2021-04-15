<?php  
$path = "../views/usersList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$idUser = $_GET["Id"];
$currentUserName   = $_GET["currentUserName"];

$userName   = $_POST["inputUserName"];
$userType   = $_POST["userType"];
$cardNumber = $_POST["cardNumber"];
$userEmail  = $_POST["userEmail"];
$userStatus = $_POST["userStatus"];

try {
    //Buscamos reservas activas para el usuario que se quiere modificar (sólo si se está desactivando el usuario)
    $sql = "SELECT id_reservation  FROM reservations WHERE user_id = :iduser AND reservation_status IN ('A', 'P')";
    $query = $conn->prepare($sql); 
    $query->execute(array(":iduser"=>$idUser));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existen reservas activas... 
    if (($query->rowCount() > 0 )) {
        // Si el administrador intenta desactivar al usuario, se mostrará un aviso y no se permitirá la desactivación hasta que no haya cancelado las reservas pendiente de ese usuario
        if ($userStatus == "I") {
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "No se puede desactivar al usuario $currentUserName ya que existen reservas activas asociadas a este usuario. Cancela antes las reservas activas y vuelve a intentarlo." ;  
        } else {
            try {
            $sql = "UPDATE users 
                       SET user_name         = :username
                         , user_type         = :usertype
                         , card_number       = :cardnumber
                         , user_email        = :useremail
                         , user_status       = :userstatus
                         , user_modification = :userModification
                         , timestamp = current_timestamp
                     WHERE id_user = :iduser";
            $query = $conn->prepare($sql);
            $query->bindParam(":username",$userName);
            $query->bindParam(":usertype",$userType);
            $query->bindParam(":cardnumber",$cardNumber);
            $query->bindParam(":useremail",$userEmail);
            $query->bindParam(":userstatus",$userStatus);
            $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
            $query->bindParam(":iduser",$idUser);
            $query->execute();
            
        
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "El usuario $currentUserName ha sido modificado correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar el usuario $currentUserName." ; 
            }
        
            } catch(PDOException $e){
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar un usuario. </br> Descripción del error: " . $queryError ; 
            
            }
        }
        
    //Si no existen reservas activas, modificamos la zona    
    } else {
        try {
            $sql = "UPDATE users 
                       SET user_name         = :username
                         , user_type         = :usertype
                         , card_number       = :cardnumber
                         , user_email        = :useremail
                         , user_status       = :userstatus
                         , user_modification = :userModification
                         , timestamp = current_timestamp
                     WHERE id_user = :iduser";
            $query = $conn->prepare($sql);
            $query->bindParam(":username",$userName);
            $query->bindParam(":usertype",$userType);
            $query->bindParam(":cardnumber",$cardNumber);
            $query->bindParam(":useremail",$userEmail);
            $query->bindParam(":userstatus",$userStatus);
            $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
            $query->bindParam(":iduser",$idUser);
            $query->execute();
            
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "El usuario $currentUserName ha sido modificado correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar el usuario $currentUserName." ; 
            }
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar un usuario. </br> Descripción del error: " . $queryError ; 
           
        }
    }


} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas del usuario que se quiere modificar. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/usersList.php?userName=&cardNumber=&allStatusUser=");
    
}

?>
