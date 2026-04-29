<?php
session_start(); // Ajouté en haut

$host = 'localhost';
$dbname = 'gestion_evenements_scolaires';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour obtenir le rôle de l'utilisateur connecté
function getUserRole($pdo) {
    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) return null;
    
    $type = $_SESSION['user_type'];
    $id = $_SESSION['user_id'];
    
    switch($type) {
        case 'admin':
            $stmt = $pdo->prepare("SELECT r.description FROM utilisateurs u JOIN roles r ON u.role_id = r.id WHERE u.id = ?");
            break;
        case 'professeur':
            $stmt = $pdo->prepare("SELECT r.description FROM professeurs p JOIN roles r ON p.role_id = r.id WHERE p.id = ?");
            break;
        case 'etudiant':
            $stmt = $pdo->prepare("SELECT r.description FROM etudiants e JOIN roles r ON e.role_id = r.id WHERE e.id = ?");
            break;
        default:
            return null;
    }
    
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}
?>
