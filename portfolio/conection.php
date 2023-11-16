<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $pdo = null; // Set $pdo to null in case of connection failure
}
?>
