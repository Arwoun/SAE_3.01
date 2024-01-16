<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Page Base de données</title>
</head>

<body>

<div class="navbar" id="navbar">
    <ul>
        <li><a href="page_admin.php">ACCUEIL</a></li>
        <li><a href="#news">ESPECES</a></li>
        <li><a href="#contact">MA COLLECTION</a></li>
        <li><a href="#about">INSCRIPTION</a></li>
        <li><a href="historique_admin.php">HISTORIQUE</a></li>
        <li><a href="edition_admin.php">EDITION</a></li>
        <li><a href="Base_donnes.php">BASE DONNÉES </a></li>

    </ul>
</div>


<?php
require_once 'conf.php';

// Déclaration de variables pour les messages
$backupMessage = '';
$restoreMessage = '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sauvegarde
    if (isset($_POST['executeBackup'])) {
        // Construit le nom du fichier de sauvegarde avec la date du jour
        $backupFileName = 'save/backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        // Chemin complet vers le fichier .bat
        $batFilePath = __DIR__ . DIRECTORY_SEPARATOR . 'backup_script.bat';

        // Contenu du fichier .bat pour effectuer la sauvegarde
        $batContent = 'mysqldump -u root  user > ' . $backupFileName;

        // Écrit le contenu dans le fichier .bat
        file_put_contents($batFilePath, $batContent);

        // Exécute le fichier .bat
        $output = shell_exec($batFilePath);

        // Affiche un message de sauvegarde
        $backupMessage = "Sauvegarde effectuée avec succès!";
        
    } elseif (isset($_POST['executeRestore'])) {
        // Vérifie si un fichier a été sélectionné
        if (isset($_FILES['restoreFile']) && $_FILES['restoreFile']['error'] == UPLOAD_ERR_OK) {
            // Récupère le nom du fichier de sauvegarde depuis le formulaire
            $restoreFileName = $_FILES['restoreFile']['tmp_name'];

            // Chemin complet vers le fichier .bat de chargement
            $batFilePath = __DIR__ . DIRECTORY_SEPARATOR . 'restore_script.bat';

            // Contenu du fichier .bat pour effectuer le chargement
            $batContent = 'mysql -u root user < ' . $restoreFileName;

            // Écrit le contenu dans le fichier .bat
            file_put_contents($batFilePath, $batContent);

            // Exécute le fichier .bat
            $output = shell_exec($batFilePath);

            // Affiche un message de restauration
            $restoreMessage = "Chargement de la sauvegarde effectué avec succès!";
        } else {
            // Affiche un message d'erreur si aucun fichier n'est sélectionné pour la restauration
            $restoreMessage = "Veuillez sélectionner un fichier pour la restauration!";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Page Base de données</title>
</head>

<body>

<div class="content">
    <br>
    <br>
    <br>
    <br>
    <form method="post" action="" enctype="multipart/form-data">

    <!-- Bouton pour effectuer la sauvegarde -->
    <button class="btn-12" type="submit" name="executeBackup"><span>Effectuer la sauvegarde</span></button>
        
    <!-- Input pour spécifier le fichier de sauvegarde -->
    <label for="restoreFile" class="custom-btn-file">Choisir le fichier de sauvegarde</label>
    <input type="file" name="restoreFile" id="restoreFile" class="btn-12 btn-file">
        
    <!-- Bouton pour charger la sauvegarde -->
    <button class="btn-12" type="submit" name="executeRestore"><span>Charger la sauvegarde</span></button>
    </form>

    <!-- Affiche le message de sauvegarde -->
    <?php if (!empty($backupMessage)) : ?>
    <p><?php echo $backupMessage; ?></p>
    <?php endif; ?>

    <!-- Affiche le message de restauration si un fichier a été sélectionné -->
    <?php if (!empty($restoreMessage) ) : ?>
    <p><?php echo $restoreMessage; ?></p>
    <?php endif; ?>
    
</div>
</body>
</html>