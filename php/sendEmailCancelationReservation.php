<?php

$sessionUserName  = $_SESSION['sessionUserName'];
$userName         = $_GET['userName'];
if (isset($_GET["userId"])){
    $userId           = $_GET["userId"];
}

if (!isset($cancelationFromModification)){
    $dateOk    = $_GET["reservationDate"];
    $startHour = $_GET["startHour"];
    $endHour   = $_GET["endHour"];
    $zoneName  = $_GET["zoneName"];
} else {
    //Con esto cambiamos el formato de la fecha a día, mes y año (dd/mm/aaaa)
    $date   = new DateTime($reservationDate);
    $dateOk = $date->format("d/m/Y");
}

//PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


//Recuperamos el email del usuario al que se le va a cancelar la reserva:
try { 
    if ($idRelatedReservation == "nonexistent"){ //En este caso sólo habrá un usuario
        $sql = "SELECT user_email, user_name, id_user
                  FROM users 
                 WHERE id_user = :iduser";
        $query = $conn->prepare($sql); 
        $query->execute(array(":iduser"=>$userId));  
        $results = $query->fetchAll(PDO::FETCH_OBJ);
   } else { //En este caso habrá más de un usuario
        $sql = "SELECT user_email, user_name, id_user
                  FROM users, reservations 
                 WHERE id_user = user_id
                   AND id_related_reservation = :idrelationreservation";
        $query = $conn->prepare($sql); 
        $query->execute(array(":idrelationreservation"=>$idRelatedReservation));  
        $results = $query->fetchAll(PDO::FETCH_OBJ); 
   }

    if ($results != []) {
        $emailTo = "";
        $names   = ""; 
        $ids     = "";  
        //relleno el campo $emailTo con la info que nos llegue de las queries
        foreach($results as $result){
            //Si es la primera iteración...
            if ($emailTo == "") {
                $emailTo = $result->user_email;
                $email1  = $result->user_email;
                $names   = $result->user_name;
                $ids     = $result->id_user;
            } else if ($result->user_email != $emailTo){
                $emailTo = $emailTo . ", " . $result->user_email;
                $names   = $names   . ", " . $result->user_name;
                $ids     = $ids     . ", " . $result->id_user; 
            }
        }
        
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
            $mail->addAddress($email1);
            $mail->addAddress($result->user_email);
            
            
            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Reserva cancelada';
            $mail->Body    = "
            <html>
            <body>
              <p>La reserva que tenías para el día $dateOk de $startHour a $endHour h en la zona $zoneName, ha sido cancelada por $sessionUserName.</p>
              <p>Por favor, revisa siempre tus reservas pendientes antes de ir a entrenar.</p>
            </body>
            </html>
            ";

            $mail->send();
            $_SESSION['successFlag'] = "Y";
            $_SESSION['message'] = "La reserva ha sido cancelada y se ha enviado un email a $names para informar de ello."; 
        } catch (Exception $e) {
            $_SESSION['successFlag'] = 'N';
            $mailError = $e->getMessage();  
            $_SESSION['message'] = "Aunque la reserva ha sido cancelada, se ha producido un error en el envío del mail a $names con email $emailTo , para informar de la cancelación de una de sus reservas. </br> Descripción del error: " . $mailError ;
        }
        
        
    } else {
        $_SESSION['successFlag'] = "N"; 
        $queryError = $e->getMessage();
        $_SESSION['message'] = "Aunque la reserva ha sido cancelada, ha habido un problema y no se ha podido encontrar el email de $names (ID: $ids), por lo que no se ha podido enviar el email de aviso de cancelación de reserva. </br> Descripción del error: " . $mailError ; 
    }          

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Aunque la reserva ha sido cancelada, se ha detectado un problema al buscar el email de $names (ID: $ids), por lo que no se ha podido enviar el email para avisar de la cancelación de la reserva. </br> Descripción del error: " . $mailError ; 
} finally { 
    //Limpiamos la memoria 
    $conn = null;
    
}

?>
