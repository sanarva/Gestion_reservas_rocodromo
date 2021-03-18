<?php

$L = false;
$M = false;
$X = false;
$J = false;
$V = false;
$S = false;
$D = false;

if (isset($hour)){
    $weekDay = $hour->week_day;
}

$weekDayArray = str_split($weekDay);

for($i = 0; $i < count($weekDayArray) ; $i++) {
    switch ($weekDayArray[$i]) {
        case "L":
            $L = true;
            break;
        case "M":
            $M = true;
            break;
        case "X":
            $X = true;
            break;
        case "J":
            $J = true;
            break;
        case "V":
            $V = true;
            break;
        case "S":
            $S = true;
            break;
        case "D":
            $D = true;
            break;
        default:
            alert("Se ha producido un error al cargar los días de la semana");
    }
        
}

?>