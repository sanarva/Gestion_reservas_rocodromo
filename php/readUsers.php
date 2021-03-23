<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

if (isset ($_POST["userNameFilter"])) {
    $userNameFilter    = $_POST["userNameFilter"] . "%";
    $userNameFilterGet = $_POST["userNameFilter"];
} else {
    $userNameFilter = "%";
    $userNameFilterGet = "";
}
if (isset ($_POST["cardNumberFilter"])) {
    $cardNumberFilter    = $_POST["cardNumberFilter"] . "%";
    $cardNumberFilterGet = $_POST["cardNumberFilter"];
} else {
    $cardNumberFilter    = "%";
    $cardNumberFilterGet = "";
}

if (isset ($_POST["checkAllUsersFilter"])) {
    $checkAllUsersFilter = "%";
    $checkAllUsersFilterGet = $_POST["checkAllUsersFilter"];
} else {
    $checkAllUsersFilter = "A%";
    $checkAllUsersFilterGet = "";
}


//*********************************************************************************************//
// Esta parte se encarga de cargar en la lista de usuarios, los usuarios de la BBDD            //
//*********************************************************************************************//
try {
    $sql = "SELECT id_user, user_type, card_number, user_status, user_name, user_email 
              FROM users
             WHERE user_status LIKE :userstatus
               AND user_name   LIKE :username
               AND card_number LIKE :cardnumber
          ORDER BY user_name";
    $query = $conn->prepare($sql);
    $query->bindParam(":userstatus",$checkAllUsersFilter);
    $query->bindParam(":username",$userNameFilter);
    $query->bindParam(":cardnumber",$cardNumberFilter);
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existen usuarios, mostramos un aviso
    if ($users == [] ){
        $_SESSION['successFlag'] = "W";
        $_SESSION['message'] = "No se ha encontrado ningún usuario.";
    }
} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar los usuarios. </br> Descripción del error: " . $queryError ; 
} finally { 
    //Limpiamos la memoria 
    $conn = null;
    if (isset ($_POST["userNameFilter"]) || isset ($_POST["cardNumberFilter"]) || isset ($_POST["checkAllUsersFilter"])) {
        $_SESSION["searchUsers"] = $users;
        header("Location: ../views/usersList.php?userName=$userNameFilterGet&cardNumber=$cardNumberFilterGet&checkAllUsersFilterGet=$checkAllUsersFilterGet");
    }
}

?>

