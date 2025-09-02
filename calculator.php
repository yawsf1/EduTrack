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
            <li><a href="#"><span>Calendrier et Rappels</span><i class="fa-solid fa-calendar"></i></a></li>
            <li><a href="question_reponse.php"><span>Questions & Réponses</span><i class="fa-solid fa-comments"></i></a></li>
            <li><a href="#"><span> Paramètres </span><i class="fa-solid fa-gear"></i></a></li>
        </ul>
    </header>
    <div id="everything">
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
        <div id="content222">
            <div class="whole_calculator">
                <div class="calculator">
                    <div class="results">
                        <h2 id="calculations"></h2>
                        <h3 id="result">0</h3>
                    </div>

                    <button id="pi" class="btnss">π</button>    <!-- pi -->
                    <button id="per" class="btnss">%</button>
                    <button id="ce" >CE</button>
                    <button id="c">C</button>
                    <button id="del"><i class="fa-solid fa-delete-left"></i></button>

                    <button id="xracine3" class="btnss">x**(⅓)</button> <!-- x^1/3 -->
                    <button id="surx" class="btnss">1/x</button>
                    <button id="xpui2" class="btnss">x²</button>
                    <button id="xracine2" class="btnss">x**(½)</button>
                    
                    
                                        <button id="fact" class="btnss">x!</button> <!-- x! -->
<button id="exp" class="btnss">e</button>  <!-- e -->
                    <button id="sev" class="btnss">7</button>
                    <button id="eig" class="btnss">8</button>
                    <button id="nin" class="btnss">9</button>
                    <button id="multiply" class="btnss">x</button>

                    <button id="minus" class="btnss">-</button>

                    <button id="fou" class="btnss">4</button>
                    <button id="fiv" class="btnss">5</button>
                    <button id="six" class="btnss">6</button>

                    <button id="deux_puix" class="btnss">2ˣ</button> <!-- 2^x -->
                                      <button id="devide" class="btnss">/</button>
                    <button id="one" class="btnss">1</button>
                    <button id="two" class="btnss">2</button>
                    
                    <button id="three" class="btnss">3</button>
                                         <button id="plus" class="btnss">+</button>

  
                    <button id="par1" class="btnss">(</button>
                    <button id="par2" class="btnss">)</button>
                    <button id="ln" class="btnss">ln</button><!-- ln -->
                    
                    <button id="ex" class="btnss">eˣ</button><!-- ex -->
                    <button id="zer" class="btnss">0</button>
                    <button id="point" class="btnss">.</button>
                    <button id="equal">=</button>
                </div>
                <div class="calculator2">
                    <div class="button_mode">
                        <button id="standard">Standard</button>
                        <button id="scientific">Scientific</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let per = document.getElementById('per');
        per.value = '%';

        let ce = document.getElementById('ce');

        let c = document.getElementById('c');

        let del = document.getElementById('del');

        let surx = document.getElementById('surx');
        surx.value = '1/';

        let xpui2 = document.getElementById('xpui2');
        xpui2.value = '²';

        let xracine2 = document.getElementById('xracine2');
        xracine2.value = '^(¹⁄²)';
        
        let devide = document.getElementById('devide');
        devide.value = '/'

        let sev = document.getElementById('sev');
        sev.value = '7';

        let eig = document.getElementById('eig');
        eig.value = '8';

        let nin = document.getElementById('nin');
        nin.value = '9';

        let multiply = document.getElementById('multiply');
        multiply.value = 'x';

        let fou = document.getElementById('fou');
        fou.value = '4';

        let fiv = document.getElementById('fiv');
        fiv.value = '5';

        let six = document.getElementById('six');
        six.value = '6';
        
        let minus = document.getElementById('minus');
        minus.value = '-';

        let one = document.getElementById('one');
        one.value = '1';

        let two = document.getElementById('two');
        two.value = '2';

        let three = document.getElementById('three');
        three.value = '3';

        let plus = document.getElementById('plus');
        plus.value = '+';

        let zer = document.getElementById('zer');
        zer.value = '0';

        let point = document.getElementById('point');
        point.value = '.';

        let equal = document.getElementById('equal');
   

        let pi = document.getElementById('pi');
        pi.value = '3.14';

        let ln = document.getElementById('ln');
        ln.value = 'ln(';

        let xracine3 = document.getElementById('xracine3');
        xracine3.value = '**(1/3)';

        let e = document.getElementById('exp');
        e.value = '2.71';
        
        let fact = document.getElementById('fact');
        fact.value = '!';

        let deux_puix = document.getElementById('deux_puix');
        deux_puix.value = '2**';

        let exp = document.getElementById('ex');
        exp.value = 'e**(';

        let par1 = document.getElementById('par1');
        par1.value = '(';
        let par2 = document.getElementById('par2');
        par2.value = ')';


        let result = document.getElementById('result');

        
        let calculations = document.getElementById('calculations');
        calculations.textContent = '';
        
        document.querySelectorAll('.btnss').forEach(btnsss => {
            btnsss.addEventListener('click', () => {
                calculations.textContent += btnsss.value;
                calculations.value += btnsss.value;

            });
        });
        del.addEventListener('click', () => {
            calculations.textContent = calculations.textContent.substr(0, calculations.textContent.length - 1);
        });

        c.addEventListener('click', () =>  {
            calculations.textContent = '';
            result.textContent = 0;
        });

        ce.addEventListener('click', () => {
            calculations.textContent = '';
        });


        plus.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length - 1).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2').replace(/3.14/g, '3.14159265358979323846').replace(/2.71/g, '2.71828182845904523536').replace(/ln\(/g, 'Math.log('));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });
        minus.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length - 1).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });
        multiply.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length - 1).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });
        devide.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length - 1).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });


        equal.addEventListener('click', () => {
            let expression = calculations.textContent;
            try {
                result.textContent = eval(expression.replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            } catch (err) {
                result.textContent = `Erreur`;
            }
        });


        let science = document.getElementById("scientific");
        let standard =  document.getElementById('standard');
        science.style.display = 'none';
        standard.style.display = 'flex';


        standard.addEventListener('click', () => {
            science.style.display = 'flex';
            standard.style.display = 'none';
            [pi,par1, par2, ln, xracine3, e, fact, deux_puix, exp].forEach(item => {
                item.style.display = 'flex';
            });
            document.querySelectorAll('.calculator button').forEach(element => {
                element.style.flexBasis = '90px';
            });
            standard.closest('.whole_calculator').style.width = '60%';
        });


        science.addEventListener('click', () => {
            science.style.display = 'none';
            standard.style.display = 'flex';
            [pi, par1,par2, ln, xracine3, e, fact, deux_puix, exp].forEach(item => {
                item.style.display = 'none';
            });
            document.querySelectorAll('.calculator button').forEach(element => {
                element.style.flexBasis = '65px';
            });
            standard.closest('.whole_calculator').style.width = '50%';
        });


    </script>
</body>
</html>