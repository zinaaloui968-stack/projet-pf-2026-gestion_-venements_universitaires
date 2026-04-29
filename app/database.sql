-- database.sql
-- À exécuter une fois ou laisser config.php le faire automatiquement

-- Table utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    full_name TEXT NOT NULL,
    role TEXT DEFAULT 'participant',  -- admin, organisateur, participant
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table pour "Se souvenir de moi"
CREATE TABLE IF NOT EXISTS user_tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    token TEXT NOT NULL,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertion d'un utilisateur admin par défaut (mot de passe: admin123)
-- Le mot de passe sera hashé en PHP, à créer via un script séparé ou manuellement
