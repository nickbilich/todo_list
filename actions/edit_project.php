<?php
    include_once 'check_user.php';

    if (!empty($_POST['project_name']) && !empty($_POST['project_id'])) {
        $project_name = $_POST['project_name'];
        $project_id = $_POST['project_id'];
        $db = new DB();
        $db->querySet('UPDATE projects SET name="' . $project_name. '" WHERE id=' . $project_id);
        $db->close();
    }