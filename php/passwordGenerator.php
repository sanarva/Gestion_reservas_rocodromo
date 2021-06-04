<?php

//Carácteres para la nueva contraseña
$possibleChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
$passwordOk = '/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8}$/';

//Buscamos generar una contraseña que cumpla los requisitos(al menos una mayúscula, una minúscula y un número)
do {
   $userNewPassword = "";
   //Construímos la contraseña con los posibles caracteres
   for($i = 0; $i < 8; $i++) {
      //obtenemos un caracter aleatorio escogido de la cadena de caracteres
      $userNewPassword .= substr($possibleChar,rand(0,62),1);
   }
} while (!preg_match($passwordOk, $userNewPassword));

?>