<?php
session_start();
include 'db.php';

if(isset($_COOKIE['remember']) && !isset($_SESSION['id_client'])){
    $id = (int)$_COOKIE['remember'];
    $stmt = $conn -> prepare('SELECT * FROM client WHERE Id_client = ?;');
    $stmt -> bind_param('i', $id);
    if(!$stmt -> execute()){
        header('Location: index.php?select');
        exit();
    }
    else{
        $result = $stmt -> get_result();
        $user = $result -> fetch_assoc();
        if($result -> num_rows > 0){
            $_SESSION['id_client'] = $id;
            session_regenerate_id(true);
            header('Location: cours.php?success');
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
    setcookie('remember', '', time() - 3600, '', '/', false, true);
    session_unset();
    session_destroy();
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
    <link rel="stylesheet" href="cours.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body>
    <header id="header1">
        <ul id="ul1">
            <li><a href="index2.php"><span>Accueil</span><i class="fa-solid fa-house"></i></a></li>
            <li><a href="cours.php"><span>Cours et Supports</span><i class="fa-solid fa-book-open"></i></a></li>
            <li><a href="outils.php"><span>Outils d’Étude</span><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
            <li><a href="#"><span>Calendrier et Rappels</span><i class="fa-solid fa-calendar"></i></a></li>
            <li><a href="question_reponse.php"><span>Questions & Réponses</span><i class="fa-solid fa-comments"></i></a></li>
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
                        <input id="search123" type="search" name="search" placeholder="Recherche ...">
                        <button id="searchbtn123" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </li>
                <li>
                    <a id="btninsc">Déconnexion</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            <input id="idclient" type="hidden" value="<?php echo $_SESSION['id_client'] ?>">
            <div id="search_div"></div>
            <form id="formcours" action="register.php" method="post" enctype="multipart/form-data">
                <div id="formsubmitting">
                    <div class="sections">
                        <div id="card1" class="cards1">
                            <label for="coursnom">Le sujet de cours: </label for="coursnom">
                            <input type="text" id="coursnom" name="coursnom" maxlength="25" minlength="1" required placeholder="Ex:.. System d’exploitation" required>
                        </div>
                        <div id="card2" class="cards1">
                            <textarea type="text" id="courstexte" name="courstexte" maxlength="1000">Collez votre cours ici ...</textarea>
                        </div>
                    </div>
                    <div class="sections">
                        <div id="cardretour"  class="cards1">
                            <a href="courscree.php">Voir les autres cours <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <div id="card3" class="cards1">
                            <label for="liencours">Ajouter un lien d’un video:</label for="">
                            <input type="text" id="liencours" name="liencours" maxlength="300" minlength="1" placeholder="https://..." >
                        </div>
                        <div id="card4" class="cards1">
                            <h4>Importer des images, pdfs ...</h4>
                            <label for="importcours" class="custombtn">Importer des images, pdfs ...<i class="fa-solid fa-upload"></i></label>
                            <input type="file" id="importcours" name="importcours"  placeholder="Importer un fichier" > 
                        </div>
                    </div>
                </div>
                <button name="enregister" id="enregistrer">Enregistrer</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>