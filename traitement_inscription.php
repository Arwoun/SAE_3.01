<?php
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

if (isset($_POST['ok'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['motdepasse'];

    $email_exists_query = $bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = :email");
    $email_exists_query->bindParam(':email', $email);
    $email_exists_query->execute();
    $email_exists = $email_exists_query->fetchColumn();

    if ($email_exists) {
        echo "L'adresse email est déjà utilisée. Veuillez en choisir une autre.";
    } else {
        $requete = $bdd->prepare("INSERT INTO utilisateur (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)");
        $requete->execute(
            array(
                "nom" => $nom,
                "prenom" => $prenom,
                "email" => $email,
                "mdp" => $mdp
            )
        );

        header('Location: confirmation_inscri.php'); 
    }
}
?>
