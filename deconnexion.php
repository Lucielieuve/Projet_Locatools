<?php
// On initialise ou transmet la session
session_start();

// On inclut la page PHP contenant nos fonctions
include 'inc.functions.php';

// On déconnecte l'utilisateur (enlève $_SESSION['utilisateur'])
setDeconnecte();

// On ajoute le message APRES avoir retiré l'utilisateur
adddMessageAlert("Vous êtes correctement déconnecté.");

// Puis on redirige vers l'accueil
header('Location: index.php');
exit;
?>