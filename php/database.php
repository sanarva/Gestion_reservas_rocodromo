<?php 
//Datos para la sesión
session_start();

//Declaro la variable donde se redirigirá la página
$path;

//Inicializo el flag para saber si todo ha ido ok
$_SESSION['successFlag'] = " ";

//Declaro la variable global conn para la conexión a la BBDD
$conn = "";

//Parámetros de inicio de sesión a la base de datos en desarrollo
$server_db = "127.0.0.1";
$name_db = "rocodromo";
$user_db = "root";
$password_db = "";

try {
    //Declaro una variable que llamaré 'conn' usaré PDO (en lugar de mysqli)
    //que es la función que crea la conexión según los parámetros que le pasemos
    $conn = new PDO( "mysql:host=$server_db; dbname=$name_db", $user_db, $password_db);

    //Gestión de errores 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("SET CHARACTER SET utf8");

} catch(PDOException $e){
    
    //La función getMessage() muestra el mensaje por pantalla
    $_SESSION["successFlag"] = 'N';
    $conexionErrorMessage = $e->getMessage();  
    $_SESSION["message"] = "No se ha podido realizar la operación. Inténtalo más tarde y si el problema continúa, ponte en contacto con los responsables del roco. 
    </br> Error al conectar con la BBDD. </br> Descripción del error: " . $conexionErrorMessage;

    if ($path == ""){
        header("Location: ../views/index.php");
    } else {
        header("Location: $path");
    }
} 
    
//Inicializo el path
 $path = "";


?>

