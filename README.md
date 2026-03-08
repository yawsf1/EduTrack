# EduTrack

Une plateforme complète de gestion éducative construite avec PHP, MySQL, HTML, CSS et JavaScript.

## Table des matières

- [Description](#description)
- [Fonctionnalités](#fonctionnalités)
- [Structure du projet](#structure-du-projet)
- [Stack technique](#stack-technique)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Modules principaux](#modules-principaux)
- [Base de données](#base-de-données)
- [Captures d'écran](#captures-décran--résultats)
- [Contribuer](#contribuer)

---

## Description

EduTrack est une application web éducative complète qui permet aux utilisateurs de gérer leurs cours, tâches, flashcards, et de suivre leurs statistiques personnelles via un tableau de bord interactif avec graphiques en temps réel.

**En résumé :** EduTrack est votre compagnon d'apprentissage ultime — une plateforme unifiée pour organiser vos études, suivre votre progression et accéder à des outils éducatifs intégrés.

## Fonctionnalités

### Fonctionnalités principales
- ** Authentification sécurisée** : Inscription, connexion et gestion des sessions
- ** Gestion des cours** : Création, modification, suppression et suivi des cours
- ** Gestionnaire de tâches** : Ajout, modification, suppression avec statuts
- ** Flashcards** : Apprentissage rapide et révision des concepts clés
- ** Calculatrice scientifique** : Outil mathématique intégré pour les calculs
- ** Tableaux de bord interactifs** : Statistiques et graphiques en temps réel (Chart.js)
- ** Recherche globale** : Recherche instantanée dans les cours, tâches et flashcards
- ** Gestion de fichiers** : Téléchargement et organisation de documents
- ** Système Q&R** : Questions et réponses interactif

### Expérience utilisateur
- ** Design responsive** : Parfaitement adapté aux mobiles, tablettes et desktops
- ** Messages flash** : Confirmations et alertes en temps réel
- ** Validation des données** : Sécurisation côté serveur et côté client
- ** Interface moderne** : Design intuitif et ergonomique

## Structure du projet

```
EduTrack/
│
├── Authentification & Inscription
│ ├── index.php # Page de connexion
│ ├── index2.php # Tableau de bord principal
│ ├── login.php # Traitement de la connexion
│ ├── register.php # Page d'inscription
│ ├── inscription.php # Traitement de l'inscription
│ ├── account_delete.php # Suppression de compte
│ └── inscconn.css # Styles d'authentification
│
├── Gestion des cours
│ ├── cours.php # Liste et détails des cours
│ ├── cours.css # Styles des cours
│ ├── courscree.php # Création/modification de cours
│ ├── courscree.css # Styles de création de cours
│ └── [fichiers de cours]
│
├── Gestion des tâches
│ ├── taches.php # Interface de gestion des tâches
│ ├── taches.css # Styles des tâches
│ └── delete.php # Gestionnaire de suppression
│
├── Outils & Utilitaires
│ ├── calculator.php # Calculatrice scientifique
│ ├── outils.php # Hub des outils
│ ├── outils.css # Styles des outils
│ ├── outils/ # Sous-répertoire des outils
│ └── question_reponse.css # Styles Q&R
│
├── Analyses & Visualisation
│ ├── graphs.php # Graphiques de performance & analytics
│ └── [visualisation des données]
│
├── ️ Backend principal
│ ├── function.php # Fonctions utilitaires partagées
│ ├── api.php # Points d'API
│ ├── db.php # Configuration base de données
│ └── [logique principale]
│
├── Assets frontend
│ ├── script.js # JavaScript côté client
│ ├── style.css # Styles globaux
│ └── [fichiers CSS additionnels]
│
├── Stockage des données
│ ├── media/ # Répertoire des médias
│ ├── uploads/ # Répertoire des fichiers uploadés
│ └── [fichiers générés par les utilisateurs]
│
└── README.md # Ce fichier
```

## ️ Stack technique

| Catégorie | Technologies |
|-----------|-------------|
| **Backend** | PHP 7.4+ |
| **Base de données** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3, JavaScript (ES6+) |
| **Bibliothèques** | Chart.js (graphiques) |
| **Serveur** | Apache/Nginx avec mod_rewrite |
| **Communication** | Requêtes HTTP |

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP** 7.4 ou supérieur
- **MySQL** 5.7+ ou **MariaDB** 10.3+
- **Serveur web** (Apache avec mod_rewrite, Nginx ou équivalent)
- **Environnement de développement local** (XAMPP, WAMP, MAMP ou similaire)
- **Navigateur web moderne** (Chrome, Firefox, Safari, Edge)

## Installation

### Étape 1 : Cloner le dépôt

```bash
git clone https://github.com/yawsf1/EduTrack.git
cd EduTrack
```

### Étape 2 : Configurer votre serveur local

**Pour XAMPP :**
```bash
# Copiez le dossier EduTrack dans :
C:\xampp\htdocs\EduTrack # Windows
/Applications/XAMPP/htdocs/EduTrack # macOS
/opt/lampp/htdocs/EduTrack # Linux
```

**Pour WAMP :**
```bash
# Copiez dans : C:\wamp\www\EduTrack
```

**Pour MAMP :**
```bash
# Copiez dans : /Applications/MAMP/htdocs/EduTrack
```

### Étape 3 : Créer la base de données

1. Ouvrez **phpMyAdmin** (généralement sur `http://localhost/phpmyadmin`)
2. Créez une nouvelle base de données nommée `edutrack`
3. Importez le schéma SQL (si fourni) :
- Allez dans l'onglet Import
- Sélectionnez le fichier SQL
- Cliquez sur Importer

**Ou créez les tables manuellement :**
```sql
CREATE DATABASE IF NOT EXISTS edutrack;
USE edutrack;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL UNIQUE,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
title VARCHAR(255) NOT NULL,
description TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE tasks (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
title VARCHAR(255) NOT NULL,
description TEXT,
status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
due_date DATE,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE flashcards (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
question VARCHAR(500) NOT NULL,
answer TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Étape 4 : Configurer la connexion à la base de données

Modifiez `db.php` :

```php
<?php
$host = 'localhost';
$dbname = 'edutrack';
$username = 'root';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
die("Erreur de connexion : " . mysqli_connect_error());
}
?>
```

### Étape 5 : Définir les permissions des fichiers

```bash
# Assurez-vous que les répertoires uploads et media sont accessibles en écriture
chmod 755 uploads/
chmod 755 media/
```

### Étape 6 : Démarrer le serveur et accéder à l'application

- **Démarrez XAMPP/WAMP/MAMP** et activez Apache & MySQL
- Ouvrez votre navigateur et accédez à :
```
http://localhost/EduTrack/index.php
```

## Utilisation

### 1. Inscription & Connexion
```
1. Accédez à http://localhost/EduTrack/index.php
2. Cliquez sur "S'inscrire" ou utilisez des identifiants existants
3. Remplissez le nom d'utilisateur, l'email et le mot de passe
4. Cliquez sur "Connexion" pour accéder à votre tableau de bord
```

### 2. Aperçu du tableau de bord
Après connexion, vous verrez :
- ** Tableau de bord statistiques** : Vue d'ensemble de votre progression
- ** Section Cours** : Tous vos cours
- ** Section Tâches** : Vos tâches en cours et terminées
- ** Section Flashcards** : Vos supports d'étude
- ** Section Outils** : Accès à la calculatrice, Q&R et autres utilitaires

### 3. Gestion des cours
```
- Cliquez sur "Cours" dans la navigation
- Cliquez sur "+ Ajouter un cours" pour créer un nouveau cours
- Remplissez les détails du cours et sauvegardez
- Modifiez ou supprimez les cours existants selon vos besoins
```

### 4. Gestion des tâches
```
- Accédez à la section "Tâches"
- Créez de nouvelles tâches avec titres, descriptions et dates d'échéance
- Marquez les tâches comme en attente, en cours ou terminées
- Suivez votre productivité avec les statistiques de tâches
```

### 5. Utilisation de la calculatrice
```
- Accessible depuis le menu "Outils"
- Effectuez des calculs mathématiques
- Supporte les fonctions scientifiques et opérations avancées
```

### 6. Consultation des analyses
```
- Accédez à "Statistiques"
- Visualisez des graphiques et tableaux en temps réel
- Suivez votre progression d'apprentissage dans le temps
```

### 7. Gestion des fichiers
```
- Uploadez des supports de cours et documents
- Les fichiers sont stockés dans le répertoire uploads/
- Organisez et téléchargez vos fichiers selon vos besoins
```

## Modules principaux

### `db.php` — Configuration de la base de données
Gère toutes les connexions et identifiants de la base de données.

### `function.php` — Fonctions utilitaires
Contient des fonctions réutilisables dans toute l'application :
- Helpers d'authentification
- Validation des données
- Gestion des sessions
- Opérations communes

### `api.php` — Points d'API
Fournit des endpoints dynamiques pour :
- Les requêtes AJAX
- La récupération de données
- Les mises à jour en temps réel
- La communication client-serveur

### `graphs.php` — Module d'analyse
Génère et affiche :
- Graphiques de performance (Chart.js)
- Visualisation de la progression d'apprentissage
- Analyses statistiques
- Suivi des tendances

### `calculator.php` — Calculatrice scientifique
Fonctionnalités :
- Opérations arithmétiques de base
- Fonctions scientifiques (sin, cos, log, etc.)
- Fonctions mémoire
- Historique des calculs

### `delete.php` — Gestionnaire de suppression
Gère en toute sécurité la suppression de :
- Cours
- Tâches
- Fichiers
- Données utilisateur

### Fichiers d'authentification
- `login.php` — Valide les identifiants et gère les sessions
- `register.php` / `inscription.php` — Traitement de l'inscription
- `account_delete.php` — Gestion et suppression de compte

### Gestion des cours
- `cours.php` — Affichage et liste des cours
- `courscree.php` — Création et modification du contenu des cours

### Gestion des tâches
- `taches.php` — Interface complète de gestion des tâches avec filtrage et tri

## ️ Schéma de la base de données

**Table users**
```
- id (INT, CLÉ PRIMAIRE)
- username (VARCHAR, UNIQUE)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashé)
- created_at (TIMESTAMP)
```

**Table courses**
```
- id (INT, CLÉ PRIMAIRE)
- user_id (INT, CLÉ ÉTRANGÈRE)
- title (VARCHAR)
- description (TEXT)
- created_at (TIMESTAMP)
```

**Table tasks**
```
- id (INT, CLÉ PRIMAIRE)
- user_id (INT, CLÉ ÉTRANGÈRE)
- title (VARCHAR)
- description (TEXT)
- status (ENUM : pending, in_progress, completed)
- due_date (DATE)
- created_at (TIMESTAMP)
```

**Table flashcards**
```
- id (INT, CLÉ PRIMAIRE)
- user_id (INT, CLÉ ÉTRANGÈRE)
- question (VARCHAR)
- answer (TEXT)
- created_at (TIMESTAMP)
```

## Captures d'écran & Résultats

### Ce qui est implémenté

- **Application web entièrement fonctionnelle** — Plateforme complète et interactive
- ️ **Base de données MySQL** — Schéma organisé avec toutes les tables nécessaires
- **Tableaux de bord interactifs** — Graphiques et statistiques en temps réel avec Chart.js
- **Messages flash** — Confirmations et alertes utilisateur
- **Design responsive** — Expérience fluide sur desktop et mobile
- **Validation des données** — Validation côté serveur et côté client
- **Interface moderne** — Design propre, intuitif et professionnel
- **Performance** — Chargement optimisé et interactions réactives

## Contribuer

Les contributions sont les bienvenues ! Pour contribuer à EduTrack :

1. **Forkez** le dépôt
2. **Créez** une branche pour votre fonctionnalité
```bash
git checkout -b feature/NomDeLaFonctionnalite
```
3. **Commitez** vos modifications
```bash
git commit -m "Ajout de NomDeLaFonctionnalite"
```
4. **Poussez** vers votre fork
```bash
git push origin feature/NomDeLaFonctionnalite
```
5. **Ouvrez** une Pull Request sur le dépôt principal

### Directives de contribution
- Respectez les standards de codage PHP PSR-12
- Ajoutez des commentaires pour la logique complexe
- Testez soigneusement vos modifications
- Mettez à jour la documentation si nécessaire

## Licence

Ce projet est actuellement sans licence. Veuillez contacter le propriétaire du dépôt pour toute information relative à la licence.

## Support & Contact

Pour les problèmes, questions ou suggestions :
- Ouvrez une **Issue** sur GitHub
- Créez une **Discussion** pour vos questions
- Signalez les **Bugs** avec des informations détaillées

---

## À propos du projet

**EduTrack** représente une solution complète de gestion éducative conçue pour les étudiants et les enseignants. Elle combine des fonctionnalités essentielles telles que le suivi des cours, la gestion des tâches et des outils d'apprentissage intégrés en une seule plateforme unifiée.

**Développé par :** [Yawsf1](https://github.com/yawsf1) 
**Dépôt :** [yawsf1/EduTrack](https://github.com/yawsf1/EduTrack) 
**Dernière mise à jour :** 2026-03-08

---

**Bonne apprentissage ! **
