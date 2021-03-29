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

    <!-- Recuperamos la información de la lista de reservas-->
    <?php
        $idReservation         = $_GET["idReservation"];
        $userId                = $_GET["userId"];
        $userName              = $_GET["userName"];
        $filterReservationDate = $_GET["reservationDate"];
        $filterStartHour       = $_GET["startHour"];
        $filterEndHour         = $_GET["endHour"];
        $zoneName              = $_GET["zoneName"];
   ?>

    <header>
        <?php include("../php/header.php");?>
      <header>

    <div class="container">
        
    
        <h2><?php if ($idReservation == " ") {?> CREAR NUEVA RESERVA <?php } else {?> MODIFICACIÓN RESERVA <?php }?></h2>
        <form>
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputUserName" class="col-lg-3 col-form-label"><i class="fas fa-user"></i> Nombre usuario</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="inputUserName" name="inputUserName" placeholder="Introduce nombre y apellidos" value ="<?php echo $userName ?>" <?php if($userName != ""){ ?> disabled <?php }?>  >
                    <div class="invalid-feedback" id="errorUserName"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputData" class="col-lg-3 col-form-label"><i class="fas fa-calendar-alt"></i> Fecha reserva</label>
                <div class="col-lg-7">
                    <input type="date" class="form-control" id="inputData" placeholder="Introduce tu usuario" value ="<?php echo $filterReservationDate ?>">
                    <div class="invalid-feedback" id="errorDateReservation"></div>
                </div>
            </div>

            <?php include("../php/dropdowns.php");?>
            
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="filterStartHour" class="col-lg-3 col-form-label"><i class="fas fa-clock"></i> Hora desde</label>
                <div class="col-lg-7 input-group">
                <select class="form-control" name="filterStartHour">
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
                <select class="form-control" name="filterEndHour">
                  <option value="">Cualquier hora</option>
                  <?php foreach($hours as $endHour):?>
                   <option value="<?php echo $endHour->end_hour?>" <?php if ($endHour->end_hour == $filterEndHour) {?> selected <?php } ?>  >
                    <?php echo $endHour->end_hour?> 
                   </option>
                  <?php endforeach; ?>
                </select>
                </div>
            </div>



            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="selectZoneReservation" class="col-lg-3 col-form-label"><i class="fas fa-map-signs"></i> Elije zona</label>
                <div class="col-lg-7 input-group">
                <select class="form-control" name="selectZoneReservation" >
                  <option value="">Zona</option>
                  <?php foreach($zones as $zone):?>
                   <option value="<?php echo $zone->zone_name?>" <?php if ($zone->zone_name == $zoneName) {?> selected <?php } ?> >
                    <?php echo $zone->zone_name?>
                  </option>
                  <?php endforeach; ?>
                </select>
                    <div class="invalid-feedback" id="errorZoneReservation"></div>
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

        <div class="row"><!--Este div aparecerá por cada uno de las posibles reservas a elegir-->
            <div class="col-lg-1"></div>
            <div class="col-lg-10"> 
                <input class="" type="radio">
                <label for="">Lunes 08/03/2021 de 18:30 - 1930h - Volúmenes - <i class="fas fa-user"></i> <i class="fas fa-user"></i> <i class="fas fa-user"></i></label>
            </div>
        </div>

    </div>
    <!-- Scripts para Bootstrap 4-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>