<?php
session_start();
require 'inc.functions.php'; //la page regroupant toutes les fonctions pour plus d'organisation

// Si l'utilisateur est déjà connecté, on le renvoie à la page d'accueil pour qu'il choisisse directement ses réservations

if (isConnecte()) {
    header('Location: index.php');
    exit;
}

// Sinon on initialise les variables de connexion avant de le connecter
$identifiant = '';
$motdepasse  = '';

// On vérifie que le formulaire est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Identifiant et mot de passe obligatoire sinon alerte
    if (!isset($_POST['identifiant']) || !isset($_POST['motdepasse'])) {
        adddMessageAlert("Merci de remplir tous les champs.");
    } else {
        $identifiant = $_POST['identifiant'];
        $motdepasse  = $_POST['motdepasse'];

        // Vérification que les champs ne sont pas vides
        if ($identifiant === '' || $motdepasse === '') {
            adddMessageAlert("Merci de remplir tous les champs.");
        } else {

            // Vérification que ce sont bien des chaînes de caractères
            if (!is_string($identifiant) && !is_string($motdepasse)) {
                adddMessageAlert("Les champs doivent être des chaînes de caractères.");
            } else {
                // on va chercher la fonction pour récupérer les données de l'utilisateur
                $user = getUtilisateurInfo($identifiant, $motdepasse);

                // Si l'identifiant et le mdp correspondent à ceux entrés alors redirection vers index.php
                if ($user) {
                    // Fonction enregistre les infos en session
                    connecterUtilisateur($user);
                    // Fonction envoie message flash 
                    adddMessageAlert("Connexion réussie, bienvenue " . htmlspecialchars($user['identifiant']) . " !");
                    // redirection vers l'index
                    header('Location: index.php');
                    exit;
                    
                } else {
                    adddMessageAlert("Identifiant ou mot de passe incorrect.");
                }
            }
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
