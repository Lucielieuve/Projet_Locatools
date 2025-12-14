<?php
session_start();
require 'inc.functions.php';

// Vérifie qu'un utilisateur est connecté
if (!isConnecte()) {
    adddMessageAlert("Vous devez être connecté pour accéder à votre profil.");
    header("Location: connexion.php");
    exit;
}

// Récupération des données utilisateur depuis la session
$user = $_SESSION['utilisateur'];
$userId = $user['id'];
$identifiant = $user['identifiant'];
$role = $user['role'];

// Récupérer ses réservations
$reservations = getReservationsByUser($userId);

// suppression réservation
if (isset($_GET['supprimer'])) {

    if (!isConnecte()) {
        adddMessageAlert("Vous devez être connecté.");
        header("Location: connexion.php");
        exit;
    }

    $reservationId = (int) $_GET['supprimer'];
    $userId = $_SESSION['utilisateur']['id'];

    if (supprimerReservation($reservationId, $userId)) {
        adddMessageAlert("Réservation supprimée.");
    } else {
        adddMessageAlert("Impossible de supprimer cette réservation.");
    }

    header("Location: profil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>LocaTools - Mon profil</title>
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
      <a href="index.php">Accueil</a>
      <a class="btn outline" href="deconnexion.php">Déconnexion</a>
    </div>
  </div>
</header>

<main class="profile-layout">
  <section class="card profile-card">
    <h1>Mon profil</h1>

    <!-- Infos utilisateur -->
    <div class="profile-info">
      <p><strong>Identifiant :</strong> <?= htmlspecialchars($identifiant); ?></p>
      <p><strong>Rôle :</strong> <?= htmlspecialchars($role); ?></p>
    </div>

    <div class="modifier-compte-area">
        <a class="modifier-compte-btn espacer" href="#.php">Modifier</a>
    </div>
      
  </section>

  <section class="profile-card">
        <h2>Mes réservations</h2>

        <?php if (empty($reservations)): ?>
            <p>Aucune réservation pour le moment.</p>
        <?php else: ?>
            <div class="reservations-list">
                <?php foreach ($reservations as $r): ?>
                    <article class="reservation-item">
                        <h3><?= htmlspecialchars($r['nom']); ?></h3>

                        <p>
                            <strong>Du :</strong> <?= htmlspecialchars($r['date_debut']); ?><br>
                            <strong>Au :</strong> <?= htmlspecialchars($r['date_fin']); ?><br>
                            <strong>Quantité :</strong> <?= (int) $r['quantite']; ?><br>
                            <strong>Tarif :</strong> <?= (int) $r['tarif_journee']; ?> € / jour
                        </p>

                        <div class="modifier-compte-area">
                          <a class="supprimer-reservation"
                            href="profil.php?supprimer=<?= (int) $r['id']; ?>"
                            onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
                            Supprimer
                          </a>
                      </div>
                      
                    </article>
                    
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
