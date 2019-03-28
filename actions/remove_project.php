<?php
    include_once 'check_user.php';

    if (!empty($_POST['project_id'])) {
        $project_id = $_POST['project_id'];
        $db = new DB();
        $db->querySet('DELETE FROM projects WHERE id=' . $project_id);
        $db->querySet('DELETE FROM tasks WHERE project_id=' . $project_id);
        $db->close();
    }