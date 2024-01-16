<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naturothèque</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* This ensures the body takes at least the full height of the viewport */
        }

        header {
            background-color: #333;
            text-align: left;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        header img {
            max-width: 150px;
        }

        .container {
            max-width: 50px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
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

        #container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        #left, #right {
            flex: 1;
            text-align: center;
            position: relative;
        }

        #left img,
        #right img {
            width: 90%;
            height: auto;
            display: block;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: transform 0.3s;
            cursor: pointer;
            position: relative; /* Add position relative */
            z-index: 0; /* Set a base z-index value */
        }

        #left img:hover,
        #right img:hover {
            transform: scale(1.1);
            z-index: 1; /* Increase z-index on hover to ensure it appears above other elements */
        }


        #left a,
        #right a {
            text-decoration: none;
            color: inherit;
            display: block;
            padding: 10px; /* Add padding to make the clickable area larger */
        }

        footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        margin-top: auto;
        width: 100%;
        }
        footer p {
            margin: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="Dossier/Dossier/Logo/logo-transparent-png3.png" alt="Logo Biopedia">
        <div class="header-buttons">
            <a href="page_accueil.php">Accueil</a>
            <a href="#">Espèces</a>
            <a href="ma_collection.php">Ma Collection</a>
            <a href="inscription.php">Inscription</a>
            <a href="connexion.php">Connexion</a>
        </div>
    </header>
    <br>
    <div id="container">
        <div id="left">
            <a href="ma_collection.php">
                <img src="Dossier/Logo/1.png" alt="Image Gauche">
            </a>
        </div>
        <div id="right">
            <a href="les_collections.php">
                <img src="Dossier/Logo/12.png" alt="Image Droite">
            </a>
        </div>
    </div>  
</body>
<br>
 <footer>
 </br>
    <p>&copy; 2024 Naturothèque. All rights reserved.
    </br>
    </br> Site réalisé dans le cadre d'un projet universitaire par : 
    </br> Ouissal Jarrari, Axelle Peenaert, Arwin Nirmaladas, Axel Alves
    </p>
    </footer>
</html>
