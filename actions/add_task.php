<?php
    include_once 'check_user.php';

    if (!empty($_POST['add_task_name']) && !empty($_POST['project_id']) && !empty($_POST['priority'])) {
        $task_name = $_POST['add_task_name'];
        $project_id = $_POST['project_id'];
        $priority = $_POST['priority'];
        $db = new DB();
        $db->querySet('INSERT INTO tasks(name, status, project_id, priority) VALUES("' . $task_name. '", 0, ' . $project_id. ', ' . $priority. ')');
        $db->close();
    }

