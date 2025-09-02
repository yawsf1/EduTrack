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
                header('Location: graphs.php?success');
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

    $stmt = $conn -> prepare('SELECT COUNT(id_cours) as nombre_cours, date_post FROM cours WHERE id_client = ? GROUP BY date_post ORDER BY date_post;');
    $stmt -> bind_param('i', $_SESSION['id_client']);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        $courses = $result -> fetch_all(MYSQLI_ASSOC);
    }
    $stmt -> close();

    $stmt = $conn -> prepare('SELECT COUNT(id_carte) as nombre_cartes, date FROM cartes WHERE id_client = ? GROUP BY date ORDER BY date;');
    $stmt -> bind_param('i', $_SESSION['id_client']);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        $cartes = $result -> fetch_all(MYSQLI_ASSOC);
    }
    $stmt -> close();

    $stmt = $conn -> prepare('SELECT COUNT(id_tache) as nombre_taches, date FROM tache WHERE id_client = ? GROUP BY date ORDER BY date;');
    $stmt -> bind_param('i', $_SESSION['id_client']);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        $taches = $result -> fetch_all(MYSQLI_ASSOC);
    }
    $stmt -> close();

    $stmt = $conn -> prepare('SELECT COUNT(DISTINCT t.id_tache) as total_tache, COUNT(DISTINCT c.id_cours) as total_cours, COUNT(DISTINCT ca.id_carte) as total_cartes
                            FROM client cl
                            left join tache t on t.id_client = cl.Id_client
                            left join cours c on c.id_client = cl.Id_client
                            left join cartes ca on ca.id_client = cl.Id_client
                            where cl.Id_client = ?;
                             ');
    $stmt -> bind_param('i', $_SESSION['id_client']);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        $totals = $result -> fetch_assoc();
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
    <link rel="stylesheet" href="outils.css">
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
        <div id="content11">
            <div class="content11_container">
                <div class="container1111">
                    <h2 class="titlesss" id="titleofcours">Graphique des Cours et des Cartes: </h2>
                    <div id="chartcourscont">
                        <canvas id="chartcours"></canvas>
                    </div>
                </div>
                <div class="container2222">
                    <h3 class="titlesss2" >Cours que vous avez ajoutés:</h3>
                        <h2><?php echo $totals['total_cours'];?></h2>
                    <h3 class="titlesss2" >Cartes que vous avez ajoutées:</h3>
                        <h2><?php echo $totals['total_cartes'];?></h2>
                    <h3 class="titlesss2" >Tâches que vous avez ajoutées:</h3>
                        <h2><?php echo $totals['total_tache'];?></h2>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
    <script>

        let courses = <?php echo json_encode($courses) ;?>;
        let datess = courses.map(date => date.date_post);


        let numbers = courses.map(num => num.nombre_cours);
                    
        let cartess = <?php echo json_encode($cartes) ;?>;
        let numbers2 = cartess.map(item => item.nombre_cartes);
        
        let taches = <?php echo json_encode($taches); ?>;
        let numbers3 = taches.map(thing => thing.nombre_taches);

        console.log(document.getElementById('titleofcours').style.height);
        let carte = document.getElementById('chartcours');

        let chart = new Chart(carte, {
            type: 'line',
            data: {
                labels: datess,
                datasets: [
                    {
                        label: '# des Cours par Jours',
                        data: numbers,
                        tension: 0.5,
                    }
                    ,                     
                    {
                        label: '# des Cartes par Jours',
                        data: numbers2,
                        tension: 0.5,
                    }
                    ,
                    {
                        label: '# des Taches par Jours',
                        data: numbers3,
                        tension: 0.5,
                    }
                ],
            },
        });
    </script>

</body>
</html>

