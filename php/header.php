<?php
//Datos para la sesión
session_start();
$invisibleClass = "";

//En la pantalla de inicio de sesión, no mostraremos los botones de "Volver al menú" ni "Cerrar sesión"
if (isset($_SESSION["sessionIdUser"])){
    $invisibleClass = "";
} else {
    $invisibleClass = "invisible";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    
    <div class="container-fluid header">
        <div class=" d-flex justify-content-between">
            <a class="text-decoration-none <?=$invisibleClass?>" href="userMenu.php"><p href="userMenu.php" class= "goMenu">
                <i class="fas fa-arrow-circle-left fa-lg"></i> Volver al menú </p> 
            </a>
            <a class="text-decoration-none <?=$invisibleClass?>" href="../php/logout.php"><p href="../php/logout.php" class= "closeSession">
                <i class="fas fa-sign-out-alt fa-lg "></i> Cerrar sesión</p> 
            </a>
        </div>

        <h1>ROCÓDROMO CAN MERCADER</h1>
    </div>

</body>

</html>