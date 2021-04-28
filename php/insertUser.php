<?php  
$path = "../views/user.php?Id= &userName=&userType=&cardNumber=&userEmail=&userStatus=";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

$userName   = $_POST["inputUserName"];
$userType   = $_POST["userType"];
$cardNumber = $_POST["cardNumber"];
$userEmail  = $_POST["userEmail"];
$userStatus = $_POST["userStatus"];

try {
    //Buscamos si existe algún usuario con el mismo nombre o número de tarjeta o email, activo o inactivo
    $sql = "SELECT user_name
                 , card_number
                 , user_email  
              FROM users
             WHERE user_name   = :username 
                OR card_number = :cardnumber
                OR user_email  = :useremail";
    $query = $conn->prepare($sql); 
    $query->execute(array(":username"=>$userName, ":cardnumber"=>$cardNumber, ":useremail"=>$userEmail));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario administrador de que no se va a crear ese nuevo usuario porque ya existe uno con el mismo nombre o número de tarjeta o email
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        if (strtolower($result['user_name']) == strtolower($userName)){
            $_SESSION['message'] = "No se puede crear el usuario con nombre $userName, número de tarjeta $cardNumber e email $userEmail porque existe otro con el mismo nombre. Por favor, modifica el existente." ; 
        } else if ($result['card_number'] == $cardNumber){
            $_SESSION['message'] = "No se puede crear el usuario con nombre $userName, número de tarjeta $cardNumber e email $userEmail porque existe otro con el mismo número de tarjeta. Por favor, modifica el existente." ; 
        } else if (strtolower($result['user_email']) == strtolower($userEmail)){
            $_SESSION['message'] = "No se puede crear el usuario con nombre $userName, número de tarjeta $cardNumber e email $userEmail porque existe otro con el mismo email. Por favor, modifica el existente." ; 
        }
    } else {
        try {
            $sql = "INSERT 
                      INTO users (
                            user_name
                          , user_type
                          , card_number
                          , user_email
                          , user_status
                          , user_modification
                        )
                    VALUES ( 
                        :username
                      , :usertype
                      , :cardnumber
                      , :useremail
                      , :userstatus
                      , :userModification
                    )";

            $query = $conn->prepare($sql);
            $query->bindParam(":username", $userName);
            $query->bindParam(":usertype", $userType);
            $query->bindParam(":cardnumber", $cardNumber);
            $query->bindParam(":useremail", $userEmail);
            $query->bindParam(":userstatus", $userStatus);
            $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
            $query->execute();
                    
                    
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "El usuario $userName ha sido creado correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido crear el usuario $userName." ; 
            }
        
            
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "C";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al crear el usuario $userName. </br> Descripción del error: " . $queryError ; 
        }
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la creación del usuario, al buscar posibles usuarios duplicados. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;
    if ($_SESSION['successFlag'] == "Y"){
        header("Location: ../views/user.php?Id= &userName=&userType=&cardNumber=&userEmail=&userStatus=");
    } else {
        header("Location: ../views/user.php?Id= &userName=$userName&userType=$userType&cardNumber=$cardNumber&userEmail=$userEmail&userStatus=$userStatus");
    }
    
}

?>
