<?php
// check_role.php - Vérification des rôles
require_once __DIR__ . '/config.php';

function requireRole($role) {
    if (!isLoggedIn()) {
        header('Location: /app/auth/connexion.php');
        exit;
    }
    if ($_SESSION['user_role'] !== $role && $_SESSION['user_role'] !== 'admin') {
        // Rediriger vers le dashboard adapté
        header('Location: /app/dashboard/' . $_SESSION['user_role'] . '.php');
        exit;
    }
}

// Vérification spécifique pour admin
function requireAdmin() {
    requireRole('admin');
}

// Vérification pour organisateur
function requireOrganisateur() {
    requireRole('organisateur');
}
?>
