<?php
require('include/connectbdd.php');

if (!empty($_SESSION['id_user']) and !empty($_SESSION['pseudo']) and !empty($_SESSION['nom']) and !empty($_SESSION['prenom'])) {
    header('Location: page_connexion.php');
} else {
?>

    <!DOCTYPE html>
    <html lang="fr">
    <!-- header connecté -->

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        if (!empty($title)) {
        ?>
            <title><?= $title;
                } ?></title>
            <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
            <a href="index_user.php">
                <div id="logo">
                    <img class="logo" src="logo2.PNG" alt="logo">
                </div>
            </a>
            <div id="nomsession">
                <!-- on affiche nom prenom session -->
                <button class="bouton_nom">
                    <?php
                    echo '<img class="iconlog" src="img/iconlog.PNG" alt="iconlog"/> ' . $_SESSION['nom'] . '' . $_SESSION['prenom'];
                    ?>
                </button>
                <button class="bouton_parametre" onclick="window.location.href = 'parametres.php';">Paramètre du compte</button>
                <button class="bouton_deconnexion" onclick="window.location.href = 'page_deconnexion.php';">Déconnexion</button>
            <?php
        }
            ?>
            </div>
        </header>
    </body>

    </html>