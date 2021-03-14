<?php  
$path = "../views/modifyPsw.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";
 
// Campos del formulario de cambio de contraseña
$userEmail    = $_POST["userEmail"];
$userCurrentPassword = $_POST["userCurrentPassword"];
$userNewPassword = $_POST["userNewPassword"];
$userConfirmNewPassword = $_POST["userConfirmNewPassword"];

try {
    // user_Status = 1 significa que el usuario está activo
    $sql = "UPDATE users 
               SET user_password     = :userNewPassword 
                 , user_modification = :userModification
             WHERE user_email = :useremail 
               AND user_password = :userpassword 
               AND user_status = '1'";
    $query = $conn->prepare($sql);
    $query->bindParam(":userNewPassword",$userNewPassword);
    $query->bindParam(":userModification",$_SESSION["sessionIdUser"]);
    $query->bindParam(":useremail", $userEmail);
    $query->bindParam(":userpassword", $userCurrentPassword);
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

} finally { 
    //Limpiamos la memoria 
    $conn = null;

    //Nos quedamos en la página origen
    header("Location: ../views/modifyPsw.php");

    //Cerramos el cursor para no utilizar recursos
    $query->closeCursor();
}

?>

