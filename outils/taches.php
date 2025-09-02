<?php
session_start();
include '../db.php';
if(isset($_COOKIE['remember']) && !isset($_SESSION['id_client'])){
    $id = (int)$_COOKIE['remember'];
    $stmt = $conn -> prepare("SELECT * FROM client WHERE Id_client = ?");
    $stmt -> bind_param('i', $id);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        if($result -> num_rows > 0){
            $_SESSION['id_client'] = $id;
            session_regenerate_id(true);
            header('Location: taches.php?succes');
            exit();        }
        else{
            header('Location: ../index.php?ends');
            exit();
        }
    }
    else{
        header('Location: ../index.php?ends');
        exit();
    }
}
if(!isset($_SESSION['id_client'])){
    header('Location: ../index.php?ends');
    exit();
}
if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    setcookie('remember', '', time() - 3600 , '/', '', false, true);
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
    <link rel="stylesheet" href="taches.css">
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
            <li><a href="../graphs.php"><span>Suivi et Progression</span><i class="fa-solid fa-chart-simple"></i></i></a></li>
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
                    <a id="btninsc" href="?logout">Déconnexion</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            
            <div class="container">
                <div id="lines4">
                    <h2>Tâches</h2>
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
                
                <div id="lines5">
                    <div id="container_of_tasks_all" class="tasklistss">
                        <?php
                            $stmt = $conn -> prepare('SELECT * FROM tache WHERE id_client = ?;');
                            $stmt -> bind_param("i", $_SESSION['id_client']);
                            if($stmt->execute()){
                                $result = $stmt -> get_result();
                                if($result -> num_rows > 0){
                                    while($task = $result -> fetch_assoc()){
                                        echo 
                                        '
                                        <div data-id="'.$task['id_tache'].'" class="tasks2" id="task1111">

                                            <h3  id="adddd" class="add"><span><i class="fa-solid fa-check"></i>'.$task['tache'].'</span><span class="btn_task_fini"><button class="add_task_done">une tache fini</button><span class="tachessss">'.$task['n_tache'].'<i class="fa-solid fa-xmark"></i><i id="ellipsis" data-class="dots" class="fa-solid fa-ellipsis-vertical"></i></span></span></h3>
                                            <div class="modifications">
                                                <div id="inputs_div">
                                                    <input type="text" name="taskname" value="'.$task['tache'].'" id="taskname" class="taskname" placeholder="Nom de la tache ..." required>
                                                </div>
                                                <div id="buttons_container" class="buttons_container2">
                                                    <input type="text" value="'.$task['n_tache'].'" id="nombre_cycle" class="nombre_cycle10">
                                                    <button id="up" class="upbtn22"><i class="fa-solid fa-caret-up"></i></button>
                                                    <button id="down" class="downbtn22"><i class="fa-solid fa-caret-down"></i></button>
                                                </div>
                                                <div id="add_or_no">
                                                    <button type="submit" id="enreg" class="enreg">Enregister</button>
                                                    <button type="reset" class="cancel" id="cancel">Annuler</button>
                                                </div>                                            
                                            </div>
                                        </div>
                                        ';
                                    }
                                }
                            }
                        ?>
                    </div>
                    <div class="tasks" id="task2">
                        <h3 id="addddd" class="add"><i id="add-i" class="fa-solid fa-add"></i><span id="ajoute_tache">ajouter une tâche</span></h3>
                        <div id="div_adding_task">
                            <div id="inputs_div">
                                <input type="text" name="taskname" id="taskname2" placeholder="Nom de la tache ..." required>
                            </div>
                            <div id="buttons_container" class="buttons_container">
                                <input type="text" value="1" id="nombre_cycle3" class="nombre_cycle3" >
                                <button id="up" class="btnup"><i class="fa-solid fa-caret-up"></i></button>
                                <button id="down" class="btndown"><i class="fa-solid fa-caret-down"></i></button>
                            </div>
                            <div id="add_or_no">
                                <button type="submit" id="enreg2" class="enreg2">Enregister</button>
                                <button type="reset" id="cancel2" class="cancel2">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="lines6">
                </div>
                <div id="lines7">
                    <?php
                        $stmt = $conn -> prepare('SELECT SUM(n_tache) as total FROM tache WHERE id_client = ?;');
                        $stmt -> bind_param('i', $_SESSION['id_client']);
                        if($stmt -> execute()){
                            $result = $stmt -> get_result();
                            $tacheeee = $result -> fetch_assoc();
                            echo '<h3 id="total_tasks"><span>'.$tacheeee['total'].'</span> pomos</h3>';
                        }
                    ?>
                </div>
            </div>        
        </div>
        
    </div>
    <script>
        let container_task = document.getElementById('task2');
        let add_button = document.getElementById('addddd');
        let container_contenu = document.getElementById('div_adding_task');
        
        add_button.addEventListener('click', () => {
            container_task.style.minHeight = '170px';
            container_task.style.backgroundColor = '#1F2833';
            container_contenu.style.display = 'flex';
            console.log(container_task.style.minHeight);

            document.querySelectorAll('.modifications').forEach(modss =>{
                modss.style.display = 'none';
            });
            document.querySelectorAll('.add').forEach(add_btn =>{
                add_btn.style.display = 'flex';
            });
            document.querySelectorAll('.tasks2').forEach(tsk => {
                tsk.style.minHeight = 'auto';
            });
            add_button.style.display = 'none';

        });
        document.addEventListener('click', (e) => {
            if(!container_task.contains(e.target)){
                add_button.style.display = 'flex';
                container_task.style.minHeight = 'auto';
                container_task.style.backgroundColor = '#C5C6C7';
                container_contenu.style.display = 'none'; 
                console.log(container_task.style.minHeight)
            }
        })

        document.getElementById('cancel2').addEventListener('click', () => {
            add_button.style.display = 'flex';
            container_task.style.minHeight = 'auto';
            container_task.style.backgroundColor = '#C5C6C7';
            container_contenu.style.display = 'none';  
            console.log('hello');
        });


        document.querySelectorAll('.enreg2').forEach(engst => {
            engst.addEventListener('click', () => {
                function add_task(data){
                    let all_tasks_exist = document.createElement('div');
                    all_tasks_exist.classList.add('tasks2');
                    document.getElementById('container_of_tasks_all').appendChild(all_tasks_exist);
                    all_tasks_exist.innerHTML = 
                    `
                        <h3  id="adddd" class="add"><span><i class="fa-solid fa-check"></i>${data.task_name}</span><span class="btn_task_fini"><button class="add_task_done">une tache fini</button><span class="tachessss">${data.nombre_tasks}<i class="fa-solid fa-xmark"></i><i id="ellipsis" data-class="dots" class="fa-solid fa-ellipsis-vertical"></i></span></span></h3>
                        <div class="div_adding_task2">
                            <div id="inputs_div">
                                <input type="text" name="taskname" id="taskname" placeholder="Nom de la tache ..." required>
                            </div>
                            <div id="buttons_container" class="buttons_container">
                                <input type="text" value="1" id="nombre_cycle" class="nombre_cycle3" >
                                <button id="up" class="btnup"><i class="fa-solid fa-caret-up"></i></button>
                                <button id="down" class="btnsown"><i class="fa-solid fa-caret-down"></i></button>
                            </div>
                            <div id="add_or_no">
                                <button type="submit" class="enreg" id="enreg">Enregister</button>
                                <button type="reset" class="cancel" id="cancel">Annuler</button>
                            </div>
                        </div>`;
                }
                fetch('http://localhost/edutrack/api.php', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'tache',
                        task_name: document.getElementById('taskname2').value,
                        nombre_tasks: document.getElementById('nombre_cycle3').value,
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res.data);
                    add_task(res.data);
                })
            });
        });



        document.querySelectorAll('.fa-xmark').forEach(xmark => {
            xmark.addEventListener('click', () => {
                let h3_container = xmark.closest('.tasks2');
                console.log(h3_container.dataset.id);
                function delete_tache(){
                    h3_container.style.display = 'none';
                }
                fetch('http://localhost/EduTrack/api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action : 'delete_task',
                        id_task : h3_container.dataset.id,
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    if(res.status === 'success'){
                        delete_tache();
                        console.log(h3_container.style.display);
                    }
                })
            });
        })


        document.querySelectorAll('.tasks2 .fa-ellipsis-vertical').forEach( modify => {
            modify.addEventListener('click', () => {
                let container_modify = modify.closest('.tasks2');
                let adding = container_modify.querySelector('.add');
                let modifs = container_modify.querySelector('.modifications');
                document.querySelectorAll('.modifications').forEach(mods => {
                    let container_modify = mods.closest('.tasks2');
                    let adding = container_modify.querySelector('.add');
                    let modifs = container_modify.querySelector('.modifications');
                    mods.style.display = 'none';
                    container_modify.style.minHeight = 'auto';
                    modify.style.display = 'flex';
                    modifs.style.display = 'none';
                    adding.style.display = 'flex';
                    
                });
                modifs.style.display = 'flex';
                modify.style.display = 'flex';
                adding.style.display = 'none';
                container_modify.style.minHeight = '170px';
            });
        });
        let cnsl_btn = document.querySelectorAll('.cancel');
        cnsl_btn.forEach(bnt_c => {
            bnt_c.addEventListener('click', () => {
                let modifications =  bnt_c.closest('.modifications');
                let container_taskkk = bnt_c.closest('.tasks2');
                modifications.style.display = 'none';
                container_taskkk.style.minHeight = 'auto'
                container_taskkk.querySelector('.add').style.display = 'flex';
            });
        });


        let count = 1;
        document.querySelectorAll('.btnup').forEach(btnup => {
            btnup.addEventListener('click', () => {
                count = count + 1;
                let inputs_n = btnup.closest('.buttons_container');
                let input_value= inputs_n.querySelector('.nombre_cycle3');
                input_value.value = count;
                console.log(input_value.value);
            });
        });

        document.querySelectorAll('.upbtn22').forEach(btnup2 => {
            btnup2.addEventListener('click', () => {

                let inputs_n = btnup2.closest('.buttons_container2');
                let input_value = inputs_n.querySelector('.nombre_cycle10');
                let count2 = Number(input_value.value);
                count2 = Number(count2 + 1);
                console.log(count2);
                input_value.value = count2;
            });
        });
        document.querySelectorAll('.downbtn22').forEach(dwnbtn2 => {
            dwnbtn2.addEventListener('click', () => {
                let inputs_n = dwnbtn2.closest('.buttons_container2');
                let input_value = inputs_n.querySelector('.nombre_cycle10');
                if(Number(input_value.value) > 1){
                    let count2 = Number(input_value.value);
                    count2 = Number(count2 - 1);
                    console.log(count2);
                    input_value.value = count2;
                }
            });
        });


        document.querySelectorAll('.btndown').forEach(btndown => {
            btndown.addEventListener('click', () => {
                if(count > 1){
                    count = count - 1;
                    let inputs_n = btndown.closest('.buttons_container');
                    let input_value= inputs_n.querySelector('.nombre_cycle3');
                    input_value.value = count;
                    console.log(input_value.value);
                }
            });
        });




        document.querySelectorAll('.enreg').forEach(engs_modif => {
            engs_modif.addEventListener('click', () => {

                let div_container_task = engs_modif.closest('.tasks2');
                let tache_id = div_container_task.dataset.id;
                let new_n_tache = div_container_task.querySelector('.nombre_cycle10').value;
                let new_tache = div_container_task.querySelector('.taskname').value; 
                
                console.log(new_tache);
                console.log(new_n_tache);
                console.log(tache_id);
                fetch('http://localhost/edutrack/api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify({
                        action : 'update_task',
                        task_n : new_n_tache,
                        task_id : tache_id,
                        new_task : new_tache
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res)
                    div_container_task.querySelector('.add').innerHTML = `<span><i class="fa-solid fa-check"></i>${new_tache}</span><span class="btn_task_fini"><button class="add_task_done">une tache fini</button><span class="tachessss">${new_n_tache}<i class="fa-solid fa-xmark"></i><i id="ellipsis" data-class="dots" class="fa-solid fa-ellipsis-vertical"></i></span></span>`;
                })
            })
        });

        
        document.querySelectorAll('.add_task_done').forEach(btn_task_done => {
            let all_container = btn_task_done.closest('.tasks2');
            let btn_container = all_container.querySelector('.buttons_container2');
            let input_field = all_container.querySelector('.nombre_cycle10');
            btn_task_done.addEventListener('click', () =>{
                if(Number(input_field.value) > 1){
                    input_field.value = Number(input_field.value) - 1;
                    console.log(input_field.value);
                    let container_id = all_container.dataset.id;
                    fetch('http://localhost/edutrack/api.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type':'application/json'
                        },
                        body: JSON.stringify({
                            action: 'update_n_task',
                            nouveau_n_tache : Number(input_field.value),
                            id_tache : container_id
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        all_container.querySelector('.tachessss').innerHTML = `${Number(input_field.value)}<i class="fa-solid fa-xmark"></i><i id="ellipsis" data-class="dots" class="fa-solid fa-ellipsis-vertical"></i>`;
                    })
                }
                else{
                    let container_id = all_container.dataset.id;
                    fetch('http://localhost/edutrack/api.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type':'application/json'
                        },
                        body: JSON.stringify({
                            action: 'delete_task',
                            id_task : container_id
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        let icon_style = all_container.querySelector('.fa-check');
                        console.log(icon_style.style.color );
                        all_container.style.display = 'none';
                    })
                }
            })
        })
    </script>
</body>
</html>