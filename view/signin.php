<?php
session_start();

$dbh = new PDO('mysql:host=localhost;dbname=projet', "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $prenom = $_POST['prenom'];

    $checkQuery = $dbh->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $checkQuery->execute([$email]);
    $existingUser = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        echo "User with the provided email already exists.";
    } else {

        $insertQuery = $dbh->prepare("INSERT INTO utilisateur (email, nom, password, prenom) VALUES (?, ?, ?, ?)");
        $insertQuery->execute([$email, $nom, $password, $prenom]);

        if ($insertQuery) {
            echo "<center> Registration successful. You can now <a href='login.html'>login</a>.</center>";
        } else {
            echo "An error occurred during registration.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #C4E7B1;
      background-size: cover;
    }
    .container {
      padding-top: 150px;
      text-align: center;
    }
    h1 {
      color: #fff;
      font-size: 36px;
      margin-bottom: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Sign Up</h1>
    <form method="POST" action="">
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control col-md-6 mx-auto" id="email" name="email" placeholder="Enter email" required>
      </div>
      <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control col-md-6 mx-auto" id="nom" name="nom" placeholder="Enter nom" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control col-md-6 mx-auto" id="password" name="password" placeholder="Password" required>
      </div>
      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control col-md-6 mx-auto" id="prenom" name="prenom" placeholder="Enter prénom" required>
      </div>
      <button type="submit" class="btn btn-primary">Sign Up</button>
      <a href="login.html" class="btn btn-warning">Log in</button>
    </form>
  </div>
</body>
</html>
