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

    if(isset($_SESSION['id_client'])){
        header('Location: index2.php?succefull');
        exit();
    }


    if(empty($_SESSION['csrf'])){
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    $message = '';
    if(isset($_GET['erreur'])){
        $erreur = $_GET['erreur'];
        if($erreur === 'emailincorrecte'){
            $message = 'Il semble qu’il y ait une erreur dans l’e-mail.';
        }
        elseif($erreur === 'empty'){
            $message = 'Vous devez remplir tous les champs.';
        }
        elseif($erreur === 'toolong'){
            $message = 'La saisie est trop longue.';
        }
        elseif($erreur === 'csrf'){
            $message = 'Veuillez actualiser la page et réessayer.';
        }
        elseif($erreur === 'select'){
            $message = 'Impossible d’accéder aux informations pour le moment.';
        }
        elseif($erreur === 'unexist_acc'){
            $message = 'Ce compte n’existe pas.';
        }
        elseif($erreur === 'passwordincorrect'){
            $message = 'Le mot de passe que vous avez saisi est incorrect.';
        }
    }
    function messages($message){
        if($message != ''){
            echo '
                <div id="message1" class="message">
                    <i id="quit" class="fa-solid fa-xmark"></i>
                    <h1 id="messagesignup">'.$message.' </h1>
                </div> 
                <style>
                #message1{
                    width: 30%;
                    position: absolute;
                    min-width: 250px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    top: 80px;
                    right: 10px;
                    background-color: #1F2833;
                    color: #C5C6C7;
                    z-index: 30000;
                    padding:30px  20px;
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
        }
    }
    messages($message);
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
    <link rel="stylesheet" href="inscconn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body>
    <div id="everything">
            <video id="bgvideo" loop autoplay muted playsinline>
                <source src="media/4K 2160p Blue Ambient Waving Lines Motion Background - AA-VFX (1080p, h264).mp4" type="video/mp4">
            </video>
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
                    <a id="btnhome" href="index.php">Accueil</a>
                    <a id="btninsc" href="inscription.php">Insciption</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            <h1 id="bigtitle">Connexion à votre compte</h1>
                <form id="calculs" action="register.php" method="post">
                    <div class="secondinput">
                        <label for="email">Votre Email: </label>
                        <input type="email" required id="email" placeholder="Ex. username@domainnom.com" name="email" class="long">
                    </div>
                    <div class="secondinput">
                        <label for="pass">Entrez votre mot de passe </label>
                        <input type="password" required id="pass" placeholder="********" minlength="8" maxlength="25" name="pass" class="long">
                    </div>
                    <div id="rememberme">

                        <i id="remember" class="fa-solid fa-check"></i>
                        <input type="hidden" name="remember2" id="remember2">

                        <label id="labelremember" for="remember2">Se souvenir de moi</label>
                    </div>
                    <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
                    <button id="enregistrer2" name="connecter" type="submit">Se connecter<i class="fa-solid fa-arrow-right"></i></button>
                </form>
        </div>
    </div>
    <script>
        let x = document.getElementById('remember');
        let y = document.getElementById('remember2');
        y.value = 0
        x.addEventListener('click',() => {
            if(y.value == 0){
                y.value = 1;
                x.style.backgroundColor = "#45A29E";
                x.style.color = "#1F2833";
            }
            else{
                y.value = 0;
                x.style.backgroundColor = "#C5C6C7";
                x.style.color = "#1F2833";
            }
        });
        
        </script>
            <script src="script.js"></script>
</body>
</html>