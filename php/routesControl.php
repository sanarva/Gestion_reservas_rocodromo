<?php  

//IMPORTANTE: Se ha de procurar que los administradores no cambien el nombre de la zona de vías ("Vía R%") porque está harcodeado en el código

//Aquí haremos todas las comprobaciones de la zona de vías para asegurarnos de que:
    // Si se quiere reservar una vía con autoasegurador (R2 y R3), pueda haber una sóla persona (reserva doble) o dos (Dejar la reserva pendiente de confirmación y enviar mail al compañero de cordada)
    // Si se quiere reservar una vía sin autoasegurador (R1, R4 y R5) se obliga a tener un compañero de cordada. Se dejará la reserva en estado pendiente durante 24h (hasta que el compañero confirme) y se enviará email a ambos
    // No se exceda el máximo total de usuarios en la zona

//Buscamos el nombre de la zona
try {
    $sql = "SELECT zone_name 
              FROM zones
             WHERE id_zone  = :idzone";
    $query = $conn->prepare($sql); 
    $query->execute(array(":idzone"=>$idZone));  
    $resultzone = $query->fetch(PDO::FETCH_ASSOC);

    if ($resultzone['zone_name'] == "Vía R1" || $resultzone['zone_name'] == "Vía R2" || $resultzone['zone_name'] == "Vía R3" || $resultzone['zone_name'] == "Vía R4" || $resultzone['zone_name'] == "Vía R5" ){
        $checkRopeTeam = "";
    } else {
        $insertReserve = "";
        $reservationStatus = "A";
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema en la creación de la reserva, al buscar posibles reservas duplicadas. </br> Descripción del error: " . $queryError ;  
} 


// Si se trata de una zona de vías, comprobamos si habrá o no cordada
if (isset($checkRopeTeam)){
    //Si se trata de vías con autoasegurador, debemos preguntar si se a hacer una reserva individual o en cordada
    if ($resultzone['zone_name'] == "Vía R2" || $resultzone['zone_name'] == "Vía R3"){
        
        $userCounterRoutes = 1;
        $userCounterRoutes = 2;
    //Si se trata de vías sin autoasegurador, se requerirá el número de tarjeta de la cordada y la reserva quedará pendiente hasta que el compañero de cordada confirme en un máximo de 24h.
    } else {
        $userCounterRoutes = 2;  
        //cordada obligatoria 
        $_SESSION['successFlag'] = "W";
        $_SESSION['form'] = "";
        $_SESSION['message'] = "Esta vía debe ser reservada por una cordada. Escribe el número de tarjeta de tu compañero/a para poder hacer la reserva."  ;
        $_SESSION['button1'] = 'Reservar';
        $_SESSION['formaction1']  = '#';
        $_SESSION['colorbutton1'] = 'btn-primary';
        $_SESSION['button2'] = 'Cancelar';
        $_SESSION['formaction2']  = '#';
        $_SESSION['colorbutton2'] = 'btn-danger';
        
        include "../php/message.php";      
    }
}

if (isset($userCounterRoutes)) {
    try {
        $sql = "SELECT COUNT(*) AS reservationsNumberInRoutes 
                FROM reservations, zones
                WHERE zone_id           = id_zone
                AND hour_id           = :idhour 
                AND reservation_Date  = :filterreservationdate
                AND zone_name         LIKE 'Vía R%'
                AND reservation_status IN ('A', 'P')";
        $query = $conn->prepare($sql); 
        $query->execute(array(":idhour"=>$idHour, ":filterreservationdate"=>$filterReservationDate));  
        $routes = $query->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema al buscar el número total de reservas en la zona de vías. </br> Descripción del error: " . $queryError ; 
    } 

    try {
        $sql = "SELECT max_users_route
                FROM reservationsconfig";
        $query = $conn->prepare($sql);
        $query->execute();
        $reservationsConfig = $query->fetch(PDO::FETCH_ASSOC);
        
        //Si no existe la configuración, damos un error
        if ($reservationsConfig == [] ){
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "No se ha encontrado la información de configuración de reservas al buscar el máximo de usuarios totales en la zona de vías.";
        }
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema a la hora de acceder a la configuración de las reservas. </br> Descripción del error: " . $queryError ; 
    } 

    if (($routes['reservationsNumberInRoutes'] + $userCounterRoutes) > $reservationsConfig['max_users_route']){
        $maxNumUsersRoute = $reservationsConfig['max_users_route'];
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede hacer una reserva en la zona de vías porque se superaría el máximo número de usuarios totales de la zona, que es de $maxNumUsersRoute personas.";   
    } else {
        //$insertReserve = ""; 
        $checkRopeTeam = "";

    }
}
/* 
        //cordada obligatoria 
        $_SESSION['successFlag'] = "W";
        $_SESSION['form'] = "";
        $_SESSION['message'] = "Esta vía debe ser reservada por una cordada. Escribe el número de tarjeta de tu compañero/a para poder hacer la reserva."  ;
        $_SESSION['button1'] = 'Reservar';
        $_SESSION['formaction1']  = '#';
        $_SESSION['colorbutton1'] = 'btn-primary';
        $_SESSION['button2'] = 'Cancelar';
        $_SESSION['formaction2']  = '#';
        $_SESSION['colorbutton2'] = 'btn-danger';
 */


?>
