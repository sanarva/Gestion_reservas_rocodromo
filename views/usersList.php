<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Usuarios</title>

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
    $searchUserName         =  $_GET["userName"];
    $searchCardNumber       =  $_GET["cardNumber"];
    $checkAllUsersFilterGet =  $_GET["checkAllUsersFilterGet"];
  ?>
  <header>
    <?php include("../php/header.php");?>
  <header>

  <h2>GESTIÓN DE USUARIOS</h2>

  <div class="container">
    <!-- Aquí se muestran los campos para poder filtrar en la lista -->
    <p class="border-bottom">Filtros:</p>
    <form method="post" action="../php/readUsers.php" autocomplete="off" id="filterUsersForm" name="filterUsersForm">     
      <div class="filterLayoutItems">
        <label for="userNameFilter" class="col-form-label d-block"><i class="far fa-user"></i> Nombre usuario:</label>
        <input type="text" name="userNameFilter" id="userNameFilter" value = <?php echo $searchUserName?>>
      </div>
      
      <div class="filterLayoutItems">
        <label for="cardNumberFilter" class="col-form-label d-block"><i class="far fa-address-card"></i> Nº tarjeta:</label>
        <input type="text" name="cardNumberFilter" id="cardNumberFilter" value = <?php echo $searchCardNumber?>>
      </div>
     
      <div class="filterLayoutItems">
        <input type="checkbox" name="checkAllUsersFilter" id="checkAllUsersFilter"  <?php if ($checkAllUsersFilterGet == "on") {?> checked <?php } ?> >
        <label for="checkAllUsersFilter" class="col-form-label">Mostrar usuarios inactivos</label>
      </div>
      <div class="row mt-2">
        <div class="col-12">
          <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
      </div>
    </form>
    
    <!-- Aquí se muestra la tabla donde ser verá la lista de usuarios -->
    <table class="table  mt-5">
      <thead>
          <tr>
            <th>NOMBRE USUARIO</th>
            <th class="text-center">TIPO</th>
            <th class="text-center">Nº TARJETA</th>
            <th>EMAIL</th>
            <th class="text-center">ESTADO</th>
            <th class="text-center">OPCIONES</th>
          </tr>
      </thead>
      <tbody>
      <!--Llamamos a leer usuarios para cargar la lista de usuarios -->
      <?php 
        if ((!isset($_SESSION["searchUsers"]))){
          include("../php/readUsers.php");
        } else {
          $users = $_SESSION["searchUsers"]; 
        }
      ?>
        <!--Por cada reserva que exista en la base de datos, tendrá que aparecer un registro-->
        <?php if(isset($users)){ foreach($users as $user):?>
        <tr> 
          <td id="userNameUL"  name="userNameUL"><?php echo $user->user_name?></td>
          <td id="userTypeUL"  name="userTypeUL" class="text-center">
          <?php if ($user->user_type == "A") { ?>
            <i class="fas fa-user-cog" title="Admin"></i> 
              <?php } else if ($user->user_type == "G"){ ?>
                <i class="far fa-user text-secondary" title="Genérico"></i> 
              <?php } ?>
          </td>
          <td class="text-center" id="cardNumberUL"  name="cardNumberUL"><?php echo $user->card_number?></td>
          <td id="emailUL"  name="emailUL"><?php echo $user->user_email?></td>
          <td id="userStatusUL"  name="userStatusUL" class="text-center">
          <?php if ($user->user_status == "A") { ?>
                <i class="fas fa-check text-success" title="Activo"></i> 
              <?php } else if ($user->user_status == "I"){ ?>
                <i class="fas fa-times text-danger" title="Inactivo"></i> 
              <?php } ?>
          </td>
          <!--Botones Actualizar y Eliminar -->
          <td class="d-flex justify-content-center">
            <a href="user.php?Id=<?php echo $user->id_user?>&userName=<?php echo $user->user_name?>&userType=<?php echo $user->user_type?>&card_number=<?php echo $user->card_number?>&userEmail=<?php echo $user->user_email?>&userStatus=<?php echo $user->user_status?>">
              <i title="Modificar" class="far fa-edit fa-lg cursorHand text-primary mr-4"></i>
            </a>              
            <a href="../php/deleteUser.php?Id=<?php echo $user->id_user?>&userName=<?php echo $user->user_name?>">
              <i title="Eliminar" class="far fa-trash-alt fa-lg text-danger "></i>
            </a> 
          </td>
        </tr>
      <?php endforeach; ?> <?php }?>
      </tbody>
    </table>
    
    <div class="row">
      <div class="col-12">
        <a class="btn btn-primary" href="user.php">Crear usuario</a>
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

    if (isset($_SESSION["searchUsers"])){
      unset ($_SESSION["searchUsers"]);
    }
  ?>

  <!-- Scripts para Bootstrap 4-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>

</html>