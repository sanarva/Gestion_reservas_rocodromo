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
    <header>
        <?php include("../php/header.php");?>
      <header>

    <div class="container ">
        <div class="legend">
            <p>CONTACTO ROCÓDROMO:</p>
            <ol>
                <li><a href="mailto:escolaescaladacornella@gmail.com?cc=reservasrocodromocornella@gmail.com&subject=Contacto%20desde%20la%20web%20de%20reservas" target="blank" ><i class="fas fa-envelope"></i> Enviar mail</a></li>
            </ol>
        </div>

        <div class="legend">
            <p>DESCRIPCIÓN ZONAS:</p>
            <ol>
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Caballo: Bloque de fibra.</li>
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Moonboard: Plafón blanco 25º de leds.</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Placa desplomada: Pared de piezas rojas, plafón curvado y pared de pirámide invertida.</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Plafón: Pared de fibra y pared de pirámide invertida de delante.</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Vía R1: Vía de escalada situada más a la izquierda.</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Vía R2: Vía de escalada (tiene autoasegurador).</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Vía R3: Vía de escalada (tiene autoasegurador).</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Vía R4: Vía de escalada.</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Vía R5: Vía de escalada situada más a la derecha.</li> 
                <li><i class="fas fa-sort-down fa-rotate-270"></i> Volúmenes: Volúmentes y placa 10º.</li> 
            </ol>
        </div>

        <div class="legend">
            <p>ESTADO RESERVAS:</p>
            <ol>
                <li><i class="fas fa-check text-success"></i>Reserva activa</li>
                <li><i class="fas fa-times text-danger"></i>Reserva Inactiva</li> 
                <li><i class="fas fa-link text-success"></i>Reserva doble (autoasegurador o reservas con menor) </li> 
                <li><i class="fas fa-hourglass-half text-warning"></i>Reserva pendiente de confirmación</li> 
            </ol>
        </div>

        <div class="legend">
            <p>BOTONES:</p>
            <ol> 
                <li><i class="far fa-edit text-primary"></i>Modificar</li>
                <li><i class="far fa-check-circle text-primary"></i>Confirmar reserva</li> 
                <li><i class="far fa-times-circle text-danger"></i>Cancelar reserva</li> 
                <li><i class="far fa-trash-alt text-danger"></i>Eliminar  </li> 
                
            </ol>
        </div>
       
    </div>
    <!-- Scripts para Bootstrap 4-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    <!-- Scripts para la lógica de la app-->
    <script src="../scripts/main.js"></script>
</body>
</html>