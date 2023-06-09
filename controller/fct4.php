<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fonctionnalité 4</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #C4E7B1;
      background-size: cover;
      background-image: url("../imgs/bg2.png");
    }

    .container {
      padding-top: 150px;
    }

    .footer {
      background-color: #f8f9fa;
      padding: 5px;
      text-align: center;
    }
  </style>
</head>

<body>
    <div class="container d-flex justify-content-end fixed-bottom mb-3 mr-3">
    <a href="../view/bienvenue.php" class="btn btn-primary">Choisir une autre fonctionnalité</a>
      <a href="../view/logout.php" class="btn btn-danger">déconnexion</a>
    </div>
  <div class="container">
    <h1>Selection d'un régime</h1>
    
    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=projet', "root", "");
    // Fetch the distinct regime types from the database
    $stm = $dbh->prepare("SELECT DISTINCT type FROM regime");
    $stm->execute();
    $regimeTypes = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo '<form action="" method="post">';
    echo '<div class="form-group">';
    echo '<label for="regimeType">Selectionner un type de regime:</label>';
    echo '<select name="regimeType" id="regimeType" class="form-control">';

    foreach ($regimeTypes as $regimeType) {
      echo '<option value="' . $regimeType['type'] . '">' . $regimeType['type'] . '</option>';
    }

    echo '</select>';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary mt-3">Select Regime</button>';
    echo '</form>';
    if (isset($_POST['regimeType'])) {
      $regimeType = $_POST['regimeType'];

      // Fetch the regimes with the selected type from the database
      $stm = $dbh->prepare("SELECT * FROM regime WHERE type = ?");
      $stm->bindParam(1, $regimeType);
      $stm->execute();
      $regimes = $stm->fetchAll(PDO::FETCH_ASSOC);

      if (!empty($regimes)) {
        // Display the selected regime and its corresponding dishes
        echo '<h2>Selected Regime</h2>';
        echo '<table class="table table-bordered mt-4">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>Type</th><th>Jour 1</th><th>Jour 2</th><th>Jour 3</th><th>Jour 4</th><th>Jour 5</th><th>Jour 6</th><th>Jour 7</th></tr>';

        foreach ($regimes as $regime) {
          echo '<tr>';
          echo '<td>' . $regime['type'] . '</td>';

          // Fetch the dishes for each jour in the regime
          for ($i = 1; $i <= 7; $i++) {
            $jourId = 'jour' . $i;
            $dishId = $regime[$jourId];

            $stm = $dbh->prepare("SELECT petitdejeune, dejeune, diner FROM jour WHERE id = ?");
            $stm->bindParam(1, $dishId);
            $stm->execute();
            $dish = $stm->fetch(PDO::FETCH_ASSOC);

            echo '<td>' . $dish['petitdejeune'] . '<br>' . $dish['dejeune'] . '<br>' . $dish['diner'] . '</td>';
          }

          echo '</tr>';
        }

        echo '</table>';
      } else {
        echo '<p>No regime found for the selected type.</p>';
      }
    } 
    ?>

  </div>
</body>

</html>
