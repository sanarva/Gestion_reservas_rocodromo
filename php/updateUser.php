<?php  
$path = "../views/usersList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 

$idUser            = $_GET["Id"];
$currentUserName   = $_GET["userName"];
$currentUserType   = $_GET["userType"];
$currentCardNumber = $_GET["cardNumber"];
$currentUserEmail  = $_GET["userEmail"];
$currentUserStatus = $_GET["userStatus"];

$userName   = $_POST["inputUserName"];
$userType   = $_POST["userType"];
$cardNumber = $_POST["cardNumber"];
$userEmail  = $_POST["userEmail"];
$userStatus = $_POST["userStatus"];

//Buscamos si existe algún usuario con el mismo nombre, número de tarjeta o email, activo o inactivo.
try {
    $sql = "SELECT user_name
                 , card_number
                 , user_email
                 , user_status
              FROM users
             WHERE id_user <> :iduser
                AND (user_name  = :username 
                 OR card_number = :cardnumber
                 OR user_email  = :useremail)";
    $query = $conn->prepare($sql); 
    $query->execute(array(":iduser"=>$idUser, ":username"=>$userName, ":cardnumber"=>$cardNumber, ":useremail"=>$userEmail));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario administrador de que no se va a crear ese nuevo usuario porque ya existe uno con el mismo nombre o número de tarjeta o email
    if (($query->rowCount() > 0 )) {
        if ($result['user_status'] == 'A'){
            $status = "activo";
        } else {
            $status = "inactivo";
        }

        $_SESSION['successFlag'] = "N";
        if (strtolower($result['user_name']) == strtolower($userName)){
            $_SESSION['message'] = "No se puede modificar el usuario $currentUserName porque existe un usuario $status con el mismo nombre que el que estás intentando poner ($userName). Por favor, modifica el existente." ; 
        } else if ($result['card_number'] == $cardNumber){
            $_SESSION['message'] = "No se puede modificar el usuario $currentUserName con número de tarjeta $currentCardNumber porque existe un usuario $status con el mismo número de tarjeta que el que estás intentando poner ($cardNumber). Por favor, modifica el existente." ; 
        } else if (strtolower($result['user_email']) == strtolower($userEmail)){
            $_SESSION['message'] = "No se puede modificar el usuario $currentUserName con email $currentUserEmail porque existe un usuario $status con el mismo email que el que estás intentando poner ($userEmail). Por favor, modifica el existente." ; 
        }
    } else
        $duplicatedUserControl = "";
} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la modificación del usuario $currentUserName, al buscar posibles usuarios duplicados. </br> Descripción del error: " . $queryError ;  
} finally { 

    if ($_SESSION['successFlag'] == "Y") {
        header("Location: ../views/user.php?Id=$idUser&userName=$userName&userType=$userType&cardNumber=$cardNumber&userEmail=$userEmail&userStatus=$userStatus");
    } else {
        header("Location: ../views/user.php?Id=$idUser&userName=$currentUserName&userType=$currentUserType&cardNumber=$currentCardNumber&userEmail=$currentUserEmail&userStatus=$CurrentUserStatus");
    }

}       

if (isset($duplicatedUserControl)){

    try {
        //Buscamos reservas activas para el usuario que se quiere modificar (sólo si se está desactivando el usuario)
        $sql = "SELECT id_reservation  FROM reservations WHERE user_id = :iduser AND reservation_status IN ('A', 'P', 'C')";
        $query = $conn->prepare($sql); 
        $query->execute(array(":iduser"=>$idUser));  
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        //Si existen reservas activas... 
        if (($query->rowCount() > 0 )) {
            // Si el administrador intenta desactivar al usuario, se mostrará un aviso y no se permitirá la desactivación hasta que no haya cancelado las reservas pendiente de ese usuario
            if ($userStatus == "I") {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "No se puede desactivar al usuario $currentUserName ya que existen reservas activas asociadas al mismo. Cancela antes las reservas activas y vuelve a intentarlo." ;  
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
                    $_SESSION['message'] = "El usuario $currentUserName ha sido modificado correctamente."  ;
                } else {
                    $_SESSION['successFlag'] = "N";
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar el usuario $currentUserName." ; 
                }
            
                } catch(PDOException $e){
                    $_SESSION['successFlag'] = "N";
                    $queryError = $e->getMessage();  
                    $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar el usuario $currentUserName. </br> Descripción del error: " . $queryError ; 
                
                }
            }
            
        //Si no existen reservas activas, modificamos el usuario    
        } else {
            try {
                $sql = "UPDATE users
                          SET user_name          = :username
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
                    $_SESSION['message'] = "El usuario $currentUserName ha sido modificado correctamente."  ;
                } else {
                    $_SESSION['successFlag'] = "N";
                    $_SESSION['message'] = "Ha habido un problema y no se ha podido modificar el usuario $currentUserName." ; 
                }
            
            } catch(PDOException $e){
                $_SESSION['successFlag'] = "N";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema a la hora de modificar el usuario $currentUserName. </br> Descripción del error: " . $queryError ; 
            
            }
        }


    } catch(PDOException $e){
        $_SESSION['successFlag'] = "N";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema al buscar reservas activas del usuario $currentUserName en la ventana de modificación de usuarios. </br> Descripción del error: " . $queryError ;  
        
    } finally { 
        if ($_SESSION['successFlag'] == "Y") {
            header("Location: ../views/user.php?Id=$idUser&userName=$userName&userType=$userType&cardNumber=$cardNumber&userEmail=$userEmail&userStatus=$userStatus");
        } else {
            header("Location: ../views/user.php?Id=$idUser&userName=$currentUserName&userType=$currentUserType&cardNumber=$currentCardNumber&userEmail=$currentUserEmail&userStatus=$CurrentUserStatus");
        }

    }
}

//Limpiamos la memoria 
$conn = null;
 

?>
