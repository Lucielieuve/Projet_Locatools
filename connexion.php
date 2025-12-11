<?php
session_start();
require 'inc.functions.php';

// Si l'utilisateur est déjà connecté, il est renvoyé vers l'accueil
if (isConnecte()) {
    header('Location: index.php');
    exit;
}

$identifiant = '';
$motdepasse  = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant'] ?? '');
    $motdepasse  = trim($_POST['motdepasse']  ?? '');

    // Si un des 2 champs est vide, une alerte apparaît
    if ($identifiant === '' || $motdepasse === '') {
        adddMessageAlert("Merci de remplir tous les champs.");
    } else {
        $user = getUtilisateurInfo($identifiant, $motdepasse);
        // Si l'identifiant et le mdp correspondent, cela renvoie l'utilisateur sur la page index.php et un message apparaît
        if ($user) {
            connecterUtilisateur($user);
            adddMessageAlert("Connexion réussie, bienvenue " . htmlspecialchars($user['identifiant']) . " !");
            header('Location: index.php');
            exit;
        } else {
            adddMessageAlert("Identifiant ou mot de passe incorrect.");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LocaTools - Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<header>
    <div class="header-inner">
        <div class="site-title">
            <span class="logo">LT</span>
            LocaTools
        </div>
        <div class="login-area">
            <a href="index.php">Retour aux outils</a>
        </div>
    </div>
</header>

<main class="auth-main">
    <section class="auth-card">
        <h1>Connexion</h1>

        <?php lireEtSupprimeMessageSession(); ?>

        <form method="post">
            <div class="filter-group">
                <label for="identifiant">Identifiant</label>
                <input
                    type="text"
                    id="identifiant"
                    name="identifiant"
                    value="<?= htmlspecialchars($identifiant, ENT_QUOTES); ?>"
                    required
                >
            </div>

            <div class="filter-group">
                <label for="motdepasse">Mot de passe</label>
                <input
                    type="password"
                    id="motdepasse"
                    name="motdepasse"
                    required
                >
            </div>

            <button type="submit" class="btn">Se connecter</button>
        </form>
    </section>
</main>

</body>
</html>
