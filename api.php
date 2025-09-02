<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

include 'db.php';
include 'function.php';

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    http_response_code(200);
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    if($data['action'] === 'delete_cours'){
        deletedata($data, $conn);
    }
    else if($data['action'] === 'search'){
        searchdata($data, $conn);
    
    }
    else if($data['action'] === 'delete_carte'){
        deletecarte($data, $conn);
    }
    else if($data['action'] === 'timers'){
        timerdata($data,$conn);
    }
    elseif($data['action'] === 'tache'){
        add_task($data, $conn);
    }
    else if($data['action'] === 'delete_task'){
        delete_task($data, $conn);
    }
    else if($data['action'] === 'update_task'){
        update_task($data, $conn, $_SESSION['id_client']);
    }
    else if($data['action'] === 'update_n_task'){
        update_n_task($data, $conn, $_SESSION['id_client']);
    }
}
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if($_GET['action'] === 'random'){
        random_carte($conn, $_SESSION['id_client']);
    }
    else if($_GET['action'] === 'graphcours'){
        graph_cours($conn, $_SESSION['id_client']);
    }
    else if($_GET['action'] === 'pomo'){
        pomoresult($conn, $_SESSION['id_client']);
    }
}

?>