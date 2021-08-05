<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Zonas</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body>
  <header>
    <?php 
      include("../php/header.php");
      
      //Si algún usuario que no es administrador, intenta entrar en esta página que es de acceso único a administradores, se redirigirá al menú
      if (isset($_SESSION["sessionIdUser"]) && $_SESSION['sessionUserType'] != "A"){
        header("Location: userMenu.php" );
      }
    ?>
  <header>
  
  <h2>GESTIÓN DE ZONAS</h2>

  <div class="container">      
    <table class="table">  
      <thead>
        <tr>
          <th>ZONA</th>
          <th class="text-center">MÁXIMO Nº USUARIOS</th>
          <th class="text-center">ESTADO</th>
          <th class="text-center">OPCIONES</th>
        </tr>
      </thead>

      <tbody>
      <!--Llamamos a leer zonas para cargar la lista de zonas -->
      <?php include("../php/readZones.php")?>
        <!--Por cada zona que exista en la base de datos, tendrá que aparecer un registro-->
        <?php if(isset($zones)){ foreach($zones as $zone):?>
          <tr> 
            <td data-label="ZONA:" id="zoneZM" name="zoneZM"><?php echo $zone->zone_name?></td>
            <td data-label="MAX. USUARIOS:" id="maxUserNumberZM" name="maxUserNumberZM" class="text-center"><?php echo $zone->max_users_zone?></td>
            <td data-label="ESTADO:" id="zoneStatusZM" name="zoneStatusZM" class="text-center">
              <?php if ($zone->zone_status == "A") { ?>
                <i class="fas fa-check text-success" title="Activa"></i> 
              <?php } else if ($zone->zone_status == "I"){ ?>
                <i class="fas fa-times text-danger" title="Inactiva"></i> 
              <?php } ?>
            </td>
            <!--Botones Actualizar y Eliminar -->
            <td data-label="" class="d-flex justify-content-center">
              <a href="zone.php?Id=<?php echo $zone->id_zone?>&zoneName=<?php echo $zone->zone_name?>&maxUserNumber=<?php echo $zone->max_users_zone?>&zoneStatus=<?php echo $zone->zone_status?>">
                <i title="Modificar" class="far fa-edit fa-lg cursorHand text-primary mr-4"></i>
              </a>              
              <a href="../php/deleteZone.php?Id=<?php echo $zone->id_zone?>&zoneName=<?php echo $zone->zone_name?>">
                <i title="Eliminar" class="far fa-trash-alt fa-lg text-danger "></i>
              </a> 
            </td>
          </tr>
        <?php endforeach; ?> <?php }?>
      </tbody>
    </table>

    <div class="row">
      <div class="col-12">
      <?php 
        if (count($zones) == 0) {?>
          <p>No existen zonas.</p>
        <?php }?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <a href="zone.php?Id= &zoneName=&maxUserNumber=&zoneStatus=" class="btn btn-primary">Crear zona</a>
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