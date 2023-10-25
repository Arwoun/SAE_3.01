<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de réinitialisation</title>
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
        <a href="connexion.php">Connexion</a>
    </div>
</header>
<div class="container">
        <div class="section active-section" id="code-reset">
            <h1>Code de réinitialisation</h1>

            <p>Entrez votre email, le code de réinitialisation que vous avez reçu par e-mail, et votre nouveau mot de passe.</p>
            <form action="" method="POST">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>

                <label for="code">Code de réinitialisation :</label>
                <input type="text" id="code" name="code" required>

                <label for="nouveau-mot-de-passe">Nouveau mot de passe :</label>
                <input type="password" id="nouveau-mot-de-passe" name="nouveau-mot-de-passe" required>

                <input type="submit" value="Changer le mot de passe">
            </form>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $email = $_POST['email'];
                $code_saisi = $_POST['code'];
                $nouveau_mot_de_passe = $_POST['nouveau-mot-de-passe'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "user";
                
                try {
                    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $check_code = "SELECT * FROM utilisateur WHERE email=? AND mdp=?";
                    $stmt = $bdd->prepare($check_code);
                    $stmt->execute([$email, $code_saisi]);
                    $result = $stmt->fetch();
                    
                    if ($result) {
                        $update_password = "UPDATE utilisateur SET mdp=? WHERE email=?";
                        $stmt = $bdd->prepare($update_password);
                        $stmt->execute([$nouveau_mot_de_passe, $email]);
                        
                        echo "Mot de passe mis à jour avec succès.";
                        echo '<div id="loading" style="display: block;"><img src="Logo/loading.gif" alt="Chargement en cours"></div>';
                        echo '<script>setTimeout(function(){ window.location.href = "page_accueil.php"; }, 2000);</script>';
                    } else {
                        echo "Le code de réinitialisation est incorrect pour cet email.";
                    }
                } catch (PDOException $e) {
                    echo "Erreur de connexion à la base de données : " . $e->getMessage();
                    exit;
                }
            }
            ?>
    </div>
</div>
</body>
</html>
