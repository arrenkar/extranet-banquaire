<?php
ob_start();
//connexion base de donnee
$title = 'mot de passe oublié';
require('include/connecbdd.php');
require_once('include/header_public.php');
session_start();

//si on submit
if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $reponse = htmlspecialchars($_POST['reponse_secrete']);

    //champs rempli
    if (!empty($_POST['username']) and !empty($_POST['reponse_secrete'])) {
        $req = $bdd->prepare('SELECT * FROM users WHERE username = :username');
        $req->execute(array('username' => $username));
        $resultat = $req->fetch();
        // on compare la reponse envoyé par le formulaire avec la base de donnee

        $isAnswerCorrect = (($_POST['username'] == $resultat['username']) and ($_POST['peponse_secrete'] == $resultat['reponse_secrete']));
        if (!$isAnswerCorrect) {
            $erreur = '<p style="color: red;">Données incorectes !</p>';
        } else {
            //renvoyer l'username + reponse vers mdp_bdd

            $_SESSION['id_user'] = $resultat['id_user'];
            $_SESSION['pseudo'] = $resultat['username'];
            $_SESSION['nom'] = $resultat['nom'];
            $_SESSION['prenom'] = $resultat['prenom'];
            header('Location: mdp_bdd.php');
        }
    } else {
        $champs = '<p style="color: rgb(255, 0, 0);">Veuillez remplir tous les champs.</p>';
    }
}
?>

<!-- formulaire pseudo - reponse -->
<div id="login">
    <form class="form" method="POST" action="mdp_oublie.php">
        <label for="username">Votre pseudo</label><br>
        <input class="input" type="text" name="username" id="username"><br>
        <label for="reponse_secrete">Réponse secrète :</label>
        <input class="input" type="text" name="reponse_secrete" id="reponse_secrete">
        <input class="bouton_connexion" type="submit" value="Valider" name="submit"><br>
    </form>
    <?php
    if (isset($erreur)) {
        echo $erreur;
    }
    ?>
    <?php
    if (isset($champs)) {
        echo $champs;
    }
    ?>
</div>
<?php
require_once('include/footer.php');
?>