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
        // Recuperamos la información de la lista de reservas
        $idReservation          = $_GET["idReservation"];
        $userName               = $_GET["userName"];
        $reservationDateChoosen = $_GET["reservationDate"];
        $filterStartHour        = $_GET["startHour"];
        $filterEndHour          = $_GET["endHour"];
        $filterZoneName         = $_GET["zoneName"];
        
        // Recuperamos las fechas en las que se puede hacer reservas, el número máximo de reservas por usuario y el total de usuarios en la zona de vías
        include("../php/readReservationConfig.php");
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
                    <input type="text" class="form-control" id="filterUserName" name="filterUserName" placeholder="Introduce nombre y apellidos" value ="<?php echo $userName ?>" <?php if($userName != "" && !isset($_SESSION['sessionErrorLookingForUser'])){ ?> readonly <?php }?> >
                    <?php if (isset($_SESSION['sessionErrorLookingForUser'])){ //Eliminamos el indicador de error al buscar el nombre por un admin
                        unset ($_SESSION['sessionErrorLookingForUser']);
                    } ?>
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
                <div class="invalid-feedback" id="errorFilterStartHour"></div>
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
                  <option value="">Todas las zonas</option>
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

        <form method="post" action="#" autocomplete="off" id="reservationForm" name="reservationForm" onsubmit="return reservate(<?php if ($idReservation == ' ' || $idReservation == '' ) { ?> 'btnInsertReservation' <?php } else {?>  'btnUpdateReservation' <?php }?>)">
            <fildset class="form-group row"><!--Este div aparecerá por cada uno de las posibles reservas a elegir-->
                <div class="col-lg-1"></div>
                <div class="col-lg-10"> 
                    <div class="form-check">
                        <?php if (isset($_SESSION["sessionReservations"])) {
                            foreach($_SESSION["sessionReservations"] as $reservation):?>
                            <input class="form-check-input" type="radio" onclick="checkZoneReservation()" id="reservationChoosen" name="reservationChoosenArray" value="<?php echo $reservation->idHourClass ?>, <?php echo $reservation->idZoneClass ?>, <?php echo $reservation->zoneNameClass?>, <?php echo $reservation->startHourClass?>, <?php echo $reservation->endHourClass?>"  data-toggle="modal" data-target="#exampleModal">
                            <label  class="form-check-label d-block" for="reservationChoosen" >
                                <?php
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
                                        <i title="Ocupado" class="fas fa-user-slash"></i>
                                    <?php
                                    }
                                    ;
                                ?> 
    
                            </label>
                        <?php endforeach; }?> 
                    </div>    
                </div>
            </fildset>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <i class="fas fa-exclamation-triangle modalIcon modalIconWarning"></i>   
                        
                    <h5 id="exampleModalLabel">ATENCIÓN:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div  class="modal-body">
                        <div id="textR1R4R5" class="d-none">
                            <p> Para reservar en las vías R1, R4 y R5 se necesita una cordada, por lo que es necesario que escribas el número de tarjeta de tu compañero/a.</p>
                        </div>
                        <div id="textR2R3" class="d-none">
                            <p>Estás intentando hacer una reserva en la zona de vías con autoasegurador. Por favor, selecciona una opción:</p>
                            <input  type="radio" onclick="checkAutoasegurador()" id="conAutoasegurador" name="autoasegurador" value="" checked>
                            <label  class="form-check-label " for="conAutoasegurador">Iré solo/a (utilizaré el auto asegurador)</label> </br>
                            <input  type="radio" onclick="checkAutoasegurador()" id="sinAutoasegurador" name="autoasegurador" value="">
                            <label  class="form-check-label " for="sinAutoasegurador">Iré con un/a compañero/a de cordada</label> 
                            <div id="divRopeTeam" class="d-none mt-3">
                                <p> Por favor, indica el número de tarjeta de tu compañero/a de cordada.</p>
                            </div>
                        </div>
                        <div id="textPlafonCaballo" class="ad-none">
                            <p>Por motivos de seguridad (COVID), en esta zona sólo puede haber reservas simultáneas de personas del mismo núcleo familiar. 
                            <p>Como esta aplicación es incapaz de conocer esa información, la escuela de escala confía en que serás responsable y solo reservarás en esta zona en caso de que no exista ninguna reserva ya hecha o si la reserva hecha, pertenece a una personas de tu mismo nucleo familiar.</p> 
                            <p>Para saber si ya se ha hecho una reserva, fíjate en los motigotillos que aparecen al lado de cada una de las reservas disponibles: </p>
                            <ul>
                                <li><i title="Libre"   class="fas fa-user pr-2"></i> Significa reserva libre  </li>
                                <li><i title="Ocupado" class="fas fa-user-slash pr-2"></i>Significa que ya existe una reserva hecha</li>
                            </ul>
                            <p> ¡Gracias por tu colaboración!</p>            
                        </div>

                        <div id="textOthers" class="d-none">
                            <?php if ($idReservation == ' ' || $idReservation == '' ) { ?>
                                <p> Estás a punto de crear una nueva reserva. ¿Deseas continuar?</p>
                            <?php } else { ?>        
                                <p> Estás a punto de modificar la reserva. ¿Deseas continuar?</p> </br>
                            <?php } ?> 

                            <?php if (($idReservation == ' ' || $idReservation == '' ) && $_SESSION['userType'] == "M") {?>
                                <input  type="checkbox" id="doubleReservationWithMinor" value="<?php echo $_SESSION['cardNumberDoubleReservationWithMinor']?>">
                                <label  class="form-check-label " for="doubleReservationWithMinor">Marca la casilla si harás la reserva acompañado por un/a menor</label> 
                            <?php }?>
                        </div>

                        <div id="idcardNumberRopeTeam" class="form group-row d-none">
                            <input type="text" maxlength="6" id="cardNumberRopeTeam" name="cardNumberRopeTeam" class="form-control" placeholder="Escribe el nº de tarjeta de tu compañero/a"> 
                            <div class="invalid-feedback" id="errorCardNumberRopeTeam"></div>
                        </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
                    <?php if ($idReservation == " " || $idReservation == "" ) {?> 
                        <button type="submit" id= "btnInsertReservation" class="btn btn-primary" data-formAction="../php/insertReservation.php?idReservation=<?php echo $idReservation?>&userName=<?php echo $userName?>&reservationDate=<?php echo $reservationDateChoosen?>&startHour=<?php echo $filterStartHour?>&endHour=<?php echo $filterEndHour?>&zoneName=<?php echo $filterZoneName?>"> <i class="far fa-calendar-check"></i> Reservar </button>
                    <?php } else {?> 
                        <button type="submit" id= "btnUpdateReservation" class="btn btn-primary" data-formAction="../php/updateReservation.php?idReservation=<?php echo $idReservation?>&userName=<?php echo $userName?>&reservationDate=<?php echo $reservationDateChoosen?>&startHour=<?php echo $filterStartHour?>&endHour=<?php echo $filterEndHour?>&zoneName=<?php echo $filterZoneName?>" > <i class="far fa-calendar-check"></i> Modificar reserva </button> 
                    <?php }?>>
                  </div>
                </div>
              </div>
            </div>
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