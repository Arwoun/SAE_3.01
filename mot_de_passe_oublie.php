<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
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

        input[type="email"] {
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
        <div class="section active-section" id="mot-de-passe-oublie">
            <h1>Mot de passe oublié</h1>

            <p>Entrez votre adresse e-mail pour réinitialiser votre mot de passe.</p>
            <form action="" method="POST">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>

                <input type="submit" value="Réinitialiser le mot de passe">
            </form>

<?php
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "user";

            try {
                $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $email = $_POST['email'];
                    $check_email = "SELECT * FROM utilisateur WHERE email=?";
                    $stmt = $bdd->prepare($check_email);
                    $stmt->execute([$email]);
                    $result = $stmt->fetch();

                    if ($result) {
                        $code = rand(100000, 999999); 
                        $update_password = "UPDATE utilisateur SET mdp=? WHERE email=?";
                        $stmt = $bdd->prepare($update_password);
                        $stmt->execute([$code, $email]);
                        require 'send_email.php';
                        $mail = new PHPMailer(true);
                        try {
                            header("Location: http://localhost/SAE_3.01/code_reset.php");
                            exit;
                            $mail->send();                            
                        } catch (Exception $e) {
                            echo "";
                        }
                    } else {
                        echo "Cette adresse e-mail n'existe pas dans notre base de données.";
                    }
                }
            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
                exit;
            }
?>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            var sections = document.querySelectorAll('.section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>
