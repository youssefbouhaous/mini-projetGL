<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fonctionnalité 3</title>
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
    <h1>Enregistrer un plat</h1>
    <form action="fct3.php" method="post">
      <div id="ingredientsList">
        <div class="form-group">
        <input type="text" name="nomplat"  class="form-control mt-2" placeholder="Entrer le nom du plat">
        <input type="datetime-local" name="dateplat"  class="form-control mt-2" placeholder="Enter the date of your dish">  
        <label>Sélectionnez les ingrédients qui existent dans votre plat :</label>
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
          <input type="number" name="quantity[]" step="1" class="form-control mt-2" placeholder="Entrer la quantité">
        </div>
      </div>
     
      <button type="button" class="btn btn-primary mt-3" onclick="addNewIngredient()">Add Ingredient</button>
      <button type="submit" class="btn btn-success mt-3">record the dish</button>
      <a href="../view/bienvenue.php" class="btn btn-primary mt-3">Choisir une autre fonctionnalité</a>
      <a href="../controller/fct5.php" class="btn btn-warning mt-3">Afficher mon journal</a>
      <a href="../view/logout.php " class="btn btn-danger mt-3">déconnexion</a>
    

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
$success = false; // Variable pour stocker l'état de l'enregistrement

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nameplat = $_POST['nomplat'];
  $dateplat = $_POST['dateplat'];
  foreach ($_POST['existing'] as $key => $value) {
    $ingredient = $_POST['existing'][$key];
    $quantity = $_POST['quantity'][$key];

    if (!empty($ingredient) && !empty($quantity)) {
      $stm = $dbh->prepare("SELECT * FROM ingrediants WHERE nom = ?");
      $stm->bindParam(1, $ingredient);
      $stm->execute();
      $ingredientValues = $stm->fetch(PDO::FETCH_ASSOC);
      $insertion = $dbh->prepare("INSERT INTO plat (nom, ingrediant, quantite)
      VALUES ('$nameplat', '" . $ingredientValues['nom'] . "', $quantity)");
      $insertion->execute();
    } 
  }
  $insertion = $dbh->prepare("INSERT INTO journal (dateTime, plat)
  VALUES ('$dateplat', '$nameplat')");
  $insertion->execute();
  // Marquer l'enregistrement comme réussi
  $success = true;
}
?>
<div class="container">
  <?php if ($success): ?>
    <div class="alert alert-success">Le plat a été enregistré avec succès.</div>
  <?php endif; ?>
</div>

  </div>
  
</body>
</html>