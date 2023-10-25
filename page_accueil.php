<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
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

        .tab-buttons {
            text-align: center;
            margin-bottom: 20px;
        }

        .tab-buttons a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #88c34a;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .tab-buttons a:hover {
            background-color: #66a230;
        }

        .section {
            display: none;
        }

        .active-section {
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
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
</style>
</head>
<body>
<header>
    <img src="Logo/ANPF.png" alt="ANPF">
    <div class="header-buttons">
    <a href="page_accueil.php">Accueil</a>
    <a href="espece.php">Espèces</a>
    <a href="ma_collection">Ma Collection</a>
    <a href="inscription.php">Inscription</a>
    <?php
    if (isset($_SESSION['nom_utilisateur'])) {
        echo '<a href="infos_persos.php">Mes Infos Persos</a>';
        echo '<a href="deco.php">Déconnexion</a>'; 
    } else {
        echo '<a href="connexion.php">Connexion</a>';
    }
    ?>
</div>
</header>

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

    <ul>
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
    </ul>
</div>

</body>
</html>