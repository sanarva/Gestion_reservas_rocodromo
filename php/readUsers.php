<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//Comprobamos si viene información del formulario de buscar usuario
if (isset($_POST["filterUserName"])) {
    $filterUserName                 = "%" . $_POST["filterUserName"] . "%";
    $filterUserNameShow             = $_POST["filterUserName"];
    $_SESSION['filterUserNameShow'] = $_POST["filterUserName"];
} else if (!isset($filterUserName) || (isset($filterUserName) && $filterUserName == "")){
    $filterUserName                 = "%";
    $filterUserNameShow             = "";
    $_SESSION['filterUserNameShow'] = "";
} else if (isset($filterUserName) && $filterUserName != ""){
    if (strpos($filterUserName, "%") > 0) {
        $filterUserName                 = $filterUserName;
        $filterUserNameShow             = $filterUserName;
        $_SESSION['filterUserNameShow'] = $filterUserName;
    } else {
        $filterUserNameShow             = $filterUserName;
        $_SESSION['filterUserNameShow'] = $filterUserName;
        $filterUserName                 = "%" . $filterUserName . "%";
    }
}

if (isset($_POST["filterCardNumber"]) && $_POST["filterCardNumber"] != "") {
    $filterCardNumber                 = $_POST["filterCardNumber"];
    $filterCardNumberShow             = $_POST["filterCardNumber"];
    $_SESSION['filterCardNumberShow'] = $_POST["filterCardNumber"];
} else if ((isset($_POST["filterCardNumber"]) && $_POST["filterCardNumber"] == "") || !isset($filterCardNumber) || (isset($filterCardNumber) && $filterCardNumber == "")){
    $filterCardNumber                 = "%";
    $filterCardNumberShow             = "";
    $_SESSION['filterCardNumberShow'] = "";
} else if (isset($filterCardNumber) && $filterCardNumber != ""){
    if (strpos($filterCardNumber, "%") > 0) {
        $filterCardNumber                 = $filterCardNumber;
        $filterCardNumberShow             = $filterCardNumber;
        $_SESSION['filterCardNumberShow'] = $filterCardNumber;
    } else {
        $filterCardNumberShow             = $filterCardNumber;
        $_SESSION['filterCardNumberShow'] = $filterCardNumber;
        $filterCardNumber                 = $filterCardNumber;
    }
}

if (isset($_POST["filterAllStatusUser"])) {
    $filterAllStatusUser                 = "%";
    $filterAllStatusUserShow             = $_POST["filterAllStatusUser"];
    $_SESSION['filterAllStatusUserShow'] = $_POST["filterAllStatusUser"];
} else if (!isset($filterAllStatusUser) || (isset($filterAllStatusUser) && $filterAllStatusUser == "")){
    $filterAllStatusUser                 = "A";
    $filterAllStatusUserShow             = "";
    $_SESSION['filterAllStatusUserShow'] = "";
} else if (isset($filterAllStatusUser) && $filterAllStatusUser == "on"){
    $filterAllStatusUser                 = "%";
    $filterAllStatusUserShow             = "on";
    $_SESSION['filterAllStatusUserShow'] = "on";

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
    $query->bindParam(":userstatus",$filterAllStatusUser);
    $query->bindParam(":username",$filterUserName);
    $query->bindParam(":cardnumber",$filterCardNumber);
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_OBJ);

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar los usuarios. </br> Descripción del error: " . $queryError ; 
} finally { 
    //Limpiamos la memoria 
    $conn = null;
    if (isset ($_POST["filterUserName"]) || isset ($_POST["filterCardNumber"]) || isset ($_POST["filterAllStatusUser"])) {
        $_SESSION["searchUsers"] = $users;
        header("Location: ../views/usersList.php?userName=$filterUserNameShow&cardNumber=$filterCardNumberShow&allStatusUser=$filterAllStatusUserShow");
    }
}

?>

