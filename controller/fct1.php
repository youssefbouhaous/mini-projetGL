<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fonctionnalité 1</title>
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
    <h1>Calcule de la valeur nutritionnelle</h1>
    <form action="fct1.php" method="post">
      <div id="ingredientsList">
        <div class="form-group">
          <label>Sélectionnez un ingrédient existant :</label>
          <select name="existing[]" class="form-control">
            <?php
            $dbh = new PDO('mysql:host=localhost;dbname=projet', "root", "");

            $stm = $dbh->prepare("SELECT nom FROM ingrediants");
            $stm->execute();
            $ingredients = $stm->fetchAll(PDO::FETCH_ASSOC);

            foreach ($ingredients as $ingredient) {
              echo '<option value="' . $ingredient['nom'] . '">' . $ingredient['nom'] . '</option>';
            }
            ?>
          </select>
          <input type="number" name="quantity[]" step="1" class="form-control mt-2" placeholder="Entrer la  quantité">
        </div>
      </div>
      <button type="button" class="btn btn-primary mt-3" onclick="addNewIngredient()">Ajouter un ingredient</button>
      <button type="submit" class="btn btn-success mt-3">Affichage du total </button>
      <a href="fct3.php" class="btn btn-warning mt-3">Enregistrer le plat</a>
      <div class="container d-flex justify-content-end  mb-3 mr-3">
    <a href="../view/logout.php" class="btn btn-danger">Logout</a>
    </div>
    </form>
    <script>
  function generateIngredientHTML(ingredients) {
    var ingredientHTML = '<label>Select a new ingredient:</label>';
    ingredientHTML += '<select name="existing[]" class="form-control">';
    for (var i = 0; i < ingredients.length; i++) {
      ingredientHTML += '<option value="' + ingredients[i]['nom'] + '">' + ingredients[i]['nom'] + '</option>';
    }
    ingredientHTML += '</select><input type="number" name="quantity[]" step="1" class="form-control mt-2" placeholder="Enter quantity">';
    return ingredientHTML;
  }

  function addNewIngredient() {
    var ingredientsList = document.getElementById("ingredientsList");
    var newIngredient = document.createElement("div");
    newIngredient.className = "form-group";
    newIngredient.innerHTML = generateIngredientHTML(<?php echo json_encode($ingredients); ?>);
    ingredientsList.appendChild(newIngredient);
  }
</script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $totalProteines = 0;
      $totalGlucides = 0;
      $totalSucres = 0;
      $totalLipides = 0;
      $totalAGS = 0;
      $totalVitC = 0;
      $totalVitE = 0;
      $totalVitA = 0;
      $totalVitD = 0;
      $totalKCalories = 0;

      foreach ($_POST['existing'] as $key => $value) {
        $ingredient = $_POST['existing'][$key];
        $quantity = $_POST['quantity'][$key];

        if (!empty($ingredient) && !empty($quantity)) {
          $stm = $dbh->prepare("SELECT * FROM ingrediants WHERE nom = ?");
          $stm->bindParam(1, $ingredient);
          $stm->execute();
          $ingredientValues = $stm->fetch(PDO::FETCH_ASSOC);

          $totalProteines += $ingredientValues['Proteines'] * $quantity / 100;
          $totalGlucides += $ingredientValues['Glucides'] * $quantity / 100;
          $totalSucres += $ingredientValues['Sucres'] * $quantity / 100;
          $totalLipides += $ingredientValues['Lipides'] * $quantity / 100;
          $totalAGS += $ingredientValues['AGS'] * $quantity / 100;
          $totalVitC += $ingredientValues['VitC'] * $quantity / 100;
          $totalVitE += $ingredientValues['VitE'] * $quantity / 100;
          $totalVitA += $ingredientValues['VitA'] * $quantity / 100;
          $totalVitD += $ingredientValues['VitD'] * $quantity / 100;
          $totalKCalories += $ingredientValues['KCalories'] * $quantity / 100;
        }
      }

      // Display the total values
      echo '<h2>Total Values</h2>';
      echo '<table class="table table-bordered mt-4">';
      echo '<thead class="thead-dark">';
      echo '<tr>';
      echo '<th>Proteines</th>';
      echo '<th>Glucides</th>';
      echo '<th>Sucres</th>';
      echo '<th>Lipides</th>';
      echo '<th>AGS</th>';
      echo '<th>VitC</th>';
      echo '<th>VitE</th>';
      echo '<th>VitA</th>';
      echo '<th>VitD</th>';
      echo '<th>KCalories</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
      echo '<tr>';
      echo '<td>' . $totalProteines . '</td>';
      echo '<td>' . $totalGlucides . '</td>';
      echo '<td>' . $totalSucres . '</td>';
      echo '<td>' . $totalLipides . '</td>';
      echo '<td>' . $totalAGS . '</td>';
      echo '<td>' . $totalVitC . '</td>';
      echo '<td>' . $totalVitE . '</td>';
      echo '<td>' . $totalVitA . '</td>';
      echo '<td>' . $totalVitD . '</td>';
      echo '<td>' . $totalKCalories . '</td>';
      echo '</tr>';
      echo '</tbody>';
      echo '</table>';
    }
    ?>
  </div>
</body>
</html>