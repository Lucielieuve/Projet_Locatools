<?php
require_once 'config.php';

/**
 * Vérifie si un utilisateur est connecté
 **/
function isConnecte() {
    return isset($_SESSION['utilisateur']);
}

/**
 * Ajoute un message lors de la connexion
 */

function adddMessageAlert($message) {
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = array();
    }
    $_SESSION['messages'][] = $message;
}

/**
 * Affiche puis supprime les messages stockés en session
 */

function lireEtSupprimeMessageSession() {
    if (isset($_SESSION['messages']) && is_array($_SESSION['messages']) && count($_SESSION['messages']) > 0) {
        foreach ($_SESSION['messages'] as $msg) {
            echo '<div class="alert alert-info">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>';
        }
        unset($_SESSION['messages']);
    }
}

/**
 * Récupère les outils filtrés depuis la BDD
 */
function getOutilsFiltres($filtres = array()) {
    global $pdo;

    $name = isset($filtres['name']) ? $filtres['name'] : '';
    $priceMin = isset($filtres['price_min']) ? $filtres['price_min'] : '';
    $priceMax = isset($filtres['price_max']) ? $filtres['price_max'] : '';
    $date = isset($filtres['date']) ? $filtres['date'] : '';

    $sql = "SELECT o.id, o.nom, o.quantite, o.tarif_journee, o.image";
    $params = array();

    if ($date != '') {
        $sql .= ", (o.quantite - COALESCE(SUM(r.quantite), 0)) AS dispo";
    }

    $sql .= " FROM outil o";

    if ($date != '') {
        $sql .= " LEFT JOIN reservation r
                  ON r.outil_id = o.id
                  AND :date BETWEEN r.date_debut AND r.date_fin";
        $params[':date'] = $date;
    }

    $sql .= " WHERE 1=1";

    if ($name != '') {
        $sql .= " AND o.nom LIKE :name";
        $params[':name'] = '%' . $name . '%';
    }

    if ($priceMin !== '' && $priceMin !== null) {
        $sql .= " AND o.tarif_journee >= :pmin";
        $params[':pmin'] = $priceMin;
    }

    if ($priceMax !== '' && $priceMax !== null) {
        $sql .= " AND o.tarif_journee <= :pmax";
        $params[':pmax'] = $priceMax;
    }

    if ($date != '') {
        $sql .= " GROUP BY o.id, o.nom, o.quantite, o.tarif_journee, o.image
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

function getOutilById($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT id, nom, quantite, tarif_journee, image FROM outil WHERE id = :id");
    $stmt->execute(array(':id' => (int)$id));
    $outil = $stmt->fetch();

    if ($outil) {
        return $outil;
    }
    return null;
}


// Récupère les infos de l'utilisateur
function getUtilisateurInfo(string $identifiant, string $motdepasse): ?array
{
    global $pdo;

    $sql = "SELECT id, identifiant, motdepasse, role
            FROM utilisateurs
            WHERE identifiant = :identifiant
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':identifiant', $identifiant, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    if (!$user) {
        return null;
    }

    // On vérifie que le mdp est bien hashé et donc que la connexion est bien sécurisée
    if (!password_verify($motdepasse, $user['motdepasse'])) {
        return null;
    }

    return $user;
}


/**
 * Connecte l'utilisateur et enregistre ses infos dans un tableau
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

function paginate($items, $perPage, $page) {
    $total = count($items);
    $totalPages = (int) ceil($total / $perPage);
    if ($totalPages < 1) $totalPages = 1;

    if ($page < 1) $page = 1;
    if ($page > $totalPages) $page = $totalPages;

    $offset = ($page - 1) * $perPage;
    $pageItems = array_slice($items, $offset, $perPage);

    return array(
        'items' => $pageItems,
        'total' => $total,
        'page' => $page,
        'total_pages' => $totalPages
    );
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
            o.tarif_journee,
            o.image
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

/**
 * Permet d'enregistrer une réservation
 */

function ajouterReservation($idUser, $idOutil) {
    global $pdo;

    $sql = "INSERT INTO reservation (utilisateur_id, outil_id, date_debut, date_fin, quantite)
            VALUES (:idUser, :idOutil, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 DAY), 1)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':idUser' => (int)$idUser,
        ':idOutil' => (int)$idOutil
    ));
}

/**
 * Supprime une réservation
 */

function supprimerReservation($reservationId, $userId) {
    global $pdo;

    $sql = "DELETE FROM reservation
            WHERE id = :rid
              AND utilisateur_id = :uid";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute(array(
        ':rid' => (int)$reservationId,
        ':uid' => (int)$userId
    ));
}
