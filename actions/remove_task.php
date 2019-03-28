<?php
    include_once 'check_user.php';

    if (!empty($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $db = new DB();
        $db->querySet('DELETE FROM tasks WHERE task_id=' . $task_id);
        $db->close();
    }