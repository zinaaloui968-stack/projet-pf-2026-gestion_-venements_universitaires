<?php
require_once __DIR__ . '/../includes/config.php';

// Supprimer le cookie remember me
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $pdo->prepare("DELETE FROM user_tokens WHERE token = ?");
    $stmt->execute([$token]);
    setcookie('remember_token', '', time() - 3600, '/');
}

// Détruire la session
$_SESSION = [];
session_destroy();

// Rediriger vers connexion
header('Location: connexion.php');
exit;
?>
