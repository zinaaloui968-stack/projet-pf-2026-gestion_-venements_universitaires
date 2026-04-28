<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

require_once '../includes/config.php';

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    header('Location: ../index.php?error=empty');
    exit;
}

// Fetch user from DB
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ? AND actif = 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['mot_de_passe'])) {
    $_SESSION['user'] = [
        'id'    => $user['id'],
        'nom'   => $user['nom'],
        'email' => $user['email'],
        'role'  => $user['role'],
    ];

    // Redirect based on role
    switch ($user['role']) {
        case 'admin':         header('Location: ../dashboard/admin.php'); break;
        case 'organisateur':  header('Location: ../dashboard/organisateur.php'); break;
        default:              header('Location: ../dashboard/participant.php'); break;
    }
    exit;
} else {
    header('Location: ../index.php?error=invalid');
    exit;
}
