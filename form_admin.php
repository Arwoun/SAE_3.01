<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = new PDO('mysql:host=localhost;dbname=user', 'root', '');

    $query = $db->prepare("SELECT * FROM admin WHERE email = :email AND mot_de_passe = :password");
    $query->execute(['email' => $email, 'password' => $password]);
    $admin = $query->fetch();

    if ($admin) {

        $code = rand(1000, 9999);

        $updateQuery = $db->prepare("UPDATE admin SET code = :code WHERE email = :email");
        $updateQuery->execute(['code' => $code, 'email' => $email]);

        include 'admin_email.php';
        $result = send_email($email, $code);

        if (strpos($result, 'Le code a été envoyé avec succès') !== false) {
            header('Location: admin_form.php');
            exit();
        } else {
            $error_message = "Erreur lors de l'envoi du code par e-mail.";
        }
    } else {
        $error_message = "L'administrateur n'existe pas ou le mot de passe est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
</head>
<body>
    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
    <form method="post" action="form_admin.php">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
