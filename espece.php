<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("fonction.php");

function getAnimalImages($animalId) {
    $mediaLink = '';
    $mediaUrl = "https://taxref.mnhn.fr/api/media/download/thumbnail/$animalId";
    try {
        $mediaData = file_get_contents($mediaUrl);
        if ($mediaData) {
            $mediaData = json_decode($mediaData, true);
            foreach ($mediaData['_embedded']['media'] as $media) {
                $mediaLink = $media['_links']['thumbnailFile']['href'];
                echo '<div class="carousel-item">';
                echo '<img class="carousel-image" src="' . $mediaLink . '" alt="Image">';
                echo '<p>Copyright: ' . $media['copyright'] . '</p>';
                echo '<p>Licence: ' . $media['licence'] . '</p>';
                echo '</div>';
            }
        } else {
            echo 'Pas d\'image disponible.';
        }
    } catch (Exception $e) {
        echo 'Erreur lors de la récupération des images.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espèces</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #FFFF;
            text-align: left;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            max-width: 200px;
        }

        h1 {
            color: #333;
            text-align: center;
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

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: auto;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #88c34a;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        #loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        #loading img {
            max-width: 100px;
        }

        .results {
            margin: 100px;
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
        #editFormPopup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        #popupContent {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .carousel {
            display: flex;
            overflow: hidden;
            width: 100%;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 100%;
            transition: transform 0.5s ease-in-out;
        }

        .carousel img {
            width: 100%;
            height: auto;
        }
    </style>
    <script>
        function showEditForm(animalId, scientificName, referenceNameHtml, mediaLink) {
            var editFormContent = '<h2>Détails de l\'animal</h2>' +
                '<p><strong>Nom scientifique :</strong> ' + scientificName + '</p>' +
                '<p><strong>Autorité :</strong> ' + referenceNameHtml + '</p>' +
                '<p><strong>ID animal :</strong> ' + animalId + '</p>';

            if (mediaLink) {
                editFormContent += '<p><strong>Images :</strong></p><div id="carousel" class="carousel">';
                editFormContent += '<?php getAnimalImages("' + animalId + '"); ?>';
                editFormContent += '</div>';
            } else {
                editFormContent += '<p>Pas d\'image disponible.</p>';
            }

            document.getElementById('popupContent').innerHTML = editFormContent;
            document.getElementById('editFormPopup').style.display = 'flex';
        }

        function closeEditForm() {
            document.getElementById('editFormPopup').style.display = 'none';
        }
    </script>
</head>
<body>
<header>
    <img src="Logo/ANPF.png" alt="ANPF">
    <div class="header-buttons">
        <a href="page_accueil.php">Accueil</a>
        <a href="espece.php">Espèces</a>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['nom_utilisateur'])) {
            echo '<a href="infos_persos.php">Mes Infos Persos</a>';
            echo include 'bouton_deconnexion.php';
        } else {
            echo include 'bouton_connexion.php';
            echo '<a href="inscription.php">Inscription</a>';
        }
        ?>
    </div>
</header>

<h1>Résultats de la recherche de Taxons</h1><br><br><br>
<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    echo $user_id;
} else {
    echo 'Utilisateur non connecté.';
}
?>

<form method="GET">
    <label for="animalId" style="padding-left: 10px;">Trouver une espèce :</label>
    <input type="text" id="animalName" name="animalName" placeholder="Entrez le nom de l'animal">
    <input type="submit" name="searchByName" value="Rechercher par Nom"><br><br><br>
</form>

<?php
if (isset($_GET['searchByName']) && isset($_GET['animalName'])) {
    $animalName = $_GET['animalName'];
    $animalNamereplace = str_replace(' ', '%20', $animalName);
    $searchUrl = "https://taxref.mnhn.fr/api/taxa/search?scientificNames=$animalNamereplace&page=1&size=5000";
    $responsebis = file_get_contents($searchUrl);

    if ($responsebis) {
        $databis = json_decode($responsebis, true);

        if (isset($databis['_embedded']['taxa'])) {
            $taxa = $databis['_embedded']['taxa'];

            echo '<h2>Résultats de la recherche :</h2>';
            echo '<div class="results">';

            $count = 0;

            foreach ($taxa as $data) {
                if ($count % 3 == 0) {
                    echo '<div class="result-row">';
                }

                echo '<div class="result">';
                echo '<div class="bookmark">';
                echo '<form method="POST" action="ajouter_favoris.php">';
                echo '<input type="hidden" name="animal_id" value="' . $data['id'] . '">';

                if (isset($_SESSION['nom_utilisateur'])) {
                    $userId = $_SESSION['user_id'];
                    if (isAnimalInFavorites($userId, $data['id'])) {
                        echo '<button type="submit" name="remove_favorite">';
                        echo '<img src="Logo/signet_jaune.png" alt="Signet Jaune">';
                    } else {
                        echo '<button type="submit" name="add_favorite">';
                        echo '<img src="Logo/signet_vide.png" alt="Signet Vide">';
                    }
                } else {
                    echo 'Connectez-vous pour ajouter aux favoris.';
                }

                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '<h3>Informations sur l\'animal</h3>';
                echo '<strong>Nom scientifique :</strong> ' . $data['scientificName'] . '<br>';
                echo '<strong>Autorité :</strong> ' . $data['referenceNameHtml'] . '<br>';
                echo '<strong>ID animal :</strong> ' . $data['id'] . '<br>';
                $animalId = $data['id'];

                $mediaLink = '';

                if (isset($data['_links']['media']['href'])) {
                    $animalId = $data['id'];
                    $mediaLink2 = "https://taxref.mnhn.fr/api/media/download/inpn/$animalId";
                    echo '<img src="' . $mediaLink2 . '" style="height:200px;width:300px">';
                } elseif (isset($data['_links']['media']['href'])) {
                    try {
                        $mediaLink = "https://taxref.mnhn.fr/api/media/download/thumbnail/$animalId";
                        echo '<img src="' . $mediaLink . '" style="height:200px;width:300px">';
                    } catch (Exception $e) {
                        echo 'Pas d\'image disponible.';
                    }
                }

                echo '<p><a href="#" onclick="showEditForm(\'' . $data['id'] . '\', \'' . $data['scientificName'] . '\', \'' . $data['referenceNameHtml'] . '\', \'' . $mediaLink . '\')">Afficher plus de détails</a></p>';

                echo '</div>';
                $count++;
                if ($count % 3 == 0 || $count == count($taxa)) {
                    echo '</div>';
                }
            }

            echo '</div>';
        } else {
            echo '<p>Aucune information trouvée pour cet animal.</p>';
        }
    } else {
        echo '<p>Erreur lors de la requête API.</p>';
    }
}
?>
<div id="editFormPopup" style="display: none;">
    <div id="popupContent"></div>
    <span onclick="closeEditForm()" style="cursor: pointer; position: absolute; top: 10px; right: 10px; font-size: 20px; color: #fff;">&times;</span>
</div>
</body>
</html>
