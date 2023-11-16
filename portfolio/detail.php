<?php
include 'conection.php';

try {
  $id = $_GET["id"]; // Move this line up

  $stmt = $pdo->prepare("SELECT * FROM portfoliodb WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  // Set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

  foreach ($stmt->fetchAll() as $row) {
    // Process the retrieved data, e.g., display it
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio Website - Overzichtspagina</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <?php
  try {
    $stmt = $pdo->prepare("SELECT * FROM portfoliodb WHERE id = $id   ");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt->fetchAll() as $k => $v) {
  ?>
      <main>
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
            <div id="project1" class="project card shadow-sm card-body m-2">
              <div class="card-text">
                <h2><?php echo ($v['titel']); ?></h2>
                <div><b><?php echo ($v['omschrijving']); ?></b></div>
                <div><?php echo ($v['type']); ?></div>
                <div><?php echo ($v['jaar']); ?></div>
                <?php
                // Check if the 'image' column exists and is not empty
                if (isset($v['image']) && !empty($v['image'])) {
                  echo '<div class="mt-3"><img src="' . $v['image'] . '" alt="Project Image" class="img-fluid"></div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </main>

  <?php
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
