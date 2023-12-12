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
        .user-block {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }
    </style>
</head>
<body>
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
</html>
