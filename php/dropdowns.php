<?php
// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//*********************************************************************************************//
// Recupera todos los horarios disponibles de la BBDD                                          //
//*********************************************************************************************//
try {
    $sql = "SELECT start_hour, end_hour 
              FROM hours
          ORDER BY start_hour, end_hour";
    $query = $conn->prepare($sql);
    $query->execute();
    $hours = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existen horas, mostramos un aviso
    if ($hours == [] ){
        $_SESSION['successFlag'] = "W";
        $_SESSION['message'] = "No existen horarios disponibles";
    }
} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de recuperar los horarios disponibles para listarlos. </br> Descripción del error: " . $queryError ; 
} 

//*********************************************************************************************//
// Recupera todas las zonas disponibles de la BBDD                                             //
//*********************************************************************************************//
try {
    $sql = "SELECT zone_name 
              FROM zones
             WHERE zone_status = 'A'
          ORDER BY zone_name ASC";
    $query = $conn->prepare($sql);
    $query->execute();
    $zones = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existen zonas, mostramos un aviso
    if ($zones == [] ){
        $_SESSION['successFlag'] = "W";
        $_SESSION['message'] = "No existen zonas disponibles";
    }
} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de recuperar las zonas disponibles para listarlas. </br> Descripción del error: " . $queryError ; 
}

//Limpiamos la memoria 
$conn = null;
?>