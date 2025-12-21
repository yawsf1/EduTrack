# EduTrack
## Description

EduTrack est une application web éducative développée en PHP, MySQL, HTML, CSS et JavaScript.
Elle permet aux utilisateurs de gérer leurs cours, tâches, flashcards, et de suivre leurs statistiques personnelles via un tableau de bord interactif avec graphiques.

Cette application combine pages PHP générées côté serveur et certaines fonctionnalités dynamiques côté client via AJAX et Chart.js.

## Fonctionnalités principales

Authentification sécurisée : inscription, connexion et gestion des sessions.

Gestion des cours et fichiers : création, modification et suppression.

Flashcards pour l’apprentissage rapide.

Calculatrice intégrée pour les besoins des cours.

Gestionnaire de tâches : ajout, modification, suppression.

Tableaux de bord interactifs avec statistiques et graphiques (Chart.js).

Recherche globale : recherche instantanée dans les cours, tâches et flashcards.

Interface responsive adaptée aux mobiles et desktops.

Messages flash pour confirmations et alertes.

Validation et sécurisation des données côté serveur et côté client.

## Technologies utilisées

Langages : PHP, HTML, CSS, JavaScript

Base de données : MySQL

Bibliothèques : Chart.js pour les graphiques

Communication client-serveur : Requêtes HTTP classiques + AJAX pour certaines interactions

## Installation et utilisation

### Prérequis :

Serveur web local (ex. XAMPP, WAMP, MAMP) avec PHP et MySQL.

Navigateur moderne (Chrome, Firefox, Edge).

### Installation :

Cloner le dépôt :

git clone https://github.com/yawsf1/EduTrack.git


Copier le dossier dans le répertoire htdocs ou www de votre serveur local.

Créer une base de données MySQL (ex. edutrack) et importer le fichier SQL fourni (ou créer les tables comme dans la section “Modélisation de la base de données”).

Modifier les informations de connexion à la base dans db.php :

$host = 'localhost';
$dbname = 'edutrack';
$username = 'root';
$password = '';


## Utilisation :

Ouvrir le navigateur et accéder à :

http://localhost/EduTrack/index.php


S’inscrire ou se connecter pour accéder aux fonctionnalités.

Explorer les sections : Cours, Tâches, Flashcards, Outils, Statistiques.

Les fichiers téléchargés sont stockés dans le dossier uploads/.

## Preuves et résultats

Application web fonctionnelle et interactive.

Base MySQL organisée avec toutes les tables nécessaires.

Tableaux de bord avec graphiques en temps réel.

Messages flash et validations des données implémentés.

Interface responsive adaptée aux écrans desktop et mobile.

## Contribution

Le projet est actuellement développé par Yawsf1.
Pour contribuer ou proposer des améliorations, fork le dépôt et soumettre une pull request.
