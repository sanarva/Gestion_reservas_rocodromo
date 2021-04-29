<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Listado reservas</title>

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
    //Recuperamos la fecha actual y modificamos el estado de la reserva a Inactiva en caso de que ya haya pasado el día
    include("../php/inactivateReservations.php");
    
    //Recuperamos los valores que nos llegan a través del GET
    $filterDateFrom             = $_GET["dateFrom"];
    $filterDateTo               = $_GET["dateTo"];
    $filterUserName             = $_GET["userName"];
    $filterCardNumber           = $_GET["cardNumber"];
    $filterStartHour            = $_GET["startHour"];
    $filterEndHour              = $_GET["endHour"];
    $filterZoneName             = $_GET["zoneName"];
    $filterAllStatusReservation = $_GET["allStatusReservation"]; 
  ?>

  <header>
    <?php 
      include("../php/header.php");
      //Con esta variable de sesión indicamos que estamos accediendo a la creación/mantenimiento de reservas desde la lista general de reservas
      $_SESSION["reservationsList"] = "Y";
    ?>

  <header>  

  <div class="container">
    <h2>GESTIÓN DE RESERVAS</h2>
    <?php include("../php/readReservationConfig.php");?>
    <form method="post" action="#" autocomplete="off" id="reservationsConfigForm" name="reservationsConfigForm" onsubmit="return validateReservationsConfigForm()">
      <div class="form-group row">
        <div class="col-lg-1 "></div>
        <label for="maxReservationsByUser" class="col-lg-3 col-form-label"><i class="fas fa-user-friends"></i> Nº máximo reservas</label>
        <div class="col-lg-7">
          <input type="text" maxlength="2" class="form-control"  id="maxReservationsByUser" name="maxReservationsByUser" placeholder="Introduce el número máximo de reservas por usuario" value ="<?php echo  $reservationsConfig[0]->max_reservation ?>">
          <!-- Mensaje de error por formato incorrecto en número máximo de reservas por usuario -->
          <div class="invalid-feedback" id="errorMaxReservationsByUser"></div>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-lg-1 "></div>
        <label for="maxNumberUsersRoute" class="col-lg-3 col-form-label"><i class="fas fa-users"></i> Máx. usuarios vías</label>
        <div class="col-lg-7">
          <input type="text" maxlength="2" class="form-control"  id="maxNumberUsersRoute" name="maxNumberUsersRoute" placeholder="Introduce el número máximo total de usuarios en vías" value ="<?php echo  $reservationsConfig[0]->max_users_route ?>">
          <!-- Mensaje de error por formato incorrecto en el nombre de la zona -->
          <div class="invalid-feedback" id="errorMaxNumberUsersRoute"></div>
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-lg-1 "></div>
        <label for="startFreeDate" class="col-lg-3 col-form-label"><i class="fas fa-calendar-check"></i> Abrir período</label>
        <div class="col-lg-7">
          <input autofocus type="date" class="form-control" id="startFreeDate" name="startFreeDate" value ="<?php echo  $reservationsConfig[0]->start_free_date ?>">
          <!-- Mensaje de error por formato incorrecto en la fecha de apertura -->
          <div class="invalid-feedback" id="errorStartFreeDate"></div>
        </div>
      </div>
      
      <div class="form-group row">
        <div class="col-lg-1 "></div>
        <label for="endFreeDate" class="col-lg-3 col-form-label"><i class="fas fa-calendar-check"></i> Cerrar período</label>
        <div class="col-lg-7">
          <input type="date" class="form-control" id="endFreeDate" name="endFreeDate" value ="<?php echo  $reservationsConfig[0]->end_free_date ?>">
          <!-- Mensaje de error por formato incorrecto en la fecha de cierre -->
          <div class="invalid-feedback" id="errorEndFreeDate"></div>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-lg-1"></div>
        <div class="col-lg-8">
          <button type="submit" class="btn btn-primary mb-5"><i class="far fa-save"></i> Guardar configuración</button>
        </div>
      </div>

    </form>

    <h2>LISTADO RESERVAS ROCÓDROMO</h2>

    <!-- Aquí se muestran los campos para poder filtrar en la lista --> 
    <p class="border-bottom">Filtros:</p>
    <form method="post" action="../php/readReservations.php" autocomplete="off">     
      <div class="filterLayoutItems">
        <label for="filterDateFrom" class="col-form-label d-block"><i class="far fa-calendar-alt"></i> Fecha desde:</label>
        <input type="date" class="form-control" name="filterDateFrom" id="filterDateFrom" value = <?php echo $filterDateFrom?>>
      </div>  
      <div class="filterLayoutItems">
        <label for="filterDateTo" class="col-form-label d-block"><i class="far fa-calendar-alt"></i> Fecha hasta:</label>
        <input type="date" class="form-control" name="filterDateTo" id="filterDateTo" value = <?php echo $filterDateTo?>>
      </div>
      
      <div class="filterLayoutItems">
        <label for="filterUserName" class="col-form-label d-block"><i class="far fa-user"></i> Usuario:</label>
        <input type="text" class="form-control" name="filterUserName" id="filterUserName" value = <?php echo $filterUserName?>>
      </div>
      
      <div class="filterLayoutItems">
        <label for="filterCardNumber" class="col-form-label d-block"><i class="far fa-address-card"></i> Nº tarjeta:</label>
        <input type="text" class="form-control" maxlength="6" name="filterCardNumber" id="filterCardNumber" value = <?php echo $filterCardNumber?>>
      </div>

      <?php include("../php/dropdowns.php");?>

      <div class="filterLayoutItems">
        <label for="filterStartHour" class="col-form-label d-block"><i class="far fa-clock"></i> Hora inicio:</label>
        <select class="form-control" name="filterStartHour">
          <option value="">Cualquier hora</option>
          <?php foreach($hours as $startHour):?>
           <option value="<?php echo $startHour->start_hour?>" <?php if ($startHour->start_hour == $filterStartHour) {?> selected <?php } ?>  >
            <?php echo $startHour->start_hour?> 
           </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filterLayoutItems">
        <label for="filterEndHour" class="col-form-label d-block"><i class="far fa-clock"></i> Hora fin:</label>
        <select class="form-control" name="filterEndHour" >
          <option value="">Cualquier hora</option>
          <?php foreach($hours as $endHour):?>
           <option value="<?php echo $endHour->end_hour?>" <?php if ($endHour->end_hour == $filterEndHour) {?> selected <?php } ?>>
            <?php echo $endHour->end_hour?> 
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filterLayoutItems">
        <label for="filterZoneName" class="col-form-label d-block"><i class="fas fa-map-signs"></i> Zona:</label>
        <select class="form-control" name="filterZoneName" >
          <option value="">Todas las zonas</option>
          <?php foreach($zones as $zone):?>
           <option value="<?php echo $zone->zone_name?>" <?php if ($zone->zone_name == $filterZoneName) {?> selected <?php } ?> >
            <?php echo $zone->zone_name?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filterLayoutItems">
        <input  type="checkbox" name="filterAllStatusReservation" id="filterAllStatusReservation" <?php if ($filterAllStatusReservation == "on") {?> checked <?php } ?>>
        <label class="col-form-label" for="filterAllStatusReservation" class="col-form-label">Mostrar reservas inactivas</label>
      </div>

      <div class="row mt-2">
        <div class="col-12">
          <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
      </div>
    </form>
    
    <!-- Aquí se muestra la tabla donde ser verá la lista de reservas -->
    <table class="table  mt-5">
      <thead>
          <tr>
            <th>FECHA</th>
            <th>HORA</th>
            <th>ZONA</th>
            <th>USUARIO</th>
            <th class="text-center">Nº TARJETA</th>
            <th class="text-center">ESTADO</th>
            <th class="text-center">OPCIONES</th>
          </tr>
      </thead>
      <tbody>
      <!--Llamamos a leer reservas para cargar la lista de reservas -->
      <?php
        if ((!isset($_SESSION["searchReservations"]))){
          include("../php/readReservations.php");
        } else {
          $reservations = $_SESSION["searchReservations"]; 
        }
      ?>
      <!--Por cada reserva que exista en la base de datos, tendrá que aparecer un registro-->
      <?php if(isset($reservations)){ foreach($reservations as $reservation):?>
        <tr> <!--Por cada reserva que exista en la base de datos, tendrá que aparecer un registro-->
          <td data-label="FECHA:">
            <?php //Esta función cambia el formato de la fecha dándole la vuelta y poníendole barras en lugar de guiones
              $date = new DateTime( $reservation->reservation_date);
              echo $date->format("d/m/Y");
            ?>
          </td>
          <td data-label="HORA:"><?php echo $reservation->start_hour . " - " . $reservation->end_hour . "h"?></td>
          <td data-label="ZONA:"><?php echo $reservation->zone_name?></td>
          <td data-label="USUARIO:"><?php echo $reservation->user_name?></td>
          <td data-label="Nº TARJETA:" class="text-center"><?php echo $reservation->card_number?></td>
          <td data-label="ESTADO:" class="text-center">
              <?php if ($reservation->reservation_status == "A") { ?>
                <i class="fas fa-check text-success" title="Activo"></i> 
              <?php } else if ($reservation->reservation_status == "I"){ ?>
                <i class="fas fa-times text-danger" title="Inactivo"></i> 
                <?php } else if ($reservation->reservation_status == "P" || $reservation->reservation_status == "C"){ ?>
                <i class="fas fa-hourglass-half text-warning" title="Pendiente confirmación"></i> 
              <?php } else if ($reservation->reservation_status == "W"){ ?>
                <i class="fas fa-link text-success" title="Reserva doble"></i> 
              <?php } ?>
          </td>
          <!--Botones Actualizar / Eliminar / Cancelar reservas-->
          <td  data-label="" class="d-flex justify-content-center">
            <!--Se inhabilita el botón de actualizar si el estado de la reserva en inactiva, pendiente de confirmar o de autoasegurador -->
            <?php if ($reservation->reservation_status == "I") {?>
              <i title="No se puede modificar una reserva inactiva" class="far fa-edit fa-lg textPrimaryDisabled mr-4"></i>
            <?php }else if ($reservation->reservation_status == "A" || $reservation->reservation_status == "P"  || $reservation->reservation_status == "W"){?>  
            <a href="reservation.php?idReservation=<?php echo $reservation->id_reservation?>&userName=<?php echo $reservation->user_name?>&reservationDate=<?php echo $reservation->reservation_date?>&startHour=<?php echo $reservation->start_hour?>&endHour=<?php echo $reservation->end_hour?>&zoneName=<?php echo $reservation->zone_name?>">
              <i title="Modificar" class="far fa-edit fa-lg cursorHand text-primary mr-4"></i>
            </a> 
            <?php }else if ($reservation->reservation_status == "C"){?>  
              <a href="../php/updateReservation.php?idReservation=<?php echo $reservation->id_reservation?>&userId=<?php echo $reservation->user_id?>&userName=<?php echo $reservation->user_name?>&confirmReservation&reservationDate=<?php echo $date->format("d/m/Y")?>&startHour=<?php echo $reservation->start_hour?>&endHour=<?php echo $reservation->end_hour?>&zoneName=<?php echo $reservation->zone_name?>">
              <i title="Confirmar" class="far fa-check-circle fa-lg cursorHand text-primary mr-4"></i>
            </a> 
            <?php }?>

            <!--Si el estado de la reserva es activa o pendiente de confirmar o de autoasegurador, se cambia el botón de eliminar por el de cancelar-->
            <?php if ($reservation->reservation_status == "I") {?>
              <a href="../php/deleteReservation.php?Id=<?php echo $reservation->id_reservation?>"> 
              <i title="Eliminar" class="far fa-trash-alt fa-lg text-danger "></i>
            <?php }else {?>  
              <a href="../php/updateReservation.php?idReservation=<?php echo $reservation->id_reservation?>&userId=<?php echo $reservation->user_id?>&userName=<?php echo $reservation->user_name?>&cancelReservation&reservationDate=<?php echo $date->format("d/m/Y")?>&startHour=<?php echo $reservation->start_hour?>&endHour=<?php echo $reservation->end_hour?>&zoneName=<?php echo $reservation->zone_name?>">
              <i title="Cancelar" class="far fa-times-circle fa-lg text-danger"></i>
            </a> 
            <?php }?>
          </td>
        </tr>
      <?php endforeach; ?> <?php }?>
      </tbody>
    </table>
    <div class="row">
      <div class="col-12">
      <?php 
        if (count($reservations) == 0) {?>
          <p>No se han encontrado coincidencias.</p>
        <?php }?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <a class="btn btn-primary" href="reservation.php?idReservation= &userName=&reservationDate=&startHour=&endHour=&zoneName=">Crear reserva</a>
      </div>
    </div>
    

  </div>

  <?php   
    if (isset($_SESSION['confirmation'])) {
      include "../php/confirmation.php";
    }

    if (isset($_SESSION['successFlag'])) { 
      include "../php/message.php";
    }

    if (isset($_SESSION["searchReservations"])){
      unset ($_SESSION["searchReservations"]);
    }
  ?>

  <!-- Scripts para Bootstrap 4-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

  <!-- Scripts para la lógica de la app-->
  <script src="../scripts/main.js"></script>
</body>

</html>