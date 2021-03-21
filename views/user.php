<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Usuario</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body>
    <div class="container">
        <p class= "closeSession"><i class="fas fa-sign-out-alt fa-lg "></i> Cerrar sesión</p> 
        <h1>CREAR USUARIO</h1>
        <form>
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputUserName" class="col-lg-3 col-form-label"><i class="fas fa-user"></i> Nombre usuario</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="inputUserName" placeholder="Introduce nombre y apellidos">
                    <div class="invalid-feedback" id="errorUserName"></div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="usertype" class="col-lg-3 col-form-label"><i class="fas fa-user-cog"></i> Tipo usuario</label>
                <div class="col-lg-7 input-group">
                    <select class="form-control" id="userType" name="userType">
                        <option value="A">Admin</option> 
                        <option selected value="I">Genérico</option>  
                    </select>
                </div>
            </div>            

            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputCardNumber" class="col-lg-3 col-form-label"><i class="fas fa-address-card"></i> Nº de tarjeta</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="inputData" placeholder="Introduce el número de tarjeta">
                    <div class="invalid-feedback" id="errorCardNumber"></div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputUserEmail" class="col-lg-3 col-form-label"><i class="fas fa-envelope"></i> Email usuario</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="inputUserEmail" placeholder="Introduce el email">
                    <div class="invalid-feedback" id="errorUserEmail"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="userStatus" class="col-lg-3 col-form-label"><i class="fas fa-question-circle"></i> Estado usuario</label>
                <div class="col-lg-7 input-group">
                    <select class="form-control" id="userStatus" name="userStatus">
                        <option value="A">Activo</option> 
                        <option value="I">Inactivo</option>  
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                </div>
            </div>
        </form>


    </div>
    <!-- Scripts para Bootstrap 4-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>