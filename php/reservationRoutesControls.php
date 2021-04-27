<?php  

//IMPORTANTE: Se ha de procurar que los administradores no cambien el nombre de la zona de vías ("Vía R%") 

// Si se quiere reservar una vía con autoasegurador (R2 y R3), pueda haber una sóla persona (reserva con autoasegurador) o dos (reserva en cordada).
// Si se quiere reservar una vía sin autoasegurador (R1, R4 y R5) se obligará a tener un compañero de cordada (reserva en cordada). 
// En caso de que se haga una reserva en cordada, se dejará la reserva en estado pendiente durante 24h (hasta que el compañero confirme) y se enviará un email a ambos.
// También se comprobará que no se exceda el máximo total de usuarios en la zona de vías


//Comprobamos el nombre de la zona. Si no es zona de vías, creamos directamente la reserva. Si lo es, haremos unas comprobaciones antes de crear las reservas
if ($zoneNameChoosen == "Vía R1" || ($zoneNameChoosen == "Vía R2" && $reservationType == "ropeTeam") || ($zoneNameChoosen == "Vía R3" && $reservationType == "ropeTeam") || $zoneNameChoosen == "Vía R4" || $zoneNameChoosen == "Vía R5"){  
    $userCounterRoutes = 2;
    $reservationStatus = "P";
    $reservationStatusRopeTeam = "C";
} else if (($zoneNameChoosen == "Vía R2" && $reservationType == "autoInsurer") || ($zoneNameChoosen == "Vía R3" && $reservationType == "autoInsurer")) {
    $userCounterRoutes = 1;
    $reservationStatus = "A";
    $reservationStatusRopeTeam = "W";
} else {
    $insertReservation = "";
    $reservationStatus = "A";
}

//Independientemente de la zona, si estamos ante una reserva doble con menor, pondremos a 2 el número de inserts
if ($reservationType == "doubleReservationWithMinor"){
    $doubleReservationWithMinor = "Y";
    $numberOfInserts = 2;
}


// Si se trata de una zona de vías, si se va a usar el autoasegurador añadiremos uno a la cuenta pero si se va a escalar en cordada, se sumará 2
if (isset($userCounterRoutes)) {
    try {
        $sql = "SELECT COUNT(*) AS reservationsNumberInRoutes 
                FROM reservations, zones
                WHERE zone_id           = id_zone
                AND hour_id           = :idhour 
                AND reservation_Date  = :filterreservationdate
                AND zone_name         LIKE 'Vía R%'
                AND reservation_status IN ('A', 'P', 'C')";
        $query = $conn->prepare($sql); 
        $query->execute(array(":idhour"=>$idHour, ":filterreservationdate"=>$filterReservationDate));  
        $routes = $query->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema al buscar el número total de reservas en la zona de vías. </br> Descripción del error: " . $queryError ; 
    } 

    //Comprobamos que no se supere el número máximo de reservas en la zona de vías
    if (($routes['reservationsNumberInRoutes'] + $userCounterRoutes) > $_SESSION['sessionMaxUsersInRouteZone']){
        $maxNumUsersRoute = $_SESSION['sessionMaxUsersInRouteZone'];
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede hacer una reserva en la zona de vías porque se superaría el máximo número de usuarios totales de la zona, que es de $maxNumUsersRoute personas.";   
    } else {
        if (isset($reservationStatusRopeTeam)){
            $numberOfInserts = 2;
            if ($cardNumberRopeTeam != ""){
                $checkTeamRope   = "";
            } else {
                $insertReservation = "";
            }
        } else {
            $numberOfInserts = 1;
        }
    }
}


?>
