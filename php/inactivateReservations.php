<?php

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

try {
  //Recuperamos la fecha actual
  $currentDate = date("Y-m-d");

  //Inactivamos todas las reservas que sean de días anteriores al actual
  $sql  =  "UPDATE reservations
               SET reservation_status = 'I'  
                 , user_modification = '999999'
                 , timestamp = current_timestamp
             WHERE reservation_status != 'I'
               AND reservation_date   < :currentdate";
  $query = $conn->prepare($sql);
  $query->bindParam(":currentdate", $currentDate);
  $query->execute();

} catch (Exception $e) {
  $_SESSION['successFlag'] = "N";
  $queryError = $e->getMessage();  
  $_SESSION['message'] = "Se ha detectado un problema al intentar poner como inactivas las reservas del día anterior. </br> Descripción del error: " . $queryError ; 
}

try {
  //Calculamos el tsultmod de hace 24h
  $yesterday = date("Y-m-d H:i:s", strtotime("-24 hours"));

  //Cancelamos todas las reservas que no hayan sido confirmadas antes de 24h
  $sql  =  "UPDATE reservations
               SET reservation_status = 'I'  
                 , user_modification = '999999'
                 , timestamp = current_timestamp
             WHERE reservation_status != 'I'
               AND reservation_status IN ('P', 'C')
               AND timestamp   <= :yesterday";
  $query = $conn->prepare($sql);
  $query->bindParam(":yesterday", $yesterday);
  $query->execute();

} catch (Exception $e) {
  $_SESSION['successFlag'] = "N";
  $queryError = $e->getMessage();  
  $_SESSION['message'] = "Se ha detectado un problema al intentar cancelar las reservas no confirmadas. </br> Descripción del error: " . $queryError ; 
}


?>