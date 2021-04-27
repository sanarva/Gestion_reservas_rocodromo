<?php

$userName        = $_GET['userName'];
$userId          = $_GET["userId"];
$reservationDate = $_GET["reservationDate"];
$startHour       = $_GET["startHour"];
$endHour         = $_GET["endHour"];
$zoneName        = $_GET["zoneName"];

//Recuperamos el email del usuario al que se le va a cancelar la reserva:
try {
    $sql = "SELECT user_email 
              FROM users 
             WHERE id_user = :iduser";
    $query = $conn->prepare($sql); 
    $query->execute(array(":iduser"=>$userId));  
    $result = $query->fetch(PDO::FETCH_ASSOC);
   
    if (($query->rowCount() > 0 )) {
        $emailTo = $result['user_email'];

        $emailSubject = "Reserva cancelada";
        
        // mensaje
        $emailBody = "
        <html>
        <body>
          <p>Lo sentimos, pero la reserva que tenías para el día $reservationDate de $startHour a $endHour h en la zona $zoneName, ha tenido que ser cancelada.</p>
          <p>Por favor, revisa tus reservas pendientes y si tienes alguna duda, ponte en contacto con nosotros contestando a este email.</p>
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
                $_SESSION['message'] = "La reserva ha sido cancelada y se ha enviado un email al usuario $userName para informarle de ello."; 
        
        
            } else {
                $_SESSION['successFlag'] = 'N';
                $_SESSION['message'] = "Aunque la reserva ha sido cancelada, no se ha podido enviar el mail de aviso de cancelación de reserva al usuario $userName." ; 
            }
            
        } catch (Exception $e) {
            $_SESSION['successFlag'] = 'N';
            $mailError = $e->getMessage();  
            $_SESSION['message'] = "Aunque la reserva ha sido cancelada, se ha producido un error en el envío del mail que avisa al usuario $userName de la cancelación de una de sus reservas. </br> Descripción del error: " . $mailError ;
        }

    } else {
        $_SESSION['successFlag'] = "N"; 
        $_SESSION['message'] = "Aunque la reserva ha sido cancelada, ha habido un problema y no se ha podido encontrar el email del usuario $userName (ID: $userId']), por lo que no se ha podido enviar el email para avisarle." ; 
    }          

} catch(PDOException $e){
    $_SESSION['successFlag'] = "N";
    $queryError = $e->getMessage();  
    $_SESSION['message'] = "Aunque la reserva ha sido cancelada, se ha detectado un problema al buscar el email del usuario $userName (ID: $userId), por lo que no se ha podido enviar el email para avisarle. </br> Descripción del error: " . $queryError ; 
   
} finally { 
    //Limpiamos la memoria 
    $conn = null;
    
}

?>
