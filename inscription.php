<?php
session_start();
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
        elseif($erreur === 'doesntmuch'){
            $message = 'Les mots de passe ne correspondent pas.';
        }
        elseif($erreur === 'csrf'){
            $message = 'Veuillez actualiser la page et réessayer.';
        }
        elseif($erreur === 'select'){
            $message = 'Impossible d’accéder aux informations pour le moment.';
        }
        elseif($erreur === 'emailexist'){
            $message = 'Cette adresse e-mail est déjà utilisée.';
        }
        elseif($erreur === 'emailexist'){
            $message = 'Cette adresse e-mail est déjà utilisée.';
        }
        elseif($erreur === 'insert'){
            $message = 'Une erreur est survenue lors de l’enregistrement.';
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
                    <a id="btnconn" href="login.php">Se connecter</a>
                </li>
            </ul>
        </nav>
        <div id="content">
                <form id="calculs" action="register.php" method="post">
                    <div id="gendercont2" class="gendercont">
                        <div class="firstinput">
                            <label for="nom">Nom: </label>
                            <input type="text" required placeholder="Entrez votre nom ..." id="nom" name="nom" class="small" required maxlength="30" minlength="3">
                        </div>
                        <div class="firstinput">
                            <label for="prenom">Prenom: </label>
                            <input type="text" required placeholder="Entrez votre prenom ..." id="prenom" name="prenom" class="small" maxlength="30" minlength="3" required>
                        </div>
                    </div>
                    <div class="secondinput">
                        <label for="email">Votre Email: </label>
                        <input type="email" required id="email" placeholder="Ex. username@domainnom.com" maxlength="50" minlength="3" name="email" class="long" required>
                    </div>

                    <div class="secondinput">
                        <label for="pass">Créez un nouveau mot de passe: </label>
                        <input type="password" required id="pass" placeholder="********" minlength="8" maxlength="25" name="pass" class="long" required>
                    </div>
                    <div class="secondinput">
                        <label for="cpass">Confirmez votre mot de passe: </label>
                        <input type="password" required id="cpass" placeholder="********" minlength="8" maxlength="25" name="cpass" class="long" required>
                    </div>
                    <div  class="gendercont">
                        <input type="hidden" id="selected" name="selected" required>
                        <h3 id="femme" class="gender" required data-value="femme">Femme</h3>
                        <h3 id='homme' class="gender" required data-value="homme">Homme</h3>
                    </div>
                    <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf'];?>">
                    <button id="enregistrer2" type="submit" name="inscription">S'inscrire <i class="fa-solid fa-arrow-right"></i></button>
                </form>
        </div>
    </div>
    <script>
    let selectedinput = document.getElementById('selected');
    let femme = document.getElementById('femme');
    let homme = document.getElementById('homme');

    selectedinput.value = homme.dataset.value;
    let blue = '#45A29E';
    let darkblue = '#1F2833';
    let white = '#C5C6C7';


    function anything(first, second){
        first.style.backgroundColor = blue;
        first.style.color = darkblue;
        first.style.transition = 'color 0.3s, background-color 0.3s';
        second.style.backgroundColor = white;
        second.style.color = darkblue;
        second.style.transition = 'color 0.3s, background-color 0.3s';
        selectedinput.value = first.dataset.value;
    }

    homme.addEventListener('click',() => { anything(homme ,femme) });
    femme.addEventListener('click',() => { anything(femme, homme) });
    </script>
</body>
</html>
