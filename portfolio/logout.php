<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION["username"])) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    header("location: index.php");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("location: index.php");
    exit();
}
?>
