<?php
global $bdd;
include_once("conf.php");

$query = 'SELECT utilisateur.user_id, utilisateur.nom, utilisateur.prenom, utilisateur.date_enregistrement, COUNT(enregistrements.id) as nombre_animaux
    FROM utilisateur
    LEFT JOIN enregistrements ON utilisateur.user_id = enregistrements.user_id
    GROUP BY utilisateur.user_id';

$result = $bdd->query($query);

if (!$result) {
    die("Erreur dans la requête : " . $bdd->errorInfo()[2]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Collections</title>
    <style>
    body {
        font-family: Arial, sans-serif;       
        background-color: #f0f0f0; 
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    header {
        background-color: #333;
        text-align: left;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    header img {
        max-width: 150px;
    }

            .user-block {
                border: 1px solid #ccc;
                padding: 10px;
                margin: 10px;
            }
            
    footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        margin-top: auto;
        width: 100%;
    }

    footer p {
        margin: 10px;
    }

    .header-buttons {
        text-align: right;
    }

    .header-buttons a {
        display: inline-block;
        margin-left: 10px;
        padding: 10px 20px;
        background-color: #88c34a;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .header-buttons a:hover {
        background-color: #66a230;
    }

    </style>
</head>
<body>
<header>
        <img src="Dossier/Dossier/Logo/logo-transparent-png3.png" alt="Logo Biopedia">
        <div class="header-buttons">
            <a href="page_accueil.php">Accueil</a>
            <a href="#">Espèces</a>
            <a href="ma_collection.php">Ma Collection</a>
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
        </div>
    </header>
<h1>Les Collections des Utilisateurs</h1>

<?php
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="user-block">';
    echo '<p>ID Utilisateur : ' . $row['user_id'] . '</p>';
    echo '<p>Nom Utilisateur : ' . $row['nom'] . '</p>';
    echo '<p>Prénom Utilisateur : ' . $row['prenom'] . '</p>';
    echo '<p>Date de Création : ' . $row['date_enregistrement'] . '</p>';
    echo '<p>Nombre d\'Animaux : ' . $row['nombre_animaux'] . '</p>';
    echo '<a href="voir_collection.php?utilisateur=' . $row['user_id'] . '">Voir la Collection</a>';
    echo '</div>';
}
?>

</body>
<footer>
 </br>
    <p>&copy; 2024 Naturothèque. All rights reserved.
    </br>
    </br> Site réalisé dans le cadre d'un projet universitaire par : 
    </br> Ouissal Jarrari, Axelle Peenaert, Arwin Nirmaladas, Axel Alves
    </p>
    </footer>
</html>
