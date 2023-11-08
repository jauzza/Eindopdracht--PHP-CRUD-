<?php
$servername = "localhost";
$username = "root";
$password = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=portfolio", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_GET['search_query'])) {
    $search_query = $_GET['search_query'];

    try {
        $stmt = $conn->prepare("SELECT * FROM portfoliodb WHERE titel LIKE :search_query");
        $search_query = '%' . $search_query . '%'; // Add wildcard for partial matching
        $stmt->bindParam(':search_query', $search_query, PDO::PARAM_STR);
        $stmt->execute();

        // Display the search results
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<h2>" . $row['titel'] . "</h2>";
            echo "<p>" . $row['korte omschrijving'] . "</p>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No search query provided.";
}
?>
