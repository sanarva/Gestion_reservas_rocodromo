<?php  
$path = "../views/zone.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

$zoneName = $_POST["zoneName"];
$maxUserNumber = $_POST["maxUserNumber"];
$zoneStatus = $_POST["zoneStatus"];

try {
    //Buscamos si existe alguna zona con el mismo nombre
    $sql = "SELECT zone_name  FROM zones WHERE zone_name = :zonename";
    $query = $conn->prepare($sql); 
    $query->execute(array(":zonename"=>$zoneName));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario de que no se va a crear esa nueva zona porque ya existe una con el mismo nombre.
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede crear la zona $zoneName porque ya existe una zona con ese nombre. Por favor, modifica la existente." ; 
   
    } else {
        try {
            $sql = "INSERT 
                      INTO zones (
                            zone_name
                          , max_users_zone
                          , zone_status
                          , user_modification
                        )
                    VALUES ( 
                        :zonename
                      , :maxuserszone
                      , :zonestatus
                      , :userModification
                    )";

            $query = $conn->prepare($sql);
            $query->bindParam(":zonename", $zoneName);
            $query->bindParam(":maxuserszone", $maxUserNumber);
            $query->bindParam(":zonestatus", $zoneStatus);
            $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
            $query->execute();
                    
                    
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La zona $zoneName ha sido creada correctamente"  ;
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido crear la zona $zoneName." ; 
            }
        
            
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "N";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al crear la zona $zoneName. </br> Descripción del error: " . $queryError ; 
        }
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la creación de la zona, al buscar zonas con el mismo nombre. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/zonesList.php");
    
}

?>
