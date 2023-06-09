<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Function5 Page</title>
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
  </style>
</head>
<body>
  <div class="container">
    <h1>MON JOURNAL</h1>

    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=projet', "root", "");

    $stm = $dbh->prepare("SELECT * FROM journal");
    $stm->execute();
    $dishes = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (count($dishes) > 0) {
      echo '<table class="table table-bordered mt-4">';
      echo '<thead class="thead-dark">';
      echo '<tr>';
      echo '<th>Plat</th>';
      echo '<th>Date</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      foreach ($dishes as $dish) {
        echo '<tr>';
        echo '<td>' . $dish['plat'] . '</td>';
        echo '<td>' . $dish['dateTime'] . '</td>';
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
    } else {
      echo '<p>No dishes found.</p>';
    }
    ?>
      <a href="../view/bienvenue.php" class="btn btn-primary">Retourner à la page bienvenue</a>
  </div>
</body>
</html>
