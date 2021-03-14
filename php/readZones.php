<?php  

$path = "../views/zoneList.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//**********************************************************************************************//
// Esta parte se encarga de cargar en la lista de zonas, todas las zonas que existen en la BBDD //
//**********************************************************************************************//

try {
    $sql = "SELECT id_zone, zone_name, max_users_zone, zone_status FROM zones ORDER BY zone_name";
    $query = $conn->query($sql);
    $zones = $query->fetchAll(PDO::FETCH_OBJ);

    //Si no existen zonas, mostramos un aviso
    if ($zones == [] ){
        $_SESSION['successFlag'] = "W";
        $_SESSION['message'] = "Todavía no se ha creado ninguna zona."  ;
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar las zonas. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;

}


 
?>

