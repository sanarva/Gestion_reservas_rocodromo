<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Listado horarios</title>

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

      //Si algún usuario que no es administrador, intenta entrar en esta página que es de acceso único a administradores, se redirigirá al m
      if (isset($_SESSION["sessionIdUser"]) && $_SESSION['sessionUserType'] != "A"){
        header("Location: userMenu.php" );
      }
    ?>
  <header>
  
  <h2>GESTIÓN DE HORARIOS</h2>
  <div class="container">        
    <table class="table">
      <thead>
          <tr class="text-center">
            <th>HORA INICIO</th>
            <th>HORA FIN</th>
            <th>DIA</th>
            <th>OPCIONES</th>
          </tr>
      </thead>
       
      <tbody>
        <!--Llamamos a leer horas para cargar la lista de horas -->
        <?php include("../php/readHours.php");?>

        <!--Por cada hora que exista en la base de datos, tendrá que aparecer un registro-->
        <?php if(isset($hours)){ foreach($hours as $hour){?>
        <tr class="text-center"> 
          <td data-label="HORA INICIO:"><?php echo $hour->start_hour?></td>
          <td data-label="HORA FIN:"><?php echo $hour->end_hour?></td>
          <td data-label="DÍA:">
            <?php include("../php/checkWeekDay.php");?>
            <input type="checkbox"readonly onclick="javascript: return false;"  <?php if ($L == true) {?> checked <?php } ?> >
            <label for="monday">Lun</label> 
            <input type="checkbox" readonly onclick="javascript: return false;" <?php if ($M == true) {?> checked <?php } ?>>
            <label for="tuesday">Mar</label> 
            <input type="checkbox" readonly onclick="javascript: return false;" <?php if ($X == true) {?> checked <?php } ?>>
            <label for="wednesday">Mie</label> 
            <input type="checkbox" readonly onclick="javascript: return false;" <?php if ($J == true) {?> checked <?php } ?>>
            <label for="thursday">Jue</label> 
            <input type="checkbox" readonly onclick="javascript: return false;" <?php if ($V == true) {?> checked <?php } ?>>
            <label for="friday">Vie</label> 
            <input type="checkbox" readonly onclick="javascript: return false;" <?php if ($S == true) {?> checked <?php } ?>>
            <label for="saturday">Sab</label> 
            <input type="checkbox" readonly onclick="javascript: return false;" <?php if ($D == true) {?> checked <?php } ?>>
            <label for="sunday">Dom</label>            
          </td>
          
          <!--Botones Actualizar y Eliminar -->
          <td data-label="" class="d-flex justify-content-center">
            <a href="hour.php?Id=<?php echo $hour->id_hour?>&startHour=<?php echo $hour->start_hour?>&endHour=<?php echo $hour->end_hour?>&weekDay=<?php echo $hour->week_day?>">
              <i title="Modificar" class="far fa-edit fa-lg cursorHand text-primary mr-4"></i>
            </a>              
            <a href="../php/deletehour.php?Id=<?php echo $hour->id_hour?>&startHour=<?php echo $hour->start_hour?>&endHour=<?php echo $hour->end_hour?>&weekDay=<?php echo $hour->week_day?>">
              <i title="Eliminar" class="far fa-trash-alt fa-lg text-danger "></i>
            </a> 
          </td>
        </tr>
        <?php }} ?>
        

      </tbody>
    </table>

    <div class="row">
      <div class="col-12">
      <?php 
        if (count($hours) == 0) {?>
          <p>No existen franjas horarias.</p>
        <?php }?>
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <a href="hour.php?Id= &startHour=&endHour=&weekDay=" class="btn btn-primary" >Crear horario</a>
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

  <!-- Scripts para la lógica de la app-->
  <script src="../scripts/main.js"></script>

</body>

</html>