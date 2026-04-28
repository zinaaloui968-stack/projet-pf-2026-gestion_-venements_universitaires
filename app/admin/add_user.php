<?php
session_start();
require_once '../includes/check_role.php';
requireRole('admin');
require_once '../includes/config.php';

$error = ''; $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom      = trim($_POST['nom']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    if (empty($nom) || empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        $check = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = 'Cet email est déjà utilisé.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role, actif, date_creation) VALUES (?, ?, ?, ?, 1, NOW())");
            $stmt->execute([$nom, $email, $hash, $role]);
            $success = 'Utilisateur créé avec succès !';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Utilisateur — UniEvent</title>
<?php include '../includes/header.php'; ?>
</head>
<body>
<div class="sidebar">
  <a href="../dashboard/admin.php"><span class="icon">📊</span> Tableau de bord</a>
  <a href="users.php" class="active"><span class="icon">👥</span> Utilisateurs</a>
</div>
<div class="main-content">
  <div class="page-header">
    <h1>Ajouter un utilisateur</h1>
  </div>
  <div class="card" style="max-width:500px;">
    <?php if($error): ?><div style="padding:12px;background:#fdecea;color:#c0392b;border-radius:8px;margin-bottom:16px;"><?= $error ?></div><?php endif; ?>
    <?php if($success): ?><div style="padding:12px;background:#eafaf1;color:#27ae60;border-radius:8px;margin-bottom:16px;"><?= $success ?></div><?php endif; ?>
    <form method="POST">
      <div class="form-group"><label>Nom complet</label><input type="text" name="nom" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
      <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
      <div class="form-group">
        <label>Rôle</label>
        <select name="role">
          <option value="participant">Participant</option>
          <option value="organisateur">Organisateur</option>
          <option value="admin">Administrateur</option>
        </select>
      </div>
      <button type="submit" class="btn-primary">Créer l'utilisateur</button>
      <a href="users.php" style="margin-left:12px;color:#8a9ab5;font-size:14px;">Annuler</a>
    </form>
  </div>
</div>
</body>
</html>
