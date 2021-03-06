<?php
session_start();
$title = 'Acteur';
require("include/connecbdd.php");
require_once("include/header.php");

// Verifier que $_get['id'] est présent
if (isset($_GET['id']) && empty($_GET['id'])) {
    $id = ($_GET['id']);
    // stock les données de la table acteur dans ($req) ou (id) == $_GET['id']
    $req = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
    $req->execute(array($_GET['id']));
}
if ($req->rowCount() == 1) {
    $donnees = $req->fetch();
    $titre = $donnees['acteur'];
    $contenu = $donnees['description'];
    $images = $donnees['logo'];

    //ajouter des likes
    $likes = $bdd->prepare('SELECT id_like FROM likes WHERE acteur_id = ?');
    $likes->execute(array($id));
    $likes = $likes->rowCount();

    //ajouter des dislikes
    $dislikes = $bdd->prepare('SELECT id_dislike FROM dislikes WHERE acteur_id = ?');
    $dislikes->execute(array($id));
    $dislikes = $dislikes->rowCount();
}
?>

<!-- Presentation acteur -->
<div class="bloc_description">
    <div class="bloc_logoacteur">
        <img class="logoacteur" src="<?php echo $donnees['logo']; ?>" alt="logoacteur" /><br /><br />
    </div>
    <div class="description_acteur">
        <?php
        echo '<h2>' . $donnees['acteur'] . '</h2>';
        echo $donnees['description'];
        ?>
    </div>
</div>

<!-- section commentaire -->
<div id="bloc_commentaire">
    <div class="vote">
        <?php
        // comparer le nombre de commentaire
        $nbr_comm = $bdd->prepare('SELECT COUNT(comment) as countcomment FROM comments WHERE acteur_id =:id_acteur');
        $nbr_comm->execute(array('id_acteur' => $_GET['id']));
        while ($result = $nbr_comm->fetch()) {
            echo '<h3>' . $result['countcomment'] . ' commentaire(s)</h3>';
        }
        ?>

        <!-- ajouter un commentaire -->
        <div class="vote_boutons">
            <button class="bouton_comm" onclick="window.location.href = 'commentaire_post.php?id=<? $_GET['id'] ?>';">Nouveau commentaire</button>

            <!-- bouton like -->
            <div class="vote_boutons">
                <button class="vote_bouton" name="vote" value="like" onclick="window.location.href='action.php?t=2&id; $id; ?>';">
                    <img class="iconlike" src="img/like.png" alt="like" style="cursor:pointer">
                    (<?= $likes ?>)
                </button>

                <!-- bouton dislike -->
                <div class="vote_bouton">
                    <button class="vote_bouton" name="vote" value="dislike" onclick="window.Location.href='action.php?t=2&id=<?= $id; ?>';">
                        <img class="iconlike" src="img/dislike.png" alt="dislike" style="cursor:pointer;">
                        (<?= $dislikes ?>)
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- affichage des commentaire -->
<div class="affichage_comm">
    <?php
    $req->closeCursor();
    // req join tables users et comment pour recuperer les commentaires
    $req = $bdd->prepare('SELECT comments.id_comment, comments.user_id, user.prenom, comments.comment,
            DATE_FORMAT(date_add, \'%d/%m/%y\') AS date_comment
            FROM coments INNER JOIN users ON comments.users_id = users.id_user
            WHERE acteur_id = ? ORDER BY date_add DESC');
    $req->execute(array($_GET['id']));

    while ($donnees = $req->fetch()) {

    ?>
        <p class="nom_com"><?php echo $donnees['prenom']; ?>, le <?php echo $donnees['date_comment']; ?> :</p>
        <p class="com"><?php echo $donnees['comment']; ?></p>

    <?php
    } // fin de boucle des commentaires
    $req->closeCursor();
    ?>
</div>
<?php
require_once('include/footer.php');
?>