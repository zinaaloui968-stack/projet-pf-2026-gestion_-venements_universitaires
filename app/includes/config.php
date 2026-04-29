<?php
// config.php - Configuration centrale
session_start();

// Définir le fuseau horaire
date_default_timezone_set('Europe/Paris');

// Configuration base de données (SQLite)
define('DB_PATH', __DIR__ . '/database.sqlite');

// Options PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO('sqlite:' . DB_PATH, null, null, $options);
} catch (PDOException $e) {
    die("Erreur de connexion BDD : " . $e->getMessage());
}

// Fonction utilitaire pour vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fonction pour rediriger si non connecté
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /app/auth/connexion.php');
        exit;
    }
}

// Inclure les autres fonctions (check_role sera séparé)
?>
