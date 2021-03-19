<?php

$emailTo      = $userEmail; 

$emailSubject = "Restablecimiento contraseña";

// mensaje
$emailBody = "
<html>
<body>
  <p>Si recibes este correo, es porque nos ha llegado una solicitud para restablecer tu contraseña.</p>
  <p>Esta es tu nueva contraseña: <b>$userNewPassword</b></p>
  <p>Recuerda que puedes cambiarla desde la opción Cambiar contraseña que aparece en tu menú. </p>
</body>
</html>
";

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Cabeceras adicionales
$headers .= 'From: Escola de escalada Cornellà <escolaescaladacornella@gmail.com>' . "\r\n";


// Enviar Mensaje
try {
    
        mail($emailTo, $emailSubject, $emailBody, $headers);
    
        if (mail) {
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message'] = "Te hemos enviado una nueva contraseña a $userEmail con las instrucciones. </br> Si no las has recibido en unos minutos, revisa la carpeta de spam." ; 
            $_SESSION['button1'] = 'Volver al inicio';
            $_SESSION['formaction1']  = '../views/index.php';
            $_SESSION['colorbutton1'] = 'btn-primary';
    
        } else {
            $_SESSION['successFlag'] = 'N';
            $_SESSION['message'] = "No se ha podido enviar el mail de recuperación de contraseña a $userEmail. Inténtalo más tarde." ; 
            header('Location:mensaje-de-envio.html');
        }
    
    } catch (Exception $e) {
        $_SESSION['successFlag'] = 'N';
        $mailError = $e->getMessage();  
        $_SESSION['message'] = "Se ha producido un error en el envío de la nueva contraseña al email $userEmail. </br> Descripción del error: " . $mailError ;
    }

?>
