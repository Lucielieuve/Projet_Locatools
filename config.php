<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=bricolage_uel204;charset=utf8mb4',
        'root',         
        'root'              
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}
?>
