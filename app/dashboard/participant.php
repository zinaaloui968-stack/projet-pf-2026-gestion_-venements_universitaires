<?php
session_start();
require_once '../includes/check_role.php';
requireLogin();
require_once '../includes/config.php';

$userId = $_SESSION['user']['id'];
$events = $pdo->query("SELECT * FROM evenement WHERE statut='publie' ORDER BY date_evenement ASC")->fetchAll();
$myInscriptions = $pdo->query("SELECT id_evenement FROM inscription WHERE id_utilisateur=$userId")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Événements — UniEvent</title>
<?php include '../includes/header.php'; ?>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-section">Navigation</div>
  <a href="participant.php" class="active"><span class="icon">🏠</span> Accueil</a>
  <a href="../evenements/mes_inscriptions.php"><span class="icon">✅</span> Mes inscriptions</a>
</div>

<div class="main-content">
  <div class="page-header">
    <h1>Événements disponibles</h1>
    <p>Découvrez et inscrivez-vous aux événements universitaires</p>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;">
  <?php foreach($events as $ev): ?>
    <?php $inscrit = in_array($ev['id'], $myInscriptions); ?>
    <div class="card" style="padding:24px;">
      <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:14px;">
        <span class="badge badge-blue"><?= htmlspecialchars($ev['categorie']) ?></span>
        <?php if($inscrit): ?><span class="badge badge-green">Inscrit ✓</span><?php endif; ?>
      </div>
      <h3 style="font-family:'DM Serif Display',serif;font-size:18px;color:#0f1c2e;margin-bottom:10px;"><?= htmlspecialchars($ev['titre']) ?></h3>
      <p style="font-size:13px;color:#8a9ab5;margin-bottom:6px;">📅 <?= date('d/m/Y H:i', strtotime($ev['date_evenement'])) ?></p>
      <p style="font-size:13px;color:#8a9ab5;margin-bottom:16px;">📍 <?= htmlspecialchars($ev['lieu']) ?></p>
      <p style="font-size:14px;color:#4a5568;margin-bottom:20px;"><?= substr(htmlspecialchars($ev['description']), 0, 100) ?>...</p>
      <?php if(!$inscrit): ?>
        <a href="../evenements/inscription.php?id=<?= $ev['id'] ?>" class="btn-primary" style="width:100%;text-align:center;">S'inscrire</a>
      <?php else: ?>
        <a href="../evenements/desinscription.php?id=<?= $ev['id'] ?>" class="btn-danger" style="width:100%;text-align:center;padding:10px;border-radius:10px;">Se désinscrire</a>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <?php if(empty($events)): ?>
    <div class="card"><p style="color:#8a9ab5;">Aucun événement disponible pour le moment.</p></div>
  <?php endif; ?>
  </div>
</div>
</body>
</html>
