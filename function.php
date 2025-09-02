<?php
function deletedata($data, $conn){
    $id_fichier = $data['id_f'];
    $id_cours = $data['id_c'];
    if(!isset($id_fichier) || !isset($id_cours)){
        echo json_encode(['status' => 'failed', 'message' => "error files"]);
        return;
    }
    try{
        $conn->begin_transaction();
        $stmt = $conn -> prepare('DELETE FROM fichier where id_fichier=? ;');
        $stmt -> bind_param('i', $id_fichier);
        if($stmt -> execute()){
            $stmt = $conn -> prepare('DELETE FROM cours where id_cours=? ;');
            $stmt -> bind_param('i', $id_cours);
            if($stmt -> execute()){
                $conn -> commit();
                echo json_encode(['status' => 'success', 'message' => 'You did change it successfully']);
            }
            else{
                $conn -> rollback();
                echo json_encode(['status' => 'failed', 'message' => "cours delete"]);
            }
        }
        else{
            $conn -> rollback();
            echo json_encode(['status' => 'failed', 'message' => "fichier delete"]);
        }
    }
    catch(Exception $e){
        $conn -> rollback();
        echo json_encode(['status' => 'failed', 'message' => $e -> getMessage()]);
    }
}
function searchdata($data, $conn) {
    $input = $data['search_content'];
    $inputlike = '%'.$input . '%'; 
    $cours = [];
    $cartes = [];
    $taches = [];

    $stmt = $conn->prepare('SELECT nom_cours, date_post, id_cours FROM cours WHERE nom_cours LIKE ? AND id_client = ? LIMIT 4;');
    $stmt->bind_param('si', $inputlike, $data['id']);
    if ($stmt->execute()) { 
        $result = $stmt->get_result(); 
        while ($row = $result->fetch_assoc()) { 
            $cours[] = $row; 
        } 
    }
    $stmt->close();

    $stmt2 = $conn->prepare('SELECT question, date, id_carte FROM cartes WHERE question LIKE ? AND id_client = ? LIMIT 4;');
    $stmt2->bind_param('si', $inputlike, $data['id']);
    if ($stmt2->execute()) { 
        $result2 = $stmt2->get_result(); 
        while ($row = $result2->fetch_assoc()) { 
            $cartes[] = $row; 
        } 
    }
    $stmt2->close();

    $stmt3 = $conn->prepare('SELECT tache, date, id_tache FROM tache WHERE tache LIKE ? AND id_client = ? LIMIT 4;');
    $stmt3->bind_param('si', $inputlike, $data['id']);
    if ($stmt3->execute()) { 
        $result3 = $stmt3->get_result(); 
        while ($row = $result3->fetch_assoc()) { 
            $taches[] = $row; 
        } 
    }
    $stmt3->close();

    echo json_encode(empty($cours) && empty($cartes) && empty($taches) ? 
    ['data1' => '', 'data2' => '', 'data3' => '','status' => 'failed', 'message' => 'No matching data found']
    : ['data1' => $cours, 'data2' => $cartes, 'data3' => $taches, 'status' => 'success', 'message' => 'Data retrieved successfully']
    );
}



function deletecarte($data, $conn){
    $stmt = $conn -> prepare('DELETE FROM cartes WHERE id_carte = ?;');
    $stmt -> bind_param('i', $data['id_question']);
    if($stmt -> execute()){
        echo json_encode(['status'=>'success', 'message'=>'carte deleted']);
        exit();
    }
    else{
        echo json_encode(['status'=>'failed', 'message'=>"carte didn't deleted"]);
        exit();
    }
    $stmt->close();
}
function random_carte($conn, $id_client){
    if(isset($id_client)){
        $stmt = $conn -> prepare('SELECT question, reponse FROM cartes where id_client = ? ORDER BY RAND() LIMIT 1;');
        $stmt -> bind_param('i', $id_client);
        if($stmt -> execute()){
            $result = $stmt -> get_result();
            $carte = $result -> fetch_assoc();
            echo json_encode(['data' => $carte, 'status' => 'success', 'message' => 'this cool']);
            exit();
        }
        else{
            echo json_encode(['data'=> '','status' => 'failed', 'message' => 'this bad']);
            exit();
        }
        $stmt -> close();
    }
}
function graph_cours($conn, $id_client){
    if(isset($id_client)){
        $stmt = $conn -> prepare('SELECT COUNT(id_cours) as nombre_cours, date_post FROM cours WHERE id_client = ? GROUP BY date_post ORDER BY nombre_cours DESC;');
        $stmt -> bind_param('i', $id_client);
        if($stmt -> execute()){
            $result = $stmt -> get_result();
            $cours = $result -> fetch_all(MYSQLI_ASSOC);
            echo json_encode(['data' => $cours, 'status' => 'success']);
            exit();
        }
        else{
            echo json_encode(['data' => '', 'status' => 'success']);
            exit();
        }
        $stmt -> close();
    }
}
function timerdata($data,$conn){
    $pomotimer = $data['pomotimer'];
    $minipause = $data['minipause'];
    $longpause = $data['longpause'];
    $mode = $data['mode'];
    $color = $data['color'];
    $stmt = $conn -> prepare('INSERT INTO minuteur(pomo,pause_mini,pause_longue,mode,background,id_client) VALUES (?, ?, ?, ?, ?, ?);');
    $stmt -> bind_param('iiissi', $pomotimer, $minipause, $longpause, $mode, $color, $_SESSION['id_client']);
    if($stmt -> execute()){
        $stmt -> close();
        $stmt = $conn -> prepare('SELECT * FROM minuteur WHERE id_client = ?;');
        $stmt -> bind_param('i', $_SESSION['id_client']);
        if($stmt -> execute()){
            $result = $stmt -> get_result();
            $timers = $result -> fetch_all(MYSQLI_ASSOC);
            echo json_encode(['data' => $timers,'status' => 'success', 'message' => 'data inserted']);
        }
        else{
            echo json_encode(['data' => '','status' => 'failed', 'message' => "data didn't selected"]);
        }
    }
    else{
        echo json_encode(['data' => '','status' => 'failed', 'message' => "data didn't inserted"]);
    }
}
function pomoresult($conn, $idclient){
    $stmt = $conn -> prepare('SELECT pomo FROM minuteur ORDER BY pomo DESC LIMIT 1 WHERE id_client = ?;');
    $stmt -> bind_param('i', $idclient);
    if($stmt -> execute()){
        $result = $stmt -> get_result();
        $pomodorodata = $result -> fetch_assoc();
        echo json_encode(['data' => $pomodorodata, 'status' => 'succes', 'message' => 'you did select']);
        exit();
    }
    else{
        echo json_encode(['data' => '', 'status' => 'failed', 'message' => "you did'nt select"]);
        exit();
    }
}
function add_task($data, $conn){
    $stmt = $conn -> prepare('INSERT INTO tache(tache, n_tache, id_client) VALUES (?,?,?)');
    $stmt -> bind_param('sii', $data['task_name'], $data['nombre_tasks'], $_SESSION['id_client']);
    if($stmt -> execute()){
        echo json_encode(['data' => $data,'status' => 'success', 'message' => 'inserted']);
    }
    else{
        echo json_encode(['data'=> '', 'status' => 'failed', 'message' => 'not inserted']);
    }
}

function delete_task($data, $conn){
    $stmt = $conn -> prepare('DELETE FROM tache WHERE id_tache = ? and id_client = ?;');
    $stmt -> bind_param('ii', $data['id_task'], $_SESSION['id_client']);
    if($stmt -> execute()){
        echo json_encode(['status' => 'success' , 'message' => 'deleted succefully']);
        exit();
    }
    else{
        echo json_encode(['status' => 'failed' , 'message' => 'cant delete the task']);
        exit();
    }
    $stmt -> close();
}
function update_task($data, $conn, $id_client){
    $stmt = $conn -> prepare('UPDATE tache SET tache = ?, n_tache = ? WHERE id_tache = ? AND id_client = ?;');
    $stmt -> bind_param('siii',$data['new_task'],$data['task_n'] ,$data['task_id'], $id_client);
    if($stmt -> execute()){
        echo json_encode(['status' => 'success' , 'message' => 'you did succefully updated it']);
        exit();
    }
    else{
        echo json_encode(['status' => 'failed' , 'message' => "you didn't updated it"]);
        exit();
    }
    $stmt -> close();
}
function update_n_task($data, $conn, $id_client2){
    $stmt = $conn -> prepare('UPDATE tache SET n_tache = ? WHERE id_tache = ? and id_client = ?;');
    $stmt -> bind_param('iii', $data['nouveau_n_tache'], $data['id_tache'], $id_client2);
    if($stmt -> execute()){
        $stmt -> close();

        $stmt = $conn -> prepare('SELECT tache, n_tache from tache where id_tache = ? and id_client = ?;');
        $stmt -> bind_param('ii', $data['id_tache'], $id_client2);
        if($stmt -> execute()){
            $result = $stmt -> get_result();
            $tache = $result -> fetch_assoc();
            echo json_encode(['data' => $tache, 'status' => 'success' , 'message' => 'updated & selecting succefully']);
            exit();
        }
        echo json_encode(['data' => '' ,'status' => 'success', 'message' => 'updated succefully']);
        exit();
    }
    else{
        echo json_encode(['data' => '' , 'status' => 'failed', 'message' => "cannnot update"]);
        exit();
    }
    $stmt -> close();
}



?>