<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Reserva</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body>

    <?php
        $count = 0;

        // Recuperamos las fechas en las que se puede hacer reservas
        include("../php/readReservationConfig.php");

        // Recuperamos la información de la lista de reservas
        $idReservation          = $_GET["idReservation"];
        $userName               = $_GET["userName"];
        $reservationDateChoosen = $_GET["reservationDate"];
        $filterStartHour        = $_GET["startHour"];
        $filterEndHour          = $_GET["endHour"];
        $filterZoneName         = $_GET["zoneName"];

        // Este código indica si se está accediendo desde la vista reservationsList.php o desde myReservationsList.php
        if(isset($_GET["path"])){
            $_SESSION["reservationList"] = $_GET["path"];
        } 
   ?>
    <p class="d-none" id="idReservation"><?php echo $idReservation ?></p>
    <header>
        <?php include("../php/header.php");?>
      <header>

    <div class="container">
        
        <h2><?php if ($idReservation == " " || $idReservation == "" ) {?> CREAR NUEVA RESERVA <?php } else {?> MODIFICACIÓN RESERVA <?php }?></h2>
        <form method="post" action="#" autocomplete="off" id="searchReservationForm" name="searchReservationForm" onsubmit="return validateSearchReservation()">
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="filterUserName" class="col-lg-3 col-form-label"><i class="fas fa-user"></i> Nombre usuario</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="filterUserName" name="filterUserName" placeholder="Introduce nombre y apellidos" value ="<?php echo $userName ?>" <?php if($userName != ""){ ?> readonly <?php }?>  >
                    <div class="invalid-feedback" id="errorFilterUserName"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="reservationDateChoosen" class="col-lg-3 col-form-label"><i class="fas fa-calendar-alt"></i> Fecha reserva</label>
                <div class="col-lg-7">
                    <input type="date" min="<?php echo $reservationsConfig[0]->start_free_date ?>" max="<?php echo $reservationsConfig[0]->end_free_date ?>" class="form-control" id="reservationDateChoosen" name="reservationDateChoosen" value ="<?php echo $reservationDateChoosen ?>">
                    <div class="invalid-feedback" id="errorReservationDateChoosen"></div>
                </div>
            </div>

            <?php include("../php/dropdowns.php");?>
            
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="filterStartHour" class="col-lg-3 col-form-label"><i class="fas fa-clock"></i> Hora desde</label>
                <div class="col-lg-7 input-group">
                <select class="form-control" id="filterStartHour" name="filterStartHour">
                  <option value="">Cualquier hora</option>
                  <?php foreach($hours as $startHour):?>
                   <option value="<?php echo $startHour->start_hour?>" <?php if ($startHour->start_hour == $filterStartHour) {?> selected <?php } ?>  >
                    <?php echo $startHour->start_hour?> 
                   </option>
                  <?php endforeach; ?>
                </select>  
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="filterEndHour" class="col-lg-3 col-form-label"><i class="fas fa-clock"></i> Hora hasta</label>
                <div class="col-lg-7 input-group">
                <select class="form-control" id="filterEndHour" name="filterEndHour">
                  <option value="">Cualquier hora</option>
                  <?php foreach($hours as $endHour):?>
                   <option value="<?php echo $endHour->end_hour?>" <?php if ($endHour->end_hour == $filterEndHour) {?> selected <?php } ?>  >
                    <?php echo $endHour->end_hour?> 
                   </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback" id="errorFilterEndHour"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="filterZoneName" class="col-lg-3 col-form-label"><i class="fas fa-map-signs"></i> Elije zona</label>
                <div class="col-lg-7 input-group">
                <select class="form-control" name="filterZoneName">
                  <option value="">Todas las zona</option>
                  <?php foreach($zones as $zone):?>
                   <option value="<?php echo $zone->zone_name?>" <?php if ($zone->zone_name == $filterZoneName) {?> selected <?php } ?> >
                    <?php echo $zone->zone_name?>
                  </option>
                  <?php endforeach; ?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
        </form>
    
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <p class="border-bottom"><b>DISPONIBILIDAD:</b> </p>
            </div>
        </div>

        <?php
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
        ?>

        <form method="post" id="reservationForm" name="reservationForm" action="#" autocomplete="off" onsubmit="reservate()">
            <fildset class="form-group row"><!--Este div aparecerá por cada uno de las posibles reservas a elegir-->
                <div class="col-lg-1"></div>
                <div class="col-lg-10"> 
                    <div class="form-check">
                        <?php if (isset($_SESSION["sessionReservations"])) {
                            foreach($_SESSION["sessionReservations"] as $reservation):?>
                            <input class="form-check-input" type="radio" id="reservationChoosen" name="reservationChoosenArray" value="<?php echo $reservation->idHourClass ?>, <?php echo $reservation->idZoneClass ?>">
                            <label class="form-check-label d-block" for="radio" >
                                <?php
                                    $count++;
                                    $date = new DateTime( $reservation->reservationDateChoosenClass); 
                                    echo $reservation->reservationDayClass . " " .
                                    $date->format("d/m/Y") . " de " . 
                                    $reservation->startHourClass . " a " .
                                    $reservation->endHourClass . " - " .
                                    $reservation->zoneNameClass . " - " ;
                                    for($i = 0; $i < $reservation->freeReservationsClass; $i++){?>
                                        <i title="Libre" class="fas fa-user"></i>
                                    <?php
                                    }
                                    for($x = 0; $x < $reservation->busyReservationsClass; $x++){?>
                                        <i title="Ocupado" class="fas fa-user textUserDisabled"></i>
                                    <?php
                                    }
                                    ;
                                ?> 
    
                            </label>
                        <?php endforeach; }?> 
                    </div>    
                </div>
            </fildset>
            <?php if ($count != 0) {?>
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <button type="submit" id= "reservationButton" class="btn btn-primary"
                        <?php if ($idReservation == " " || $idReservation == "" ) {?> formaction="../php/insertReservation.php?userName=<?php echo $userName?>&reservationDate=<?php echo $reservationDateChoosen?>&startHour=<?php echo $filterStartHour?>&endHour=<?php echo $filterEndHour?>&zoneName=<?php echo $filterZoneName?>" value="insertReservation"
                        <?php } else {?> formaction="../php/updateReservation.php?idReservation=<?php echo $idReservation?>&userName=<?php echo $userName?>&reservationDate=<?php echo $reservationDateChoosen?>&startHour=<?php echo $filterStartHour?>&endHour=<?php echo $filterEndHour?>&zoneName=<?php echo $filterZoneName?>" value="updateReservation" <?php }?>>
                        <i class="far fa-calendar-check"></i> Reservar
                    </button>
                </div>
            </div> 
            <?php } ?>
        </form>
                        
    </div>
   
    <?php 
        if (isset($_SESSION["sessionReservations"])){
            unset ($_SESSION["sessionReservations"]);
        }

        include "../php/message.php"; 
    ?>
    
    <!-- Scripts para Bootstrap 4-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    
    <!-- Scripts para la lógica de la app-->
    <script src="../scripts/main.js"></script>
</body>
</html>