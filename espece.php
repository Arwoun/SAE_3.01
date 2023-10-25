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
</style>
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


                if (isset($data['_links']['media']['href'])) {
                    $animalId = $data['id'];
                    $mediaLink2 = "https://taxref.mnhn.fr/api/media/download/inpn/$animalId";

                    echo '<img src="' . $mediaLink2 . '" style="height:200px;width:300px">';
                }
                elseif (isset($data['_links']['media']['href'])){
                    try {
                        $mediaLink ="https://taxref.mnhn.fr/api/media/download/thumbnail/$animalId";
                        echo '<img src="' . $mediaLink . '" style="height:200px;width:300px">';
                    }
                    catch (Exception $e) {
                        echo 'Pas d\'image disponible.';
                    }
                }
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
</body>
</html>
