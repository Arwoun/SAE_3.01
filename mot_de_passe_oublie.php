<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #5e655c; /* Fond plus sombre pour correspondre à l'image */
        margin: 0;
        padding: 0;
        color: #E5E5E5; /* Texte plus clair pour contraster avec le fond */
    }

    header {
        background-color: #525252; /* Adaptation pour correspondre à l'en-tête de l'image */
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
        max-width: 700px;
        max-height: 500px;
        margin: 20px auto;
        background-color: #C8C8C8; /* Couleur du conteneur modifiée */
        padding: 20px; /* Ajusté pour l'espacement */
        border-radius: 5px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée */
    }

    h1 {
        color: #525252; /* Titre en blanc */
    }

    .header-buttons {
        text-align: right;
    }

    .header-buttons a {
        display: inline-block;
        margin-left: 10px;
        padding: 10px 20px;
        background-color: #2E8B57; /* Couleur adaptée aux boutons de l'image */
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .header-buttons a:hover {
        background-color: #3A5D2F; /* Effet hover plus sombre */
    }

    input[type="email"], input[type="submit"] {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        margin-bottom: 10px;
        border: 3px solid #A9A9A9;
        background-color: #C0C0C0; /* Fond des champs de saisie */
        color: #fff; /* Texte en blanc */
        border-radius: 3px;
    }

    input[type="submit"] {
        background-color: #2E8B57; /* Couleur du bouton soumettre */
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #3A5D2F; /* Effet hover pour le bouton soumettre */
    }

    #loading {
        display: none;
        text-align: center;
        margin-top: 20px;
    }

    #loading img {
        max-width: 100px;
    }
    .texte {
        color: #525252;
    }
</style>

</head>
<body>
<header>
    <img src="Dossier\Dossier\Logo\logo-transparent-png3.png" alt="Biopédia" style="height: 50px; width: auto;">
        <div class="header-buttons">
            <a href="page_accueil.php">Accueil</a>
            <a href="#">Espèces</a>
            <a href="#">Ma Collection</a>
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
        </div>
</header>
<br><br><br><br><br><br>
    <div class="container">
        <div class="section active-section" id="mot-de-passe-oublie">
            <h1>Mot de passe oublié</h1>

            <p class ="texte">Entrez votre adresse e-mail pour réinitialiser votre mot de passe.</p>
            <form action="" method="POST">
                <label for="email" class="texte">Adresse e-mail :</label>
                <input type="email" id="email" name="email" required>

                <input type="submit" value="Réinitialiser le mot de passe">
            </form>
        </div>
    </div>

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