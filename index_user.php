<?php
session_start();
$title = 'Accueil Membre';
require('include/connecbdd.php');
require_once('include/header.php');
?>
<!-- presentation GBAF -->
<div id="presentation">
    <h1>Bienvenue sur l'extranet de GBAF</h1>
    <p>Le groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 grands groupes frncais :<br /><br />
        BNP paribas <br />
        BPCE<br />
        Crédit Agricole<br />
        Crédit Mutuel-CIC<br />
        Société Générale<br />
        La Banque Postale<br /><br />
        Même s'il existe une forte concurence entre ces entités, elle vont toutes travailler de la même façon pour gérer près de 80 millions de comptes
        sur le territoire national.<br />
        Le GBAF est le représentant de la profession banquaire et des assureurs sur tous les axes de la réglementation financière française.
        Sa mission est de promouvoir l'activité bancaire à l'échelle nationale. C'est aussi un interlocuteur privilégié des pouvoirs publics.
    </p>
    <div id="banniere_image">
        <img src="img/banniere.png" alt="banniere">
    </div>
</div>
<!-- affichage acteurs -->
<div class="separateur"></div>
<div id="bloc_acteur">
    <h2>Acteurs et Partenaires</h2>
    <p>Présentation de la liste des différents acteurs du système bancaire français</p>
</div>
<div id="separateur"></div>
<div id="acteurs">
    <?php
    $req = $bdd->query('SELECT * FROM acteurs');
    //boucle affichage acteur
    while ($donnees = $req->fetch()) {
    ?>
        <div class="styleacteur">
            <img class="logo_acteur_mini" src="<?php echo $donnees['logo']; ?>" alt="acteur_logo_mini" /><br />
            <div class="texteacteur">
                <?php
                echo '<h2>' . $donnees['acteur'] . '</h2>';
                echo substr($donnees['description'], 0, 100) . '...';
                ?>
                <button class="bouton_suite" onclick="window.location.href='acteur.php'?id=<?php echo $donnees['id_acteur']; ?>">Afficher la suite</button>
            </div>
        </div>
    <?php
    } //fin boucle
    ?>
</div>
<?php
require_once('include/footer.php');
?>