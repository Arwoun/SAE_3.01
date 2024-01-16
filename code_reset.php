<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de réinitialisation</title>
<style>

        body {
            font-family: Arial, sans-serif;
            background-color: #5e655c;
            margin: 0;
            padding: 0;
        }


        .container {
            max-width: 625px;
            background-color:  #C8C8C8;
            padding: 41px;
            padding-top: 20px;
            border-radius: 31px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 180px auto;
        }

        h1 {
            color: #525252;
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
            border-radius: 3px;
            box-sizing: border-box;
            border: 3px solid #A9A9A9;
            background-color: #C0C0C0; /* Fond des champs de saisie */
            color: #fff; /* Texte en blanc */
        }

        input[type="submit"] {
            background-color: #525252;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
        background-color: #8FBC8F; /* Effet hover pour le bouton soumettre */
        }


        #loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        #loading img {
            max-width: 100px;
        }

        .logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 20vh;
    z-index: 1000; /* Assure que le logo reste au-dessus du contenu */
}

.logo-container img {
    max-width: 100%;
    max-height: 100%;
    margin: 0 auto; /* Centre l'image horizontalement */
}

</style>
</head>
<body>
    <div class="logo-container">
        <img src="Dossier/Dossier/Logo/logo-transparent-png3.png" alt="Logo de votre site">
    </div>
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
