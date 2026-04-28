<?php
if (!isset($_SESSION['user'])) { header('Location: ../index.php'); exit; }
$user = $_SESSION['user'];
$roleLabels = ['admin' => 'Administrateur', 'organisateur' => 'Organisateur', 'participant' => 'Participant'];
$roleColors = ['admin' => '#e8a020', 'organisateur' => '#27ae60', 'participant' => '#2980b9'];
$roleLabel = $roleLabels[$user['role']] ?? $user['role'];
$roleColor = $roleColors[$user['role']] ?? '#888';
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap');
:root{--navy:#0f1c2e;--blue:#1a3a5c;--accent:#e8a020;--light:#f5f0e8;--white:#ffffff;--gray:#8a9ab5;}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'DM Sans',sans-serif;background:#f0f2f5;min-height:100vh;}
.topbar{background:var(--navy);padding:0 40px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:0 2px 20px rgba(0,0,0,0.3);}
.topbar-brand{display:flex;align-items:center;gap:12px;}
.topbar-brand .icon{width:36px;height:36px;background:var(--accent);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;}
.topbar-brand span{font-family:'DM Serif Display',serif;color:var(--white);font-size:18px;}
.topbar-right{display:flex;align-items:center;gap:20px;}
.user-info{display:flex;align-items:center;gap:10px;}
.user-avatar{width:36px;height:36px;background:var(--blue);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--white);font-weight:600;font-size:14px;border:2px solid var(--accent);}
.user-name{color:var(--white);font-size:14px;font-weight:500;}
.user-role{font-size:11px;padding:2px 10px;border-radius:20px;font-weight:600;color:var(--white);}
.btn-logout{padding:8px 18px;background:transparent;border:1px solid rgba(255,255,255,0.2);color:var(--white);border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;cursor:pointer;transition:all 0.2s;text-decoration:none;}
.btn-logout:hover{background:rgba(255,255,255,0.1);}
.sidebar{width:240px;background:var(--white);height:calc(100vh - 64px);position:fixed;left:0;top:64px;padding:24px 0;box-shadow:2px 0 12px rgba(0,0,0,0.06);overflow-y:auto;}
.sidebar-section{padding:8px 20px;font-size:10px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:1px;margin-top:16px;}
.sidebar a{display:flex;align-items:center;gap:12px;padding:12px 24px;color:#4a5568;text-decoration:none;font-size:14px;font-weight:500;transition:all 0.2s;}
.sidebar a:hover,.sidebar a.active{background:#f7f3ed;color:var(--navy);border-right:3px solid var(--accent);}
.sidebar a .icon{font-size:18px;width:24px;text-align:center;}
.main-content{margin-left:240px;padding:32px 40px;min-height:calc(100vh - 64px);}
.page-header{margin-bottom:32px;}
.page-header h1{font-family:'DM Serif Display',serif;font-size:28px;color:var(--navy);}
.page-header p{color:var(--gray);font-size:14px;margin-top:6px;}
.card{background:var(--white);border-radius:16px;padding:28px;box-shadow:0 2px 12px rgba(0,0,0,0.06);margin-bottom:24px;}
.card-title{font-family:'DM Serif Display',serif;font-size:18px;color:var(--navy);margin-bottom:20px;}
.btn-primary{padding:10px 22px;background:var(--navy);color:var(--white);border:none;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s;text-decoration:none;display:inline-block;}
.btn-primary:hover{background:var(--accent);transform:translateY(-1px);}
.btn-accent{padding:10px 22px;background:var(--accent);color:var(--white);border:none;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s;text-decoration:none;display:inline-block;}
.btn-danger{padding:8px 16px;background:#fdecea;color:#c0392b;border:none;border-radius:8px;font-size:13px;cursor:pointer;font-family:'DM Sans',sans-serif;}
.badge{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
.badge-green{background:#eafaf1;color:#27ae60;}
.badge-orange{background:#fef9e7;color:#e67e22;}
.badge-red{background:#fdecea;color:#c0392b;}
.badge-blue{background:#eaf2fb;color:#2980b9;}
table{width:100%;border-collapse:collapse;}
th{background:#f8f9fa;padding:12px 16px;text-align:left;font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;}
td{padding:14px 16px;border-bottom:1px solid #f0f0f0;font-size:14px;color:#4a5568;}
tr:hover td{background:#fafafa;}
.form-group{margin-bottom:20px;}
.form-group label{display:block;font-size:12px;font-weight:600;color:var(--navy);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:12px 16px;border:2px solid #e8e8e8;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--navy);outline:none;transition:border-color 0.2s;}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--accent);}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;margin-bottom:32px;}
.stat-card{background:var(--white);border-radius:16px;padding:24px;box-shadow:0 2px 12px rgba(0,0,0,0.06);}
.stat-card .number{font-family:'DM Serif Display',serif;font-size:36px;color:var(--navy);}
.stat-card .label{font-size:13px;color:var(--gray);margin-top:4px;}
.stat-card .icon{font-size:28px;margin-bottom:12px;}
</style>

<div class="topbar">
  <div class="topbar-brand">
    <div class="icon">🎓</div>
    <span>UniEvent</span>
  </div>
  <div class="topbar-right">
    <div class="user-info">
      <div class="user-avatar"><?= strtoupper(substr($user['nom'], 0, 1)) ?></div>
      <div>
        <div class="user-name"><?= htmlspecialchars($user['nom']) ?></div>
        <span class="user-role" style="background:<?= $roleColor ?>"><?= $roleLabel ?></span>
      </div>
    </div>
    <a href="../auth/deconnexion.php" class="btn-logout">Déconnexion</a>
  </div>
</div>
