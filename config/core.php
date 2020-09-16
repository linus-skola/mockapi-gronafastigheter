<?php
// show error reporting
error_reporting(E_ALL);
 
// set your default time-zone
date_default_timezone_set("Europe/Stockholm");
$date = strtotime("now");
$dateExp = strtotime("+1 hour");
// variables used for jwt
$key = "w8Xv#d$%SFZYO@iceX3xLN8cp^oBQ7^@G9IuTO&eKNwxrI*QWQN0QvXS69Dlmb&vH5qVg#OxhEl*f$*3NoEqXv9zQSSpmudmmNX";
$iss = "gronafastigheter.se";
$aud = "gronafastigheter.se";
$iat = $date;
$nbf = $date;
$exp = $dateExp;