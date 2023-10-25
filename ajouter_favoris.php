<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("fonction.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $animalId = $_POST["animal_id"];
    $userId = getCurrentUserId();

    if (isset($_POST["add_favorite"])) {
        $checkQuery = "SELECT COUNT(*) FROM enregistrements WHERE user_id = :user_id AND animal_id = :animal_id";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':user_id', $userId);
        $checkStmt->bindParam(':animal_id', $animalId);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            if (isAnimalInFavorites($userId, $animalId)) {
                echo "Cet animal est déjà dans vos favoris.";
            } else {
                if (insertAnimalToFavorites($userId, $animalId)) {
                    header('Location: confirmation.php');
                    exit;
                } else {
                    echo "Erreur lors de l'ajout aux favoris.";
                }
            }
        } else {
            echo "Cet animal est déjà enregistré dans vos enregistrements.";
        }
    } elseif (isset($_POST["remove_favorite"])) {
        if (isAnimalInFavorites($userId, $animalId)) {
            if (removeAnimalFromFavorites($userId, $animalId)) {
                header('Location: confirmation.php');
                exit;
            } else {
                echo "Erreur lors de la suppression des favoris.";
            }
        } else {
            echo "Cet animal n'est pas dans vos favoris.";
        }
    }
}
?>
