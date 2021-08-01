<?php
//Datos para la sesión. Solo la inicio si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$invisibleClass = "";

//En la pantalla de inicio de sesión, no mostraremos los botones de "Volver al menú" ni "Cerrar sesión"
if (!isset($_SESSION["sessionIdUser"])){
    $invisibleClass = "invisible";
    //Si no hay datos de sesión y además no estamos en la página de inicio, redireccionamos a la página de inicio
    if ($page != "index") {
        header("Location: ../index.php" );
    }
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
                <i class="fas fa-arrow-circle-left fa-lg goMenuIcon"></i> Volver al menú </p> 
            </a>
            <a class="text-decoration-none <?=$invisibleClass?>" href="../php/logout.php"><p href="../php/logout.php" class= "closeSession">
                <i class="fas fa-sign-out-alt fa-lg closeSessionIcon"></i> Cerrar sesión</p> 
            </a>
        </div>

        <h1 class="mt-5">ROCÓDROMO CAN MERCADER</h1>
    </div>

</body>

</html>