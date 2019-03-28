<?php
    include_once 'check_user.php';

    if (!empty($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
        $db = new DB();
        $res = $db->queryGet('SELECT MAX(priority) as priority FROM tasks WHERE project_id=' . $project_id. ' AND status = 0');
        $db->close();
        echo json_encode($res);
    } else {
        echo json_encode(array('error' => true));
    }