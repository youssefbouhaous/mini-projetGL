<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenue</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #C4E7B1;
      background-size: cover;
      background-image: url("../imgs/bg2.png");
    }
    .container {
      padding-top: 30px;
      text-align: center;
    }
    h1 {
      color: black;
      font-size: 36px;
      margin-bottom: 30px;
    }
    .btn-container {
      margin-bottom: 20px;
    }
    .btn-container .btn {
      width: 200px;
      height: 200px;
      margin-right: 20px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
  <h1>Bienvenue sur la gae</h1>
    <div class="btn-container">
      <a href="../controller/fct1.php" class="btn btn-outline-success">Calculer la valeur nutritionnelle</a>
      <a href="../controller/fct2.php" class="btn btn-outline-success">Proposition des plats</a>
    </div>

    <div class="btn-container">
      
      <a href="../controller/fct3.php" class="btn btn-outline-success">Enregistrer un plat</a>
      <a href="../controller/fct4.php" class="btn btn-outline-success">Plants de régime</a>
    </div>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</body>
</html>
