<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naturothèque</title>
    <style>
    

        .container {
            max-width: 50px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            width: 97%;
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

       
        
        body {
    font-family: 'Arial', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;

}

header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #f0f0f0;
    padding: 10px 20px;
}

img {
    width: 200px; /* Définit une largeur spécifique */
    height: auto; /* Maintient le rapport hauteur-largeur original */
}

nav {
    background-color: #f0f0f0;
    padding: 10px 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

nav a {
    margin: 0 20px;
    margin-left: 20px;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    font-size: 18px;
    border-radius: 4px;
    position: relative;
    transition: color 0.3s;
}

/* Effet de sous-ligne animée */
nav a::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 3px;
    bottom: 0;
    left: 0;
    background-color: #3d405b;
    visibility: hidden;
    transform: scaleX(0);
    transition: all 0.3s ease-in-out 0s;
}

nav a:hover::before {
    visibility: visible;
    transform: scaleX(1);
}

nav a:hover {
    color: #3d405b;
    background-color: transparent;
}

nav a.active {
    color: #3d405b;
    font-weight: bold;
}

/* Style optionnel : Effet d'ombre légère */
nav a:hover, nav a.active {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}


.search-bar {
    display: flex;
    justify-content: center;
    padding: 20px;
    background-color: #f8f8f8;
}

.search-bar form {
    display: flex;
    width: 100%;
    max-width: 600px; /* Ajustez en fonction de la largeur désirée */
}

.search-bar input[type="text"] {
    flex-grow: 1;
    padding: 10px 15px;
    font-size: 17px;
    border: 2px solid #ddd;
    border-radius: 25px 0 0 25px; /* Coins arrondis à gauche */
    outline: none;
    transition: border-color 0.3s;
}

.search-bar input[type="text"]:focus {
    border-color: #3d405b; /* Changement de couleur lors de la sélection */
}

.search-bar button {
    border-radius: 0 25px 25px 0; /* Coins arrondis à droite */
    padding: 10px 15px;
    /* Styles du bouton déjà définis dans le CSS précédent */
}

/* Optionnel: Ajouter une ombre portée sur le focus */
.search-bar input[type="text"]:focus {
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
}


.filters-column {
    width: 200px;
    float: left;
    padding: 20px;
}

.results-container {
    margin-left: 220px;
    padding: 20px;
}

footer {
    background-color: #f8f8f8;
    color: grey;
    text-align: center;
    margin-top: auto;
    width: 100%;


}

button {
    display: inline-block;
    border-radius: 4px;
    background-color: #3d405b;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 17px;
    padding: 16px;
    width: 130px;
    transition: all 0.5s;
    cursor: pointer;
    margin: 5px;
}

button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
}

button span:after {
    content: '»';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -15px;
    transition: 0.5s;
}

button:hover span {
    padding-right: 15px;
}

button:hover span:after {
    opacity: 1;
    right: 0;
}
.results-container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.animal-card {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
}

.animal-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.animal-card h3 {
    margin: 0;
    color: #333333;
    font-size: 1.2em;
}

.animal-card p {
    margin: 10px 0 0;
    color: #666666;
    font-size: 1em;
}
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination a, .pagination .current-page {
    display: inline-block;
    padding: 8px 12px;
    margin: 2px;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
}

.pagination a:hover {
    background-color: #f0f0f0;
}

.pagination .current-page {
    background-color: #3d405b;
    color: #fff;
}
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination a, .current-page {
    padding: 5px 10px;
    margin: 0 5px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #333;
    background-color: #fff;
}

.current-page {
    background-color: #333;
    color: #fff;
}
.about-button {
    background-color: #165580;
    color: white;
    border: none;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
}

.about-button:hover {
    background-color: #165580;
}
    </style>
</head>
<body>
    <header>
        
        <img class="logo-container"src="Dossier/Dossier/biopedia_black.png" alt="Logo Biopedia">
        <nav>
        <div class="header-buttons">
            <a href="page_accueil.php">Accueil</a>
            <a href="#">Recherche</a>
            <a href="naturoteque2.php">Naturothèque</a>
            <a href="page_inscription.html">Inscription</a>
            <a href="page_connexion.html">Connexion</a>
        </div>
        </nav>
    </header>
    <br>
    <div id="container">
        <div id="left">
            <a href="ma_collection.php">
                <img src="1.png" alt="Image Gauche">
            </a>
        </div>
        <div id="right">
            <a href="les_collections.php">
                <img src="12.png" alt="Image Droite">
            </a>
        </div>
    </div>  
</body>
<br>
 <footer>
 </br>
    <p>&copy; 2024 Biopedia. All rights reserved.
    </br>
    </br> Site réalisé dans le cadre d'un projet universitaire par : 
    </br> Ouissal Jarrari, Axelle Peenaert, Arwin Nirmaladas, Axel Alves
    </p>
    </footer>
</html>
