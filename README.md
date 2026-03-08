# EduTrack

A comprehensive educational management platform built with PHP, MySQL, HTML, CSS, and JavaScript.

## 📋 Table of Contents

- [Description](#description)
- [Features](#features)
- [Project Structure](#project-structure)
- [Technology Stack](#technology-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Usage](#usage)
- [Core Modules](#core-modules)
- [Database](#database)
- [Screenshots & Results](#screenshots--results)
- [Contributing](#contributing)

---

## 🎯 Description

EduTrack est une application web éducative complète qui permet aux utilisateurs de gérer leurs cours, tâches, flashcards, et de suivre leurs statistiques personnelles via un tableau de bord interactif avec graphiques en temps réel.

**En résumé:** EduTrack est votre compagnon d'apprentissage ultime - une plateforme unifiée pour organiser vos études, suivre votre progression et accéder à des outils éducatifs intégrés.

## ✨ Features

### Core Functionality
- **🔐 Authentification sécurisée** : Inscription, connexion et gestion des sessions
- **📚 Gestion des cours** : Création, modification, suppression et suivi des cours
- **✅ Gestionnaire de tâches** : Ajout, modification, suppression avec statuts
- **🎴 Flashcards** : Apprentissage rapide et révision des concepts clés
- **🧮 Calculatrice scientifique** : Outil mathématique intégré pour les calculs
- **📊 Tableaux de bord interactifs** : Statistiques et graphiques en temps réel (Chart.js)
- **🔍 Recherche globale** : Recherche instantanée dans les cours, tâches et flashcards
- **📁 Gestion de fichiers** : Téléchargement et organisation de documents
- **💬 Système Q&A** : Questions et réponses interactif

### User Experience
- **📱 Design responsive** : Parfaitement adapté aux mobiles, tablettes et desktops
- **⚡ Messages flash** : Confirmations et alertes en temps réel
- **🔒 Validation de données** : Sécurisation côté serveur et client
- **🎨 Interface moderne** : Design intuitif et ergonomique

## 📁 Project Structure

```
EduTrack/
│
├── 🔐 Authentication & Registration
│   ├── index.php              # Login page
│   ├── index2.php             # Main dashboard
│   ├── login.php              # Login handler
│   ├── register.php           # Registration page
│   ├── inscription.php        # Registration processing
│   ├── account_delete.php     # Account deletion
│   └── inscconn.css           # Auth styling
│
├── 📚 Courses Management
│   ├── cours.php              # Courses listing & details
│   ├── cours.css              # Courses styling
│   ├── courscree.php          # Course creation/editing
│   ├── courscree.css          # Course creation styling
│   └── [course files here]
│
├── ✅ Tasks Management
│   ├── taches.php             # Task management interface
│   ├── taches.css             # Task styling
│   └── delete.php             # Delete operations handler
│
├── 🧮 Tools & Utilities
│   ├── calculator.php         # Scientific calculator
│   ├── outils.php             # Tools hub page
│   ├── outils.css             # Tools styling
│   ├── outils/                # Tools subdirectory
│   └── question_reponse.css   # Q&A styling
│
├── 📊 Analytics & Visualization
│   ├── graphs.php             # Performance graphs & analytics
│   └── [chart data visualization]
│
├── 🛠️ Core Backend
│   ├── function.php           # Shared utility functions
│   ├── api.php                # API endpoints
│   ├── db.php                 # Database configuration
│   └── [core logic]
│
├── 🎨 Frontend Assets
│   ├── script.js              # Client-side JavaScript
│   ├── style.css              # Global styling
│   └── [additional CSS files]
│
├── 📦 Data Storage
│   ├── media/                 # Media assets directory
│   ├── uploads/               # User uploads directory
│   └── [user generated files]
│
└── README.md                  # This file
```

## 🛠️ Technology Stack

| Category | Technologies |
|----------|---------------|
| **Backend** | PHP 7.4+ |
| **Database** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3, JavaScript (ES6+) |
| **Libraries** | Chart.js (graphiques), AJAX |
| **Server** | Apache/Nginx with mod_rewrite |
| **Communication** | HTTP requests + AJAX for dynamic interactions |

## 💻 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** 7.4 or higher
- **MySQL** 5.7+ or **MariaDB** 10.3+
- **Web Server** (Apache with mod_rewrite, Nginx, or equivalent)
- **Local Development Environment** (XAMPP, WAMP, MAMP, or similar)
- **Modern Web Browser** (Chrome, Firefox, Safari, Edge)

## 📦 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/yawsf1/EduTrack.git
cd EduTrack
```

### Step 2: Set Up Your Local Server

**For XAMPP:**
```bash
# Copy EduTrack folder to:
C:\xampp\htdocs\EduTrack  # Windows
/Applications/XAMPP/htdocs/EduTrack  # macOS
/opt/lampp/htdocs/EduTrack  # Linux
```

**For WAMP:**
```bash
# Copy to: C:\wamp\www\EduTrack
```

**For MAMP:**
```bash
# Copy to: /Applications/MAMP/htdocs/EduTrack
```

### Step 3: Create Database

1. Open **phpMyAdmin** (usually at `http://localhost/phpmyadmin`)
2. Create a new database named `edutrack`
3. Import the SQL schema (if provided):
   - Go to Import tab
   - Select the SQL file
   - Click Import

**Or manually create tables using:**
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

### Step 4: Configure Database Connection

Edit `db.php`:

```php
<?php
$host = 'localhost';
dbname = 'edutrack';
$username = 'root';
$password = '';  // Leave empty for XAMPP/WAMP default

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Error: " . $e->getMessage());
}
?>
```

### Step 5: Set File Permissions

```bash
# Ensure uploads and media directories are writable
chmod 755 uploads/
chmod 755 media/
```

### Step 6: Start Your Server & Access Application

- **Start XAMPP/WAMP/MAMP** control panel and enable Apache & MySQL
- Open your browser and navigate to:
  ```
  http://localhost/EduTrack/index.php
  ```

## 🚀 Usage

### 1. User Registration & Login
```
1. Navigate to http://localhost/EduTrack/index.php
2. Click "S'inscrire" (Register) or use existing credentials
3. Fill in username, email, and password
4. Click "Connexion" (Login) to access your dashboard
```

### 2. Dashboard Overview
After login, you'll see:
- **📊 Statistics Dashboard**: Your learning progress overview
- **📚 Courses Section**: All your enrolled courses
- **✅ Tasks Section**: Your pending and completed tasks
- **🎴 Flashcards Section**: Study materials
- **🧮 Tools Section**: Access to calculator, Q&A, and other utilities

### 3. Managing Courses
```
- Click "Cours" (Courses) in the navigation
- Click "+ Ajouter un cours" to create a new course
- Fill in course details and save
- Edit or delete existing courses as needed
```

### 4. Task Management
```
- Go to "Tâches" (Tasks) section
- Create new tasks with titles, descriptions, and due dates
- Mark tasks as pending, in progress, or completed
- Track your productivity with task statistics
```

### 5. Using the Calculator
```
- Access from "Outils" (Tools) menu
- Perform mathematical calculations
- Supports scientific functions and operations
```

### 6. Viewing Analytics
```
- Go to "Statistiques" (Statistics)
- View real-time charts and graphs
- Track your learning progress over time
```

### 7. File Management
```
- Upload course materials and documents
- Files are stored in the uploads/ directory
- Organize and download files as needed
```

## 🔧 Core Modules

### `db.php` - Database Configuration
Handles all database connections and credentials.

### `function.php` - Utility Functions
Contains reusable functions throughout the application:
- User authentication helpers
- Data validation
- Session management
- Common operations

### `api.php` - API Endpoints
Provides dynamic endpoints for:
- AJAX requests
- Data retrieval
- Real-time updates
- Client-server communication

### `graphs.php` - Analytics Module
Generates and displays:
- Performance charts (Chart.js)
- Learning progress visualization
- Statistical analysis
- Trend tracking

### `calculator.php` - Scientific Calculator
Features:
- Basic arithmetic operations
- Scientific functions (sin, cos, log, etc.)
- Memory functions
- Calculation history

### `delete.php` - Data Deletion Handler
Safely handles deletion of:
- Courses
- Tasks
- Files
- User data

### Authentication Files
- `login.php` - Validates credentials and manages sessions
- `register.php` / `inscription.php` - User registration processing
- `account_delete.php` - Account management and deletion

### Course Management
- `cours.php` - Display and list courses
- `courscree.php` - Create and edit course content

### Task Management
- `taches.php` - Complete task management interface with filtering and sorting

## 🗄️ Database Schema

**Users Table**
```
- id (INT, PRIMARY KEY)
- username (VARCHAR, UNIQUE)
- email (VARCHAR, UNIQUE)
- password (VARCHAR, hashed)
- created_at (TIMESTAMP)
```

**Courses Table**
```
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- title (VARCHAR)
- description (TEXT)
- created_at (TIMESTAMP)
```

**Tasks Table**
```
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- title (VARCHAR)
- description (TEXT)
- status (ENUM: pending, in_progress, completed)
- due_date (DATE)
- created_at (TIMESTAMP)
```

**Flashcards Table**
```
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- question (VARCHAR)
- answer (TEXT)
- created_at (TIMESTAMP)
```

## 📊 Screenshots & Results

### ✅ What's Implemented

- ✨ **Fully Functional Web Application** - Complete and interactive platform
- 🗄️ **MySQL Database** - Organized schema with all necessary tables
- 📊 **Interactive Dashboards** - Real-time charts and statistics with Chart.js
- 💬 **Flash Messages** - User confirmations and alerts
- 📱 **Responsive Design** - Seamless experience on desktop and mobile devices
- 🔒 **Data Validation** - Both server-side and client-side validation
- 🎨 **Modern UI** - Clean, intuitive, and professional interface
- 🚀 **Performance** - Optimized loading and responsive interactions

## 🤝 Contributing

We welcome contributions! To contribute to EduTrack:

1. **Fork** the repository
2. **Create** a feature branch
   ```bash
   git checkout -b feature/YourFeatureName
   ```
3. **Commit** your changes
   ```bash
   git commit -m "Add YourFeatureName"
   ```
4. **Push** to your fork
   ```bash
   git push origin feature/YourFeatureName
   ```
5. **Open** a Pull Request on the main repository

### Contribution Guidelines
- Follow PHP PSR-12 coding standards
- Add comments for complex logic
- Test your changes thoroughly
- Update documentation as needed

## 📝 License

This project is currently unlicensed. Please contact the repository owner for licensing information.

## 📧 Support & Contact

For issues, questions, or suggestions:
- 📌 Open an **Issue** on GitHub
- 💬 Create a **Discussion** for questions
- 🐛 Report **Bugs** with detailed information

---

## 🎓 About This Project

**EduTrack** représente une solution complète de gestion éducative conçue pour les étudiants et les enseignants. Elle combine des fonctionnalités essentielles telles que le suivi des cours, la gestion des tâches et des outils d'apprentissage intégrés en une seule plateforme unifiée.

**Developed by:** [Yawsf1](https://github.com/yawsf1)  
**Repository:** [yawsf1/EduTrack](https://github.com/yawsf1/EduTrack)  
**Last Updated:** 2026-03-08 17:01:00

---

**Happy Learning! 📚✨**