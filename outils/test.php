<?php
session_start();
include '../db.php';
    if(isset($_COOKIE['remember']) && !isset($_SESSION['id_client'])){
        $id = (int)$_COOKIE['remember'];
        $stmt = $conn -> prepare('SELECT * FROM client where Id_client = ?');
        $stmt -> bind_param('i', $id);
        if(!$stmt -> execute()){
            header('Location: ../index.php?logout');
            exit();
        }
        else{
            $result = $stmt -> get_result();
            $user = $result -> fetch_assoc();
            if($result -> num_rows > 0){
                $_SESSION['id_client'] = $id;
                session_regenerate_id(true);
                header('Location: outils/cartes.php?success');
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
    <link rel="stylesheet" href="flashcards.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body>
    <header id="header1">
        <ul id="ul1">
            <li><a href="../index2.php"><span>Accueil</span><i class="fa-solid fa-house"></i></a></li>
            <li><a href="../cours.php"><span>Cours et Supports</span><i class="fa-solid fa-book-open"></i></a></li>
            <li><a href="../outils.php"><span>Outils d’Étude</span><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
            <li><a href="#"><span>Calendrier et Rappels</span><i class="fa-solid fa-calendar"></i></a></li>
            <li><a href="../question_reponse.php"><span>Questions & Réponses</span><i class="fa-solid fa-comments"></i></a></li>
            <li><a href="#"><span>Suivi et Progression</span><i class="fa-solid fa-chart-simple"></i></i></a></li>
            <li><a href="#"><span> Paramètres </span><i class="fa-solid fa-gear"></i></a></li>
        </ul>
    </header>
    <div id="everything">
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
                    <a href="?logout" id="btninsc">Déconnexion</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            <div id="questionpack2">
                <h1>La Face avant (<span class="titlesss">Une Question</span>):</h1>
                <?php
                    if(isset($_GET['id_carte']) && is_numeric($_GET['id_carte'])){
                        $id_carte = (int)$_GET['id_carte'];
                        $stmt = $conn -> prepare('SELECT * FROM cartes WHERE id_carte = ?');
                        $stmt -> bind_param('i', $id_carte);
                        if($stmt -> execute()){
                            $results = $stmt -> get_result();
                            if($results -> num_rows > 0){
                                $cartes = $results -> fetch_assoc();
                                echo '
                                <div class="questionnnsss">
                                    <h1 id="reponsearea1" class="reponsearea">'.$cartes['question'].'</h1>
                                </div>
                                <h1>La Face arrière (<span class="titlesss">Une Reponse</span>):  </h1>
                                <div id="answerdivv" class="questionnnsss2">
                                    <h1 id="reponsearea2" class="reponsearea">'.$cartes['reponse'].'</h1>
                                </div>
                                ';
                            }
                        }
                    }
                ?>
                <div id="btnssss123" class="btnssss123">
                    <button class="enregistrer-question" id="verifiez">Verifiez</button>
                    <button class="enregistrer-question" id="verifiez2">Aleatoire <i class="fa-solid fa-shuffle"></i></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("verifiez").addEventListener('click', () => {
            let answerarea = document.getElementById('reponsearea2');
                answerarea.style.opacity = '1';
                answerarea.style.transition = 'opacity 0.5s';
        });
        document.getElementById('verifiez2').addEventListener('click', () => {
            fetch(`http://localhost/EduTrack/api.php?action=random`)
            .then(res => res.json())
            .then(res => {
                console.log(res)
                change_data(res.data);
                document.getElementById('reponsearea2').style.transition = 'opacity 0s';
                document.getElementById('reponsearea2').style.opacity = '0';
            })
        });
        function change_data(data){
            document.getElementById('reponsearea1').textContent = data.question;
            document.getElementById('reponsearea2').textContent = data.reponse;
        }
    </script>
</body>
</html>