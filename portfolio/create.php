<?php
include 'conection.php';

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $titel = $_POST["titel"];
    $omschrijving = $_POST["omschrijving"];
    $korteOmschrijving = isset($_POST["korte_omschrijving"]) ? $_POST["korte_omschrijving"] : ''; // Check if key exists
    $type = $_POST["type"];
    $jaar = $_POST["jaar"];
    $image = isset($_POST["image"]) ? $_POST["image"] : ''; // Check if key exists

    // Insert new project into the database
    $query = "INSERT INTO portfoliodb (titel, omschrijving, `korte omschrijving`, type, jaar, image) VALUES (:titel, :omschrijving, :korteOmschrijving, :type, :jaar, :image)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':titel', $titel, PDO::PARAM_STR);
    $stmt->bindParam(':omschrijving', $omschrijving, PDO::PARAM_STR);
    $stmt->bindParam(':korteOmschrijving', $korteOmschrijving, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':jaar', $jaar, PDO::PARAM_INT);
    $stmt->bindParam(':image', $image, PDO::PARAM_STR); // Add binding for image
    $stmt->execute();

    // Redirect back to index.php after insertion
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-25 m-auto">
        <?php
        // Display the logout button if logged in
        if ($isLoggedIn) {
            echo '<a href="?logout" class="btn btn-danger">Logout</a>';
            // Display a message if the session is active
            echo "<p style='color: green;'>Session is active for user: " . $_SESSION["username"] . "</p>";
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1 class="h3 mb-3 fw-normal">Create Project</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingTitel" name="titel" placeholder="Titel" required>
                <label for="floatingTitel">Titel</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" id="floatingOmschrijving" name="omschrijving" placeholder="Omschrijving" required></textarea>
                <label for="floatingOmschrijving">Omschrijving</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" id="floatingKorteOmschrijving" name="korte_omschrijving" placeholder="Korte Omschrijving" required></textarea>
                <label for="floatingKorteOmschrijving">Korte Omschrijving</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingType" name="type" placeholder="Type" required>
                <label for="floatingType">Type</label>
            </div>
            <div class="form-floating">
                <input type="year" class="form-control" id="floatingJaar" name="jaar" placeholder="Jaar" required>
                <label for="floatingJaar">Jaar</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingImage" name="image" placeholder="Image URL" required>
                <label for="floatingImage">Image URL</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">
                Create Project
            </button>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
