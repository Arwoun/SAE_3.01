<?php
require_once 'conf.php';

function enregistrerHistorique($bdd, $action, $user_id) {
    $insert_historique = "INSERT INTO historique_utilisateur (action, user_id) VALUES (?, ?)";
    $stmt = $bdd->prepare($insert_historique);
    $stmt->execute([$action, $user_id]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['rechercher'])) {
        $recherche = $_POST['recherche'] ?? '';
        $stmt = $bdd->prepare("SELECT * FROM utilisateur WHERE nom LIKE ? OR prenom LIKE ? OR user_id = ? ORDER BY user_id");
        $stmt->execute(["%$recherche%", "%$recherche%", $recherche]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<div class="formulaire-view-result">';
        echo '<h4>Résultats de la recherche :</h4>';
        echo '<table>';
        echo '<tr>';
        echo '<th>ID Utilisateur</th>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Email</th>';
        echo '<th>Mot de passe</th>';
        echo '<th>Date d\'enregistrement</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $row['user_id'] . '</td>';
            echo '<td>' . $row['nom'] . '</td>';
            echo '<td>' . $row['prenom'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['mdp'] . '</td>';
            echo '<td>' . $row['date_enregistrement'] . '</td>';
            echo '<td><button onclick="showEditForm(' . $row['user_id'] . ', \'' . $row['nom'] . '\', \'' . $row['prenom'] . '\', \'' . $row['email'] . '\', \'' . $row['mdp'] . '\')">Modifier</button></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    } elseif (isset($_POST['modifier'])) {
        $user_id = $_POST['edit_user_id'] ?? '';
        $nom = $_POST['edit_nom'] ?? '';
        $prenom = $_POST['edit_prenom'] ?? '';
        $email = $_POST['edit_email'] ?? '';
        $mdp = $_POST['edit_mdp'] ?? '';

        $modifier_utilisateur = "UPDATE utilisateur SET nom=?, prenom=?, email=?, mdp=? WHERE user_id=?";
        $stmt = $bdd->prepare($modifier_utilisateur);
        $stmt->execute([$nom, $prenom, $email, $mdp, $user_id]);

        $action = "Modification utilisateur";
        enregistrerHistorique($bdd, $action, $user_id);

        echo "Utilisateur modifié avec succès!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edition_admin.css">
    <title>Page Admin</title>
</head>

<body>
<div class="navbar" id="navbar">
    <a href="page_admin.php">ACCUEIL</a>
    <a href="#news">ESPECES</a>
    <a href="#contact">MA COLLECTION</a>
    <a href="#about">INSCRIPTION</a>
    <a href="historique_admin.php">HISTORIQUE</a>
    <a href="edition_admin.php">EDITION</a>
</div>

<div class="formulaire-view-result">
    <form action="" method="POST">
        <label for="recherche">Recherche :</label>
        <input type="text" id="recherche" name="recherche" required>
        <input type="submit" name="rechercher" value="Rechercher">
    </form>

    <?php
    if (!isset($_POST['rechercher'])) {
        $stmt = $bdd->prepare("SELECT * FROM utilisateur");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<h4>Les utilisateurs :</h4>';
        echo '<table>';
        echo '<tr>';
        echo '<th>ID Utilisateur</th>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Email</th>';
        echo '<th>Mot de passe</th>';
        echo '<th>Date d\'enregistrement</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        foreach ($result as $row) {
            echo '<tr>';
            echo '<td>' . $row['user_id'] . '</td>';
            echo '<td>' . $row['nom'] . '</td>';
            echo '<td>' . $row['prenom'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['mdp'] . '</td>';
            echo '<td>' . $row['date_enregistrement'] . '</td>';
            echo '<td><button onclick="showEditForm(' . $row['user_id'] . ', \'' . $row['nom'] . '\', \'' . $row['prenom'] . '\', \'' . $row['email'] . '\', \'' . $row['mdp'] . '\')">Modifier</button></td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    ?>
</div>

<!-- Ajout de l'élément modal manquant -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Modifier Utilisateur</h2>
        <form id="editForm" action="" method="POST">
            <label for="edit_nom">Nom :</label>
            <input type="text" id="edit_nom" name="edit_nom" required>

            <label for="edit_prenom">Prénom :</label>
            <input type="text" id="edit_prenom" name="edit_prenom" required>

            <label for="edit_email">Email :</label>
            <input type="email" id="edit_email" name="edit_email" required>

            <label for="edit_mdp">Mot de passe :</label>
            <input type="password" id="edit_mdp" name="edit_mdp" required>

            <input type="hidden" id="edit_user_id" name="edit_user_id">
            <input type="submit" name="modifier" value="Enregistrer">
            <button type="button" onclick="closeModal()">Fermer</button>
        </form>
    </div>
</div>

<script src="admin.js"></script>

</body>
</html>
