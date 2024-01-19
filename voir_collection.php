<?php
global $bdd;
include_once("fonction.php");
include_once("conf.php");

if (isset($_GET['utilisateur'])) {
    $utilisateur_id = $_GET['utilisateur'];

    // Récupérer la collection de l'utilisateur
    $query = 'SELECT enregistrements.animal_id, enregistrements.date_enregistrement
        FROM enregistrements
        WHERE enregistrements.user_id = :utilisateur_id
        ORDER BY enregistrements.date_enregistrement DESC';

    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$query2 = 'SELECT utilisateur.nom, utilisateur.prenom, enregistrements.animal_id, enregistrements.date_enregistrement
    FROM utilisateur
    INNER JOIN enregistrements ON utilisateur.user_id = enregistrements.user_id
    WHERE enregistrements.user_id = :utilisateur_id';

$stmt2 = $bdd->prepare($query2);
$stmt2->bindParam(':utilisateur_id', $utilisateur_id, PDO::PARAM_INT);
$stmt2->execute();
$result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection de l'Utilisateur</title>
    <style>
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


.search-bar {
    display: flex;
    justify-content: center;
    padding: 20px;
    background-color: #f8f8f8;
}

.search-bar form {
    display: flex;
    width: 100%;
    max-width: 600px; /* Ajustez en fonction de la largeur désirée */
}

.search-bar input[type="text"] {
    flex-grow: 1;
    padding: 10px 15px;
    font-size: 17px;
    border: 2px solid #ddd;
    border-radius: 25px 0 0 25px; /* Coins arrondis à gauche */
    outline: none;
    transition: border-color 0.3s;
}

.search-bar input[type="text"]:focus {
    border-color: #3d405b; /* Changement de couleur lors de la sélection */
}

.search-bar button {
    border-radius: 0 25px 25px 0; /* Coins arrondis à droite */
    padding: 10px 15px;
    /* Styles du bouton déjà définis dans le CSS précédent */
}

/* Optionnel: Ajouter une ombre portée sur le focus */
.search-bar input[type="text"]:focus {
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
}


.filters-column {
    width: 200px;
    float: left;
    padding: 20px;
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
    </style>
</head>
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
<body>
<h1>Naturothèque de l'Utilisateur : <?php echo $result[0]['nom'] . ' ' . $result[0]['prenom']; ?></h1>

<div class="animal-card">
<?php
if (isset($result) && count($result) > 0) {
    $count = 0;

    foreach ($result as $row) {
        $animalId = $row['animal_id'];
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

                if ($count % 3 == 0 || $count == count($result)) {
                    echo '</div>';
                }
            }
        }
    }
} else {
    echo '<p>Utilisateur non trouvé ou aucune collection enregistrée.</p>';
}
?>
</div>
</body>
<footer>
 </br>
    <p>&copy; 2024 Biopedia. All rights reserved.
    </br>
    </br> Site réalisé dans le cadre d'un projet universitaire par : 
    </br> Ouissal Jarrari, Axelle Peenaert, Arwin Nirmaladas, Axel Alves
    </p>
    </footer>
</html>
