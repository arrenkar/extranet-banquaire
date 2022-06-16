<?php
session_start();
$title = 'like';
require('include/connecbdd.php');
require_once('include/header.php');

// verifie que les $_GET ne sont pas vide
if(isset($_GET['t'], $_GET['id'], $_SESSION['id_user']) AND !empty($_GET['t']) AND !empty($_GET['id']) AND !empty($_SESSION['id_user']))
{

    // stocker information dans variable
    $getid = (int) $_GET['id'];
    $gett = (int) $_GET['t'];
    $sessionid = (int) $_SESSION['id_user'];

    // verifier que id du $_GET existe dans la bdd
    $check = $bdd->prepare('SELECT id_acteur FROM acteurs WHERE id_acteur =?');
    $check->execute(array($getid));

    //si tableau stocké = 1 -> acteur existe
    if($check->rowCount() == 1)
    {
        // 1 -> like
        if($gett == 1)
        {
            // verification utilisateur de la session a like acteur
            $check_like = $bdd->prepare('SELECT id_like FROM likes WHERE acteur_id = ? AND user_id = ?');
            $check_like->execute(array($getid, $sessionid));

            //si utilisateur dislike -> on supprime
            $check_dislike = $bdd->prepare('DELETE FROM dislikes WHERE acteur_id = ? AND user_id = ?');
            $check_dislike->execute(array($getid, $sessionid));

            // like deja present -> on supprime
            if($check_like->rowCount() ==1)
            {
                $dellike = $bdd->prepare('DELETE FROM likes WHere acteur_id = ? AND user_id = ?');
                $dellike->execute(array($getid, $sessionid));
            }

            // si pas de like on ajoute
            else
            {
                $ins = $bdd->prepare('INSERT INTO likes (acteur_id, user_id) VALUE (?, ?)');
                $ins->execute(array($getid, $sessionid));
            }
        }
        // 2 = dilike
        elseif ($gett == 2)
        {
            //verification si acteur a deja dislike acteur
            $check_like = $bdd->prepare('SELECT id_dilike FROM dislikes WHERE acteur_id = ? AND user_id = ?');
            $check_like->execute(array($getid, $sessionid));

            // si utilisateur deja like on supprime like
            $dellike = $bdd->prepare('DELETE FROM likes WHERE acteur_id = ? AND user_id = ?');
            $dellike->execute(array($getid, $sessionid));

            // si dislike -> on supprime
            if($check_like->rowCount() == 1)
            {
                $deldislike = $bdd->prepare('DELETE FROM dislikes WHERE acteur_id = ? AND user_id = ?');
                $deldislike->execute(array($getid, $sessionid));
            }
            // si pas de dislike -> on ajoute
            else
            {
                $ins = $bdd->prepare('INSERT INTO dislikes (acteur_id, user_id) VALUE (?, ?)');
                $ins->execute(array($getid, $sessionid));
            }
        }
        //actualisation page apres action
        header('Location: acteur.php?id=' .$getid);
    }
    else
    {
        exit('Erreur Fatale');
    }
}
else{
    exit('Erreur Fatale. <a href="index_user.php">Revenir à la page d\'accueil</a>');
}
