<?php
    include_once 'check_user.php';

    if (!empty($_POST['task_id']) && !empty($_POST['project_id'])) {
        $task_id = $_POST['task_id'];
        $project_id = $_POST['project_id'];
        $db = new DB();
        $priority = $db->queryGet('SELECT priority FROM tasks WHERE task_id=' . $task_id. ' AND status = 0')[0]['priority'];
        $priority_next = $db->queryGet('SELECT * FROM tasks WHERE priority > '. $priority .' AND status = 0 ORDER BY priority LIMIT 1')[0]['priority'];
        $db->querySet('UPDATE tasks SET priority=' . $priority . ' WHERE status = 0 AND project_id=' . $project_id. ' AND priority=' . $priority_next);
        $db->querySet('UPDATE tasks SET priority=' . $priority_next . ' WHERE task_id=' . $task_id);
        $db->close();
    }