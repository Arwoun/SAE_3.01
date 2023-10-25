<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
</head>
<body>

<div class="container">
    <form action="" method="POST">
        <?php
        include 'input_admin.php';
        ?>
    </form>
</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

//recupere les données du userInput
if (isset($_POST['userInput'])) {
    $userInput = $_POST['userInput'];
    echo $userInput;
    try{
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user_id = "SELECT * FROM utilisateur WHERE user_id =?";
        $stmt = $bdd->prepare($user_id);
        $stmt->execute([$userInput]);
        $result = $stmt->fetch();

        echo $result;
    }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
</body>
</html>
