<?php  
$path = "../index.php";

// Requerimos la conexión a la base de datos que está en el fichero database.php
require "database.php";


// Campos del formulario de login
$userEmail    = $_POST["userEmail"];
$userPassword = $_POST["userPassword"];

try {
    $sql = "SELECT id_user, user_type, user_name, user_email, user_password
              FROM users 
             WHERE user_email  = :useremail 
               AND user_status = 'A'";
    $query = $conn->prepare($sql);
    $query->execute(array(":useremail"=>$userEmail)); 
   
    $result = $query->fetch(PDO::FETCH_ASSOC);
 
    if (($query->rowCount() > 0 && password_verify($userPassword, $result["user_password"]))) {
        //Guardamos las variables de sesión 
        $_SESSION["sessionIdUser"]    = $result["id_user"];
        $_SESSION["sessionUserType"]  = $result["user_type"];
        $_SESSION["sessionUserName"]  = $result["user_name"];
        $_SESSION["sessionUserEmail"] = $result["user_email"];

        header("Location: ../views/userMenu.php" );

    } else {
        $_SESSION["successFlag"] = "N";
        $_SESSION["message"] = "El email o la contraseña no existen";
        header("Location: ../index.php");
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "No se ha podido acceder a la aplicación. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;
    //Cerramos el cursor para no utilizar recursos
    $query->closeCursor();
}
?>