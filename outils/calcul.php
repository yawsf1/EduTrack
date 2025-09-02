<?php
session_start();
include '../db.php';
    if(isset($_COOKIE['remember']) && !isset($_SESSION['id_client'])){
        $cookie_token = $_COOKIE['remember'];
        $token = hash('sha256',$cookie_token);
        $stmt = $conn -> prepare('SELECT * FROM tokens where token = ? AND expire_date >= NOW();');
        $stmt -> bind_param('s', $token);
        if(!$stmt -> execute()){
            header('Location: ../index.php?logout');
            exit();
        }
        else{
            $result = $stmt -> get_result();
            $user_row = $result -> fetch_assoc();
            if($result -> num_rows > 0){
                $id = $user_row['id_client'];
                $_SESSION['id_client'] = $id;
                session_regenerate_id(true);
                header('Location: calcul.php?success');
                exit();
            }
            else{
                setcookie('remember', '', time() - 3600,  '/', '', false, true);
                header('Location: ../index.php?logout');
                exit();
            }
        }
    }
    if(!isset($_SESSION['id_client'])){
        header('Location: ../index.php?sessionend');
        exit();
    }
    if(isset($_GET['logout'])){
        session_unset();
        session_destroy();
        setcookie('remember', '', time() - 3600,  '/', '', false, true);
        header('Location: ../index.php?ends');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../media/EduTrack.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../calcul.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body>
    <header id="header1">
        <ul id="ul1">
            <li><a href="../index2.php"><span>Accueil</span><i class="fa-solid fa-house"></i></a></li>
            <li><a href="../cours.php"><span>Cours et Supports</span><i class="fa-solid fa-book-open"></i></a></li>
            <li><a href="../outils.php"><span>Outils d’Étude</span><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
            <li><a href="../taches.php"><span>À faire</span><i class="fa fa-tasks" aria-hidden="true"></i></a></li>
            <li><a href="../graphs.php"><span>Suivi et Progression</span><i class="fa-solid fa-chart-simple"></i></i></a></li>
            <?php include "../delete.php"; ?>
        </ul>
    </header>
    <div id="everything">
        <?php 
            $path = "../register.php";
            include "../account_delete.php"; 
        ?>
        <nav id="navigation">
            <ul id="ul2">
                <li><h1>EduTrack</h1></li>
                <li>
                    <div id="divsearch">
                        <input type="search" name="search" placeholder="Recherche ...">
                        <button name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </li>
                <li>
                    <a id="btninsc" href="?logout">Déconnexion</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            <input id="idclient" type="hidden" value="<?php echo $_SESSION['id_client'] ?>">
            <div id="search_div"></div>
            <h1 id="bigtitle">Ajouter une matiere: <i class="fa-solid fa-plus"></i></h1>
                <form id="calculs" action="#" method="post">
                    <div class="allform">
                        <div id="matiere1" class="matieres">
                            <i id="ix" class="fa-solid fa-xmark"></i>
                            <div class="containerinputs">
                                <label for="matierenom">Nom de la matiere:</label>
                                <input type="text" id="matierenom" class="queswers" name="question" maxlength="40" required>
                            </div>
                            <div class="containerinputs">
                                <label for="matierenom">Nombre des devoirs:</label>
                                <input type="text" id="matierenom" class="queswers" name="question" maxlength="40" required>
                            </div>
                            <div class="containerinputs">
                                <label for="matierenom">Entrer la coefficient:</label>
                                <input type="text" id="matierenom" class="queswers" name="question" maxlength="40" required>
                            </div>
                            <div class="containerinputs">
                                <label for="note1">Entrer les notes:</label>
                                <input type="text" id="note1" class="queswers" name="name" maxlength="40" required>
                            </div>
                        </div>
                    </div>
                    <button id="enregistrer2" type="submit">Calculer</button>
                </form>
        </div>
    </div>
    <script src="../script.js"></script>
    
</body>
</html>