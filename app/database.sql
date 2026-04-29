-- MISE À JOUR de la base existante
USE gestion_evenements_scolaires;

-- Table PROFESSEURS
CREATE TABLE professeurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    matiere_principale VARCHAR(100),
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table ÉTUDIANTS
CREATE TABLE etudiants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    classe VARCHAR(50),
    date_naissance DATE,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- MODIFIER table utilisateurs (pour admins uniquement)
ALTER TABLE utilisateurs ADD COLUMN type_user ENUM('admin', 'super_admin') DEFAULT 'admin';

-- Table des rôles/permissions
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_role VARCHAR(50) UNIQUE NOT NULL,
    description TEXT
);

INSERT INTO roles (nom_role, description) VALUES 
('super_admin', 'Accès total à l''application'),
('admin', 'Gestion événements et utilisateurs'),
('professeur', 'Inscription et consultation événements'),
('etudiant', 'Inscription aux événements uniquement');

-- Associer rôles aux tables
ALTER TABLE professeurs ADD COLUMN role_id INT DEFAULT 3;
ALTER TABLE etudiants ADD COLUMN role_id INT DEFAULT 4;
ALTER TABLE utilisateurs ADD COLUMN role_id INT DEFAULT 2;

ALTER TABLE professeurs ADD FOREIGN KEY (role_id) REFERENCES roles(id);
ALTER TABLE etudiants ADD FOREIGN KEY (role_id) REFERENCES roles(id);
ALTER TABLE utilisateurs ADD FOREIGN KEY (role_id) REFERENCES roles(id);

-- Données de test
INSERT INTO professeurs (nom, prenom, email, mot_de_passe, matiere_principale) VALUES 
('DUPONT', 'Marie', 'marie.dupont@ecole.fr', MD5('prof123'), 'Mathématiques'),
('LEMAIRE', 'Pierre', 'pierre.lemaire@ecole.fr', MD5('prof123'), 'Français');

INSERT INTO etudiants (nom, prenom, email, mot_de_passe, classe) VALUES 
('MARTIN', 'Jean', 'jean.martin@ecole.fr', MD5('etud123'), '3ème A'),
('DURAND', 'Sophie', 'sophie.durand@ecole.fr', MD5('etud123'), '2nde B');
