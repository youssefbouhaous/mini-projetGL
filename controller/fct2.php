<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fonctionnalité 2</title>
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
  <div class="container">
    <h1>proposition des plats</h1>
    <form action="" method="post">
      <label for="proteins">Protéines :</label>
      <input type="text" name="proteins" id="proteins" class="form-control">
      <label for="glucids">Glucides :</label>
      <input type="text" name="glucids" id="glucids" class="form-control">
      <label for="sugar">Sucre:</label>
      <input type="text" name="sugar" id="sugar" class="form-control">
      <button type="submit" class="btn btn-primary mt-3">Trouver le plat le plus proche</button>
    </form>
    <div class="container d-flex justify-content-end fixed-bottom mb-3 mr-3">
    <a href="../view/bienvenue.php" class="btn btn-primary">Choisir une autre fonctionnalité</a>
      <a href="../view/logout.php" class="btn btn-danger">Deconnexion</a>
    </div>
    <?php
    if (isset($_POST['proteins']) && isset($_POST['glucids']) && isset($_POST['sugar'])) {

      $targetProteins = (float)$_POST['proteins'];
      $targetGlucids = (float)$_POST['glucids'];
      $targetSugar = (float)$_POST['sugar'];

      $dbh = new PDO('mysql:host=localhost;dbname=projet', "root", "");

      $stm = $dbh->prepare("SELECT DISTINCT nom FROM plat");
      $stm->execute();
      $dishes = $stm->fetchAll(PDO::FETCH_ASSOC);

      $closestDish = null;
      $closestDistance = PHP_FLOAT_MAX;

      foreach ($dishes as $dish) {
        $stm = $dbh->prepare("SELECT * FROM plat JOIN ingrediants ON plat.ingrediant = ingrediants.nom WHERE plat.nom = ?");
        $stm->bindParam(1, $dish['nom']);
        $stm->execute();
        $ingredients = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($ingredients)) {
          $sumProteins = 0;
          $sumGlucids = 0;
          $sumSugar = 0;

          foreach ($ingredients as $ingredient) {
            $quantity = (float)$ingredient['quantite'];
            $sumProteins += ($ingredient['Proteines'] * $quantity / 100);
            $sumGlucids += ($ingredient['Glucides'] * $quantity / 100);
            $sumSugar += ($ingredient['Sucres'] * $quantity / 100);
          }

          $distance = sqrt(pow($sumProteins - $targetProteins, 2) + pow($sumGlucids - $targetGlucids, 2) + pow($sumSugar - $targetSugar, 2));

          if ($distance < $closestDistance) {
            $closestDish = $dish['nom'];
            $closestDistance = $distance;
          }
        }
      }

      if ($closestDish) {
        // Fetch the source image from the imgplat table
        $stm = $dbh->prepare("SELECT srcimg FROM imgplat WHERE nom = ?");
        $stm->bindParam(1, $closestDish);
        $stm->execute();
        $imageRow = $stm->fetch(PDO::FETCH_ASSOC);
        echo '<h2>Closest Dish: ' . $closestDish . '</h2>';
        if ($imageRow && isset($imageRow['srcimg'])) {
          $imageSrc = $imageRow['srcimg'];
      
          // Display the closest dish with its image
         
        } else {
          $imageSrc="../imgs/defaultdish.png";
        }
        
        echo '<img src="../imgs/' . $imageSrc . '" alt="' . $closestDish . '" width="200">';
        echo '<table class="table table-bordered mt-4">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>Ingredient</th><th>Quantity</th></tr>';
        
        // Fetch and display the ingredients for the closest dish
        $stm = $dbh->prepare("SELECT * FROM plat JOIN ingrediants ON plat.ingrediant = ingrediants.nom WHERE plat.nom = ?");
        $stm->bindParam(1, $closestDish);
        $stm->execute();
        $ingredients = $stm->fetchAll(PDO::FETCH_ASSOC);
      
        foreach ($ingredients as $ingredient) {
          echo '<tr>';
          echo '<td>' . $ingredient['ingrediant'] . '</td>';
          echo '<td>' . $ingredient['quantite'] . '</td>';
          echo '</tr>';
        }
      
        echo '</table>';
      } else {
        echo '<p>No dishes found.</p>';
      }
      
    }
    ?>
  </div>
</body>

</html>
