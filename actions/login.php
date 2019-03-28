<?php
    include_once 'check_user.php';
    
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $salt = md5(SALT);
        $pass = md5($pass . $salt);
        
        $db = new DB();
        $res = $db->queryGet('SELECT count(*) as count FROM user WHERE username = "' . $user . '"');
        if ($res[0]['count'] <= 0) {
            $text = 'Wrong username or password';
            $status = false;
        } else {
            $res = $db->queryGet('SELECT id, password as pass FROM user WHERE username = "' . $user . '"');
            if ($pass == $res[0]['pass']) {
                $text = 'You successfuly logined';
                $status = true;
                $_SESSION['user_id'] = $res[0]['id'];
                
            } else {
                $text = 'Wrong username or password';
                $status = false;
            }
        }
        $db->close();
    } else {
        $text = 'Wrong username or password';
        $status = false;
    }
    $response = array('text' => $text, 'status' => $status);
    echo json_encode($response);