<?php

//Recuperamos la fecha actual
$currentDate = date("Y-m-d");

// Incluímos la conexión a la base de datos que está en el fichero database.php
require "database.php";

//Inactivamos todas las reservas que sean de días anteriores al actual
$sql  =  "UPDATE reservations
             SET reservation_status = 'I'  
               , user_modification = '999999'
               , timestamp = current_timestamp
           WHERE reservation_status = 'A'
             AND reservation_date   < :currentdate";
$query = $conn->prepare($sql);
$query->bindParam(":currentdate", $currentDate);
$query->execute();


?>