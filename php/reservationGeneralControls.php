<?php  

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";


//**************************************************************************************************//
// Recuperamos la información del usuario para comprobar el número de reservas pendientes que tiene.// 
// Sólo para usuarios genéricos. Los administradores no tienen límite de reservas para que puedan   //
// hacer todas las reservas necesarias para la escuela.                                             //
//**************************************************************************************************//
if (isset($checkReservationsNumberUser) && $checkReservationsNumberUser == "Y") {

    try {
        $sql = "SELECT id_user, user_type, user_name, user_email, card_number
                  FROM users
                 WHERE (user_name   = :username
                    OR  card_number = :cardnumberropeteam)
                   AND  user_status = 'A'";
        $query = $conn->prepare($sql);
        $query->bindParam(":username",$userName);
        $query->bindParam(":cardnumberropeteam",$cardNumberRopeTeam); 
        $query->execute();
        $userResult = $query->fetch(PDO::FETCH_ASSOC);
        if (($query->rowCount() > 0 )) {
            $idUser   = $userResult["id_user"];
            if ($cardNumberRopeTeam == ""){
                $_SESSION['sessionIdUserReservation']             = $userResult["id_user"];
                $_SESSION['sessionIdUserSameReservationControl']  = $userResult["id_user"];                     
                $_SESSION['sessionNameReservation']               = $userResult["user_name"];
                $_SESSION['userType']                             = $userResult["user_type"];
                $_SESSION['cardNumberDoubleReservationWithMinor'] = $userResult["card_number"];
            } else {
                $_SESSION['sessionIdUserReservationRopeTeam']  = $userResult["id_user"];
                $_SESSION['sessionNameReservationRopeTeam']    = $userResult["user_name"];
                $_SESSION['userEmailDobleReservationRopeTeam'] = $userResult["user_email"];
                $_SESSION['userTypeRopeTeam']                  = $userResult["user_type"];
            }

            //Creamos un indicador para saber que el usuario genérico con menor está haciendo una reserva doble con el menor y volvemos a comprobar la disponibilidad de la zona
            if ($cardNumberRopeTeam != "" && $_SESSION['userType'] == "M" && $_SESSION['sessionIdUserReservation'] == $userResult["id_user"]){
                $doubleReservationWithMinor = "Y";
            } 

            //Controlamos que un usuario genérico no pueda hacer una reserva en cordada poniendo su mismo número de tarjeta
            if ($cardNumberRopeTeam != "" && $_SESSION['userType'] == "G" && $_SESSION['sessionIdUserReservation'] == $userResult["id_user"]){
                $_SESSION['successFlag'] = "N";
                $_SESSION['message'] = "No se puede crear la reserva porque el número de la tarjeta de tu compañero/a de cordada debe ser diferente al tuyo." ;
                $fail = "";
            }
            if (!isset($fail)) {
                //***********************************************************************************************************//
                // Si lo encontramos y además, el número de tarjeta de la cordada no es igual que el del usuario             //
                // que está haciendo la reserva, comprobamos que el usuario no haya llegado al máximo de reservas permitidas //
                //***********************************************************************************************************//
                try {
                    $sql = "SELECT COUNT(*) AS counter
                            FROM reservations
                            WHERE reservation_status IN ('A', 'P', 'C') 
                            AND user_id = :iduser";   
                    $query = $conn->prepare($sql);
                    $query->bindParam(":iduser", $idUser);                
                    $query->execute();
                    $reservations = $query->fetch(PDO::FETCH_ASSOC);
                    //Si el usuario es genérico y tiene el número máximo de reservas, mostramos un error y no dejamos hacer otra reserva...
                    if ($reservations['counter'] >= $_SESSION['sessionMaxReservationByUser'] && $userResult['user_type'] != 'A' && (($idReservation == "" || $idReservation == " ") || ($idReservation != "" && $idReservation != " " && isset($backToUpdate))  )       ) {
                        $maxReservationByUser = $_SESSION['sessionMaxReservationByUser']; 
                        $_SESSION['successFlag'] = "N";
                        $_SESSION['message'] = "El usuario $userName $cardNumberRopeTeam ha alcanzado el máximo número de reservas activas por usuario que es de $maxReservationByUser, por lo que no se puede crear otra reserva." ; 
                    //Si no ha alcanzado el máximo de reservas, damos el control por correcto y continuamos
                    } else {
                        $checkReservationsNumberUser = "OK";
                    }
                } catch(PDOException $e){
                    $_SESSION['successFlag'] = "C";
                    $queryError = $e->getMessage();  
                    if ($userName != null) {
                        $_SESSION['message'] = "Se ha detectado un problema al consultar el número total de reservas del usuario $userName. </br> Descripción del error: " . $queryError ; 
                    } else {
                        $_SESSION['message'] = "Se ha detectado un problema al consultar el número total de reservas del compañero de cordada con número de tarjeta $cardNumberRopeTeam. </br> Descripción del error: " . $queryError ; 
                    }
                } 
            }

        } else {
            $_SESSION['successFlag'] = "N";
            if ($userName != null) {
                $_SESSION['message'] = "El usuario $userName no existe o no está activo, por lo que no se puede crear la reserva." ; 
                $_SESSION['sessionErrorLookingForUser'] = "";
            } else  {
                $_SESSION['message'] = "El usuario con número de tarjeta $cardNumberRopeTeam no existe o no está activo, por lo que no se puede crear la reserva." ; 
            }
            $userName = "";
        }

    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema a la hora de recuperar la información del usuario. </br> Descripción del error: " . $queryError ; 

    }

}

//**************************************************************************************************************//
// Comprobamos si ya existe una reserva el mismo día. Sólo para ausuarios genéricos                             //
// Si existe, se hará otro control para comprobar que la reserva no se está haciendo en la misma franja horaria //
// de alguna reserva pendiente o de franjas horarias consecutivas.                                              //
//**************************************************************************************************************//

if (isset($checkSameReservation) && $checkSameReservation == "Y") {

    if ($reservationType == "doubleReservationWithMinor" && $freeReservations < 2){
        $_SESSION['successFlag'] = "N";
        $_SESSION['message'] = "No se puede hacer la reserva en la zona $zoneNameChoosen porque se superaría el máximo del aforo de la misma. Prueba a seleccionar otra zona." ; 
    
    } else {

        try {
            $sql = "SELECT start_hour 
                      FROM reservations, users, hours
                     WHERE hour_id            = id_hour
                       AND user_id            = id_user
                       AND user_id            = :iduser
                       AND reservation_Date   = :filterreservationdate
                       AND user_type          <> 'A'
                       AND reservation_status IN ('A', 'P', 'C')";
            $query = $conn->prepare($sql); 
            $query->execute(array(":iduser"=>$_SESSION['sessionIdUserSameReservationControl'], ":filterreservationdate"=>$filterReservationDate));  
            $resultCheckSameReservation = $query->fetchAll(PDO::FETCH_OBJ);
        
            //Si existe, comprobaremos las franjas horarias
            if ($resultCheckSameReservation != [] ) {
               $checkTimeZone ="Y";      
            }

            //Si no existe, y no estamos haciendo los controles del compañero/a de cordada, continuaremos con los controles y miraremos en qué zona se está intentando hacer la reserva
            if ($resultCheckSameReservation == [] && !isset($checkTeamRope)) {
                $checkZone = "Y";
            }

            //Si no existe, y estamos haciendo los controles del compañero/a de cordada, daremos por finalizados los controles e insertaremos los registros
            if ($resultCheckSameReservation == [] && isset($checkTeamRope)) {
                $insertReservation = "";
            }

        } catch(PDOException $e){
            $_SESSION['successFlag'] = "C";
            $queryError = $e->getMessage();  
            $_SESSION['message'] = "Se ha detectado un problema al buscar reservas del mismo día. </br> Descripción del error: " . $queryError ;  
        } 
    }
}

//*******************************************************************************************//
// En caso de existir alguna reserva el mismo día se hará otro control para comprobar que    //
// la reserva no se está haciendo en la misma franja horaria o franja horaria consecutiva.   //
//*******************************************************************************************//

if (isset($checkTimeZone) && $checkTimeZone == "Y" ) {

    try {
        $sql = "SELECT id_hour, start_hour
                  FROM hours
              ORDER BY start_hour ASC, end_hour ASC";
        $query = $conn->prepare($sql); 
        $query->execute();
        $arrayTimeZones = $query->fetchAll(PDO::FETCH_OBJ);
    
        //Si no existe el listado de franjas horarias, daremos un error
        if ($arrayTimeZones == [] ){ 
            $_SESSION['successFlag'] = "N";
            $_SESSION['message'] = "Se ha detectado un problema al buscar las franjas horarias." ;       
        //Si existe, con la franja horaria que elegido el usuario, sacaremos las consecutivas (anterior y la posterior) y...
        } else {
            $i = 0;
            $timeZoneFound = "N";
            foreach($arrayTimeZones as $timeZone){
                if ($idHour == $timeZone->id_hour){
                    $indexHourChoosen = $i;
                    $indexAfterHourChoosen  = ($i + 1);
                    $indexBeforeHourChoosen = ($i - 1);
                }
                $i++;
            }

            $hourChoosen = $arrayTimeZones[$indexHourChoosen]->start_hour;
            //Si el usuario ha escogido la última franja horaria, no comprobaremos la franja horaria posterior a la elegida (el índice da error)
            if ($indexAfterHourChoosen == $i){
                $afterHourChoosen  = "noCheck";
            } else {
                $afterHourChoosen  = $arrayTimeZones[$indexAfterHourChoosen]->start_hour;
            }
            //Si el usuario ha escogido la primera franja horaria, no comprobaremos la franja horaria anterior a la elegida (el índice da error)
            if ($indexBeforeHourChoosen < 0){
                $beforeHourChoosen = "noCheck";
            } else {
                $beforeHourChoosen = $arrayTimeZones[$indexBeforeHourChoosen]->start_hour;
            }
            
            //...compararemos las tres franjas horarias con las franjas horarias de las reservas que ya tiene el usuario ese mismo día
            foreach($resultCheckSameReservation as $possibleSameReservation){
                if($hourChoosen == $possibleSameReservation->start_hour){
                    $_SESSION['successFlag'] = "N";
                    if (isset($checkTeamRope)){
                        $_SESSION['message'] = "Lo sentimos, pero no se puede crear la reserva porque tu compañero de cordada con número de tarjeta $cardNumberRopeTeam ya tiene una reserva ese día a la misma hora." ; 
                    } else {
                        $_SESSION['message'] = "Lo sentimos, pero no se puede crear la reserva porque ya tienes una reserva ese día a la misma hora." ; 
                    }
                } else if ($afterHourChoosen == $possibleSameReservation->start_hour || $beforeHourChoosen == $possibleSameReservation->start_hour){
                    $_SESSION['successFlag'] = "N";
                    if (isset($checkTeamRope)){
                        $_SESSION['message'] = "Lo sentimos, pero no se puede crear la reserva porque tu compañero/a de cordada con número de tarjeta $cardNumberRopeTeam, no puede tener varias reservas el mismo día en franjas horarias consecutivas. Prueba a seleccionar otra franja horaria." ; 
                    } else {
                        $_SESSION['message'] = "Lo sentimos, pero no puedes crear varias reservas el mismo día en franjas horarias consecutivas. Prueba a seleccionar otra franja horaria." ; 
                    }
                } else {
                    $checkZone = "Y";
                    if (isset($checkTeamRope)){
                        $checkZone = "N";
                        $insertReservation = "";
                    }
                }
            }

        }

    } catch(PDOException $e){
        $_SESSION['successFlag'] = "C";
        $queryError = $e->getMessage();  
        $_SESSION['message'] = "Se ha detectado un problema al buscar posibles reservas duplicadas o en horas consecutivas. </br> Descripción del error: " . $queryError ;  
    }

}   


//Comprobamos en qué zona se está haciendo la reserva
if (isset($checkZone) && $checkZone == "Y" ){
    include "reservationRoutesControls.php";
}


 
?>
