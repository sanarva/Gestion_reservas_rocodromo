<?php  

//Datos para la sesión
session_start();

//Parámetros de inicio de sesión a la base de datos en desarrollo
$server_db = "127.0.0.1";
$user_db = "root";
$password_db = "";
$name_db = "rocodromo";

//Declaro una variable que llamaré 'sqlconexion' y que será igual a la función mysqli()
//que es la función que crea la conexión según los parámetros que le pasemos
$sqlconexion = new mysqli( $server_db, $user_db , $password_db , $name_db);

//Gestión de errores de la conexión a la BBDD
if ($sqlconexion->connect_errno) {
    echo "No se ha podido conectar con la BBDD debido al código de error " . $sqlconexion->connect_errno . ". ";
    echo "Descripción del error: " . $sqlconexion->connect_error;
    exit;
}

$sqlconexion->set_charset("utf8");

?>