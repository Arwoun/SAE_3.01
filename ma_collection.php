<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("fonction.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Naturothèque</title>
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

.logo-container img {
    height: 50px; /* ou toute autre taille souhaitée */
    margin-right: 20px; /* espace entre le logo et la navigation */
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
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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

img {
    width: 200px; /* Définit une largeur spécifique */
    height: auto; /* Maintient le rapport hauteur-largeur original */
}

    </style>
</head>
<body>
<header>


<img src="Dossier/Dossier/biopedia_black.png" alt="Logo Biopedia">
<nav>
<div class="header-buttons">
    <a href="page_accueil.php">Accueil</a>
        <a href="espece.php">Recherche</a>
        <a href="naturoteque2.php">Naturothèque</a>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['nom_utilisateur'])) {
            echo '<a href="infos_persos.php">Mes Infos Persos</a>';
            echo '<a href="deco.php">Déconnexion</a>';
        } else {
            echo '<a href="page_inscription.php">Inscription</a>';
            echo ' <a href="page_connexion.php">Connexion</a>';
        }
        ?>
    </div>
    </nav>
</header>


<h1>Ma Naturothèque</h1>
<h3>Retrouvez vos espèces favorites</h3>
<br><br>

<div class="results">
    <?php
    $userId = getCurrentUserId();

    if ($userId) {
        $favoriteAnimalIds = getFavoriteAnimalIds($userId);

        if (!empty($favoriteAnimalIds)) {
            $count = 0;

            foreach ($favoriteAnimalIds as $animalId) {
                $apiUrl = "https://taxref.mnhn.fr/api/taxa/$animalId";
                $response = file_get_contents($apiUrl);

                if ($response) {
                    $data = json_decode($response, true);

                    if (isset($data['id'])) {
                        if ($count % 3 == 0) {
                            echo '<div class="result-row">';
                        }

                        echo '<div class="result">';
                        echo '<h3>Informations sur l\'animal</h3>';
                        echo '<strong>Nom scientifique :</strong> ' . $data['scientificName'] . '<br>';
                        echo '<strong>Autorité :</strong> ' . $data['referenceNameHtml'] . '<br>';
                        echo '<strong>ID animal :</strong> ' . $data['id'] . '<br>';

                        if (isset($data['_links']['media']['href'])) {
                            $mediaLink = "https://taxref.mnhn.fr/api/media/download/thumbnail/{$data['id']}";
                            echo '<img src="' . $mediaLink . '" style="height:200px;width:300px">';
                        } else {
                            echo '<p>Aucune image trouvée pour cet animal.</p>';
                        }
                        echo '</div>';

                        $count++;

                        if ($count % 3 == 0 || $count == count($favoriteAnimalIds)) {
                            echo '</div>';
                        }
                    }
                }
            }
        } else {
            echo '<p>Votre collection est vide.</p>';
        }
    } else {
        echo 'Utilisateur non connecté.';
    }
    ?>
</div>
</body>
</br>
</br>
</br>
<footer>
 </br>
    <p>&copy; 2024 Naturothèque. All rights reserved.
        </br>
    </br> Site réalisé dans le cadre d'un projet universitaire par : 
    </br> Ouissal Jarrari, Axelle Peenaert, Arwin Nirmaladas, Axel Alves
        </p>
    </footer>
</html>
