<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        <div class="tab-buttons">
            <img src="Logo/upec.png" alt="logo_upec" style="width: 200px; text-align: left;">
            <a href="inscription.php" style="margin-left: 130px;">Inscription</a>
            <a href="connexion.php">Connexion</a>
        </div>
        <div class="section active-section" id="inscription">
            <h1>Inscription au site</h1>
            <form method="POST" action="traitement_inscription.php">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="email">Email :</label>
                <input type="text" id="email" name="email" required>

                <label for="motdepasse">Mot de passe :</label>
                <input type="password" id="motdepasse" name="motdepasse" required>

                <input type="submit" name="ok" value="S'inscrire">
            </form>
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
