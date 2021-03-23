<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//Comprobamos si viene información del formulario de buscar reserva
if (isset ($_POST["dateFromFilter"]) && $_POST["dateFromFilter"] != "") {  
    $dateFromFilter    = $_POST["dateFromFilter"];
    $dateFromFilterGet = $_POST["dateFromFilter"];
} else {
    $dateFromFilter = "0000-01-01";
    $dateFromFilterGet = "";
}

if (isset ($_POST["dateToFilter"]) && $_POST["dateToFilter"] != "") {
    $dateToFilter    = $_POST["dateToFilter"];
    $dateToFilterGet = $_POST["dateToFilter"];
} else {
    $dateToFilter = "9999-12-31";
    $dateToFilterGet = "";
}

if (isset ($_POST["userFilter"])) {
    $userFilter    = $_POST["userFilter"] . "%";
    $userFilterGet = $_POST["userFilter"];
} else {
    $userFilter   = "%";
    $userFilterGet = "";
}

if (isset ($_POST["cardNumberFilter"])) {
    $cardNumberFilter    = $_POST["cardNumberFilter"] . "%";
    $cardNumberFilterGet = $_POST["cardNumberFilter"];
} else {
    $cardNumberFilter   = "%";
    $cardNumberFilterGet = "";
}

if (isset ($_POST["hourStartFilter"]) && $_POST["hourStartFilter"] != "") {
    $hourStartFilter    = $_POST["hourStartFilter"];
    $hourStartFilterGet = $_POST["hourStartFilter"];
} else {
    $hourStartFilter   = "00:00";
    $hourStartFilterGet = "";
}

if (isset ($_POST["hourEndFilter"]) && $_POST["hourEndFilter"] != "") {
    $hourEndFilter    = $_POST["hourEndFilter"];
    $hourEndFilterGet = $_POST["hourEndFilter"];
} else {
    $hourEndFilter   = "99:99";
    $hourEndFilterGet = "";
}

if (isset ($_POST["selectZoneFilter"])) {
    $selectZoneFilter    = $_POST["selectZoneFilter"] . "%";
    $selectZoneFilterGet = $_POST["selectZoneFilter"];
} else {
    $selectZoneFilter   = "%";
    $selectZoneFilterGet = "";
}

if (isset ($_POST["checkAllReservationsFilter"])) {
    $checkAllReservationsFilter = "%";
    $checkAllReservationsFilterGet = $_POST["checkAllReservationsFilter"];
} else {
    $checkAllReservationsFilter = "A%";
    $checkAllReservationsFilterGet = "";
}


//*********************************************************************************************//
// Esta parte se encarga de cargar en la lista de reservas, las reservas de la BBDD            //
//*********************************************************************************************//
try {
    $sql = "SELECT id_reservation
                 , reservation_date
                 , start_hour
                 , end_hour
                 , zone_name
                 , user_name
                 , card_number
                 , reservation_status
              FROM reservations, hours, zones, users
             WHERE reservation_status LIKE :reservationstatus
               AND hour_id = id_hour
               AND zone_id = id_zone
               AND user_id = id_user
               AND reservation_date BETWEEN :fromreservationdate AND :toreservationdate
               AND user_name        LIKE :username
               AND card_number      LIKE :cardnumber
               AND start_hour       >= :starthour
               AND end_hour         <= :endhour
               AND zone_name        LIKE :zonename
          ORDER BY reservation_date DESC, start_hour ASC, end_hour ASC, card_number ASC";
    $query = $conn->prepare($sql);
    $query->bindParam(":reservationstatus",$checkAllReservationsFilter);
    $query->bindParam(":fromreservationdate",$dateFromFilter);
    $query->bindParam(":toreservationdate",$dateToFilter);
    $query->bindParam(":username",$userFilter);
    $query->bindParam(":cardnumber",$cardNumberFilter);
    $query->bindParam(":starthour",$hourStartFilter);
    $query->bindParam(":endhour",$hourEndFilter);
    $query->bindParam(":zonename",$selectZoneFilter);

    $query->execute();
    $reservations = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existen usuarios, mostramos un aviso
    if ($reservations == [] ){
        $_SESSION['successFlag'] = "W";
        $_SESSION['message'] = "No se ha encontrado ninguna reserva.";
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar las reservas. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;

    if (isset ($_POST["dateFromFilter"]) || isset ($_POST["dateToFilter"]) || isset ($_POST["userFilter"]) || isset ($_POST["cardNumberFilter"]) || isset ($_POST["hourStartFilter"]) || isset ($_POST["hourEndFilter"]) || isset ($_POST["selectZoneFilter"]) || isset ($_POST["checkAllReservationsFilter"])) {
        $_SESSION["searchReservations"] = $reservations;
        header("Location: ../views/reservationsList.php?dateFrom=$dateFromFilterGet&dateTo=$dateToFilterGet&userName=$userFilterGet&cardNumber=$cardNumberFilterGet&startHour=$hourStartFilterGet&endHour=$hourEndFilterGet&zoneName=$selectZoneFilterGet&checkAllReservationsFilterGet=$checkAllReservationsFilterGet");
    }
}

?>

