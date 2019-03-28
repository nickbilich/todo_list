<?php
    include_once 'check_user.php';

    $db = new DB();
    if (!empty($_POST['task_status'])) {
        if ($_POST['task_status'] == 'on') {
            $status = 1;
        } else {
            $status = 0;
        }
    } else {
        $status = 0;
    }
    if(!empty($_POST['task_name']) && !empty($_POST['task_id'])) {
        $task_name = $_POST['task_name'];
        $task_id = $_POST['task_id'];
        $db->querySet('UPDATE tasks SET status=' . $status . ', name="' . $task_name. '" WHERE task_id=' . $task_id);
        $db->close();
    }