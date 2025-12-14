<?php
session_start();
require 'config.php'; // connexion à la BDD

// Si le formulaire de modification du compte a été envoyé alors

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // on stocke les nouvelles infos dans les variables
        $id = ($_POST['id']);
        $identifiant = ($_POST['identifiant']);
        $motdepasse = ($_POST['motdepasse']);

        if (empty($identifiant) || empty($motdepasse)) {
            die("Pour modifier vos informations, l'identifiant et le mot de passe sont obligatoires.");
        } else {

        // Hash du mot de passe
        $motdepasse_hash = password_hash($motdepasse, PASSWORD_DEFAULT);

        // Préparation de la requête avec placeholders
        $requete = $pdo->prepare('UPDATE utilisateurs SET identifiant = :identifiant, motdepasse = :motdepasse WHERE id = :id');

        // Exécution avec tableau associatif façon "execute(array(...))"
        $requete->execute(array(
            'identifiant' => $identifiant,
            'motdepasse'  => $motdepasse_hash,
            'id'          => $id
        ));

        echo "Vos modifications ont été enregistrées.";
        $requete->closeCursor();

        header("Location: profil.php");
        exit;
    }
}


?>
