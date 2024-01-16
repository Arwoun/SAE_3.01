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
    <title>Ma Collection</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* This ensures the body takes at least the full height of the viewport */
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

.container {
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    padding: 121px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333;
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

.results {
    margin: 20px;
}

.result-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 20px;
}

.result {
    width: 300px;
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    position: relative;
}

.bookmark {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

.bookmark img {
    width: 24px;
    height: 24px;
}

footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    margin-top: auto;
    width: 100%;
}
        

    </style>
</head>
<body>
<header>
<img src="Dossier/Dossier/Logo/logo-transparent-png3.png" alt="Logo Biopedia">
<div class="header-buttons">
    <a href="page_accueil.php">Accueil</a>
        <a href="espece.php">Espèces</a>
        <a href="ma_collection.php">Ma Collection</a>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['nom_utilisateur'])) {
            echo '<a href="infos_persos.php">Mes Infos Persos</a>';
            echo '<a href="deco.php">Déconnexion</a>';
        } else {
            echo '<a href="inscription.php">Inscription</a>';
            echo ' <a href="connexion.php">Connexion</a>';
        }
        ?>
    </div>
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
