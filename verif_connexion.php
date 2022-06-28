<?php
session_start();
require('include/connectbdd.php');
//recuperation de l'utilisateur et de son mot de passe
$req = $bdd->prepare('SELECT id_user, nom, prenom, password FROM users WHERE username = ?');
$req->execute(array($_POST['username']));
$resultat = $req->fetch();

if(!empty($_POST['username']) AND !empty($_POST['password']))
{
    //comparaison mot de passe 
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

    if(!$isPasswordCorrect)
    {
        header('Location: page_connexion.php?err=password');
    }
    else{
        S_SESSION['id_user'] = $resultat['id_user'];
        S_SESSION['pseudo'] = $_POST['username'];
        S_SESSION['nom'] = $resultat['nom'];
        S_SESSION['prenom'] = $resultat['prenom'];
        header('Location: index.php');
    }
}
else
{
    header('Location: page_connexion.php?err=champs');
}
