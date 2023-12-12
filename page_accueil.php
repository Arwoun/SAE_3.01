<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link type="text/css" rel="stylesheet" href="accueil.css">
</head>
<body>
    <div class="navbar" id="navbar">
        <ul>
            <li><a href="page_accueil.php">ACCUEIL</a></li>
            <li><a href="espece.php">ESPECES</a></li>
            <li><a href="ma_collection">MA COLLECTION</a></li>
            <li><a href="inscription.php">INSCRIPTION</a></li>
            <?php
            if (isset($_SESSION['nom_utilisateur'])) {
                echo '<li><a href="infos_persos.php">MES INFOS PERSOS</a></li>';
                echo '<li><a href="deco.php">DECONNEXION</a></li>';
            } else {
                echo '<li><a href="connexion.php">CONNEXION</a></li>';
            }
            ?>
        </ul>
    </div>

<div class="container">
    <h1>Résultats de la recherche de Taxons</h1>

    <form method="GET">
        <label for="animalId">Rechercher par ID :</label>
            <input type="text" id="animalId" name="animalId" placeholder="ID de l'animal">
            <input type="submit" name="searchById" value="Rechercher par ID"><br><br><br>
        <label for="animalName">Rechercher par Nom :</label>
            <input type="text" id="animalName" name="animalName" placeholder="Nom de l'animal">
            <input type="submit" name="searchByName" value="Rechercher par Nom"><br><br><br>
        <label for="animalName">Rechercher approximative par nom ou auteur:</label>
            <input type="text" id="animalNameappro" name="animalNameappro" placeholder=" Auteur ou Nom de l'animal">
            <input type="submit" name="searchByappro" value="Rechercher approximative par nom ou auteur">
    </form>
        <?php

        # Nous faison la recherche par le Nom
        if (isset($_GET['searchByName']) && isset($_GET['animalName'])) {
            $animalName = $_GET['animalName'];
            $animalNamereplace = str_replace(' ', '%20', $animalName);
            $searchUrl = "https://taxref.mnhn.fr/api/taxa/search?scientificNames=$animalNamereplace&page=1&size=5000";
            $responsebis = file_get_contents($searchUrl);

            if ($responsebis) {
                $databis = json_decode($responsebis, true);

                if (isset($databis['_embedded']['taxa'][0])) {
                    $data = $databis['_embedded']['taxa'][0];
                    echo '<h2>Informations sur l\'animal</h2>';
                    echo '<strong>Nom scientifique :</strong> ' . $data['scientificName'] . '<br>';
                    echo '<strong>Autorité :</strong> ' . $data['referenceNameHtml'] . '<br>';
                    echo '<strong>ID animal :</strong> ' . $data['id'] . '<br>';
                    if (isset($data['_links']['media']['href'])) {
                        $animalId = $data['id'];
                        $mediaLink = "https://taxref.mnhn.fr/api/media/download/thumbnail/$animalId";
                        echo '<img src="' . $mediaLink . '" style="height:200px;width:300px">';
                    } else {
                        echo '<p>Aucune image trouvée pour cet animal.</p>';
                    }
                } else {
                    echo '<p>Aucune information trouvée pour cet animal.</p>';
                }
            } else {
                echo '<p>Erreur lors de la requête API.</p>';
            }
        }

        # Nous faison la recherche par le Nom ou auteur cette fois-ci
        else if (isset($_GET['searchByappro']) && isset($_GET['animalNameappro'])) {
            $animalNameappro = $_GET['animalNameappro'];
            $animalNameapproreplace = str_replace(' ', '%20', $animalNameappro);
            $searchUrlappro = "https://taxref.mnhn.fr/api/taxa/fuzzyMatch?term=$animalNameapproreplace";
            $responseter = file_get_contents($searchUrlappro);

            if ($responseter) {
                $datater = json_decode($responseter, true);

                if (isset($datater['_embedded']['taxa'][0])) {
                    $data = $datater['_embedded']['taxa'][0];
                    echo '<h2>Informations sur l\'animal</h2>';
                    echo '<strong>Nom scientifique :</strong> ' . $data['scientificName'] . '<br>';
                    echo '<strong>Autorité :</strong> ' . $data['referenceNameHtml'] . '<br>';
                    echo '<strong>ID animal :</strong> ' . $data['id'] . '<br>';
                    if (isset($data['_links']['media']['href'])) {
                        $animalId = $data['id'];
                        $mediaLinkbis = "https://taxref.mnhn.fr/api/media/download/thumbnail/$animalId";
                        echo '<img src="' . $mediaLinkbis . '" style="height:200px;width:300px">';
                    } else {
                        echo '<p>Aucune image trouvée pour cet animal.</p>';
                    }
                } else {
                    echo '<p>Aucune information trouvée pour cet animal.</p>';
                }
            } else {
                echo '<p>Erreur lors de la requête API.</p>';
            }
        }

        # Nous faisons la recherche par L'ID cette fois ci 
        else if (isset($_GET['searchById']) && isset($_GET['animalId'])) {
            $animalId = $_GET['animalId'];
            $apiUrl = "https://taxref.mnhn.fr/api/taxa/$animalId";

            $response = file_get_contents($apiUrl);

            if ($response) {
                $data = json_decode($response, true);

                if (isset($data['scientificName'])) {

                    echo '<h2>Informations sur l\'animal</h2>';
                    echo '<strong>Nom scientifique :</strong> ' . $data['scientificName'] . '<br>';
                    echo '<strong>Autorité :</strong> ' . $data['referenceNameHtml'] . '<br>';
                    echo '<strong>ID animal :</strong> ' . $data['id'] . '<br>';
                    echo '<strong>Reference ID :</strong> ' . $data['referenceId'] . '<br>';
                        if ($data['frenchVernacularName'] = 'null'){
                            echo '<p>Pas de nom français disponible pour cet animal.</p>';
                        }
                        else {
                            echo '<strong> Nom Français : </strong>'. $data['frenchVernacularName'].'<br>';
                        }

                    if (isset($data['_links']['media']['href'])) {
                        $mediaLink2 = "https://taxref.mnhn.fr/api/media/download/inpn/$animalId";
                        echo '<img src="' . $mediaLink2 . '" style="height:200px;width:300px">';
                    } else{
                        $mediaLink = "https://taxref.mnhn.fr/api/media/download/thumbnail/$animalId";
                        echo '<img src="' . $mediaLink . '" style="height:200px;width:300px">';
                    }

                } else {
                    echo '<p>Aucune information trouvée pour cet animal.</p>';
                }
            } else {
                echo '<p>Erreur lors de la requête API.</p>';
            }
        }
        ?>
</div>
<script src="admin.js"></script>
</body>
</html>