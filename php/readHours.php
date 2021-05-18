<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//**********************************************************************************************//
// Esta parte se encarga de cargar en la lista de horas, todas las horas que existen en la BBDD //
//**********************************************************************************************//

try {
    $sql = "SELECT id_hour, start_hour, end_hour, week_day FROM hours ORDER BY start_hour, end_hour";
    $query = $conn->query($sql);
    $hours = $query->fetchAll(PDO::FETCH_OBJ);

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar las franjas horarias. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;
}


?>

