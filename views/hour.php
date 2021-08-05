<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Horario</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body>
    <!-- Recuperamos la información de la lista de horas-->
    <?php
        $idHour    = $_GET["Id"];
        $startHour = $_GET["startHour"];
        $endHour   = $_GET["endHour"];
        $weekDay   = $_GET["weekDay"];  
   ?>

    <header>
        <?php 
            include("../php/header.php");

            //Si algún usuario que no es administrador, intenta entrar en esta página que es de acceso único a administradores, se redirigirá al menú
            if (isset($_SESSION["sessionIdUser"]) && $_SESSION['sessionUserType'] != "A"){
                header("Location: userMenu.php" );
            }
        ?>
    <header>

    <div class="container">

        <h2><?php if ($idHour == " ") {?> CREAR NUEVA HORA <?php } else {?> MODIFICACIÓN HORA <?php }?></h2>
        <form method="post" action="#" autocomplete="off" id="hourForm" name="hourForm" onsubmit="return validateHourForm( <?php if($idHour ==' ') { ?> 'btnInsertHour' <?php } else {?>  'btnUpdateHour' <?php }?> )">
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="startHour" class="col-lg-3 col-form-label"><i class="far fa-clock"></i> Hora de inicio</label>
                <div class="col-lg-7">
                    <input autofocus type="time" class="form-control"  id="startHour" name="startHour" placeholder="Introduce la hora de inicio" value ="<?php echo $startHour ?>">
                    <!-- Mensaje de error por validación incorrecta en la hora de inicio -->
                    <div class="invalid-feedback" id="errorStartHour"></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="endHour" class="col-lg-3 col-form-label"><i class="fas fa-clock"></i> Hora de finalización</label>
                <div class="col-lg-7">
                    <input autofocus type="time" class="form-control"  id="endHour" name="endHour" placeholder="Introduce la hora de finalización" value ="<?php echo $endHour ?>">
                    <!-- Mensaje de error por validación incorrecta en la hora de fin -->
                    <div class="invalid-feedback" id="errorEndHour"></div>
                </div>
            </div>
 
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="weekDay" class="col-lg-3 col-form-label"><i class="fas fa-calendar-alt"></i> Días de la semana</label>
                <div class="col-lg-7 input-group">
                    <?php include("../php/checkWeekDay.php");?>
                    <!-- Añado este input invisible para enviar en un solo campo los valores de los días de la semana -->
                    <input type="text" class="d-none"  id="weekDay" name="weekDay" value="#">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="monday" name="day" value="L" <?php if ($L == true) {?> checked <?php } ?>>
                        <label for="monday"    class="form-check-label" >Lun</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="tuesday" name="day" value="M" <?php if ($M == true) {?> checked <?php } ?>>
                        <label for="tuesday"   class="form-check-label">Mar</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="wednesday" name="day" value="X" <?php if ($X == true) {?> checked <?php } ?>>
                        <label for="wednesday" class="form-check-label">Mie</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="thursday" name="day" value="J" <?php if ($J == true) {?> checked <?php } ?>>
                        <label for="thursday"  class="form-check-label">Jue</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="friday" name="day" value="V" <?php if ($V == true) {?> checked <?php } ?>>
                        <label for="friday"    class="form-check-label">Vie</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="saturday" name="day" value="S" <?php if ($S == true) {?> checked <?php } ?>>
                        <label for="saturday"  class="form-check-label">Sab</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="sunday" name="day" value="D" <?php if ($D == true) {?> checked <?php } ?>> 
                        <label for="sunday" class="form-check-label">Dom</label>
                    </div>
                    <!-- Mensaje de error por validación incorrecta en la hora de fin -->
                    <div class="invalid-feedback d-block" id="errorWeekDay"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <?php if ($idHour == " ") {?>
                        <button type="submit" formaction="../php/insertHour.php?Id=<?php echo $idHour?>&startHour=<?php echo $startHour?>&endHour=<?php echo $endHour?>&weekDay=<?php echo $weekDay?>" id="btnInsertHour" class="btn btn-primary">Crear</button>
                    <?php } else {?>
                        <button type="submit" formaction="../php/updateHour.php?Id=<?php echo $idHour?>&startHour=<?php echo $startHour?>&endHour=<?php echo $endHour?>&weekDay=<?php echo $weekDay?>" id="btnUpdateHour" class="btn btn-primary">Modificar</button>
                    <?php }?>     
                </div>
            </div>
        </form>
    
    </div>

    <?php     
    
      if ( (isset($_SESSION['deleteConfirmation'])) && $_SESSION['deleteConfirmation'] == "pending") {
        include "../php/confirmation.php";
      }

        if (isset($_SESSION['successFlag'])) { 
            $_SESSION["button1"] = "Lista horarios";
            $_SESSION["formaction1"]  = "hoursList.php";
            $_SESSION["colorbutton1"] = "btn-dark";
        //Solo permitimos volver a la pantalla Hora en la creación de horas
        if ($idHour == " ") {
            $_SESSION["button2"] = "Crear otro horario";
            $_SESSION["formaction2"]  = "hour.php?Id= &startHour=&endHour=&weekDay=";
            $_SESSION["colorbutton2"] = "btn-primary";
        } else {
            $_SESSION["button2"] = "Modificar de nuevo";
            $_SESSION["formaction2"]  = "hour.php?Id= &startHour=&endHour=&weekDay=";
            $_SESSION["colorbutton2"] = "btn-primary";
        }
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