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
    </style>
</head>
<body>
<h1>Collection de l'Utilisateur</h1>

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
</body>
</html>
