<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Zona</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body>
    <!-- Recuperamos la información de la lista de zonas-->
    <?php
        $idZone = $_GET["Id"];
        $zoneName = $_GET["zoneName"];
        $maxUserNumber = $_GET["maxUserNumber"];
        $zoneStatus = $_GET["zoneStatus"];
   ?>

    <header>
        <?php include("../php/header.php");?>
      <header>

    <div class="container">

        <h2><?php if ($idZone == " ") {?> CREAR NUEVA ZONA <?php } else {?> MODIFICACIÓN ZONA <?php }?></h2>
        <form method="post" action="#" autocomplete="off" id="zoneForm" name="zoneForm" onsubmit="return validateZoneForm( <?php if($idZone ==' ') { ?> 'btnInsertZone' <?php } else {?>  'btnUpdateZone' <?php }?> )">
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="zoneName" class="col-lg-3 col-form-label"><i class="fas fa-map-signs"></i> Nombre zona</label>
                <div class="col-lg-7">
                    <input autofocus type="text" maxlength="30" class="form-control"  id="zoneName" name="zoneName" placeholder="Introduce el nombre de la zona" value ="<?php echo $zoneName ?>">
                    <!-- Mensaje de error por formato incorrecto en el nombre de la zona -->
                    <div class="invalid-feedback" id="errorZoneName"></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="maxUserNumber" class="col-lg-3 col-form-label"><i class="fas fa-users"></i> Nº máximo usuarios</label>
                <div class="col-lg-7">
                    <input type="text" maxlength="2" class="form-control" id="maxUserNumber" name="maxUserNumber" placeholder="Introduce el número máximo de usuarios de la zona" value ="<?php echo $maxUserNumber ?>">
                    <!-- Mensaje de error por formato incorrecto en el número máximo de usuarios por zona -->
                    <div class="invalid-feedback" id="errorMaxUserNumber"></div>
                </div>
            </div>
 
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="zoneStatus" class="col-lg-3 col-form-label"><i class="fas fa-question-circle"></i> Estado zona</label>
                <div class="col-lg-7 input-group">
                    <select class="form-control" id="zoneStatus" name="zoneStatus">
                        <option value="A" <?php if ($zoneStatus == "A") {?>selected <?php }?>>Activa</option> 
                        <option value="I" <?php if ($zoneStatus == "I") {?>selected <?php }?>>Inactiva</option>  
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <?php if ($idZone == " ") {?>
                        <button type="submit" formaction="../php/insertZone.php?Id=<?php echo $idZone?>&currentMaxUserNumber=<?php echo $maxUserNumber?>&CurrentZoneStatus=<?php echo $zoneStatus?>" id="btnInsertZone" class="btn btn-primary">Crear zona </button>
                    <?php } else {?>
                        <button type="submit" formaction="../php/updateZone.php?Id=<?php echo $idZone?>&currentMaxUserNumber=<?php echo $maxUserNumber?>&CurrentZoneStatus=<?php echo $zoneStatus?>" id="btnUpdateZone" class="btn btn-primary">Modificar zona</button>
                        <button type="submit" formmethod="post" formaction="../php/deleteZone.php?Id=<?php echo $idZone?>&zoneName=<?php echo $zoneName?>" class="btn btn-danger ml-3">Eliminar zona</button>
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
            $_SESSION["button1"] = "Lista zonas";
            $_SESSION["formaction1"]  = "zonesList.php";
            $_SESSION["colorbutton1"] = "btn-dark";
        //Solo permitimos volver a la pantalla Zona en la creación de zonas
        if ($idZone == " ") {
            $_SESSION["button2"] = "Crear otra zona";
            $_SESSION["formaction2"]  = "zone.php?Id= &zoneName=&maxUserNumber=&zoneStatus=";
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