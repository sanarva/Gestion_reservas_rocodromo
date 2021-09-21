<?php  

$path = "../views/reservation.php?idReservation= &userName=&reservationDate=&startHour=&endHour=&zoneName=";

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//Declaramos el tipo array para la variable de sesión que contendrá las reservas disponibles
$_SESSION['sessionReservations'] = [];

//Recuperamos el idReservation
$idReservation =  $_GET["idReservation"];
$idRelatedReservation =  $_GET["idRelatedReservation"];

//Recuperamos la información que nos llega del formulario de búsqueda de reservas disponibles
$filterUserName         = $_POST["filterUserName"];

$reservationDateChoosen     = $_POST["reservationDateChoosen"];
$reservationDateChoosenShow = $_POST["reservationDateChoosen"];
$reservationDateChoosenTo   = $_POST["reservationDateChoosenTo"];

if ($_POST["filterStartHour"] == "") {
    $filterStartHour     = "00:00";
    $filterStartHourShow = "";
} else {
    $filterStartHour     = $_POST["filterStartHour"];
    $filterStartHourShow = $_POST["filterStartHour"];
}

if ($_POST["filterEndHour"] == "") {
    $filterEndHour     = "99:99";
    $filterEndHourShow = "";
} else {
    $filterEndHour     = $_POST["filterEndHour"];
    $filterEndHourShow = $_POST["filterEndHour"];
}

if ($_POST["filterZoneName"] == "") {
    $filterZoneName     = "%";
    $filterZoneNameShow = "";
} else {
    $filterZoneName     = $_POST["filterZoneName"] . "%";
    $filterZoneNameShow = $_POST["filterZoneName"];
}


// Control del número de reservas pendientes que tiene el usuario
$checkReservationsNumberUser = "Y";
$userName = $filterUserName;
$cardNumberRopeTeam = "";
include("../php/reservationGeneralControls.php");


if ($checkReservationsNumberUser == "OK") {
    $firtTime = "Yes"; //Cuando sea la primera vez, llenaremos el array de horas y zonas y declararemos la clase reservation. Las siguientes ya no hace falta
    //*********************************************************************************************//
    // Recuperamos el/los día/s de la semana de la/s fecha/s que nos han pasando                   //
    //*********************************************************************************************//
    $dateFromSearch=strtotime($reservationDateChoosen);
    $dateToSearch=strtotime($reservationDateChoosenTo);
    
    
    /* Recorremos el rango de fechas. El valor de 86400 son los segundos que tiene un dia (24 horas * 60 minutos * 60 segundos)*/
    for($i = $dateFromSearch; $i <= $dateToSearch; $i += 86400){
        $reservationDateChoosen = date("Y-m-d", $i);
        $reservationDay = date ('l', strtotime(date("d-m-Y", $i))); 
        
        switch ($reservationDay) {
            case "Monday":
                $reservationDay = "Lunes";
                $reservationDaySearch = "%L%";
                break;
            case "Tuesday":
                $reservationDay = "Martes";
                $reservationDaySearch = "%M%";
                break;
            case "Wednesday":
                $reservationDay = "Miércoles";
                $reservationDaySearch = "%X%";
                break;
            case "Thursday":
                $reservationDay = "Jueves";
                $reservationDaySearch = "%J%";
                break;
            case "Friday":
                $reservationDay = "Viernes";
                $reservationDaySearch = "%V%";
                break;
            case "Saturday":
                $reservationDay = "Sábado";
                $reservationDaySearch = "%S%";
                break;
            case "Sunday":
                $reservationDay = "Domingo";
                $reservationDaySearch = "%D%";
                break;
        }
    
        if ($firtTime == "Yes") {
            //*********************************************************************************************//
            // Recuperamos el array de horas                                                               //
            //*********************************************************************************************//
            try {
                $sql = "SELECT id_hour, start_hour, end_hour
                          FROM hours
                         WHERE start_hour >= :filterstarthour
                           AND end_hour <= :filterendhour
                           AND week_day  LIKE :reservationdaysearch
                      ORDER BY start_hour ASC, end_hour ASC";
                $query = $conn->prepare($sql);
                $query->bindParam(":filterstarthour", $filterStartHour);
                $query->bindParam(":filterendhour", $filterEndHour);
                $query->bindParam(":reservationdaysearch", $reservationDaySearch);
                $query->execute();
                $hours = $query->fetchAll(PDO::FETCH_OBJ);
                //Si no existen horas, mostramos un aviso
                if ($hours == [] ){
                    $_SESSION['successFlag'] = "W";
                    $_SESSION['message'] = "No existen reservas disponibles para esta búsqueda."; 
                } else {
                    //*********************************************************************************************//
                    // Recuperamos el array de zonas                                                               //
                    //*********************************************************************************************//
                    try {
                        $prepareReservations = "N";
                        $sql = "SELECT id_zone, zone_name, max_users_zone
                                  FROM zones
                                 WHERE zone_name LIKE :filterzonename
                                   AND zone_status = 'A'
                              ORDER BY zone_name ASC";
                        $query = $conn->prepare($sql);
                        $query->bindParam(":filterzonename", $filterZoneName);
                        $query->execute();
                        $zones = $query->fetchAll(PDO::FETCH_OBJ);
                        //Si no existen zonas, mostramos un aviso
                        if ($zones == [] ){
                            $_SESSION['successFlag'] = "W";
                            $_SESSION['message'] = "No existen zonas disponibles"; 
                        } else {
                            $prepareReservations = "Y";
                        }

                    } catch(PDOException $e){
                        $_SESSION['successFlag'] = "C";
                        $queryError = $e->getMessage();  
                        $_SESSION['message'] = "Se ha detectado un problema al buscar las zonas para mostrar las reservas disponibles. </br> Descripción del error: " . $queryError ; 
                    } 
                }

            } catch(PDOException $e){
                $_SESSION['successFlag'] = "C";
                $queryError = $e->getMessage();  
                $_SESSION['message'] = "Se ha detectado un problema al buscar las horas para mostrar las reservas disponibles. </br> Descripción del error: " . $queryError ; 

            }
        }

        if (isset($prepareReservations) && $prepareReservations == "Y") {
            if ($firtTime == "Yes"){
                class reservation {
                    public $reservationDayClass;
                    public $reservationDateChoosenClass;
                    public $idHourClass;
                    public $startHourClass;
                    public $endHourClass;
                    public $idZoneClass;
                    public $zoneNameClass;
                    public $freeReservationsClass;
                    public $busyReservationsClass;
                
                    public function __construct($reservationDayClass, $reservationDateChoosenClass, $idHourClass, $startHourClass, $endHourClass, $idZoneClass, $zoneNameClass, $freeReservationsClass, $busyReservationsClass)
                    {
                        $this->reservationDayClass         = $reservationDayClass;
                        $this->reservationDateChoosenClass = $reservationDateChoosenClass;
                        $this->idHourClass                 = $idHourClass;
                        $this->startHourClass              = $startHourClass;
                        $this->endHourClass                = $endHourClass;
                        $this->idZoneClass                 = $idZoneClass;
                        $this->zoneNameClass               = $zoneNameClass;
                        $this->freeReservationsClass       = $freeReservationsClass;
                        $this->busyReservationsClass       = $busyReservationsClass;
                    }
                }   

                $firtTime = "No";
            }

            foreach($hours as $hour) {
                foreach($zones as $zone){
                    try {
                        $sql = "SELECT COUNT(*) AS busyReservationsCounter
                                  FROM reservations
                                 WHERE reservation_date   = :reservationdatechoosen
                                   AND hour_id = :idhour
                                   AND zone_id = :idzone
                                   AND reservation_status IN ('A', 'P', 'C', 'W')";
                        $query = $conn->prepare($sql);
                        $query->bindParam(":reservationdatechoosen", $reservationDateChoosen);
                        $query->bindParam(":idhour", $hour->id_hour);
                        $query->bindParam(":idzone", $zone->id_zone);
                        $query->execute();
                        $busyReservations = $query->fetch(PDO::FETCH_ASSOC);
                        //Si no existe ninguna reserva ocupada, metemos la información en el array tal cuál
                        if ($busyReservations['busyReservationsCounter'] == 0){
                            $reservationAvailable = new reservation($reservationDay, $reservationDateChoosen, $hour->id_hour, $hour->start_hour, $hour->end_hour, $zone->id_zone, $zone->zone_name, $zone->max_users_zone, $busyReservations['busyReservationsCounter']);
                            array_push($_SESSION['sessionReservations'], $reservationAvailable);  
                        //Si existen reservas ocupada, comprobamos si queda alguna plaza libre. Si queda actualizamos las plazas disponibles y si no, no metemos el registro en el array.
                        } else if ($busyReservations['busyReservationsCounter'] < $zone->max_users_zone){
                            $freeReservations= $zone->max_users_zone - $busyReservations['busyReservationsCounter'];
                            $reservationAvailable = new reservation($reservationDay, $reservationDateChoosen, $hour->id_hour, $hour->start_hour, $hour->end_hour, $zone->id_zone, $zone->zone_name, $freeReservations, $busyReservations['busyReservationsCounter']);
                            array_push($_SESSION['sessionReservations'], $reservationAvailable); 
                        }
        
                    } catch(PDOException $e){
                        $_SESSION['successFlag'] = "C";
                        $queryError = $e->getMessage();  
                        $_SESSION['message'] = "Se ha detectado un problema al buscar reservas no disponibles para el dia  $reservationDateChoosen. </br> Descripción del error: " . $queryError ; 
                
                    } 
                }    
            }
        }    
    }

    if (count($_SESSION['sessionReservations']) == 0){
        $_SESSION['successFlag'] = "W"; 
        $_SESSION['message'] = "No existen reservas disponibles con esos criterios" ; 
    }
}

//Limpiamos la memoria 
$conn = null;

//Volvemos a la página de origen
header("Location: ../views/reservation.php?idReservation=$idReservation&idRelatedReservation=$idRelatedReservation&userName=$filterUserName&reservationDate=$reservationDateChoosenShow&reservationDateTo=$reservationDateChoosenTo&startHour=$filterStartHourShow&endHour=$filterEndHourShow&zoneName=$filterZoneNameShow");

?>

