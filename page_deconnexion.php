<?php
session_start();

//suppression des variable et de la session
$_SESSION = array();
session_destroy();

//suppression cookies connexion automatique

setcookie('login', '');
setcookie('pass hash', '');
header('location: page_connexion.php');
