<?php
    include_once 'check_user.php';

    if (!empty($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $db = new DB();
        $res = $db->queryGet('SELECT name, status FROM tasks WHERE task_id=' . $task_id);
        $db->close();
        echo json_encode($res);
    } else {
        echo json_encode(array('error' => true));
    }