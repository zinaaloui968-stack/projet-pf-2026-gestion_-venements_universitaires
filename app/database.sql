-- ============================================================
-- Base de données : gestion_evenements
-- Application Web de Gestion des Événements Universitaires
-- ============================================================

CREATE DATABASE IF NOT EXISTS gestion_evenements CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_evenements;

-- ── Table : utilisateur ────────────────────────────────────
CREATE TABLE utilisateur (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nom            VARCHAR(100)  NOT NULL,
    email          VARCHAR(150)  NOT NULL UNIQUE,
    mot_de_passe   VARCHAR(255)  NOT NULL,
    role           ENUM('admin','organisateur','participant') NOT NULL DEFAULT 'participant',
    actif          TINYINT(1)    NOT NULL DEFAULT 1,
    date_creation  DATETIME      DEFAULT NOW()
);

-- ── Table : categorie ──────────────────────────────────────
CREATE TABLE categorie (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    libelle   VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- ── Table : evenement ──────────────────────────────────────
CREATE TABLE evenement (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    titre            VARCHAR(200) NOT NULL,
    description      TEXT,
    date_evenement   DATETIME     NOT NULL,
    lieu             VARCHAR(200) NOT NULL,
    places_max       INT          NOT NULL DEFAULT 50,
    statut           ENUM('en_attente','publie','annule') NOT NULL DEFAULT 'en_attente',
    id_organisateur  INT          NOT NULL,
    id_categorie     INT,
    date_creation    DATETIME     DEFAULT NOW(),
    FOREIGN KEY (id_organisateur) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categorie)    REFERENCES categorie(id)   ON DELETE SET NULL
);

-- ── Table : inscription ────────────────────────────────────
CREATE TABLE inscription (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur  INT NOT NULL,
    id_evenement    INT NOT NULL,
    statut          ENUM('inscrit','liste_attente','desinscrit') NOT NULL DEFAULT 'inscrit',
    date_inscription DATETIME DEFAULT NOW(),
    UNIQUE KEY unique_inscription (id_utilisateur, id_evenement),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (id_evenement)   REFERENCES evenement(id)   ON DELETE CASCADE
);

-- ── Données de test ────────────────────────────────────────

-- Catégories
INSERT INTO categorie (libelle, description) VALUES
('Conférence',  'Conférences académiques et scientifiques'),
('Séminaire',   'Séminaires de formation et d''études'),
('Atelier',     'Ateliers pratiques et workshops'),
('Culturel',    'Événements culturels et artistiques'),
('Sportif',     'Événements sportifs universitaires');

-- Utilisateurs (mot de passe : Test1234 pour tous)
INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES
('Admin Système',    'admin@univ.tn',        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('El Mabrouk Ghaith','ghaith@univ.tn',       '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'organisateur'),
('Jebali Mayssa',    'mayssa@univ.tn',       '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'organisateur'),
('Aloui Zina',       'zina@univ.tn',         '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'participant'),
('Ben Mbarek Rayen', 'rayen@univ.tn',        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'participant');

-- Événements de test
INSERT INTO evenement (titre, description, date_evenement, lieu, places_max, statut, id_organisateur, id_categorie) VALUES
('Conférence Intelligence Artificielle', 'Découvrez les dernières avancées en IA et machine learning.', '2026-04-10 09:00:00', 'Amphithéâtre A, Bâtiment Principal', 100, 'publie', 2, 1),
('Séminaire Cybersécurité',              'Sensibilisation aux menaces informatiques modernes.',          '2026-04-15 14:00:00', 'Salle de conférences B2',             50,  'publie', 3, 2),
('Atelier Développement Web',            'Initiation à HTML, CSS, PHP et MySQL.',                       '2026-04-20 10:00:00', 'Labo Informatique 3',                 30,  'en_attente', 2, 3);
