<?php
ob_start();
// connexion bdd
$title = 'Nouveau mot de passe';
require('include/connecbdd.php');
require_once('include/header_public.php');
session_start();

//si session pas ouverte ne pas afficher page
if (!empty($_SESSION['id_user'])) {
    // si submit
    if (isset($_POST['submit'])) {
        if (!empty($_POST['password'])) {
            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            // metre nouveau mot de passe
            $new_mdp = $bdd->prepare('UPDATE users SET password= :password WHERE username= :username');
            $new_mdp->execute(array(
                'password' => $pass_hash,
                'username' => $_SESSION['pseudo']
            ));
            header('Location: page_connexion.php?ok=password');
        } else {
            echo '<p style="color: rge (255, 0, 0);>Veuillez remplir tous les champs.</p>';
        }
    }
} else {
    header('Location: page_connexion.php');
}
?>
<div id="login">
    <form class="form" method="POST" action="mdp_bdd.php">
        <label for="password">Votre nouveau mot de passe :</label><br />
        <input class="input" type="password" id="password"><br />
        <input class="bouton_connexion" type="submit" value="Valider" name="submit"><br />
    </form>
</div>
<?php
require_once('include/footer.php');
?>