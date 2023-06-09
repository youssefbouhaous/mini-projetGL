<?php
include "../model/utilisateur.php";

class DaoUtilisateur
{
    private $dbh;
    
    public function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=projet', "root", "");
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function save(Utilisateur $utilisateur)
    {
        $stm = $this->dbh->prepare("INSERT INTO utilisateur (email, nom, password, prenom) VALUES (?, ?, ?, ?)");

        $stm->bindValue(1, $utilisateur->getEmail());
        $stm->bindValue(2, $utilisateur->getNom());
        $stm->bindValue(3, $utilisateur->getPassword());
        $stm->bindValue(4, $utilisateur->getPrenom());
        $result = $stm->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function findUtilisateur($email, $password)
    {
        $utilisateur = null;
        $stm = $this->dbh->prepare("SELECT * FROM utilisateur where email=? AND password=?");
        $stm->bindValue(1, $email);
        $stm->bindValue(2, $password);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            $utilisateur = new Utilisateur($result['email'], $result['nom'], $result['password'], $result['prenom']);
        }
        return $utilisateur;
    }
}
?>
