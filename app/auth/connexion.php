<?php
require_once __DIR__ . '/../includes/config.php';

$error = '';
$success = '';

// Déjà connecté ? Redirection vers le dashboard selon le rôle
if (isLoggedIn()) {
    $role = $_SESSION['user_role'] ?? 'participant';
    switch ($role) {
        case 'admin':
            header('Location: /app/dashboard/admin.php');
            break;
        case 'organisateur':
            header('Location: /app/dashboard/organisateur.php');
            break;
        default:
            header('Location: /app/dashboard/participant.php');
    }
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT id, email, password, full_name, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];

            // Gestion "Se souvenir de moi"
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
                $stmtToken = $pdo->prepare("INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
                $stmtToken->execute([$user['id'], $token, $expires]);
                setcookie('remember_token', $token, strtotime('+30 days'), '/', '', false, true);
            }

            // Redirection selon le rôle
            switch ($user['role']) {
                case 'admin':
                    header('Location: /app/dashboard/admin.php');
                    break;
                case 'organisateur':
                    header('Location: /app/dashboard/organisateur.php');
                    break;
                default:
                    header('Location: /app/dashboard/participant.php');
            }
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    }
}

// Vérification du cookie "remember me"
if (isset($_COOKIE['remember_token']) && !isLoggedIn()) {
    $token = $_COOKIE['remember_token'];
    $stmt = $pdo->prepare("
        SELECT u.id, u.email, u.full_name, u.role 
        FROM user_tokens t
        JOIN users u ON t.user_id = u.id
        WHERE t.token = ? AND t.expires_at > datetime('now')
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        // Redirection
        switch ($user['role']) {
            case 'admin': header('Location: /app/dashboard/admin.php'); break;
            case 'organisateur': header('Location: /app/dashboard/organisateur.php'); break;
            default: header('Location: /app/dashboard/participant.php');
        }
        exit;
    } else {
        setcookie('remember_token', '', time() - 3600, '/');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des Événements Universitaires</title>
    <style>
        /* Même style que précédemment, gardez le CSS exact de login.php */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .login-container { background: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); width: 100%; max-width: 450px; padding: 40px; transition: transform 0.3s ease; }
        .login-container:hover { transform: translateY(-5px); }
        h1 { font-size: 28px; color: #333; margin-bottom: 10px; text-align: center; }
        .subtitle { text-align: center; color: #667eea; font-weight: 600; margin-bottom: 30px; font-size: 14px; letter-spacing: 1px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: 500; font-size: 14px; }
        input { width: 100%; padding: 12px 15px; border: 2px solid #e1e5e9; border-radius: 10px; font-size: 14px; transition: all 0.3s ease; outline: none; }
        input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .checkbox-group { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; font-size: 14px; }
        .checkbox-label { display: flex; align-items: center; gap: 8px; cursor: pointer; color: #555; }
        .checkbox-label input { width: auto; margin: 0; }
        .forgot-password { color: #667eea; text-decoration: none; transition: color 0.3s; }
        .forgot-password:hover { color: #764ba2; text-decoration: underline; }
        .btn-login { width: 100%; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102,126,234,0.3); }
        .signup-link { text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e1e5e9; color: #777; font-size: 14px; }
        .signup-link a { color: #667eea; text-decoration: none; font-weight: 600; margin-left: 5px; }
        .signup-link a:hover { text-decoration: underline; }
        .error-message { background-color: #fee; color: #c33; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #c33; }
        @media (max-width: 480px) { .login-container { padding: 25px; } h1 { font-size: 24px; } }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <div class="subtitle">Gestion des Événements Universitaires</div>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="votre_email@universite.fr" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="**********" required>
            </div>
            <div class="checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    Se souvenir de moi
                </label>
                <a href="forgot_password.php" class="forgot-password">Mot de passe oublié ?</a>
            </div>
            <button type="submit" class="btn-login">Se connecter</button>
        </form>
        <div class="signup-link">
            Pas encore de compte ?
            <a href="register.php">Créer un compte</a>
            <!-- Note : vous devrez créer register.php ou l'adapter -->
        </div>
    </div>
</body>
</html>
