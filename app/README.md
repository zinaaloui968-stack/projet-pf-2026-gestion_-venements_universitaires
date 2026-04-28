# 🎓 UniEvent — Application Web de Gestion des Événements Universitaires

> Projet réalisé dans le cadre du module Projet Fédéré — Sprint 1  
> Encadrante : **Mme Wafa Hidri**

---

## 👥 Équipe

| Membre | Rôle | Branche |
|--------|------|---------|
| El Mabrouk Ghaith | Scrum Master / Dev | `feature/gestion-users` |
| Jebali Mayssa | Product Owner / Dev | `feature/dashboard` |
| Aloui Zina | Développeuse | `feature/login` |
| Ben Mbarek Rayen | Développeur | `feature/logout` |

---

## 📋 Description

Application web permettant la gestion, la consultation et la participation aux événements universitaires avec trois rôles : **Administrateur**, **Organisateur** et **Participant**.

---

## 🛠️ Technologies

- **Frontend** : HTML5, CSS3, JavaScript
- **Backend** : PHP (architecture client-serveur)
- **Base de données** : MySQL / phpMyAdmin
- **Serveur local** : XAMPP
- **Versioning** : Git / GitHub

---

## 🚀 Installation

### 1. Prérequis
- Installer [XAMPP](https://www.apachefriends.org/)
- Installer [VS Code](https://code.visualstudio.com/)
- Installer [Git](https://git-scm.com/)

### 2. Cloner le projet
```bash
git clone https://github.com/VOTRE-GROUPE/gestion-evenements.git
```

### 3. Placer le projet dans XAMPP
```
Copier le dossier dans : C:/xampp/htdocs/gestion-evenements/
```

### 4. Créer la base de données
1. Ouvrir **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Créer une base : `gestion_evenements`
3. Importer le fichier : `database.sql`

### 5. Lancer l'application
Ouvrir : `http://localhost/gestion-evenements/`

---

## 🔐 Comptes de test

| Email | Mot de passe | Rôle |
|-------|-------------|------|
| admin@univ.tn | Test1234 | Administrateur |
| ghaith@univ.tn | Test1234 | Organisateur |
| zina@univ.tn | Test1234 | Participant |

---

## 📁 Structure du projet

```
gestion-evenements/
├── index.php               ← Page de connexion
├── database.sql            ← Script SQL
├── README.md
├── auth/
│   ├── connexion.php
│   ├── deconnexion.php
│   └── forgot_password.php
├── dashboard/
│   ├── admin.php
│   ├── organisateur.php
│   └── participant.php
├── admin/
│   ├── users.php
│   ├── add_user.php
│   ├── edit_user.php
│   └── events_pending.php
├── evenements/
│   ├── create.php
│   ├── edit.php
│   └── inscription.php
├── includes/
│   ├── config.php
│   ├── header.php
│   └── check_role.php
└── css/
    └── style.css
```

---

## 📅 Sprint Backlog

| Sprint | Période | Objectif |
|--------|---------|----------|
| Sprint 0 | 14/03 → 18/03/2026 | Conception & Base de données |
| Sprint 1 | 19/03 → 28/03/2026 | Authentification & Utilisateurs |
| Sprint 2 | 29/03 → 08/04/2026 | Gestion des Événements |
| Sprint 3 | 09/04 → 18/04/2026 | Inscriptions & Livraison |

---

## 📌 Liens utiles

- 🎯 **Jira** : [Lien vers votre projet Jira]
- 🐙 **GitHub** : [Lien vers votre dépôt]
