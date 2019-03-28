<?php
    include_once '../config.php';
    include_once '../class/DB.php';

    session_start();
    $db = new DB();
    if(!empty($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }
    if (!empty($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
        $res = $db->queryGet('SELECT id FROM projects WHERE id = ' . $project_id . ' AND user_id = ' . $user_id);
        if (empty($res)) {
            die();
        }
    }
    if(!empty($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $project_id = $db->queryGet('SELECT project_id FROM tasks WHERE task_id = ' . $task_id)[0]['project_id'];
        $res = $db->queryGet('SELECT id FROM projects WHERE id = ' . $project_id . ' AND user_id = ' . $user_id);
        if (empty($res)) {
            die();
        }
    }
    
    $db->close();