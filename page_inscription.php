<?php
$title = 'Inscription';
require('include/connectbdd.php');
require_once('include/header_public.php');
?>

<div id="bloc_page">
    <div id="inscription">
        <h2>Inscription</h2>
        <?php // affiche erreur si pseudo deja utilisé
        if (!empty($_GET['err']) && $_GET['err'] == "pseudo") {
            echo '<p style="color: rgb(252, 116, 106);"><strong> Pseudo déjà utilisé ! </strong></p>';
        }

        // validation si tous les champs sont ok
        if (!empty($_GET['err']) && $_GET['err'] == "champs") {
            echo '<p style="color: rgb(252, 116, 106);"><strong> Veuillez remplir tous les champs !</strong></p>';
        }
        ?>
        <!-- formulaire inscription -->
        <form class="form" method="POST" action="inscription_bdd.php">
            votre nom :
            <input class="input" type="text" name="nom">
            votre prenom :
            <input class="input" type="text" name="prenom">
            votre pseudo :
            <input class="input" type="text" name="pseudo">
            votre mot de passe :
            <input class="input" type="password" name="password">
            votre question secrète : <br>
            <select class="input" name="choix">
                <option value="choix1">Le nom de jeune fille de votre mère</option>
                <option value="choix2">Le nom de votre premier animal de compagnie</option>
                <option value="choix3">La ville de naissance de votre père</option>
            </select><br>
            Réponse à la question secrète :
            <input class="input" type="text" name="reponse">
            <input class="bouton_connexion" type="submit" name="valider" value="Valider">
        </form>
    </div>
</div>
<?php
require_once('include/footer.php');
?>