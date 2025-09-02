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
                header('Location: calculator.php?success');
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
    <link rel="icon" href="media/EduTrack.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../outils.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>EduTrack</title>
</head>
<body>
    <header id="header1">
        <ul id="ul1">
            <li><a href="../index2.php"><span>Accueil</span><i class="fa-solid fa-house"></i></a></li>
            <li><a href="../cours.php"><span>Cours et Supports</span><i class="fa-solid fa-book-open"></i></a></li>
            <li><a href="../outils.php"><span>Outils d’Étude</span><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
            <li><a href="../taches.php"><span>À faire</span><i class="fa fa-tasks" aria-hidden="true"></i></a></li>
            <li><a href="../graphs.php"><span>Suivi et Progression</span><i class="fa-solid fa-chart-simple"></i></i></a></li>
            <?php include "../delete.php"; ?>
        </ul>
    </header>
    <div id="everything">
        <?php 
            $path = "../register.php";
            include "../account_delete.php"; 
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
        <div id="content222">
            <input id="idclient" type="hidden" value="<?php echo $_SESSION['id_client'] ?>">
            <div id="search_div"></div>
            <div class="whole_calculator">
                <div class="calculator">
                    <div class="results">
                        <h2 id="calculations"></h2>
                        <h3 id="result">0</h3>
                    </div>
                    <button id="per" class="btnss">%</button>
                    <button id="ce" >CE</button>
                    <button id="c">C</button>
                    <button id="del"><i class="fa-solid fa-delete-left"></i></button>
                    <button id="surx" class="btnss">1/x</button>
                    <button id="xpui2" class="btnss">x²</button>
                    <button id="xracine2" class="btnss">x**(½)</button>
                    <button id="plus" class="btnss">+</button>
                    <button id="sev" class="btnss">7</button>
                    <button id="eig" class="btnss">8</button>
                    <button id="nin" class="btnss">9</button>
                    <button id="minus" class="btnss">-</button>
                    <button id="fou" class="btnss">4</button>
                    <button id="fiv" class="btnss">5</button>
                    <button id="six" class="btnss">6</button>
                    <button id="devide" class="btnss">/</button>
                    <button id="one" class="btnss">1</button>
                    <button id="two" class="btnss">2</button>
                    <button id="three" class="btnss">3</button>
                    <button id="multiply" class="btnss">x</button>
                    <button id="zer" class="btnss">0</button>
                    <button id="point" class="btnss">.</button>
                    <button id="equal">=</button>
                </div>
                <div class="calculator22">
                    <div class="results">
                        <h2 id="calculations2"></h2>
                        <h3 id="result2">0</h3>
                    </div>
                    <button id="pi2" class="btnss2">π</button>    <!-- pi -->
                    <button id="per2" class="btnss2">%</button>
                    <button id="ce2" >CE</button>
                    <button id="c2">C</button>
                    <button id="xracine32" class="btnss2">x**(⅓)</button> 
                    <button id="del2"><i class="fa-solid fa-delete-left"></i></button><!-- x^1/3 -->
                    <button id="surx2" class="btnss2">1/x</button>
                    <button id="xpui22" class="btnss2">x²</button>
                    <button id="xracine22" class="btnss2">x**(½)</button>
                                        <button id="sev2" class="btnss2">7</button>
                    <button id="eig2" class="btnss2">8</button>
                    <button id="nin2" class="btnss2">9</button>
                    <button id="fact2" class="btnss2">x!</button> <!-- x! -->
                    <button id="minus2" class="btnss2">-</button>

                    <button id="multiply2" class="btnss2">x</button>
                    <button id="fou2" class="btnss2">4</button>
                    <button id="fiv2" class="btnss2">5</button>
                    <button id="six2" class="btnss2">6</button>
                    <button id="exp2" class="btnss2">e</button>  <!-- e -->
                    <button id="plus2" class="btnss2">+</button>

                    <button id="devide2" class="btnss2">/</button>
                    <button id="one2" class="btnss2">1</button>
                    <button id="two2" class="btnss2">2</button>
                    <button id="three2" class="btnss2">3</button>

                    <button id="deux_puix2" class="btnss2">2ˣ</button> <!-- 2^x -->

                    <button id="par12" class="btnss2">(</button>
                    <button id="par22" class="btnss2">)</button>
                    <button id="ln2" class="btnss2">ln</button><!-- ln -->
                    <button id="zer2" class="btnss2">0</button>
                    <button id="ex2" class="btnss2">eˣ</button><!-- ex -->

                    <button id="point2" class="btnss2">.</button>
                    <button id="equal2">=</button>
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
    <script src="../script.js"></script>
    <script>
        let ce = document.getElementById('ce');
        let c = document.getElementById('c');
        let del = document.getElementById('del');

        let per = document.getElementById('per');
        per.value = '%';

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
   








        let ce2 = document.getElementById('ce2');
        let c2 = document.getElementById('c2');
        let del2 = document.getElementById('del2');

        let per2 = document.getElementById('per2');
        per2.value = '%';

        let surx2 = document.getElementById('surx2');
        surx2.value = '1/';

        let xpui22 = document.getElementById('xpui22');
        xpui22.value = '²';

        let xracine22 = document.getElementById('xracine22');
        xracine22.value = '^(¹⁄²)';
        
        let devide2 = document.getElementById('devide2');
        devide2.value = '/'

        let sev2 = document.getElementById('sev2');
        sev2.value = '7';

        let eig2 = document.getElementById('eig2');
        eig2.value = '8';

        let nin2 = document.getElementById('nin2');
        nin2.value = '9';

        let multiply2 = document.getElementById('multiply2');
        multiply2.value = 'x';

        let fou2 = document.getElementById('fou2');
        fou2.value = '4';

        let fiv2 = document.getElementById('fiv2');
        fiv2.value = '5';

        let six2 = document.getElementById('six2');
        six2.value = '6';
        
        let minus2 = document.getElementById('minus2');
        minus2.value = '-';

        let one2 = document.getElementById('one2');
        one2.value = '1';

        let two2 = document.getElementById('two2');
        two2.value = '2';

        let three2 = document.getElementById('three2');
        three2.value = '3';

        let plus2 = document.getElementById('plus2');
        plus2.value = '+';

        let zer2 = document.getElementById('zer2');
        zer2.value = '0';

        let point2 = document.getElementById('point2');
        point2.value = '.';


        let pi = document.getElementById('pi2');
        pi.value = '3.14';

        let ln = document.getElementById('ln2');
        ln.value = 'ln(';

        let xracine3 = document.getElementById('xracine32');
        xracine3.value = '**(1/3)';

        let e = document.getElementById('exp2');
        e.value = '2.71';
        
        let fact = document.getElementById('fact2');
        fact.value = '!';

        let deux_puix = document.getElementById('deux_puix2');
        deux_puix.value = '2**';

        let exp = document.getElementById('ex2');
        exp.value = 'e**(';

        let par1 = document.getElementById('par12');
        par1.value = '(';
        let par2 = document.getElementById('par22');
        par2.value = ')';


        let equal2 = document.getElementById('equal2');

        let result = document.getElementById('result');

        let result2 = document.getElementById('result2');
        
        let calculations = document.getElementById('calculations');
        let calculations2 = document.getElementById('calculations2');

        calculations.textContent = '';
        calculations2.textContent = '';

        

        


        del.addEventListener('click', () => {
            calculations.textContent = calculations.textContent.substr(0, calculations.textContent.length - 1);
        });
        del2.addEventListener('click', () => {
            calculations2.textContent = calculations2.textContent.substr(0, calculations2.textContent.length - 1);
        });
        c.addEventListener('click', () =>  {
            calculations.textContent = '';
            result.textContent = 0;
        });
        c2.addEventListener('click', () =>  {
            calculations2.textContent = '';
            result2.textContent = 0;
        });

        ce.addEventListener('click', () => {
            calculations.textContent = '';
        });
        ce2.addEventListener('click', () => {
            calculations2.textContent = '';
        });

        plus.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });
        plus2.addEventListener('click', () => {
            let expression = calculations2.textContent;
            try{
                result2.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2').replace(/3.14/g, '3.14159265358979323846').replace(/2.71/g, '2.71828182845904523536').replace(/ln\(/g, 'Math.log('));
            }
            catch(err){
                result2.textContent = `Erreur`;
            }
        });


        minus.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });


        minus2.addEventListener('click', () => {
            let expression = calculations2.textContent;
            try{
                result2.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result2.textContent = `Erreur`;
            }
        });


        multiply.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });

        multiply2.addEventListener('click', () => {
            let expression = calculations2.textContent;
            try{
                result2.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result2.textContent = `Erreur`;
            }
        });
        devide.addEventListener('click', () => {
            let expression = calculations.textContent;
            try{
                result.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result.textContent = `Erreur`;
            }
        });
        devide2.addEventListener('click', () => {
            let expression = calculations2.textContent;
            try{
                result2.textContent = eval(expression.substr(0, expression.length).replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            }
            catch(err){
                result2.textContent = `Erreur`;
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

        equal2.addEventListener('click', () => {
            let expression = calculations2.textContent;
            try {
                result2.textContent = eval(expression.replace(/%/g, '/100').replace(/x/g, '*').replace(/\^\(¹⁄²\)/g, '**(1/2)').replace(/²/g, '**2'));
            } catch (err) {
                result2.textContent = `Erreur`;
            }
        });



        let science = document.getElementById("scientific");
        let standard =  document.getElementById('standard');
        let science_calc = document.querySelector('.calculator22');
        let standard_calc  = document.querySelector('.calculator');


        document.querySelectorAll('.btnss').forEach(btnsss => {
            btnsss.addEventListener('click', () => {
                calculations.textContent += btnsss.value;
                calculations.value += btnsss.value;
            });
        });
        document.querySelectorAll('.btnss2').forEach(btnsss2 => {
            btnsss2.addEventListener('click', () => {
                calculations2.textContent += btnsss2.value;
                calculations2.value += btnsss2.value;
            });
        });

        standard.addEventListener('click', () => {
            standard.closest('.whole_calculator').style.width = '70%';
            science.style.display = 'flex';
            standard.style.display = 'none';
            science_calc.style.display = 'flex';
            standard_calc.style.display = 'none';
            document.querySelectorAll('.calculator22 button').forEach(element => {
                element.style.flexBasis = '90px';
            });
        });


        science.addEventListener('click', () => {
            standard.closest('.whole_calculator').style.width = '50%';
            science.style.display = 'none';
            standard.style.display = 'flex';
            science_calc.style.display = 'none';
            standard_calc.style.display = 'flex';
            document.querySelectorAll('.calculator button').forEach(element => {
                element.style.flexBasis = '75px';
            });
        });
        
    </script>
</body>
</html>