<?php
session_start();
require_once '../includes/check_role.php';
requireRole('organisateur');
require_once '../includes/config.php';

$userId = $_SESSION['user']['id'];
$myEvents = $pdo->prepare("SELECT * FROM evenement WHERE id_organisateur = ? ORDER BY date_evenement DESC");
$myEvents->execute([$userId]);
$myEvents = $myEvents->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Organisateur — UniEvent</title>
<?php include '../includes/header.php'; ?>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-section">Navigation</div>
  <a href="organisateur.php" class="active"><span class="icon">🏠</span> Mes événements</a>
  <a href="../evenements/create.php"><span class="icon">➕</span> Créer un événement</a>
</div>

<div class="main-content">
  <div class="page-header" style="display:flex;justify-content:space-between;align-items:center;">
    <div>
      <h1>Mes Événements</h1>
      <p>Gérez vos événements universitaires</p>
    </div>
    <a href="../evenements/create.php" class="btn-primary">+ Créer un événement</a>
  </div>

  <div class="card">
    <table>
      <tr><th>Titre</th><th>Date</th><th>Lieu</th><th>Statut</th><th>Actions</th></tr>
      <?php foreach($myEvents as $ev): ?>
      <?php
        $badge = match($ev['statut']) {
          'publie'     => 'badge-green',
          'en_attente' => 'badge-orange',
          'annule'     => 'badge-red',
          default      => 'badge-blue'
        };
        $label = match($ev['statut']) {
          'publie'     => 'Publié',
          'en_attente' => 'En attente',
          'annule'     => 'Annulé',
          default      => $ev['statut']
        };
      ?>
      <tr>
        <td><strong><?= htmlspecialchars($ev['titre']) ?></strong></td>
        <td><?= date('d/m/Y', strtotime($ev['date_evenement'])) ?></td>
        <td><?= htmlspecialchars($ev['lieu']) ?></td>
        <td><span class="badge <?= $badge ?>"><?= $label ?></span></td>
        <td>
          <a href="../evenements/edit.php?id=<?= $ev['id'] ?>" class="btn-primary" style="font-size:12px;padding:6px 14px;">✏️ Modifier</a>
          <a href="../evenements/delete.php?id=<?= $ev['id'] ?>" class="btn-danger" style="margin-left:6px;" onclick="return confirm('Confirmer la suppression ?')">🗑️ Supprimer</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if(empty($myEvents)): ?>
        <tr><td colspan="5" style="text-align:center;color:#8a9ab5;padding:32px;">Aucun événement créé.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</div>
</body>
</html>
