<?php
    include_once 'check_user.php';

    if (!empty($_POST['task_id']) && !empty($_POST['project_id'])) {
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $db = new DB();
        $priority = $db->queryGet('SELECT priority FROM tasks WHERE task_id=' . $task_id. ' AND status = 0')[0]['priority'];
        $priority_prev = $db->queryGet('SELECT * FROM tasks WHERE status = 0 AND priority < '. $priority .' ORDER BY priority DESC LIMIT 1')[0]['priority'];
        $db->querySet('UPDATE tasks SET priority=' . $priority . ' WHERE status = 0 AND project_id=' . $_POST['project_id']. ' AND priority=' . $priority_prev);
        $db->querySet('UPDATE tasks SET priority=' . $priority_prev . ' WHERE status = 0 AND task_id=' . $task_id);
        $db->close();
    }