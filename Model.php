<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>