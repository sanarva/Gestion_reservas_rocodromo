<?php  
$path = "../views/recoveryPsw.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
// Campos del formulario de cambio de contraseña
$userEmail = $_POST["userEmail"];

try {
    //Buscamos si existe el usuario y está activo
    $sql = "SELECT id_user  FROM users WHERE user_email = :useremail AND user_status = 'A'";
    $query = $conn->prepare($sql); 
    $query->execute(array(":useremail"=>$userEmail));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    //Si existe el usuario y está activo, generamos una nueva contraseña, modificamos la BBDD con esa nueva contraseña y si todo ha ido ok, enviamos un mail al usuario
    if (($query->rowCount() == 1 )) {
        //Generamos una nueva contraseña
        include("../php/passwordGenerator.php");


        //Modificamos la BBDD con la nueva contraseña
        try {
            $sql = "UPDATE users
                       SET user_password     = :usernewpasswordencripted 
                         , user_modification = '999999'
                         , timestamp = current_timestamp
                     WHERE user_email = :useremail 
                       AND user_status = 'A'"; // user_Status = 1 significa que el usuario está activo
            $query = $conn->prepare($sql);
            $userNewPasswordEncripted = password_hash($userNewPassword, PASSWORD_DEFAULT);
            $query->bindParam(":usernewpasswordencripted",$userNewPasswordEncripted);
            $query->bindParam(":useremail", $userEmail);
            $query->execute();
            //Si se ha podido modificar la contraseña en la BBDD...
            if ($query->rowCount() > 0 ){
                //Enviamos un email al usuario con la nueva contraseña 
                include("../php/sendEmail.php");
            //Si no se ha podido modificar damos un error
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema al crear la nueva contraseña. Inténtalo en otro momento." ;
            } 
        //Si ha habido algún problema al modificar la contraseña, damos un error
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "No se ha podido crear una nueva contraseña. Inténtalo en otro momento. </br> Descripción del error: " . $queryError ; 
        }

    //Si no existe el usuario o existe pero no está activo o está duplicado, damos un error    
    } else {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "Es posible que el usuario $userEmail no exista, esté dado de baja o esté duplicado." ; 
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha producido un error al buscar al usuario $userEmail. </br> Descripción del error: " . $queryError ;

} finally { 
    //Limpiamos la memoria 
    $conn = null;

    //Cerramos el cursor para no utilizar recursos
    $query->closeCursor();

    //Nos quedamos en la página origen
    header("Location: ../views/recoveryPsw.php");
}

?>