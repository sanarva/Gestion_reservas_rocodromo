<?php  
$path = "../views/modifyPsw.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
// Campos del formulario de cambio de contraseña
$userEmail                = $_POST["userEmail"];
$userCurrentPassword      = $_POST["userCurrentPassword"];
$userNewPassword          = $_POST["userNewPassword"];
$userNewPasswordEncripted = password_hash($userNewPassword, PASSWORD_DEFAULT);
$userConfirmNewPassword   = $_POST["userConfirmNewPassword"];

try {
    $sql = "SELECT id_user, user_password
              FROM users 
             WHERE user_email  = :useremail 
               AND user_status = 'A'";
    $query = $conn->prepare($sql);
    $query->execute(array(":useremail"=>$userEmail)); 
    $resultUser = $query->fetch(PDO::FETCH_ASSOC);
    
    if (($query->rowCount() > 0 && password_verify($userCurrentPassword, $resultUser["user_password"]))) {
        //Cambiamos la contraseña
        try {
            $sql = "UPDATE users 
                       SET user_password     = :userNewPasswordEncripted 
                         , user_modification = :userModification
                         , timestamp = current_timestamp
                     WHERE id_user = :iduser";
            $query = $conn->prepare($sql);
            $query->bindParam(":userNewPasswordEncripted",$userNewPasswordEncripted);
            $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
            $query->bindParam(":iduser", $resultUser["id_user"]);
            $query->execute();
            
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "Acabas de cambiar tu contraseña. Recuerda apuntarla bien, no la vayas a olvidar."  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "La contraseña que has escrito no es correcta o coincide con la contraseña actual." ;
            } 
        
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "No se ha podido cambiar la contraseña. </br> Descripción del error: " . $queryError ; 
        
        }

    } else {
        $_SESSION["successFlag"] = "N";
        $_SESSION["message"] = "La contraseña que has escrito no es correcta o coincide con la contraseña actual.";
        
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Lo sentimos, pero no se ha podido modificar la contraseña. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;

    //Nos quedamos en la página origen
    header("Location: ../views/modifyPsw.php");

    //Cerramos el cursor para no utilizar recursos
    $query->closeCursor();
}

?>
