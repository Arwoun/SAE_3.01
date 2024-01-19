<?php

$elementsParPage = 12;


$pageActuelle = isset($_GET['page']) ? $_GET['page'] : 1;


$pointDeDepart = ($pageActuelle - 1) * $elementsParPage;


include_once("conf.php");
$queryCount = 'SELECT COUNT(user_id) AS total FROM utilisateur';
$totalResult = $bdd->query($queryCount);
$totalRow = $totalResult->fetch();
$totalPages = ceil($totalRow['total'] / $elementsParPage);


$parametresUrl = $_GET;
unset($parametresUrl['page']);

$urlParametres = http_build_query($parametresUrl);


$query = 'SELECT utilisateur.user_id, utilisateur.nom, utilisateur.prenom, utilisateur.date_enregistrement, COUNT(enregistrements.id) as nombre_animaux
    FROM utilisateur
    LEFT JOIN enregistrements ON utilisateur.user_id = enregistrements.user_id
    GROUP BY utilisateur.user_id
    LIMIT :pointDeDepart, :elementsParPage';

$stmt = $bdd->prepare($query);
$stmt->bindParam(':pointDeDepart', $pointDeDepart, PDO::PARAM_INT);
$stmt->bindParam(':elementsParPage', $elementsParPage, PDO::PARAM_INT);
$stmt->execute();


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les  Naturothèques</title>
    <style>
   body {
    font-family: 'Arial', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;

}

header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #f0f0f0;
    padding: 10px 20px;
}

img {
    width: 200px; /* Définit une largeur spécifique */
    height: auto; /* Maintient le rapport hauteur-largeur original */
}



nav {
    background-color: #f0f0f0;
    padding: 10px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

nav a {
    margin: 0 20px;
    margin-left: 20px;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    font-size: 18px;
    border-radius: 4px;
    position: relative;
    transition: color 0.3s;
}

/* Effet de sous-ligne animée */
nav a::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 3px;
    bottom: 0;
    left: 0;
    background-color: #3d405b;
    visibility: hidden;
    transform: scaleX(0);
    transition: all 0.3s ease-in-out 0s;
}

nav a:hover::before {
    visibility: visible;
    transform: scaleX(1);
}

nav a:hover {
    color: #3d405b;
    background-color: transparent;
}

nav a.active {
    color: #3d405b;
    font-weight: bold;
}

/* Style optionnel : Effet d'ombre légère */
nav a:hover, nav a.active {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}


.results-container {
    margin-left: 220px;
    padding: 20px;
}

footer {
    background-color: #f8f8f8;
    color: grey;
    text-align: center;
    margin-top: auto;
    width: 100%;

}

button {
    display: inline-block;
    border-radius: 4px;
    background-color: #3d405b;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 17px;
    padding: 16px;
    width: 130px;
    transition: all 0.5s;
    cursor: pointer;
    margin: 5px;
}

button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
}

button span:after {
    content: '»';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -15px;
    transition: 0.5s;
}

button:hover span {
    padding-right: 15px;
}

button:hover span:after {
    opacity: 1;
    right: 0;
}
.results-container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px;
}


.animal-card {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
}

.animal-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.animal-card h3 {
    margin: 0;
    color: #333333;
    font-size: 1.2em;
}

.animal-card p {
    margin: 10px 0 0;
    color: #666666;
    font-size: 1em;
}
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination a, .pagination .current-page {
    display: inline-block;
    padding: 8px 12px;
    margin: 2px;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
}

.pagination a:hover {
    background-color: #f0f0f0;
}

.pagination .current-page {
    background-color: #3d405b;
    color: #fff;
}
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination a, .current-page {
    padding: 5px 10px;
    margin: 0 5px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #333;
    background-color: #fff;
}

.current-page {
    background-color: #333;
    color: #fff;
}
.about-button {
    background-color: #165580;
    color: white;
    border: none;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
}

.about-button:hover {
    background-color: #165580;
}
.animal-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px; 
}

    

    </style>
</head>
<body>
    <header>
    
        <img src="Dossier/Dossier/biopedia_black.png" alt="Logo Biopedia">
        <nav>
        <div class="button">
            <a href="page_accueil.php">Accueil</a>
            <a href="#">Recherche</a>
            <a href="naturoteque2.php">Naturothèque</a>
            <a href="page_inscription.php">Inscription</a>
            <a href="page_connexion.php">Connexion</a>
        </div>
</nav>
    </header>
    <h1>Les Naturothèques des Utilisateurs</h1>
    <div class="results-grid">

   
        <?php
      
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          
            echo '<div class="animal-row">';
        
            echo '<div class="animal-card">';
            echo '<p>ID Utilisateur : ' . $row['user_id'] . '</p>';
            echo '<p>Nom Utilisateur : ' . $row['nom'] . '</p>';
            echo '<p>Prénom Utilisateur : ' . $row['prenom'] . '</p>';
            echo '<p>Date de Création : ' . $row['date_enregistrement'] . '</p>';
            echo '<p>Nombre d\'Animaux : ' . $row['nombre_animaux'] . '</p>';
            echo '<a href="voir_collection.php?utilisateur=' . $row['user_id'] . '">Voir la Naturothèque</a>';
            echo '</div>';
        
            
            echo '</div>';
        }
        ?>
 </div>
        
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '" class="' . ($i == $pageActuelle ? 'current-page' : '') . '">' . $i . '</a>';
            }
            ?>
       
    </div>
    </div>
</body>
<footer>
<footer>
 </br>
    <p>&copy; 2024 Biopedia. All rights reserved.
    </br>
    </br> Site réalisé dans le cadre d'un projet universitaire par : 
    </br> Ouissal Jarrari, Axelle Peenaert, Arwin Nirmaladas, Axel Alves
    </p>
    </footer>
</footer>
</html>
