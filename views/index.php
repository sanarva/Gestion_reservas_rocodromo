<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Acceder</title>

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
        <form method="post" action="#" autocomplete="off" id="loginForm" name="loginForm" onsubmit="return login()">
            <!-- Campo para introducir el usuario, que será el email -->
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="userEmail" class="col-lg-3 col-form-label "><i class="fas fa-user-check"></i> Usuario</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Introduce tu usuario">
                    <!-- Mensaje de error por formato incorrecto en el email -->
                    <div class="invalid-feedback" id="errorEmail"></div>
                </div>
            </div>

            <!-- Campo para introducir la contraseña -->
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="userPassword" class="col-lg-3 col-form-label"><i class="fas fa-lock"></i> Contraseña</label>
                <div class="col-lg-7">
                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Introduce tu contraseña">
                    <!-- Icono para mostrar/ocultar la contraseña -->
                    <i class="fas fa-eye passwordIcon" id="eyeIcon" onclick="showHidePassword('userPassword')"></i> 
                    <!-- Mensaje de error por formato incorrecto en la contraseña -->
                    <div title="La contraseña debe ser de 8 caracteres y tener como mínimo una mayúscula, una minúscula y un número." class="invalid-feedback" id="errorPassword"></div> 
                    
                </div>
            </div>

            <!--Botón para acceder a la aplicación en caso de que no haya ningún error -->
            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <button 
                        type="submit" 
                        class="btn btn-primary">
                        Acceder
                    </button>
                    <!--Link para acceder a la pantalla de recuperar contraseña -->
                    <a class="small" href="recoveryPsw.php"> He olvidado mi contraseña <i class="far fa-grin-beam-sweat"></i></a>
                </div>
            </div>
        </form>

        <!-- Gestión de errores y mensajes-->
        <?php 
            if (isset($_SESSION['successFlag'])) {
                include "../php/message.php";
            } 
        ?>   

    </div>
    <!-- Scripts para Bootstrap 4-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    
    <!-- Scripts para la lógica de la app-->
    <script src="../scripts/main.js"></script>
</body>


</html>