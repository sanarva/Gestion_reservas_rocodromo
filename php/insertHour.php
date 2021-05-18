<?php  
$path = "../views/hour.php?Id= &startHour=&endHour=&weekDay=";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

$startHour = $_POST["startHour"];
$endHour   = $_POST["endHour"];
$weekDay   = $_POST["weekDay"];

try {
    //Buscamos si existe alguna franja horaria que empiece a la misma hora 
    $sql = "SELECT start_hour, end_hour FROM hours WHERE start_hour = :starthour";
    $query = $conn->prepare($sql);
    //Estamos usando un array asociativo para los parámetros
    $query->execute(array(":starthour"=>$startHour));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    //Si existe, avisamos al usuario de que no se va a crear esa nueva hora porque ya existe una.
    if (($query->rowCount() > 0 )) {
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede crear la franja horaria de $startHour a $endHour h porque ya existe una con la misma hora de inicio. Por favor, modifica la existente." ; 

    } else {
        try {
            $sql = "INSERT 
                      INTO hours (
                            start_hour
                          , end_hour
                          , week_day
                          , user_modification
                        )
                    VALUES ( 
                        :starthour
                      , :endhour
                      , :weekday
                      , :userModification
                    )";

            $query = $conn->prepare($sql);
            $query->bindParam(":starthour", $startHour);
            $query->bindParam(":endhour", $endHour);
            $query->bindParam(":weekday", $weekDay);
            $query->bindParam(":userModification", $_SESSION["sessionIdUser"]);
            $query->execute();
                    
                    
            if ($query->rowCount() > 0 ){
                $_SESSION['successFlag'] = "Y";
                $_SESSION['message'] = "La franja horaria de $startHour a $endHour h ha sido creada correctamente.";
            } else {
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "Ha habido un problema y no se ha podido crear la franja horaria de $startHour a $endHour h." ; 
            }
        
            
        } catch(PDOException $e){
            $_SESSION['successFlag'] = "C";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al crear la franja horaria de $startHour a $endHour h. </br> Descripción del error: " . $queryError ; 
        }
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la creación de franjas horarias, al buscar posibles duplicados. </br> Descripción del error: " . $queryError ;  
     
} finally { 
    //Limpiamos la memoria 
    $conn = null;

    header("Location: ../views/hour.php?Id= &startHour=&endHour=&weekDay=");
    
}

?>
