<?php  

// Incluímos la conexión a la base de datos que está en el fichero database.php
include ("database.php");

// Campos del formulario de login
$userEmail    = $_POST["userEmail"];
$userPassword = $_POST["userPassword"];

$query = "SELECT id_user, user_type, user_name FROM users WHERE user_email = '$userEmail'";

$result = mysqli_query($sqlconexion, $query);



if (mysqli_num_rows($result)>0){
    while ($row = mysqli_fetch_assoc($result)) {
    echo ($row["user_name"]);
    //Guardamos los datos que hemos recuperado
    $_SESSION['sessionIdUser'] = ($row["id_user"]);
    $_SESSION['sessionUserType'] = ($row["user_type"]);
    $_SESSION['sessionUserName'] = ($row["user_name"]);
   
    header("Location: ../views/userMenu.php" );
    }
} else {
    $_SESSION['sessionUserNotFound'] = 'N';
    header("Location: ../views/index.php" );
}



//Código que me ayuda durante el desarrollo en caso de
// que haya un problema en la formación de la sentencia SQL
if (!$result){
    /* var_dump(mysqli_error($sqlconexion));
    exit; */
}



  
?>