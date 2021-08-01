<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Recuperar contraseña</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body >

    <header>
        <?php 
            $page = "index";
            include("../php/header.php")
        ?>
    <header>

    <div class="container">

        <div class="row ">
            <div class="col-lg-1"></div>
            <p class="col-lg-10 text-justify">¿Has olvidado tu contraseña? No te preocupes, escribe tu correo electrónico para que podamos enviarte una nueva.</p>
        </div>
        
        <form method="post" action="#" autocomplete="off" id="recoveryPswForm" name="recoveryPswForm" onsubmit="return checkEmail()">
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <label for="inputUser" class="col-lg-2 col-form-label"><i class="fas fa-user-check"></i> Usuario</label>
                <div class="col-lg-8">
                    <input type="text" autofocus class="form-control" id="userEmail" name="userEmail" placeholder="Introduce tu email">
                    <div class="invalid-feedback" id="errorEmail"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary">Enviar contraseña</button>
                </div>
            </div>
        </form>

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

    <!-- Scripts para la lógica de la app-->
    <script src="../scripts/main.js"></script>

</body>


</html>