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
    $searchDateFrom                =  $_GET["dateFrom"];
    $searchDateTo                  =  $_GET["dateTo"];
    $searchUserName                =  $_GET["userName"];
    $searchCardNumber              =  $_GET["cardNumber"];
    $searchStartHour               =  $_GET["startHour"];
    $searchEndHour                 =  $_GET["endHour"];
    $searchZoneName                =  $_GET["zoneName"];
    $checkAllReservationsFilterGet =  $_GET["checkAllReservationsFilterGet"];
  ?>

  <header>
    <?php include("../php/header.php");?>
  <header>  

  <h2>LISTADO RESERVAS ROCÓDROMO</h2>

  <div class="container">
    <!-- Aquí se muestran los campos para poder filtrar en la lista --> 
    <p class="border-bottom">Filtros:</p>
    <form method="post" action="../php/readReservations.php" autocomplete="off">     
      <div class="filterLayoutItems">
        <label for="dateFromFilter" class="col-form-label d-block"><i class="far fa-calendar-alt"></i> Fecha desde:</label>
        <input type="date" name="dateFromFilter" id="dateFromFilter" value = <?php echo $searchDateFrom?>>
      </div>  
      <div class="filterLayoutItems">
        <label for="dateToFilter" class="col-form-label d-block"><i class="far fa-calendar-alt"></i> Fecha hasta:</label>
        <input type="date" name="dateToFilter" id="dateToFilter" value = <?php echo $searchDateTo?>>
      </div>
      
      <div class="filterLayoutItems">
        <label for="userFilter" class="col-form-label d-block"><i class="far fa-user"></i> Usuario:</label>
        <input type="text" name="userFilter" id="userFilter" value = <?php echo $searchUserName?>>
      </div>
      
      <div class="filterLayoutItems">
        <label for="cardNumberFilter" class="col-form-label d-block"><i class="far fa-address-card"></i> Nº tarjeta:</label>
        <input type="text" name="cardNumberFilter" id="cardNumberFilter" value = <?php echo $searchCardNumber?>>
      </div>

      <?php include("../php/dropdowns.php");?>

      <div class="filterLayoutItems">
        <label for="hourStartFilter" class="col-form-label d-block"><i class="far fa-clock"></i> Hora inicio:</label>
        <select name="hourStartFilter">
          <option value="">Cualquier hora</option>
          <?php foreach($hours as $startHour):?>
           <option name="hourStartFilter" value="<?php echo $startHour->start_hour?>" <?php if ($startHour->start_hour == $searchStartHour) {?> selected <?php } ?>  >
            <?php echo $startHour->start_hour?> 
           </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filterLayoutItems">
        <label for="hourEndFilter" class="col-form-label d-block"><i class="far fa-clock"></i> Hora fin:</label>
        <select name="hourEndFilter" >
          <option value="">Cualquier hora</option>
          <?php foreach($hours as $endHour):?>
           <option value="<?php echo $endHour->end_hour?>" <?php if ($endHour->end_hour == $searchEndHour) {?> selected <?php } ?>>
            <?php echo $endHour->end_hour?> 
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filterLayoutItems">
        <label for="selectZoneFilter" class="col-form-label d-block"><i class="fas fa-map-signs"></i> Zona:</label>
        <select name="selectZoneFilter" >
          <option value="">Todas las zonas</option>
          <?php foreach($zones as $zone):?>
           <option value="<?php echo $zone->zone_name?>" <?php if ($zone->zone_name == $searchZoneName) {?> selected <?php } ?> >
            <?php echo $zone->zone_name?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filterLayoutItems">
        <input type="checkbox" name="checkAllReservationsFilter" id="checkAllReservationsFilter" <?php if ($checkAllReservationsFilterGet == "on") {?> checked <?php } ?>>
        <label for="checkAllReservationsFilter" class="col-form-label">Mostrar reservas inactivas</label>
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
          <td>
            <?php //Esta función cambia el formato de la fecha dándole la vuelta y poníendole barras en lugar de guiones
              $date = new DateTime( $reservation->reservation_date);
              echo $date->format("d/m/Y");
            ?>
          </td>
          <td><?php echo $reservation->start_hour . " - " . $reservation->end_hour . "h"?></td>
          <td><?php echo $reservation->zone_name?></td>
          <td><?php echo $reservation->user_name?></td>
          <td class="text-center"><?php echo $reservation->card_number?></td>
          <td class="text-center">
              <?php if ($reservation->reservation_status == "A") { ?>
                <i class="fas fa-check text-success" title="Activo"></i> 
              <?php } else if ($reservation->reservation_status == "I"){ ?>
                <i class="fas fa-times text-danger" title="Inactivo"></i> 
              <?php } ?>
          </td>
           <!--Botones Actualizar y Eliminar -->
          <td class="d-flex justify-content-center">
            <a href="../php/updateReservation.php?Id=<?php echo $reservation->id_reservation?>">
              <i title="Modificar" class="far fa-edit fa-lg cursorHand text-primary mr-4"></i>
            </a> 
            <a href="../php/deleteReservation.php?Id=<?php echo $reservation->id_reservation?>">
              <i title="Eliminar" class="far fa-trash-alt fa-lg text-danger "></i>
            </a> 
          </td>
        </tr>
      <?php endforeach; ?> <?php }?>
      </tbody>
    </table>

    <div class="row">
      <div class="col-12">
        <a class="btn btn-primary" href="reservation.php?Id= &userId=&reservationDate=&hourId=&zoneId=">Crear reserva</a>
      </div>
    </div>
    

  </div>

  <?php   
    if ( isset($_SESSION['confirmation'])) {
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
</body>

</html>