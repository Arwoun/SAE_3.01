<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['email_utilisateur'])) {
    $email_utilisateur = $_SESSION['email_utilisateur'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "votre_base_de_donnees";

    try {
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT nom, prenom, email FROM utilisateur WHERE email = :email";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':email', $email_utilisateur, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $nom_utilisateur = $row['nom'];
            $prenom_utilisateur = $row['prenom'];
        } else {
            echo "Aucune information trouvée pour cet utilisateur.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations Personnelles</title>
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
            padding: 121px;
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
            color: #fff;
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
        <a href="#">Espèces</a>
        <a href="#">Ma Collection</a>
        <a href="inscription.php">Inscription</a>
        <?php
        session_start();
        if (isset($_SESSION['email_utilisateur'])) {
            echo '<a href="deco.php">Se déconnecter</a>';
        } else {
            echo '<a href="connexion.php">Connexion</a>';
        }
        ?>
    </div>
</header>

    <div class="container">
        <h1>Informations Personnelles</h1>
        <p><strong>Nom d'utilisateur :</strong> <?php echo $nom_utilisateur; ?></p>
        <p><strong>Email :</strong> <?php echo $email_utilisateur; ?></p>
    </div>
</body>
</html>
