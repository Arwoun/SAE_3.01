<?php
require_once 'conf.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Historique</title>
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

<div class="formulaire-modif">

    <div class="formulaire-view-result">
        <?php
        $stmt2 = $bdd->prepare("SELECT * FROM historique_utilisateur INNER JOIN utilisateur ON historique_utilisateur.user_id = utilisateur.user_id ORDER BY historique_utilisateur.date_action DESC LIMIT 5");
        $stmt2->execute();
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        echo '<h4>Les derniers ajouts et modifications effectués :</h4>';
        echo '<table>';
        echo '<tr>';
        echo '<th>ID Utilisateur</th>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Champ modifié</th>';
        echo '<th>Date de modification</th>';

        echo '</tr>';

        //recuperer las actions supprimé de la table historique_utilisateur
        foreach ($result2 as $row) {
            echo '<tr>';
            echo '<td>' . $row['user_id'] . '</td>';
            echo '<td>' . $row['nom'] . '</td>';
            echo '<td>' . $row['prenom'] . '</td>';
            echo '<td>' . $row['action'] . '</td>';
            echo '<td>' . $row['date_action'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
    </div>
    <div class="formulaire-view-result">
        <?php
        //afficher les dernieres modifications effectuées de la table historique_utilisateur avec foreign key utilisateur_id de la table utilisateur
        $stmt = $bdd->prepare("SELECT * FROM historique_utilisateur WHERE action = 'Suppression utilisateur' ORDER BY date_action DESC LIMIT 10");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<h4>Les dernières suppressions effectuées :</h4>';
        echo '<table>';
        echo '<tr>';
        echo '<th>ID Utilisateur</th>';
        echo '<th>Champ modifié</th>';
        echo '<th>Date de modification</th>';

        echo '</tr>';
        //recuperer las actions ajouté de la table historique_utilisateur
        foreach ($result as $row) {
        echo '<tr>';
            echo '<td>' . $row['user_id'] . '</td>';
            echo '<td>' . $row['action'] . '</td>';
            echo '<td>' . $row['date_action'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        ?>
    </div>
</div>
</body>
<script>
    window.onscroll = function() {
        var navbar = document.getElementById('navbar');
        if (window.pageYOffset > 50) {
            navbar.classList.add('opaque');
        } else {
            navbar.classList.remove('opaque');
        }
    }
</script>
</html>

