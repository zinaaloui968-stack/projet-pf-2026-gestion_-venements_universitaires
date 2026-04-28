<?php
session_start();
require_once '../includes/check_role.php';
requireRole('admin');
require_once '../includes/config.php';

$users = $pdo->query("SELECT * FROM utilisateur ORDER BY date_creation DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion Utilisateurs — UniEvent</title>
<?php include '../includes/header.php'; ?>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-section">Navigation</div>
  <a href="../dashboard/admin.php"><span class="icon">📊</span> Tableau de bord</a>
  <a href="users.php" class="active"><span class="icon">👥</span> Utilisateurs</a>
  <a href="events_pending.php"><span class="icon">⏳</span> Événements en attente</a>
</div>

<div class="main-content">
  <div class="page-header" style="display:flex;justify-content:space-between;align-items:center;">
    <div>
      <h1>Gestion des Utilisateurs</h1>
      <p>Créer, modifier et gérer les comptes</p>
    </div>
    <a href="add_user.php" class="btn-primary">+ Ajouter un utilisateur</a>
  </div>

  <div class="card">
    <table>
      <tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Date création</th><th>Actions</th></tr>
      <?php foreach($users as $u): ?>
      <tr>
        <td><strong><?= htmlspecialchars($u['nom']) ?></strong></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td>
          <span class="badge <?= $u['role']==='admin' ? 'badge-orange' : ($u['role']==='organisateur' ? 'badge-green' : 'badge-blue') ?>">
            <?= ucfirst($u['role']) ?>
          </span>
        </td>
        <td><span class="badge <?= $u['actif'] ? 'badge-green' : 'badge-red' ?>"><?= $u['actif'] ? 'Actif' : 'Inactif' ?></span></td>
        <td><?= date('d/m/Y', strtotime($u['date_creation'])) ?></td>
        <td>
          <a href="edit_user.php?id=<?= $u['id'] ?>" class="btn-primary" style="font-size:12px;padding:6px 14px;">✏️</a>
          <a href="toggle_user.php?id=<?= $u['id'] ?>" class="btn-danger" style="margin-left:6px;"><?= $u['actif'] ? '🔴 Désactiver' : '🟢 Activer' ?></a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
</body>
</html>
