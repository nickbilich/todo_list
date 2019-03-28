<?php
    include_once 'check_user.php';

    if (!empty($_POST['project_name'])){
        $project_name = $_POST['project_name'];
        $db = new DB();
        $res = $db->querySet('INSERT INTO projects(name, user_id) VALUES("' . $project_name . '", ' . $user_id . ')');
    }
    $db->close();