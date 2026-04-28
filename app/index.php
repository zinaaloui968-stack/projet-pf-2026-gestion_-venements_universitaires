<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniEvent — Connexion</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap');

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --navy:   #0f1c2e;
    --blue:   #1a3a5c;
    --accent: #e8a020;
    --light:  #f5f0e8;
    --white:  #ffffff;
    --gray:   #8a9ab5;
    --error:  #c0392b;
    --success:#27ae60;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  /* Animated background */
  body::before {
    content: '';
    position: fixed;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(232,160,32,0.12) 0%, transparent 70%);
    top: -200px; right: -200px;
    border-radius: 50%;
    animation: pulse 6s ease-in-out infinite;
  }
  body::after {
    content: '';
    position: fixed;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(26,58,92,0.4) 0%, transparent 70%);
    bottom: -100px; left: -100px;
    border-radius: 50%;
    animation: pulse 8s ease-in-out infinite reverse;
  }
  @keyframes pulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.1);opacity:0.7} }

  .container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    width: 900px;
    min-height: 550px;
    background: var(--white);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 40px 80px rgba(0,0,0,0.4);
    position: relative;
    z-index: 1;
    animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1);
  }
  @keyframes slideUp { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }

  /* Left panel */
  .left {
    background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
    padding: 60px 50px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
  }
  .left::before {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    border: 60px solid rgba(232,160,32,0.08);
    border-radius: 50%;
    top: -100px; right: -100px;
  }
  .left::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border: 40px solid rgba(255,255,255,0.04);
    border-radius: 50%;
    bottom: -60px; left: -60px;
  }

  .brand {
    position: relative;
    z-index: 1;
  }
  .brand-icon {
    width: 52px; height: 52px;
    background: var(--accent);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
    margin-bottom: 20px;
    box-shadow: 0 8px 24px rgba(232,160,32,0.3);
  }
  .brand h1 {
    font-family: 'DM Serif Display', serif;
    font-size: 32px;
    color: var(--white);
    line-height: 1.2;
    margin-bottom: 12px;
  }
  .brand p {
    color: var(--gray);
    font-size: 14px;
    line-height: 1.6;
  }

  .stats {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }
  .stat {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    padding: 16px;
  }
  .stat-number {
    font-family: 'DM Serif Display', serif;
    font-size: 28px;
    color: var(--accent);
  }
  .stat-label {
    font-size: 11px;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 4px;
  }

  /* Right panel */
  .right {
    padding: 60px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--light);
  }

  .right h2 {
    font-family: 'DM Serif Display', serif;
    font-size: 28px;
    color: var(--navy);
    margin-bottom: 8px;
  }
  .right > p {
    color: var(--gray);
    font-size: 14px;
    margin-bottom: 36px;
  }

  .form-group {
    margin-bottom: 20px;
  }
  label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
  }
  input {
    width: 100%;
    padding: 14px 18px;
    background: var(--white);
    border: 2px solid transparent;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    color: var(--navy);
    transition: all 0.2s;
    outline: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(232,160,32,0.12);
  }

  .forgot {
    text-align: right;
    margin-top: -12px;
    margin-bottom: 28px;
  }
  .forgot a {
    font-size: 12px;
    color: var(--accent);
    text-decoration: none;
    font-weight: 500;
  }

  .btn {
    width: 100%;
    padding: 15px;
    background: var(--navy);
    color: var(--white);
    border: none;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    letter-spacing: 0.3px;
  }
  .btn:hover {
    background: var(--accent);
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(232,160,32,0.3);
  }

  .alert {
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
  }
  .alert-error { background: #fdecea; color: var(--error); border-left: 3px solid var(--error); }
  .alert-success { background: #eafaf1; color: var(--success); border-left: 3px solid var(--success); }

  @media(max-width:700px){
    .container{ grid-template-columns:1fr; width:95%; }
    .left{ display:none; }
  }
</style>
</head>
<body>
<div class="container">
  <div class="left">
    <div class="brand">
      <div class="brand-icon">🎓</div>
      <h1>Gestion des Événements Universitaires</h1>
      <p>Plateforme centralisée pour organiser, publier et participer aux événements de votre université.</p>
    </div>
    <div class="stats">
      <div class="stat">
        <div class="stat-number">3</div>
        <div class="stat-label">Rôles</div>
      </div>
      <div class="stat">
        <div class="stat-number">∞</div>
        <div class="stat-label">Événements</div>
      </div>
      <div class="stat">
        <div class="stat-number">100%</div>
        <div class="stat-label">Sécurisé</div>
      </div>
      <div class="stat">
        <div class="stat-number">4</div>
        <div class="stat-label">Sprints</div>
      </div>
    </div>
  </div>
  <div class="right">
    <h2>Bienvenue 👋</h2>
    <p>Connectez-vous à votre espace universitaire</p>

    <?php if(isset($_GET['error'])): ?>
      <div class="alert alert-error">❌ Email ou mot de passe incorrect.</div>
    <?php endif; ?>
    <?php if(isset($_GET['logout'])): ?>
      <div class="alert alert-success">✅ Vous avez été déconnecté avec succès.</div>
    <?php endif; ?>

    <form method="POST" action="auth/connexion.php">
      <div class="form-group">
        <label>Email / Matricule</label>
        <input type="text" name="email" placeholder="ex: zina.aloui@univ.tn" required>
      </div>
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="forgot">
        <a href="auth/forgot_password.php">Mot de passe oublié ?</a>
      </div>
      <button type="submit" class="btn">Se connecter →</button>
    </form>
  </div>
</div>
</body>
</html>
