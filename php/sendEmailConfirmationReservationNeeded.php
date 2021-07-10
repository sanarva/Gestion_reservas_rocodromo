<?php

//PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$emailTo = $_SESSION['userEmailDobleReservationRopeTeam'];

//Con esto cambiamos el formato de la fecha a día, mes y año (dd/mm/aaaa)
$date   = new DateTime($filterReservationDate);
$dateOk = $date->format("d/m/Y");


$userNameTeamRope1= $_SESSION['sessionNameReservation'];
$userNameTeamRope2 = $_SESSION['sessionNameReservationRopeTeam'];


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
    $mail->addAddress($emailTo);
    
    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Reserva pendiente de confirmar';
    $mail->Body    = "
    <html>
        <body>
            <p>Hola $userNameTeamRope2,</p>
            <p>Este mensaje es para informate que el usuario $userNameTeamRope1 quiere crear una reserva contigo como compañero/a de cordada en la $zoneNameChoosen para el día $dateOk de $startHourChoosen a $endHourChoosen h.</p>
            <p>La reserva ha quedado pendiente y no se hará efectiva hasta que tú la confirmes, por lo que es necesario que entres a la aplicación de reservas (http://reservesrocodrom.escolamuntanya.org/) y dentro de tu lista de reservas le des al botón confirmar, antes de 24h o la reserva será cancelada.</p>
            <p>Si no te va bien la reserva o has sido elegido como compañero/a de cordada por error, no te preocupes porque también puedes cancelarla desde tu lista de reservas.</p>
        </body>
    </html>
    ";

    $mail->send();
    $_SESSION["sessionUserReservation"] = "";
    $_SESSION['successFlag'] = "W";
    $_SESSION['message'] = "La reserva ha sido creada en estado pendiente y se ha enviado un email a tu compañero/a de cordada para informarle que debe confirmarla antes de 24h para que se haga efectiva. De no ser así, la reserva será cancelada automáticamente."; 
    if ($reservationsList != "") {
        $_SESSION['button1'] = 'Volver a la lista';
        $_SESSION['formaction1']  = '../views/reservationsList.php?&dateFrom=&dateTo=&userName=&cardNumber=&startHour=&endHour=&zoneName=&allStatusReservation'; 
    } else {
        $_SESSION['button1'] = 'Volver a mis reservas';
        $_SESSION['formaction1']  = '../views/myReservationsList.php';
    }  
    $_SESSION['colorbutton1'] = 'btn-dark';
    $_SESSION['button2'] = 'Crear otra reserva';
    $_SESSION['formaction2']  = '#';
    $_SESSION['colorbutton2'] = 'btn-primary';
    $_SESSION["datadismiss"]  = "Yes";
} catch (Exception $e) {
    $_SESSION['successFlag'] = 'N';
    $mailError = $e->getMessage();  
    $_SESSION['message'] = "Aunque la reserva ha sido creada en estado pendiente, se ha producido un error en el envío del mail y no se ha podido avisar a tu compañero/a de cordada para que confirme, así que te aconsejamos que le envíes un WhatApp o le llames para que confirme y así te aseguras la reserva porque, si no lo hace en un plazo de 24h, la reserva será cancelada. </br> Descripción del error: " . $mailError; 

} finally {
    unset ($_SESSION['sessionIdUserReservationRopeTeam']);
    unset ($_SESSION['sessionNameReservationRopeTeam']);
    unset ($_SESSION['userEmailDobleReservationRopeTeam']);
}


?>
