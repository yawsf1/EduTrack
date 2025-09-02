<?php
session_start();
include 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['inscription'])){
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        
        $password = $_POST['pass'] ?? '';
        $cpassword = $_POST['cpass'] ?? '';
        $genre = $_POST['selected'] ?? '';

        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['genre'] = $genre;

        if(!$email){
            header('Location: inscription.php?erreur=emailincorrecte');
            exit();
        }
        else if(empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($cpassword) || empty($genre)){
            header('Location: inscription.php?erreur=empty');
            exit();
        }
        else if(strlen($nom) > 200 || strlen($prenom) > 200 || strlen($email) > 200 || strlen($password) > 200 || strlen($cpassword) > 200){
            header('Location: inscription.php?erreur=toolong');
            exit();
        }
        else if($password !== $cpassword){
            header('Location: inscription.php?erreur=doesntmuch');
            exit();
        }
        else if($_POST['csrf'] !== $_SESSION['csrf'] || !isset($_SESSION['csrf'])){
            header('Location: inscription.php?erreur=csrf');
            exit();
        }
        else{
            $stmt = $conn -> prepare('SELECT * FROM client WHERE email_client = ?;');
            $stmt -> bind_param('s', $email);
            if(!$stmt -> execute()){
                header('Location: inscription.php?erreur=select');
                exit();
            }
            else{
                $result = $stmt -> get_result();
                $user = $result -> fetch_assoc();
                $lines = $result -> num_rows;
                if($lines !== 0){
                    header('Location: inscription.php?erreur=emailexist');
                    exit();
                }
                else{
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn -> prepare('INSERT INTO client(nom_client,prenom_client,email_client,password,genre_client) VALUES (?, ?, ?, ?, ?);');
                    $stmt -> bind_param('sssss', $nom, $prenom, $email, $pass, $genre);
                    if(!$stmt -> execute()){
                        header('Location: inscription.php?erreur=insert');
                        exit();
                    }
                    else{
                        $id = $conn -> insert_id;
                        $_SESSION['id_client'] = $id;
                        $_SESSION['message'] = 'Vous vous êtes inscrit avec succès.';
                        unset($_SESSION['csrf']);
                        header('Location: index2.php?email='.$email);
                        exit();
                    }
                }
            }
        }
    }
    if(isset($_POST['connecter'])){
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $pass = $_POST['pass'] ?? '';
        if(empty($email) || empty($pass)){
            $erreur = 'empty';
        }
        else if(!$email){
            $erreur = 'emailincorrect';
        }
        else if(strlen($email) > 70 || strlen($pass) > 70){
            $erreur = 'toolong';
        }
        else if(!isset($_SESSION['csrf']) || $_POST['csrf'] !== $_SESSION['csrf'] ){
            $erreur = 'csrf';
        }
        else{
            $stmt = $conn -> prepare('SELECT * FROM client WHERE email_client = ?');
            $stmt -> bind_param('s', $email);
            if(!$stmt -> execute()){
                $erreur = 'select';
            }
            else{
                $result = $stmt -> get_result();
                $user = $result -> fetch_assoc();
                if($result -> num_rows === 0){
                    $erreur = 'unexist_acc';
                }
                else if(!password_verify($pass, $user['password'])){
                    $erreur = 'passwordincorrect';
                }
                else{
                    $id_user = $user['Id_client'];
                    if(isset($_POST['remember2']) && $_POST['remember2'] == 1){
                        $token = bin2hex(random_bytes(32));
                        $token_hashed = hash('sha256' ,$token);
                        $date_expire = date('Y-m-d H:i:s', time() + 3600 * 24 * 7);

                        $stmt2 = $conn -> prepare('INSERT INTO tokens(token, expire_date, id_client) VALUES (?,?,?);');
                        $stmt2 -> bind_param('ssi', $token_hashed, $date_expire,$id_user);
                        if($stmt2 -> execute()){
                            setcookie('remember', $token, time() + 3600 * 24 * 7, "/", "", false, true);
                        }
                    }
                    $_SESSION['id_client'] = $id_user;
                    $_SESSION['message'] = 'Vous vous êtes connectez avec succès.';
                    session_regenerate_id(true);
                    unset($_SESSION['csrf']);
                    header('Location: index2.php?succes');
                    exit();
                }
            }
        }
        if(isset($erreur)){
            header('Location: login.php?erreur='.$erreur);
            exit();
        }
    }
    if(isset($_POST['enregister'])){
        $nom = trim(filter_input(INPUT_POST, 'coursnom', FILTER_SANITIZE_SPECIAL_CHARS)) ;
        $cours = trim(filter_input(INPUT_POST, 'courstexte', FILTER_SANITIZE_SPECIAL_CHARS)) ;
        $lien = trim(filter_input(INPUT_POST, 'liencours', FILTER_SANITIZE_SPECIAL_CHARS)) ;
        $fichier = $_FILES['importcours'] ?? 'Aucune fichier';
        $id_client = $_SESSION['id_client'];
        
        $fichiernom = $fichier['name'];
        $fichiertype = $fichier['type'];
        $fichiertmp = $fichier['tmp_name'];
        $fichiertaille = $fichier['size'];
        $fichiererror = $fichier['error'];

        $type = explode('.',$fichiernom);
        $realtype = strtolower(end($type));

        $types = array('png', 'pdf', 'jpeg', 'jpg');
        $erreur = '';
        if(empty($nom) || ( empty($cours) && empty($lien) && empty($fichiernom))){
            $erreur = 'empty';
        }
        elseif(strlen($nom) > 120 || strlen($cours) > 1000 || strlen($lien) > 300){
            $erreur = 'toolong';
        }
        elseif(!empty($fichiernom) && !in_array($realtype, $types)){
            $erreur = 'type';
        }
        elseif(!empty($fichiernom) && $fichiertaille > 30000000){
            $erreur = 'sizetoobig';
        }
        elseif(!empty($fichiernom) && $fichiererror !== 0){
            $erreur = 'Thereerror';
        }
        else{
            if(empty($lien)) {
                $lien = 'Aucune lien';
            }
            if(empty($cours)){
                $cours = 'Aucune cours';
            }
            $stmt = $conn -> prepare('INSERT INTO cours(nom_cours,lien_cours,cours_texte,id_client) Values (?, ?, ?, ?);');
            $stmt -> bind_param('sssi', $nom, $lien, $cours, $id_client);
            if(!$stmt -> execute()){
                $erreur = 'Insert';
            }
            else{
                $id_cours = $conn -> insert_id;
                if(!empty($fichiernom) && $fichiererror === 0){
                    $newnom = uniqid('file_', true).'.'.$realtype;
                    $destination = 'uploads/'.$newnom;
                    move_uploaded_file($fichiertmp, $destination);
                    $stmt = $conn -> prepare('INSERT INTO fichier(nom_fichier,type_fichier,id_cours) VALUES (?, ?, ?);');
                    $stmt -> bind_param('ssi', $newnom, $realtype, $id_cours);
                    if(!$stmt -> execute()){
                        $erreur = 'insertfile';
                    }
                }
                header('Location: courscree.php?succes=courscree');
                exit();
            }
        }
        if(!empty($erreur)){
            header('Location: cours.php?erreur='.$erreur);
            exit();
        }
    }
    if(isset($_POST['examinez'])){
        $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_SPECIAL_CHARS);
        $reponse = filter_input(INPUT_POST, 'reponse', FILTER_SANITIZE_SPECIAL_CHARS);
        $erreur = '';
        if(empty($question) || empty($reponse)){
            $erreur = 'empty';
        }
        elseif(strlen($question) > 121 || strlen($reponse) > 121){
            $erreur = 'toolong';
        }
        else{
            $stmt = $conn -> prepare('INSERT INTO cartes(question,reponse,id_client) VALUES (?, ?, ?);');
            $stmt -> bind_param('ssi', $question, $reponse, $_SESSION['id_client']);
            if($stmt -> execute()){
                header('Location: outils/cartes.php?cartecree');
                exit();
            }
            else{
                $erreur = 'insertion';
            }
        }
        if(!empty($erreur)){
            header('Location: outils/flashcards.php?erreur='.$erreur);
            exit();
        }
    }
    if(isset($_POST['delete_account'])){
        $stmt = $conn -> prepare("DELETE FROM client WHERE Id_client = ? ;");
        $stmt -> bind_param("i", $_SESSION['id_client']);
        if($stmt -> execute()){
            $_SESSION['deleted'] = "Votre compte etre supprimer !";
            session_unset();
            session_destroy();
            header("Location: index.php?account_deleted");
            exit();
        }
    }
}
?>