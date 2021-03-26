<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Menu usuario</title>

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
        <?php include("../php/header.php")?>
    <header>

    <div class="container">        
        <h2>MENÚ</h2>
        
        <div class="divOptions">
            <!-- Items comunes para usuarios genéricos y administradores -->    
            <a href="myReservationsList.php" class="itemOption itemOption1"><p class="itemOptionText">MIS RESERVAS<i class="fas fa-calendar-check d-block"></i></p></a>
            <a href="modifyPsw.php" class="itemOption"><p class="itemOptionText">CAMBIAR CONTRASEÑA<i class="fas fa-unlock-alt d-block"></i></p></a>  
            <a href="http://www.escolamuntanya.org/rocodrom-usuaris" target="blank" class="itemOption"><p class="itemOptionText">NORMATIVA ROCÓDROMO<i class="fas fa-book-reader d-block"></i></p></a>
            <a href="mailto:escolaescaladacornella@gmail.com?subject=Contacto%20desde%20la%20web%20de%20reservas" target="blank" class="itemOption"><p class="itemOptionText">CONTACTAR CON EL ROCO <i class="fas fa-envelope d-block"></i></p></a>
            <!-- Items específicos para usuarios usuarios administradores --> 
            <?php if ((isset($_SESSION['sessionUserType'])) && $_SESSION['sessionUserType']=="A") { ?>
            <a href="usersList.php?userName=&cardNumber=&allStatusUser=" class="itemOption"><p class="itemOptionText">GESTIONAR USUARIOS<i class="fas fa-users-cog d-block"></i></p></a>
            <a href="reservationsList.php?dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation" class="itemOption"><p class="itemOptionText">GESTIONAR RESERVAS<i class="fas fa-clipboard-list d-block"></i></p></a>
            <a href="zonesList.php" class="itemOption"><p class="itemOptionText">GESTIONAR ZONAS<i class="fas fa-map-signs d-block"></i></p></a>
            <a href="hoursList.php" class="itemOption"><p class="itemOptionText">GESTIONAR HORARIOS<i class="fas fa-clock d-block"></i></p></a> 
            <?php } ?>
        </div>  
    </div>

    <?php         
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