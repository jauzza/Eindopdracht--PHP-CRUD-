<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // If there's an error in the connection, you might want to handle it appropriately.
    // You can redirect the user to an error page or show a user-friendly error message.
    exit(); // Stop script execution after connection failure
}

// Start the session
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION["username"]);

// Check if the logout button is clicked
if ($isLoggedIn && isset($_GET["logout"])) {
    // Destroy the session
    session_destroy();
    // Redirect to the login page after logout
    header("location: login.php");
    exit();
}

// Check if the project ID is provided in the URL
if (isset($_GET["id"])) {
    $projectId = $_GET["id"];

    try {
        // Perform the deletion without confirmation
        $query = "DELETE FROM portfoliodb WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $projectId, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to index.php after deletion
        header("location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // If there's an error in the deletion, you might want to handle it appropriately.
        // You can redirect the user to an error page or show a user-friendly error message.
        exit(); // Stop script execution after deletion failure
    }
} else {
    // Redirect to index.php if no project ID is provided
    header("location: index.php");
    exit();
}
?>
