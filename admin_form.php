<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <link rel="stylesheet" href="style_form.css">
</head>
<body>
<form class="form-card" action="" method="post">
    <p class="form-card-title">Nous vous avons envoyé un email!</p>
    <p class="form-card-prompt">Entrer le code envoyé :</p>
    <div class="form-card-input-wrapper">
        <label>
            <input class="form-card-input" id="code" name="code" placeholder="   code" type="number" required maxlength="4">
        </label>
    </div>
    <button class="form-card-submit" type="submit">Verify</button>
</form>

<?php
$code = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];


}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $check_code = "SELECT * FROM admin WHERE code=?";
    $stmt = $bdd->prepare($check_code);
    $stmt->execute([$code]);
    $result = $stmt->fetch();

    if ($result) {
        header('Location: page_admin.php');
        echo "Code correct";

        exit();
    } else {
        echo "Code incorrect";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</body>
</html>
