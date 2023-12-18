<?php
// Connexion à la base de données depuis le fichier conf.php
require_once 'conf.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Page Admin</title>
</head>

<body>

<div class="navbar" id="navbar">
    <ul>
        <li><a href="page_admin.php">ACCUEIL</a></li>
        <li><a href="#news">ESPECES</a></li>
        <li><a href="#contact">MA COLLECTION</a></li>
        <li><a href="#about">INSCRIPTION</a></li>
        <li><a href="historique_admin.php">HISTORIQUE</a></li>
        <li><a href="edition_admin.php">EDITION</a></li>
    </ul>
</div>

<!-- Formulaire de recherche -->
<div class="formulaire-view">
    <h3>Pour voir un utilisateur</h3>
    <form action="" method="POST">
        <div class="form-control">
            <input type="number" id="user_id" name="user_id" required>
            <label>
                <span style="transition-delay:0ms">U</span><span style="transition-delay:50ms">s</span><span style="transition-delay:100ms">e</span><span style="transition-delay:150ms">r</span><span style="transition-delay:200ms">I</span><span style="transition-delay:250ms">D</span>
            </label>
        </div>

    </form>
    <?php
    // Afficher les informations d'un utilisateur
    if (isset($_POST['user_id'])) {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $stmt = $bdd->prepare("SELECT * FROM utilisateur WHERE user_id=?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo '<div class="formulaire-view-result">';
        echo '<h4>Résultat de la recherche :</h4>';

        if ($result) {
            echo '<p><strong>Nom:</strong> ' . $result['nom'] . '</p>';
            echo '<p><strong>Prénom:</strong> ' . $result['prenom'] . '</p>';
            echo '<p><strong>Email:</strong> ' . $result['email'] . '</p>';
            echo '<p><strong>Mot de passe:</strong> ' . $result['mdp'] . '</p>';
            echo '<p><strong>Date d\'enregistrement:</strong> ' . $result['date_enregistrement'] . '</p>';

        } else {
            echo '<p>Aucun utilisateur trouvé avec cet ID.</p>';
        }

        echo '</div>';
    }
    ?>
</div>

<!-- Formulaire de suppression -->
<div class="formulaire-delete">
    <h3>Pour supprimer un utilisateur</h3>
    <form action="" method="POST">
        <div class="form-control">
            <input type="number" id="delete_user_id" name="delete_user_id" required>
            <label>
                <span style="transition-delay:0ms">I</span><span style="transition-delay:50ms">d</span>
            </label>
        </div>
        <input hidden="hidden" type="submit" name="supprimer" value="Supprimer">
    </form>
    <?php
    try{
        if (isset($_POST['supprimer'])) {
            $user_id = isset($_POST['delete_user_id']) ? $_POST['delete_user_id'] : null;

            // Préparer et exécuter la requête de suppression d'utilisateur
            $delete_user = "DELETE FROM utilisateur WHERE user_id=?";
            $stmt = $bdd->prepare($delete_user);
            $stmt->execute([$user_id]);

            // Enregistrer l'action dans l'historique
            $action = "Suppression utilisateur";
            enregistrerHistorique($bdd, $action, $user_id);

            echo "Utilisateur supprimé avec succès!";
        }
        else {
            echo "Erreur lors de la suppression de l'utilisateur";
        }
    }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Fonction pour enregistrer l'historique

    ?>
</div>



<!-- Formulaire d'ajout -->
<div class="formulaire-add">
    <h3>Pour ajouter un utilisateur</h3>
    <form action="" method="POST" style="display: flex; flex-direction: row; flex-wrap: wrap;">

        <div class="form-control" style="margin-right: 10px;">
            <input type="text" id="nom" name="nom" required>
            <label>
                <span style="transition-delay:0ms">N</span><span style="transition-delay:50ms">o</span><span style="transition-delay:100ms">m</span>
            </label>
        </div>

        <div class="form-control" style="margin-right: 10px;">
            <input type="text" id="prenom" name="prenom" required>
            <label>
                <span style="transition-delay:0ms">P</span><span style="transition-delay:50ms">r</span><span style="transition-delay:100ms">é</span><span style="transition-delay:150ms">n</span><span style="transition-delay:200ms">o</span><span style="transition-delay:250ms">m</span>
            </label>
        </div>

        <div class="form-control" style="margin-right: 10px;">
            <input type="email" id="email" name="email" required>
            <label>
                <span style="transition-delay:0ms">E</span><span style="transition-delay:50ms">m</span><span style="transition-delay:100ms">a</span><span style="transition-delay:150ms">i</span><span style="transition-delay:200ms">l</span>
            </label>
        </div>

        <div class="form-control">
            <input type="password" id="mdp" name="mdp" required>
            <label>
                <span style="transition-delay:0ms">M</span><span style="transition-delay:50ms">o</span><span style="transition-delay:100ms">t</span><span style="transition-delay:150ms">d</span><span style="transition-delay:200ms">e</span><span style="transition-delay:250ms">p</span><span style="transition-delay:300ms">a</span><span style="transition-delay:350ms">s</span><span style="transition-delay:400ms">s</span><span style="transition-delay:450ms">e</span>
            </label>
        </div>

        <input class="button-add" type="submit" name="ajouter" value="Ajouter">
    </form>
</div>


    <?php
    //Ajout d'un utilisateur
    if (isset($_POST['ajouter'])) {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $mdp = $_POST['mdp'] ?? '';

        // Préparer et exécuter la requête d'ajout d'utilisateur
        $ajout_utilisateur = "INSERT INTO utilisateur (nom, prenom, email, mdp, date_enregistrement) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $bdd->prepare($ajout_utilisateur);
        $stmt->execute([$nom, $prenom, $email, $mdp]);

        // Enregistrer l'action dans l'historique
        $action = "Ajout utilisateur";
        $utilisateur_id = $bdd->lastInsertId();
        enregistrerHistorique($bdd, $action, $utilisateur_id);


        //recuperer dans la table utilisateur le dernier id
        $sql = "SELECT * FROM utilisateur ORDER BY user_id DESC LIMIT 1";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $result['user_id'];

        if ($stmt) {
            echo '<div class="formulaire-view-result">';
            echo '<h4>Votre ajout utilisateur :</h4>';
            echo '<p><strong>Id:</strong> ' . $user_id . '</p>';
            echo '<p><strong>Nom:</strong> ' . $nom . '</p>';
            echo '<p><strong>Prénom:</strong> ' . $prenom . '</p>';
            echo '<p><strong>Email:</strong> ' . $email . '</p>';
            echo '<p><strong>Mot de passe:</strong> ' . $mdp . '</p>';
            echo '</div>';
        }
        else {
            echo '<p>Erreur lors de votre ajout de utilisateur</p>';
        }
    }
    ?>
</div>



<?php
    function enregistrerHistorique($bdd, $action, $user_id) {
        $insert_historique = "INSERT INTO historique_utilisateur (action, user_id) VALUES (?, ?)";
        $stmt = $bdd->prepare($insert_historique);
        $stmt->execute([$action, $user_id]);
    }
    ?>
<script src="admin.js"></script>
</body>

</html>
