<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=extranet;charset=utf-8', 'root', 'root');
} catch (Exception $e) {
    die('erreur' . $e->getMessage());
}
