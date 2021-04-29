<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Mis reservas</title>

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
  
  //Con esta variable de sesión indicamos que estamos accediendo a la creación/mantenimiento de reservas desde mi lista de reservas
  $_SESSION["reservationsList"] = "";
  ?>

  <header>
    <?php include("../php/header.php");?>
  <header>
  
  <h2>MIS RESERVAS</h2>

  <div class="container">      
    <!-- Aquí se muestra la tabla donde ser verá la lista de reservas -->
    <table class="table  mt-5">
      <thead>
          <tr>
            <th>USUARIO</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>ZONA</th>
            <th class="text-center">ESTADO</th>
            <th class="text-center">OPCIONES</th>
          </tr>
      </thead>

      <tbody>
      <!--Llamamos a leer reservas para cargar la lista de reservas -->
      <?php
        $filterUserName = $_SESSION["sessionUserName"];
        include("../php/readReservations.php");
      ?>
      <!--Por cada reserva que exista en la base de datos, tendrá que aparecer un registro-->
      <?php if(isset($reservations)){ foreach($reservations as $reservation):?>
        <tr> <!--Por cada reserva que exista en la base de datos, tendrá que aparecer un registro-->
          <td data-label="USUARIO:"><?php echo $reservation->user_name?></td>
          <td data-label="FECHA:">
            <?php //Esta función cambia el formato de la fecha dándole la vuelta y poníendole barras en lugar de guiones
              $date = new DateTime( $reservation->reservation_date);
              echo $date->format("d/m/Y");
            ?>
          </td>
          <td data-label="HORA:"><?php echo $reservation->start_hour . " - " . $reservation->end_hour . "h"?></td>
          <td data-label="ZONA:"><?php echo $reservation->zone_name?></td>
          <td data-label="ESTADO:" class="text-center">
              <?php if ($reservation->reservation_status == "A") { ?>
                <i class="fas fa-check text-success" title="Activo"></i> 
              <?php } else if ($reservation->reservation_status == "I"){ ?>
                <i class="fas fa-times text-danger" title="Inactivo"></i>
              <?php } else if ($reservation->reservation_status == "W"){ ?>
                <i class="fas fa-link text-success" title="Reserva doble"></i> 
              <?php } else if ($reservation->reservation_status == "P" || $reservation->reservation_status == "C"){ ?>
                <i class="fas fa-hourglass-half text-warning" title="Pendiente confirmación"></i> 
              <?php } ?>
          </td>
           <!--Botones Actualizar y Eliminar -->
          <td data-label="" class="d-flex justify-content-center" >
          <?php if ($reservation->reservation_status == "C") {?>
            <a href="../php/updateReservation.php?idReservation=<?php echo $reservation->id_reservation?>&confirmReservation"> 
              <i title="Confirmar" class="far fa-check-circle fa-lg cursorHand text-primary mr-4"></i>
            </a> 
          <?php }else {?>
            <a href="reservation.php?idReservation=<?php echo $reservation->id_reservation?>&userName=<?php echo $_SESSION['sessionUserName']?>&reservationDate=<?php echo $reservation->reservation_date?>&startHour=<?php echo $reservation->start_hour?>&endHour=<?php echo $reservation->end_hour?>&zoneName=<?php echo $reservation->zone_name?>">
              <i title="Modificar" class="far fa-edit fa-lg cursorHand text-primary mr-4"></i>
            </a>
          <?php }?>

            <a href="../php/updateReservation.php?idReservation=<?php echo $reservation->id_reservation?>&cancelReservation"> 
              <i title="Cancelar" class="far fa-times-circle fa-lg text-danger "></i>
            </a> 
          </td>
        </tr>
      <?php endforeach; ?> <?php }?>

      </tbody>
    </table>
    <div class="row">
      <div class="col-12">
      <?php 
        if (count($reservations) == 0) {?>
          <p>No tienes reservas pendientes.</p>
        <?php }?>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <!-- Si el usuario es genérico y tiene ya dos reservas activas, deshabilitamos el botón de crear -->
        <a class="btn btn-primary" href="reservation.php?idReservation= &userName=<?php echo $_SESSION["sessionUserName"]?>&reservationDate=&startHour=&endHour=&zoneName=">Crear reserva</a>
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
  ?>
    
  <!-- Scripts para Bootstrap 4-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  
 </body>

</html>