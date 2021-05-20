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
    <!-- Recuperamos la información de la lista de usuarios-->
    <?php
        $idUser = $_GET["Id"];
        $userName = $_GET["userName"];
        $userType = $_GET["userType"];
        $cardNumber = $_GET["cardNumber"];
        $userEmail = $_GET["userEmail"];
        $userStatus = $_GET["userStatus"];
   ?>

    <header>
        <?php include("../php/header.php");?>
    <header>

    <div class="container">
        <h2><?php if ($idUser == " ") {?> CREAR NUEVO USUARIO <?php } else {?> MODIFICACIÓN USUARIO <?php }?></h2>
        <form method="post" action="#" autocomplete="off" id="userForm" name="userForm" onsubmit="return validateUserForm( <?php if($idUser ==' ') { ?> 'btnInsertUser' <?php } else {?>  'btnUpdateUser' <?php }?> )">
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputUserName" class="col-lg-3 col-form-label"><i class="fas fa-user"></i> Nombre usuario</label>
                <div class="col-lg-7">
                    <input autofocus type="text" class="form-control" id="inputUserName" name="inputUserName" placeholder="Introduce nombre y apellidos" value ="<?php echo $userName ?>">
                    <div class="invalid-feedback" id="errorUserName"></div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="usertype" class="col-lg-3 col-form-label"><i class="fas fa-user-cog"></i> Tipo usuario</label>
                <div class="col-lg-7 input-group">
                    <select class="form-control" id="userType" name="userType">
                        <option value="G" <?php if ($userType == "G") {?>selected <?php }?>>Genérico</option>  
                        <option value="M" <?php if ($userType == "M") {?>selected <?php }?>>Genérico con menores</option> 
                        <option value="A" <?php if ($userType == "A") {?>selected <?php }?>>Admin</option> 
                    </select>
                </div>
            </div>            

            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputCardNumber" class="col-lg-3 col-form-label"><i class="fas fa-address-card"></i> Nº de tarjeta</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Introduce el número de tarjeta" value ="<?php echo $cardNumber ?>">
                    <div class="invalid-feedback" id="errorCardNumber"></div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="inputUserEmail" class="col-lg-3 col-form-label"><i class="fas fa-envelope"></i> Email usuario</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Introduce el email" value ="<?php echo $userEmail ?>">
                    <div class="invalid-feedback" id="errorEmail"></div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1 "></div>
                <label for="userStatus" class="col-lg-3 col-form-label"><i class="fas fa-question-circle"></i> Estado usuario</label>
                <div class="col-lg-7 input-group">
                    <select class="form-control" id="userStatus" name="userStatus">
                    <option value="A" <?php if ($userStatus == "A") {?>selected <?php }?>>Activo</option>  
                        <option value="I" <?php if ($userStatus == "I") {?>selected <?php }?>>Inactivo</option>  
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-1"></div>
                <div class="col-lg-8">
                    <?php if ($idUser == " ") {?>
                        <button type="submit" formaction="../php/insertUser.php?Id=<?php echo $idUser?>&currentUserName=<?php echo $userName?>&currentUserType=<?php echo $userType?>&currentCardNumber=<?php echo $cardNumber?>&currentUserEmail=<?php echo $userEmail?>&currentUserStatus=<?php echo $userStatus?>" id="btnInsertUser" class="btn btn-primary">Crear</button>
                    <?php } else {?>
                        <button type="submit" formaction="../php/updateUser.php?Id=<?php echo $idUser?>&userName=<?php echo $userName?>&userType=<?php echo $userType?>&cardNumber=<?php echo $cardNumber?>&userEmail=<?php echo $userEmail?>&userStatus=<?php echo $userStatus?>" id="btnUpdateUser" class="btn btn-primary">Modificar</button>
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

            //Recuperamos la info de los filtros cuando hacemos creamos o modificamos un usuario
            if (isset($_SESSION['filterUserNameShow'])){
                $filterUserName = $_SESSION['filterUserNameShow'];
            }    
            if (isset($_SESSION['filterCardNumberShow'])){
                $filterCardNumber = $_SESSION['filterCardNumberShow'];
            }    
            if (isset($_SESSION['filterAllStatusUserShow'])){
                $filterAllStatusUser = $_SESSION['filterAllStatusUserShow'];
            }    

            $_SESSION["button1"] = "Lista usuarios";
            $_SESSION["formaction1"]  = "usersList.php?userName=$filterUserName&cardNumber=$filterCardNumber&allStatusUser=$filterAllStatusUser";
            $_SESSION["colorbutton1"] = "btn-dark";
        
        if ($idUser == " ") {
            $_SESSION["button2"] = "Crear otro usuario";
            $_SESSION["formaction2"]  = "user.php?Id= &userName=&userType=&cardNumber=&userEmail=&userStatus=";
            $_SESSION["colorbutton2"] = "btn-primary";
        } else {
            $_SESSION["button2"] = "Modificar de nuevo";
            $_SESSION["formaction2"]  = "user.php?Id= &userName=&userType=&cardNumber=&userEmail=&userStatus=";
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