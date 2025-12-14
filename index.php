<?php
// On initialise ou relaye la session
session_start();

// Récupère le fichier PHP qui contient les fonctions
require 'inc.functions.php';

// --- Gestion d’un ajout d’outil au “panier” via ?outil=ID ---
if (!empty($_GET['outil'])) {

    if (!isConnecte()) {
        adddMessageAlert("Vous devez d'abord vous connecter pour ensuite réserver un outil.");
    } else {
        $idOutil = (int) $_GET['outil'];
        $outil   = getOutilById($idOutil);

        if ($outil) {
            addOutilToSession($outil['id'], $outil['nom'], (int) $outil['tarif_journee']);
            adddMessageAlert("Outil ajouté à votre panier / réservations !");
            header('Location: index.php');
            exit;
        } else {
            adddMessageAlert("Erreur : outil introuvable.");
        }
    }
}

// --- Récupération des filtres depuis le formulaire ---
$filtres = [
    'name'      => isset($_GET['name'])      ? trim($_GET['name'])      : '',
    'price_min' => $_GET['price_min'] ?? null,
    'price_max' => $_GET['price_max'] ?? null,
    'date'      => $_GET['date']      ?? null,
];

// --- Lecture des outils filtrés depuis la BDD ---
$_outils = getOutilsFiltres($filtres);

// --- Pagination ---
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$pagination  = paginate($_outils, 9, $currentPage);

$pageTools   = $pagination['items'];
$totalTools  = $pagination['total'];
$currentPage = $pagination['page'];
$totalPages  = $pagination['total_pages'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LocaTools - Liste des outils</title>
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
        <!-- Si l'utilisateur est connecté en session, le bouton "mon profil" apparaît -->
      <?php if (isConnecte()): ?>
        <span>Connecté</span>
        <button class="btn outline" onclick="window.location.href='profil.php'">
          Mon profil
        </button>
        <!-- Sinon, il y a un lien pour pouvoir se connecter -->
      <?php else: ?>
        <a href="connexion.php">Se connecter</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main>
  <!-- COLONNE GAUCHE : FILTRES -->
  <aside class="filters">
    <h2>Filtrer les outils</h2>

    <form method="get">
      <div class="filter-group">
        <label for="filter-name">Nom de l'outil</label>
        <input type="text" id="filter-name" name="name"
               placeholder="Perceuse, tondeuse..."
               value="<?= htmlspecialchars($filtres['name'] ?? '', ENT_QUOTES); ?>">
      </div>

      <div class="filter-inline">
        <div class="filter-group">
          <label for="filter-price-min">Prix min (€ / jour)</label>
          <input type="number" id="filter-price-min" name="price_min" min="0" step="1"
                 value="<?= htmlspecialchars($filtres['price_min'] ?? '', ENT_QUOTES); ?>">
        </div>
        <div class="filter-group">
          <label for="filter-price-max">Prix max (€ / jour)</label>
          <input type="number" id="filter-price-max" name="price_max" min="0" step="1"
                 value="<?= htmlspecialchars($filtres['price_max'] ?? '', ENT_QUOTES); ?>">
        </div>
      </div>

      <div class="filter-group">
        <label for="filter-date">Date de réservation</label>
        <input type="date" id="filter-date" name="date"
               value="<?= htmlspecialchars($filtres['date'] ?? '', ENT_QUOTES); ?>">
      </div>

      <div class="filters-footer">
        <a href="index.php" class="btn outline">Réinitialiser</a>
        <button type="submit" class="btn">Appliquer</button>
      </div>
    </form>
  </aside>

  <!-- COLONNE DROITE : OUTILS -->
  <section class="tools-section">
    <div class="tools-header">
      <h2>Outils disponibles</h2>
      <span>
        <?= $totalTools; ?> outil(s) trouvé(s)
      </span>
    </div>

    <?php lireEtSupprimeMessageSession(); ?>

    <div class="tools-grid">
      <?php if (!empty($pageTools)): ?>
        <?php foreach ($pageTools as $outil): ?>
          <article class="tool-card">
            <img class="tool-img" src="<?= htmlspecialchars($outil['image'], ENT_QUOTES); ?>" alt="Image de <?= htmlspecialchars($outil['nom']); ?>">
            <div class="tool-title">
              <?= htmlspecialchars($outil['nom'], ENT_QUOTES); ?>
            </div>

            <div class="tool-meta tool-price">
              <?= (int) $outil['tarif_journee']; ?> € / jour
            </div>

            <div class="tool-meta">
              Quantité totale : <?= (int) $outil['quantite']; ?>
            </div>

            <?php if (!empty($filtres['date']) && isset($outil['dispo'])): ?>
              <div class="tool-meta">
                Disponible le <?= htmlspecialchars($filtres['date'], ENT_QUOTES); ?> :
                <strong><?= max(0, (int) $outil['dispo']); ?></strong>
              </div>
            <?php endif; ?>

            <div class="tool-footer">
              <?php if (isConnecte()): ?>
                <a href="?outil=<?= (int) $outil['id']; ?>" class="btn">Réserver</a>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Aucun outil ne correspond à votre recherche.</p>
      <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <div class="pagination">
        <?php if ($currentPage > 1): ?>
          <a class="page-btn" href="<?= buildPageUrl($currentPage - 1); ?>">«</a>
        <?php else: ?>
          <span class="page-btn disabled">«</span>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <?php if ($i == $currentPage): ?>
            <span class="page-btn active"><?= $i; ?></span>
          <?php else: ?>
            <a class="page-btn" href="<?= buildPageUrl($i); ?>"><?= $i; ?></a>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
          <a class="page-btn" href="<?= buildPageUrl($currentPage + 1); ?>">»</a>
        <?php else: ?>
          <span class="page-btn disabled">»</span>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<footer>LocaTools</footer>
</body>
</html>
