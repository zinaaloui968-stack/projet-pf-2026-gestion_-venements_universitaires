<?php
session_start();
require_once '../includes/check_role.php';
requireRole('admin');
require_once '../includes/config.php';

$totalUsers  = $pdo->query("SELECT COUNT(*) FROM utilisateur")->fetchColumn();
$totalEvents = $pdo->query("SELECT COUNT(*) FROM evenement")->fetchColumn();
$pending     = $pdo->query("SELECT COUNT(*) FROM evenement WHERE statut='en_attente'")->fetchColumn();
$inscriptions= $pdo->query("SELECT COUNT(*) FROM inscription")->fetchColumn();
$recentUsers = $pdo->query("SELECT * FROM utilisateur ORDER BY date_creation DESC LIMIT 5")->fetchAll();
$pendingEvts = $pdo->query("SELECT e.*, u.nom as organisateur FROM evenement e JOIN utilisateur u ON e.id_organisateur=u.id WHERE e.statut='en_attente' LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin — UniEvent</title>
<?php include '../includes/header.php'; ?>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-section">Navigation</div>
  <a href="admin.php" class="active"><span class="icon">📊</span> Tableau de bord</a>
  <a href="../admin/users.php"><span class="icon">👥</span> Utilisateurs</a>
  <a href="../admin/events_pending.php"><span class="icon">⏳</span> Événements en attente</a>
  <a href="../admin/events_all.php"><span class="icon">📅</span> Tous les événements</a>
</div>

<div class="main-content">
  <div class="page-header">
    <h1>Tableau de bord Administrateur</h1>
    <p>Vue d'ensemble de la plateforme</p>
  </div>

  <div class="stats-grid">
    <div class="stat-card">
      <div class="icon">👥</div>
      <div class="number"><?= $totalUsers ?></div>
      <div class="label">Utilisateurs</div>
    </div>
    <div class="stat-card">
      <div class="icon">📅</div>
      <div class="number"><?= $totalEvents ?></div>
      <div class="label">Événements</div>
    </div>
    <div class="stat-card">
      <div class="icon">⏳</div>
      <div class="number"><?= $pending ?></div>
      <div class="label">En attente de validation</div>
    </div>
    <div class="stat-card">
      <div class="icon">✅</div>
      <div class="number"><?= $inscriptions ?></div>
      <div class="label">Inscriptions</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <div class="card">
      <div class="card-title">⏳ Événements en attente</div>
      <?php if(empty($pendingEvts)): ?>
        <p style="color:#8a9ab5;font-size:14px;">Aucun événement en attente.</p>
      <?php else: ?>
        <table>
          <tr><th>Titre</th><th>Organisateur</th><th>Action</th></tr>
          <?php foreach($pendingEvts as $e): ?>
          <tr>
            <td><?= htmlspecialchars($e['titre']) ?></td>
            <td><?= htmlspecialchars($e['organisateur']) ?></td>
            <td>
              <a href="../admin/validate_event.php?id=<?=$e['id']?>&action=approve" class="btn-accent" style="font-size:12px;padding:6px 12px;">✅ Valider</a>
              <a href="../admin/validate_event.php?id=<?=$e['id']?>&action=reject"  class="btn-danger"  style="font-size:12px;margin-left:4px;">❌ Rejeter</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </table>
      <?php endif; ?>
    </div>

    <div class="card">
      <div class="card-title">👥 Derniers utilisateurs</div>
      <table>
        <tr><th>Nom</th><th>Rôle</th><th>Statut</th></tr>
        <?php foreach($recentUsers as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['nom']) ?></td>
          <td><?= ucfirst($u['role']) ?></td>
          <td><span class="badge <?= $u['actif'] ? 'badge-green' : 'badge-red' ?>"><?= $u['actif'] ? 'Actif' : 'Inactif' ?></span></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <br>
      <a href="../admin/users.php" class="btn-primary">Gérer les utilisateurs</a>
    </div>
  </div>
</div>
</body>
</html>
