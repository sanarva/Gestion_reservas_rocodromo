<?php
    //Iniciamos la sesión
    session_start();
  
    //Borra los valores de sesión
    session_unset();

    //Eliminar sesión
    session_destroy();

    header("Location: ../views/index.php");

?>