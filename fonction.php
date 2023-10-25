<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}

function getFavoritesForUser($userId) {
    global $bdd;

    $stmt = $bdd->prepare("SELECT a.id, a.scientificName, a.referenceNameHtml, l.href as mediaLink
                          FROM collection_utilisateur cu
                          JOIN animaux a ON cu.animal_id = a.id
                          LEFT JOIN media_links l ON a.id = l.id
                          WHERE cu.utilisateur_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isAnimalInFavorites($userId, $animalId) {
    global $bdd;

    $stmt = $bdd->prepare("SELECT id FROM enregistrements WHERE user_id = :userId AND animal_id = :animalId");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':animalId', $animalId);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

function getCurrentUserId() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        return null;
    }
}

function insertAnimalToFavorites($userId, $animalId) {
    global $bdd;

    $sql = "INSERT INTO enregistrements (user_id, animal_id) VALUES (?, ?)";
    $stmt = $bdd->prepare($sql);
    $result = $stmt->execute([$userId, $animalId]);

    return $result;
}

function removeAnimalFromFavorites($userId, $animalId) {
    global $bdd;

    $sql = "DELETE FROM enregistrements WHERE user_id = ? AND animal_id = ?";
    $stmt = $bdd->prepare($sql);
    $result = $stmt->execute([$userId, $animalId]);

    return $result;
}
function getFavoriteAnimalIds($userId) {
    global $bdd;

    $stmt = $bdd->prepare("SELECT animal_id FROM enregistrements WHERE user_id = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
}
function getAnimalData($animalId) {
    $apiUrl = "https://taxref.mnhn.fr/api/taxa/$animalId";
    return json_decode(file_get_contents($apiUrl), true);
}
?>
