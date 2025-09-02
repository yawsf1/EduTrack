<?php
session_start();
include 'db.php';
    if(isset($_COOKIE['remember']) && !isset($_SESSION['id_client'])){
        $id = (int)$_COOKIE['remember'];
        $stmt = $conn -> prepare('SELECT * FROM client where Id_client = ?');
        $stmt -> bind_param('i', $id);
        if(!$stmt -> execute()){
            header('Location: index.php?logout');
            exit();
        }
        else{
            $result = $stmt -> get_result();
            $user = $result -> fetch_assoc();
            if($result -> num_rows > 0){
                $_SESSION['id_client'] = $id;
                session_regenerate_id(true);
                header('Location: index2.php?succes');
                exit();
            }
            else{
                setcookie('remember', '', time() - 3600,  '/', '', false, true);
                header('Location: index.php?hello');
                exit();
            }
        }
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
    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.6.2/dist/dotlottie-wc.js" type="module"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body id="body111">
    <div id="everything">
        <nav id="navigation">
            <ul id="ul2">
                <li><h1>EduTrack</h1></li>
                <li>
                    <a id="btninsc" href="inscription.php">Insciption</a>
                    <a id="btnconn" href="login.php">Se connecter</a>
                </li>
            </ul>
        </nav>
        <div class="contenttt" id="content">
            <div class="importhalf">
                <h1>Bienvenue sur <br><span>EduTrack</span></h1>
                <h2>Cours, outils intelligents, calendrier et communauté. <br>Tout ce qu’il te faut pour réussir tes études.</h2>
                <div class="btncontainer"><a href="inscription.php">Commencer</a></div>
            </div>
            <div class="slidess">
                <div id="slide11" class="slide1">
                    <dotlottie-wc src="https://lottie.host/5eee3d9e-b849-4003-aece-2be87f34a3d7/nYhdUeI9sK.lottie" style="width: 750px;height: 500px" speed="1" autoplay loop></dotlottie-wc>
                </div>
            </div>
        </div>
    </div>
    <script>

        let quit = document.getElementById('quit');
        let messagecard = document.getElementById('message1');

        stop = () => {
            if(messagecard.style.display === 'none'){
                messagecard.style.display = 'flex';
                messagecard.style.opacity = '1';
            }
            else{
                setTimeout(()=>{
                    messagecard.style.opacity = '0';
                    messagecard.style.transition = 'opacity 1s';
                }, 4500);
                messagecard.style.display = 'none';

            }
        }
        stop2 = () =>{
            if(messagecard.style.display === 'none'){
                messagecard.style.display = 'flex';
                messagecard.style.opacity = '1';
                messagecard.style.top = '30px';
                messagecard.style.left = '10px';
                messagecard.style.bottom = 'auto';

            }
            else{
                messagecard.style.display = 'none';
                setTimeout(()=>{
                    messagecard.style.opacity = '0';
                    messagecard.style.transition = 'opacity 1s';
                }, 4500);
            }
        }
        del = () =>{
            if(messagecard.style.display === 'none'){
                messagecard.style.display = 'flex';
            }
            else{
                messagecard.style.display = 'none';
            }
        }

    </script>
</body>
</html>