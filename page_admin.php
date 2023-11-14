<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Page Admin</title>
</head>
<body>

<!-- Formulaire de recherche -->
<div class="formulaire-view">
    <h3>Pour voir un utilisateur</h3>
    <form action="" method="POST">
        <label for="user_id">Id :</label>
        <input type="number" id="user_id" name="user_id" required>
        <input type="submit" value="Rechercher">
    </form>
</div>

<!-- Formulaire de suppression -->
<div class="formulaire-delete">
    <h3>Pour supprimer un utilisateur</h3>
    <form action="" method="POST">
        <label for="delete_user_id">Id :</label>
        <input type="number" id="delete_user_id" name="delete_user_id" required>
        <input type="submit" name="supprimer" value="Supprimer">
    </form>
</div>

<!-- Formulaire d'ajout -->
<div class="formulaire-add">
    <h3>Pour ajouter un utilisateur</h3>
    <form action="" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required>

        <input type="submit" name="ajouter" value="Ajouter">
    </form>
</div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ajouter un nouvel utilisateur à la base de données
        if (isset($_POST['ajouter'])) {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $mdp = $_POST['mdp'] ?? '';

            // Vérifier si l'utilisateur existe déjà
            $stmt = $bdd->prepare("SELECT * FROM utilisateur WHERE email=?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                echo "Cet utilisateur existe déjà!";
                return;
            }

            // Préparer et exécuter la requête d'ajout d'utilisateur
            $ajout_utilisateur = "INSERT INTO utilisateur (nom, prenom, email, mdp, date_enregistrement) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $bdd->prepare($ajout_utilisateur);
            $stmt->execute([$nom, $prenom, $email, $mdp]);

            // Enregistrer l'action dans l'historique
            $action = "Ajout utilisateur";
            $utilisateur_id = $bdd->lastInsertId(); // Récupérer l'ID de l'utilisateur ajouté
            enregistrerHistorique($bdd, $action, $utilisateur_id);

            echo "Utilisateur ajouté avec succès!";
        } // Supprimer un utilisateur existant
        elseif (isset($_POST['supprimer'])) {
            $user_id = isset($_POST['delete_user_id']) ? $_POST['delete_user_id'] : null;

            // Préparer et exécuter la requête de suppression d'utilisateur
            $delete_user = "DELETE FROM utilisateur WHERE user_id=?";
            $stmt = $bdd->prepare($delete_user);
            $stmt->execute([$user_id]);

            // Enregistrer l'action dans l'historique
            $action = "Suppression utilisateur";
            enregistrerHistorique($bdd, $action, $user_id);

            echo "Utilisateur supprimé avec succès!";
        }
        // Afficher les informations d'un utilisateur
        elseif (isset($_POST['user_id'])) {
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
            $stmt = $bdd->prepare("SELECT * FROM utilisateur WHERE user_id=?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //si l'utilisateur n'existe pas
            if (!$result) {
                echo "Utilisateur non trouvé!";
                return;
            }
            echo "<pre>";
            print_r($result);
            echo "</pre>";
        }


        function enregistrerHistorique($bdd, $action, $utilisateur_id) {
            $insert_historique = "INSERT INTO historique_utilisateur (action, utilisateur_id) VALUES (?, ?)";
            $stmt = $bdd->prepare($insert_historique);
            $stmt->execute([$action, $utilisateur_id]);
        }
    }
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</body>
</html>
