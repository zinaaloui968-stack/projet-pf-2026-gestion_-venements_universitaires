<?php
session_start();
require_once 'db.php';

// Supprimer le cookie remember me
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $pdo = Database::getConnection();
    $pdo->prepare("DELETE FROM user_tokens WHERE token = ?")->execute([$token]);
    setcookie('remember_token', '', time() - 3600, '/');
}

// Détruire la session
$_SESSION = array();
session_destroy();

// Rediriger vers login
header('Location: login.php');
exit;
?>
