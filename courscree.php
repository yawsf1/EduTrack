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
                header('Location: courscree.php?success');
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
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Anton&family=Bebas+Neue&family=Boldonse&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Flex:opsz,wght@8..144,100..1000&family=Roboto:ital,wght@0,100..900;1,100..900&family=Rubik+Glitch&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="courscree.css">
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
            $path = "register";
            include "account_delete.php"; 
        ?>        
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
                    <a href="?logout" id="btninsc">Déconnexion</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            <input id="idclient" type="hidden" value="<?php echo $_SESSION['id_client'] ?>">
            <div id="search_div"></div>
            <div class="retourbtn">
                <a href="cours.php"><i class="fa-solid fa-arrow-left"></i>Retour</a>
            </div>
            <?php
                $stmt = $conn -> prepare('  SELECT c.id_client,c.id_cours,c.nom_cours, c.lien_cours, c.cours_texte, f.nom_fichier, f.id_fichier
                                            FROM cours c left join fichier f 
                                            on f.id_cours = c.id_cours
                                            where c.id_client = ?;');
                $stmt -> bind_param('i', $_SESSION['id_client']);
                if($stmt -> execute()){
                    $result = $stmt -> get_result();
                    $numrows = $result -> num_rows;
                    if($numrows > 0){
                        while($cours = $result -> fetch_assoc()){
                            echo '
                            <div class="deuxcours" id="cours_'.$cours['id_cours'].'" data-id="'.$cours['id_cours'].'">
                                <i id="quit" class="fa-solid fa-xmark quitbtn"></i>
                                <h3 id="bigtitlesss"><span class="titles"><i class="fa-solid fa-star-of-life"></i><span class="titres">Nom de cours:</span></span> <span class="title123123">"'.htmlspecialchars($cours['nom_cours']).'"</span></h3>
                            ';
                            if(empty($cours['lien_cours'])){
                                echo '<span class="titles" id="title3"><i class="fa-solid fa-star-of-life"></i><span class="titres">Lien: </span><a id="nomdecours">Aucune lien</a></span>';
                            }
                            else{
                                echo '<span class="titles" id="title3"><i class="fa-solid fa-star-of-life"></i><span class="titres">Lien: </span><a id="nomdecours" href="'.$cours['lien_cours'].'"><span class="url">Url:</span> '.$cours['lien_cours'].'</a></span>';
                            }
                            echo 
                            '   <span class="titles"><i class="fa-solid fa-star-of-life"></i><span class="titres">Cours: </span></span>
                                <div class="paragraph">
                                    <p>'.htmlspecialchars($cours['cours_texte']).'</p>
                                </div>
                                <div class="files">
                                    <img src="uploads/'.htmlspecialchars($cours['nom_fichier']).'"  class="fileee" data-id="'.$cours['id_fichier'].'" >
                                    <div>
                                        <a href="uploads/'.htmlspecialchars($cours['nom_fichier']).'" download>Enregister ce fichier: </a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            ';
                        }
                    }
                }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
    <script>
        let quits = document.querySelectorAll('.quitbtn');
        quits.forEach(quit => {
            quit.addEventListener('click', () => {
                let div = quit.closest('.deuxcours');
                div.style.display = "none";
                let fichier = div.querySelector('.fileee');
                let id_fichier = fichier ? fichier.dataset.id : null;
                let id_cours = div.dataset.id;
                fetch('http://localhost/EduTrack/api.php', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        action: 'delete_cours',
                        id_c: id_cours,
                        id_f: id_fichier,
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                })
            });
        });

    </script>
</body>
</html>

