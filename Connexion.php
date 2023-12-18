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

if (isset($_SESSION['nom_utilisateur'])) {
    $nom_utilisateur = $_SESSION['nom_utilisateur'];
} else {
    $error_msg = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = $_POST['email'];
        $mdp = $_POST['motdepasse'];
        
        if (empty($email) || empty($mdp)) {
            $error_msg = "Veuillez remplir tous les champs.";
        } else {
            $req = $bdd->prepare("SELECT * FROM utilisateur WHERE email = :email AND mdp = :mdp");
            $req->bindParam(':email', $email);
            $req->bindParam(':mdp', $mdp);
            $req->execute();
            $rep = $req->fetch(PDO::FETCH_ASSOC);

            if ($rep) {
                $_SESSION['nom_utilisateur'] = $rep['prenom'];
                $_SESSION['user_id'] = $rep['user_id'];
            } else {
                $error_msg = "Email ou mot de passe incorrect !";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
            <a href="espece.php">Espèces</a>
            <a href="ma_collection.php">Ma Collection</a>
            <?php
            if (isset($_SESSION['nom_utilisateur'])) {
                echo '<a href="infos_persos.php">Mes Infos Persos</a>';
                echo '<a href="deco.php">Déconnexion</a>';
            } else {
                echo '<a href="connexion.php">Connexion</a>';
                echo '<a href="inscription.php">Inscription</a>';
            }
            ?>
        </div>
    </header>
    <div class="container">
        <?php
        if (isset($_SESSION['nom_utilisateur'])) {
            echo "<h1>Bienvenue," .$_SESSION['nom_utilisateur']. "!</h1>";
        } else {
            ?>
            <div class="tab-buttons">
                <img src="Logo/upec.png" alt="logo_upec" style="width: 200px; text-align: left;">
                <a href="inscription.php" style="margin-left: 130px;">Inscription</a>
                <a href="connexion.php">Connexion</a>
            </div>
            <div class="section active-section" id="connexion">
                <h1>Connexion au site</h1>
                <form action="" method="POST">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>

                    <label for="motdepasse">Mot de passe :</label>
                    <input type="password" id="motdepasse" name="motdepasse" required>

                    <input type="submit" value="Se connecter">
                </form>
                <p><a href="mot_de_passe_oublie.php">Mot de passe oublié ?</a></p>

                <?php
                if ($error_msg) {
                    ?>
                    <p><?php echo $error_msg; ?> </p>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
