<?php
session_start();
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real app: generate token, save to DB, send email via PHPMailer
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Mot de passe oublié — UniEvent</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap');
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--navy:#0f1c2e;--accent:#e8a020;--light:#f5f0e8;}
body{font-family:'DM Sans',sans-serif;background:var(--navy);min-height:100vh;display:flex;align-items:center;justify-content:center;}
.box{background:var(--light);border-radius:20px;padding:50px;width:420px;box-shadow:0 30px 60px rgba(0,0,0,0.3);}
h2{font-family:'DM Serif Display',serif;font-size:26px;color:var(--navy);margin-bottom:8px;}
p{color:#8a9ab5;font-size:14px;margin-bottom:28px;}
label{display:block;font-size:12px;font-weight:600;color:var(--navy);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;}
input{width:100%;padding:14px 18px;background:#fff;border:2px solid transparent;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:15px;outline:none;transition:border-color 0.2s;margin-bottom:20px;}
input:focus{border-color:var(--accent);}
.btn{width:100%;padding:15px;background:var(--navy);color:#fff;border:none;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;cursor:pointer;transition:background 0.2s;}
.btn:hover{background:var(--accent);}
.back{display:block;text-align:center;margin-top:16px;color:#8a9ab5;font-size:13px;text-decoration:none;}
.alert{padding:12px;background:#eafaf1;color:#27ae60;border-radius:10px;margin-bottom:16px;font-size:14px;}
</style>
</head>
<body>
<div class="box">
  <h2>Mot de passe oublié 🔑</h2>
  <p>Entrez votre email pour recevoir un lien de réinitialisation.</p>
  <?php if($success): ?>
    <div class="alert">✅ Un lien de réinitialisation a été envoyé à votre email.</div>
  <?php else: ?>
  <form method="POST">
    <label>Votre email</label>
    <input type="email" name="email" placeholder="ex: zina@univ.tn" required>
    <button type="submit" class="btn">Envoyer le lien →</button>
  </form>
  <?php endif; ?>
  <a href="../index.php" class="back">← Retour à la connexion</a>
</div>
</body>
</html>
