<?php  

$path = "../views/userMenu.php";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//Comprobamos si viene información del formulario de buscar reserva
if (isset($_POST["filterDateFrom"]) && $_POST["filterDateFrom"] != "") {  
    $filterDateFrom                 = $_POST["filterDateFrom"];
    $filterDateFromShow             = $_POST["filterDateFrom"];
    $_SESSION['dateFromFilterShow'] = $_POST["filterDateFrom"];
} else if (!isset($filterDateFrom) || (isset($filterDateFrom) && $filterDateFrom == "")){
    $filterDateFrom                 = "0000-01-01";
    $filterDateFromShow             = "";
    $_SESSION['filterDateFromShow'] = "";
}

if (isset($_POST["filterDateTo"]) && $_POST["filterDateTo"] != "") {
    $filterDateTo                 = $_POST["filterDateTo"];
    $filterDateToShow             = $_POST["filterDateTo"];
    $_SESSION['filterDateToShow'] = $_POST["filterDateTo"];
} else if (!isset($filterDateTo) || (isset($filterDateTo) && $filterDateTo == "")){
    $filterDateTo                 = "9999-12-31";
    $filterDateToShow             = "";
    $_SESSION['filterDateToShow'] = "";
}

if (isset($_POST["filterUserName"])) {
    $filterUserName                 = $_POST["filterUserName"] . "%";
    $filterUserNameShow             = $_POST["filterUserName"];
    $_SESSION['filterUserNameShow'] = $_POST["filterUserName"];
} else if (!isset($filterUserName) || (isset($filterUserName) && $filterUserName == "")){
    $filterUserName                 = "%";
    $filterUserNameShow             = "";
    $_SESSION['filterUserNameShow'] = "";
} else if (isset($filterUserName) && $filterUserName != ""){
    if (strpos($filterUserName, "%") > 0) {
        $filterUserName             = $filterUserName;
    } else {
        $filterUserName             = $filterUserName . "%";
    }
    $filterUserNameShow             = $filterUserName;
    $_SESSION['filterUserNameShow'] = $filterUserName;
}


if (isset($_POST["filterCardNumber"])) {
    $filterCardNumber                = $_POST["filterCardNumber"] . "%";
    $filterCardNumberShow             = $_POST["filterCardNumber"];
    $_SESSION['filterCardNumberShow'] = $_POST["filterCardNumber"];
} else if (!isset($filterCardNumber) || (isset($filterCardNumber) && $filterCardNumber == "")){
    $filterCardNumber                 = "%";
    $filterCardNumberShow             = "";
    $_SESSION['filterCardNumberShow'] = "";
} else if (isset($filterCardNumber) && $filterCardNumber != ""){
    if (strpos($filterCardNumber, "%") > 0) {
        $filterCardNumber            = $filterCardNumber;
    } else {
        $filterCardNumber            = $filterCardNumber . "%";
    }
    $filterCardNumberShow             = $filterCardNumber;
    $_SESSION['filterCardNumberShow'] = $filterCardNumber;
}

if (isset($_POST["filterStartHour"]) && $_POST["filterStartHour"] != "") {
    $filterStartHour                 = $_POST["filterStartHour"];
    $filterStartHourShow             = $_POST["filterStartHour"];
    $_SESSION['filterStartHourShow'] = $_POST["filterStartHour"];
} else if (!isset($filterStartHour) || (isset($filterStartHour) && $filterStartHour == "")){
    $filterStartHour                 = "00:00";
    $filterStartHourShow             = "";
    $_SESSION['filterStartHourShow'] = "";
}

if (isset($_POST["filterEndHour"]) && $_POST["filterEndHour"] != "") {
    $filterEndHour                  = $_POST["filterEndHour"];
    $filterEndHourShow              = $_POST["filterEndHour"];
    $_SESSION['filterEndHourShow']  = $_POST["filterEndHour"];
} else if (!isset($filterEndHour) || (isset($filterEndHour) && $filterEndHour == "")){
    $filterEndHour                 = "99:99";
    $filterEndHourShow              = "";
    $_SESSION['filterEndHourShow']  = "";
}

if (isset($_POST["filterZoneName"])) {
    $filterZoneName                 = $_POST["filterZoneName"] . "%";
    $filterZoneNameShow             = $_POST["filterZoneName"];
    $_SESSION['filterZoneNameShow'] = $_POST["filterZoneName"];
} else if (!isset($filterZoneName) || (isset($filterZoneName) && $filterZoneName == "")){
    $filterZoneName                 = "%";
    $filterZoneNameShow             = "";
    $_SESSION['filterZoneNameShow'] = "";
}

if (isset($_POST["filterAllStatusReservation"])) {
    $filterAllStatusReservation                 = "%";
    $filterAllStatusReservationShow             = $_POST["filterAllStatusReservation"];
    $_SESSION['filterAllStatusReservationShow'] = $_POST["filterAllStatusReservation"];
} else if (!isset($filterAllStatusReservation) || (isset($filterAllStatusReservation) && $filterAllStatusReservation == "")){
    $filterAllStatusReservation                 = "A";
    $filterAllStatusReservationShow             = "";
    $_SESSION['filterAllStatusReservationShow'] = "";
} else if (isset($filterAllStatusReservation) && $filterAllStatusReservation == "on"){
    $filterAllStatusReservation                 = "%";
    $filterAllStatusReservationShow             = "on";
    $_SESSION['filterAllStatusReservationShow'] = "on";

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
    $query->bindParam(":reservationstatus",$filterAllStatusReservation);
    $query->bindParam(":fromreservationdate",$filterDateFrom);
    $query->bindParam(":toreservationdate",$filterDateTo);
    $query->bindParam(":username",$filterUserName);
    $query->bindParam(":cardnumber",$filterCardNumber);
    $query->bindParam(":starthour",$filterStartHour);
    $query->bindParam(":endhour",$filterEndHour);
    $query->bindParam(":zonename",$filterZoneName);

    $query->execute();
    $reservations = $query->fetchAll(PDO::FETCH_OBJ);
    //Si no existen reservas, mostramos un aviso
    if ($reservations == [] ){
        if ($_SESSION['successFlag'] != "Y"){ //Si en la lista solo hay un registro y se elimina, en lugar de dar el error de que se ha eliminado correctamente, aparece el warning de que no se ha encontrado ninguna reservas. Así que ponemos este if para solucionar el problema
            $_SESSION['successFlag'] = "W";
            $_SESSION['message'] = "No se ha encontrado ninguna reserva.";
        }
    }

} catch(PDOException $e){
    $_SESSION['successFlag'] = "C";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Se ha detectado un problema a la hora de mostrar las reservas. </br> Descripción del error: " . $queryError ; 

} finally { 
    //Limpiamos la memoria 
    $conn = null;

    if (isset ($_POST["filterDateFrom"]) || isset ($_POST["filterDateTo"]) || isset ($_POST["filterUserName"]) || isset ($_POST["filterCardNumber"]) || isset ($_POST["filterStartHour"]) || isset ($_POST["filterEndHour"]) || isset ($_POST["filterZoneName"]) || isset ($_POST["filterAllStatusReservation"])) {
        $_SESSION["searchReservations"] = $reservations;

        header("Location: ../views/reservationsList.php?dateFrom=$filterDateFromShow&dateTo=$filterDateToShow&userName=$filterUserNameShow&cardNumber=$filterCardNumberShow&startHour=$filterStartHourShow&endHour=$filterEndHourShow&zoneName=$filterZoneNameShow&allStatusReservation=$filterAllStatusReservationShow");
    }
    

}

?>

