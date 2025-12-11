<?php
require_once 'config.php';

/**
 * Vérifie si un utilisateur est connecté.
 * À adapter plus tard selon ta page connexion.
 */
function isConnecte(): bool
{
    return isset($_SESSION['utilisateur']);
}

/**
 * Ajoute un message flash en session.
 */
function adddMessageAlert(string $message): void
{
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    $_SESSION['messages'][] = $message;
}

/**
 * Affiche puis supprime les messages stockés en session.
 */
function lireEtSupprimeMessageSession(): void
{
    if (!empty($_SESSION['messages']) && is_array($_SESSION['messages'])) {
        foreach ($_SESSION['messages'] as $msg) {
            echo '<div class="alert alert-info">'.htmlspecialchars($msg, ENT_QUOTES, 'UTF-8').'</div>';
        }
        unset($_SESSION['messages']);
    }
}

/**
 * Récupère les outils filtrés depuis la BDD.
 */
function getOutilsFiltres(array $filtres = []): array
{
    global $pdo;

    $name     = $filtres['name']      ?? '';
    $priceMin = $filtres['price_min'] ?? null;
    $priceMax = $filtres['price_max'] ?? null;
    $date     = $filtres['date']      ?? null;

    $sql = "SELECT 
                o.id,
                o.nom,
                o.quantite,
                o.tarif_journee";

    if (!empty($date)) {
        $sql .= ",
                (o.quantite - COALESCE(SUM(r.quantite), 0)) AS dispo";
    }

    $sql .= " FROM outil o";

    $params = [];

    if (!empty($date)) {
        $sql .= " LEFT JOIN reservation r
                  ON r.outil_id = o.id
                  AND :date BETWEEN r.date_debut AND r.date_fin";
        $params[':date'] = $date;
    }

    $sql .= " WHERE 1=1";

    if ($name !== '') {
        $sql .= " AND o.nom LIKE :name";
        $params[':name'] = '%' . $name . '%';
    }

    if ($priceMin !== null && $priceMin !== '') {
        $sql .= " AND o.tarif_journee >= :pmin";
        $params[':pmin'] = (float) $priceMin;
    }

    if ($priceMax !== null && $priceMax !== '') {
        $sql .= " AND o.tarif_journee <= :pmax";
        $params[':pmax'] = (float) $priceMax;
    }

    if (!empty($date)) {
        $sql .= " GROUP BY o.id, o.nom, o.quantite, o.tarif_journee
                  HAVING dispo > 0";
    }

    $sql .= " ORDER BY o.nom ASC";

    $stmt = $pdo->prepare($sql);

    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

function getUtilisateurInfo(string $identifiant, string $motdepasse): ?array
{
    global $pdo;

    $sql = "SELECT id, identifiant, motdepasse, role
            FROM utilisateurs
            WHERE identifiant = :identifiant
              AND motdepasse = :motdepasse";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':identifiant', $identifiant, PDO::PARAM_STR);
    $stmt->bindValue(':motdepasse', $motdepasse, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    return $user ?: null;
}

/**
 * Connecte l'utilisateur : enregistre ses infos en session
 */
function connecterUtilisateur(array $user): void
{
    $_SESSION['utilisateur'] = [
        'id'          => (int) $user['id'],
        'identifiant' => $user['identifiant'],
        'role'        => $user['role'],
    ];
}

function setDeconnecte(){
    unset($_SESSION['utilisateur']);
}

/**
 * Ajoute un outil dans un "panier" en session
 */
function addOutilToSession(int $id, string $nom, int $tarif): void
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $_SESSION['panier'][] = [
        'id'    => $id,
        'nom'   => $nom,
        'tarif' => $tarif,
    ];
}

/**
 * Récupère un outil par son id
 */
function getOutilById(int $id): ?array
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT id, nom, quantite, tarif_journee FROM outil WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $outil = $stmt->fetch();

    return $outil ?: null;
}

/**
 * Pagination
 */
function paginate(array $items, int $perPage, int $page): array
{
    $total = count($items);
    $totalPages = max(1, (int) ceil($total / $perPage));

    if ($page < 1) $page = 1;
    if ($page > $totalPages) $page = $totalPages;

    $offset    = ($page - 1) * $perPage;
    $pageItems = array_slice($items, $offset, $perPage);

    return [
        'items'       => $pageItems,
        'total'       => $total,
        'page'        => $page,
        'total_pages' => $totalPages,
    ];
}

/**
 * Construit l’URL de pagination
 */
function buildPageUrl(int $page): string
{
    $params = $_GET;
    $params['page'] = $page;
    return '?' . http_build_query($params);
}

/**
 * Récupère les réservations d'un utilisateur avec les infos des outils
 */
function getReservationsByUser(int $userId): array
{
    global $pdo;

    $sql = "
        SELECT 
            r.id,
            r.date_debut,
            r.date_fin,
            r.quantite,
            o.nom,
            o.tarif_journee
        FROM reservation r
        INNER JOIN outil o ON o.id = r.outil_id
        WHERE r.utilisateur_id = :uid
        ORDER BY r.date_debut DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}