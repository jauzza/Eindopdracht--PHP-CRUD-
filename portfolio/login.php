<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio Website - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
  <main class="form-signin w-25 m-auto">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "portfolio";

    try {
      $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      $pdo = null; // Set $pdo to null in case of connection failure
    }
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get the username and password from the form
      $username = $_POST["username"];
      $password = $_POST["password"];

      // Assuming you have a table named "users" with columns "username" and "password"
      $query = "SELECT * FROM users WHERE username = :username AND password = :password";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->bindParam(':password', $password, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // Check if a row is returned (login successful)
      if ($result) {
        // Start a session
        session_start();

        // Store user data in session variables
        $_SESSION["username"] = $username;

        // Redirect to the dashboard or another page
        header("location: index.php");
        exit();
      } else {
        // Display an error message for invalid login
        $error_message = "Invalid username or password";
      }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input type="text" class="form-control" id="floatingUsername" name="username" placeholder="Username" required>
        <label for="floatingUsername">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>

      <button class="btn btn-primary w-100 py-2" type="submit">
        Sign in
      </button>
    </form>

    <?php
    // Display error message, if any
    if (isset($error_message)) {
      echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
  </main>
  <script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>