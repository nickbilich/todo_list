<?php
    include_once 'check_user.php';

    if (!empty($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
        $db = new DB();
        $res = $db->queryGet('SELECT name FROM projects WHERE id=' . $project_id);
        $db->close();
        echo json_encode($res);
    } else {
        echo json_encode(array('error' => true));
    }