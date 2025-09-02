<?php
session_start();
include 'db.php';
    if(isset($_COOKIE['remember']) && !isset($_SESSION['id_client'])){
        $cookie_token = $_COOKIE['remember'];
        $token = hash('sha256',$cookie_token);
        $stmt = $conn -> prepare('SELECT * FROM tokens where token = ? AND expire_date >= NOW();');
        $stmt -> bind_param('s', $token);
        if(!$stmt -> execute()){
            header('Location: index.php?logout');
            exit();
        }
        else{
            $result = $stmt -> get_result();
            $user_row = $result -> fetch_assoc();
            if($result -> num_rows > 0){
                $id = $user_row['id_client'];
                $_SESSION['id_client'] = $id;
                session_regenerate_id(true);
                header('Location: index2.php?success');
                exit();
            }
            else{
                setcookie('remember', '', time() - 3600,  '/', '', false, true);
                header('Location: index.php?logout');
                exit();
            }
        }
    }
    if(!isset($_SESSION['id_client'])){
        header('Location: index.php?sessionend');
        exit();
    }
    if(isset($_GET['logout'])){
        session_unset();
        session_destroy();
        setcookie('remember', '', time() - 3600,  '/', '', false, true);
        header('Location: index.php?ends');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="media/EduTrack.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body>
    <header id="header1">
        <ul id="ul1">
            <li><a href="index2.php"><span>Accueil</span><i class="fa-solid fa-house"></i></a></li>
            <li><a href="cours.php"><span>Cours et Supports</span><i class="fa-solid fa-book-open"></i></a></li>
            <li><a href="outils.php"><span>Outils d’Étude</span><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
            <li><a href="taches.php"><span>À faire</span><i class="fa fa-tasks" aria-hidden="true"></i></a></li>
            <li><a href="graphs.php"><span>Suivi et Progression</span><i class="fa-solid fa-chart-simple"></i></i></a></li>
            <?php include "delete.php"; ?>
        </ul>
    </header>
    <div id="everything">
        <?php 
            $path="register";
            include "account_delete.php"; 
        ?>
        <?php
                if(isset($_SESSION['message'])){
                    echo '
                        <div id="message1" class="message">
                            <i onclick="del()" id="quit" class="fa-solid fa-xmark"></i>
                            <h1 id="messagesignup">'.$_SESSION['message'].' </h1>
                        </div> 
                        <style>
                        #message1{
                            width: 30%;
                            position: absolute;
                            min-width: 250px;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            bottom: 15px;
                            right: 70px;
                            background-color: #1F2833;
                            color: #C5C6C7;
                            z-index: 20000;
                            padding: 30px  20px;
                            border-radius: 12px;
                            min-height: 200px;
                            justify-content: center;
                        }
                        #message1 #messagesignup{
                            font-size: 1.8rem;
                            text-align: center;
                        }
                        #quit{
                            position: absolute;
                            top: 0;
                            right: 0;
                            height: 30px;
                            width: 30px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            background-color: #45A29E;
                            color: #1F2833;
                            border-radius: 50%;
                            margin: 10px;
                            cursor: pointer;
                        }
                        </style>
                        <script>
                            let quit = document.getElementById("quit");
                            let h1111 = document.getElementById("messagesignup");
                            let div111 = document.getElementById("message1");
                            div111.style.opacity = "1";
                            setTimeout(() => {
                                div111.style.transition = "opacity 0.3s";
                                div111.style.opacity = "0";
                            }, 5000);
                            quit.addEventListener("click", ()=>{
                                div111.style.display = "none";
                            });
                            document.addEventListener("click", (event)=>{
                                if(div111.style.display !== "none" && !div111.contains(event.target)){
                                    div111.style.display = "none";
                                }
                            });
                        </script>
                        ';
                    unset($_SESSION['message']);
                }
            ?>
        <div id="navigation">
            <ul id="ul2" >
                <li><h1>EduTrack</h1></li>
                <li>
                    <div id="divsearch">
                        <input type="search" id="search123" name="search" placeholder="Recherche ...">
                        <button id="searchbtn123" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </li>
                <li>
                    <a href="?logout" id="btninsc">Déconnexion</a>
                </li>
            </ul>
        </div>
        <div id="content">

            <input id="idclient" type="hidden" name="id_client" value="<?php echo $_SESSION['id_client'] ?>">
            <div id="search_div"></div>
            
            <?php
            $stmt = $conn -> prepare("SELECT * FROM client WHERE Id_client = ?;");
            $stmt -> bind_param('i', $_SESSION['id_client']);
            if($stmt -> execute()){
                $resultss = $stmt -> get_result();
                $client = $resultss -> fetch_assoc();
            }
            ?>
            <h1 id="bigtitle">Bienvenue sur EduTrack, <span><?= strtoupper($client['prenom_client'] ?? "") ?></span></h1>
            <h3 id="smalltitle">Votre plateforme complète pour suivre les progrès, la présence et la performance des étudiants.</h3>
            <div class="section_container">
                <div class="graphiques">
                    <div class="undergraphiques"></div>
                </div>
                <div class="sections">
                    <div class="section">
                        <div class="cards1">
                            <i class="fa-solid fa-book-open"></i>
                            <p>Cours et Supports</p>
                            <a href="cours.php"><i class="fa-solid fa-arrow-right"></i>Cours</a>
                        </div>
                        <div class="cards1">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            <p>Outils d’Étude</p>
                            <a href="outils.php"><i class="fa-solid fa-arrow-right"></i>Outils</a>
                        </div>
                        <div class="cards1">
                            <i class="fa-solid fa-chart-simple"></i></i>
                            <p>Suivi et Progression</p>
                            <a href="graphs.php"><i class="fa-solid fa-arrow-right"></i>Progression</a>       
                        </div>
                    </div>
                    <div id="section2" class="section">
                        <div class="cards1">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <p>À faire</p>
                            <a href="taches.php"><i class="fa-solid fa-arrow-right"></i>Tâches</a>
                        </div>
                        <div class="cards1">
                            <i class="fa-solid fa-comments"></i>
                            <p>Questions & Réponses</p>
                            <a href="question_reponse.php"><i class="fa-solid fa-arrow-right"></i>Questions</a>
                        </div>
                    </div>
                </div>
                <div id="sections2" class="sections">
                    <div class="section">
                        <div class="cards1">
                            <i class="fa-solid fa-book-open"></i>
                            <p>Cours et Supports</p>
                            <a href="cours.php"><i class="fa-solid fa-arrow-right"></i>Cours</a>
                        </div>
                        <div class="cards1">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            <p>Outils d’Étude</p>
                            <a href="outils.php"><i class="fa-solid fa-arrow-right"></i>Outils</a>
                        </div>
                    </div>
                    <div id="section2" class="section">
                        <div class="cards1">
                            <i class="fa-solid fa-calendar"></i>
                            <p>Calendrier et Rappels</p>
                            <a href="#"><i class="fa-solid fa-arrow-right"></i>Calendrier</a>
                        </div>
                        <div class="cards1">
                            <i class="fa-solid fa-comments"></i>
                            <p>Questions & Réponses</p>
                            <a href="question_reponse.php"><i class="fa-solid fa-arrow-right"></i>Questions</a>
                        </div>
                    </div>
                    <div id="section3" class="section">
                        <div class="cards1">
                            <i class="fa-solid fa-chart-simple"></i></i>
                            <p>Suivi et Progression</p>
                            <a href="#"><i class="fa-solid fa-arrow-right"></i>Progression</a>       
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>