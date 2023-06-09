<?php
include "../dao/dao-utilisateur.php";

$action = $_GET['action'];
$dao = new DaoUtilisateur();

switch ($action) {
    case 'insert':
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $password = $_POST['password'];
        $prenom = $_POST['prenom'];
        if (isset($nom, $email, $password, $prenom)) {
            $flag = false;
            $utilisateur = new Utilisateur($email, $nom, $password, $prenom);
            $flag = $dao->save($utilisateur);
            header("Location: ../view/bienvenue.php");
        }
        break;
    case 'login':
        $email = $_POST['email'];
        $password = $_POST['password'];

        $utilisateur = $dao->findUtilisateur($email, $password);
        if ($utilisateur != null) {
            session_start();
            $_SESSION['utilisateur'] = $utilisateur;
            header('Location: ../view/bienvenue.php');
        } else {
            echo "echec de connexion!";
        }
        break;

}
?>
