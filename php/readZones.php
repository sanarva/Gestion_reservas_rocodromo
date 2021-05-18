<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//**********************************************************************************************//
// Esta parte se encarga de cargar en la lista de zonas, todas las zonas que existen en la BBDD //
//**********************************************************************************************//

try {
    $sql = "SELECT id_zone, zone_name, max_users_zone, zone_status FROM zones ORDER BY zone_name";
    $query = $conn->query($sql);
    $zones = $query->fetchAll(PDO::FETCH_OBJ);

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar las zonas. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;
}


?>

