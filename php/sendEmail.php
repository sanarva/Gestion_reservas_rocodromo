<?php
//PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'XXXXXXXXXX@gmail.com';                 //SMTP username
    $mail->Password   = 'XXXXXXXXXX';                           //SMTP password
    $mail->SMTPSecure = 'tsl';                                  //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('XXXXXXXXXXXX@gmail.com', 'Escola de escalada Cornellà');
    $mail->addAddress($userEmail);
    
    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Restablecimiento contraseña';
    $mail->Body    = "<html>
    <body>
      <p>Si recibes este correo, es porque nos ha llegado una solicitud para restablecer tu contraseña.</p>
      <p>Esta es tu nueva contraseña: <b>$userNewPassword</b></p>
      <p>Recuerda que puedes cambiarla desde la opción Cambiar contraseña que aparece en tu menú. </p>
    </body>
    </html>";

    $mail->send();
    $_SESSION['successFlag'] = "Y";
    $_SESSION['message'] = "Te hemos enviado una nueva contraseña a $userEmail con las instrucciones. </br> Si no las has recibido en unos minutos, revisa la carpeta de spam." ; 
    $_SESSION['button1'] = 'Volver al inicio';
    $_SESSION['formaction1']  = '../index.php';
    $_SESSION['colorbutton1'] = 'btn-primary';
} catch (Exception $e) {
    $_SESSION['successFlag'] = 'N';
    $mailError = $e->getMessage();  
    $_SESSION['message'] = "Se ha producido un error en el envío de la nueva contraseña al email $userEmail. Inténtalo más tarde y si el problema continúa, ponte en contacto con los responsables del roco. </br> Descripción del error: " . $mailError ;

}

?>
