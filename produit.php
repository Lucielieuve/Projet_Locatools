<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>LocaTools - Réservation d'un outil</title>
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
      <a class="btn outline" href="profil.php">Mon profil</a>
    </div>
  </div>
</header>

<main class="page-centered">
  <section class="card reservation-card">
    <h1>Réserver un outil</h1>

    <!-- Bloc récap de l’outil -->
    <div class="reservation-tool">
      <img class="tool-img" src="" alt="Image de l'outil">
      <div>
        <h2>Tronçonneuse</h2>
        <p>Tarif : 30 € / jour</p>
        <p>Quantité disponible : 5</p>
      </div>
    </div>

    <!-- Formulaire de réservation -->
    <form>
      <div class="filter-group">
        <label for="date-debut">Date de début</label>
        <input type="date" id="date-debut" name="date_debut" required>
      </div>

      <div class="filter-group">
        <label for="date-fin">Date de fin</label>
        <input type="date" id="date-fin" name="date_fin" required>
      </div>

      <div class="filter-group">
        <label for="quantite">Quantité</label>
        <input type="number" id="quantite" name="quantite" min="1" value="1" required>
      </div>

      <button type="submit" class="btn">Valider la réservation</button>
    </form>
  </section>
</main>

<footer>
  &copy; 2025 LocaTools
</footer>

</body>
</html>
