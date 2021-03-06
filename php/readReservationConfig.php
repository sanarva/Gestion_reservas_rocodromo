<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//*********************************************************************************************//
// Esta parte se encarga de cargar los valores actuales de la tabla reservationsconfig         //
//*********************************************************************************************//
try {
    $sql = "SELECT max_reservation
                 , max_users_route
                 , start_free_date
                 , end_free_date
              FROM reservationsconfig";
    $query = $conn->prepare($sql);
    $query->execute();
    $reservationsConfig = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existe la configuración, damos un error
    if ($reservationsConfig == [] ){
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se ha encontrado la información de configuración de reservas. Es necesario que la cree para que los usuarios puedan reservar.";
    //Si existe, crearemos estas dos variables de sesión para no tener que acceder varias veces a la hora de hacer una reserva
    } else {
        $_SESSION['sessionMaxReservationByUser'] = $reservationsConfig[0]->max_reservation;
        $_SESSION['sessionMaxUsersInRouteZone']  = $reservationsConfig[0]->max_users_route;
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar la configuración de las reservas. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null; 
}

?>

