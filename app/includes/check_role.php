<?php
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user']['role'] !== $role) {
        header('Location: ../index.php?error=unauthorized');
        exit;
    }
}

function isAdmin()        { return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'; }
function isOrganisateur() { return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'organisateur'; }
function isParticipant()  { return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'participant'; }
