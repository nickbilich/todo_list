<?php
    include_once 'check_user.php';

    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $salt = md5(SALT);
        $pass = md5($pass . $salt);
        
        $db = new DB();
        $res = $db->queryGet('SELECT count(*) as count FROM user WHERE username = "' . $user . '" or email = "' . $email . '"');
        if ($res[0]['count'] > 0) {
            $text = "User or email already exist's!";
            $status = false;
        } else {
            $db->querySet('INSERT INTO user(username, email, password) VALUES("' . $user. '", "' . $email. '", "' . $pass . '")');
            $text = 'You successfuly registred';
            $status = true;
        }
        $db->close();
    } else {
        $text = 'Wrong username, email or password';
        $status = false;
    }
    $response = array('text' => $text, 'status' => $status);
    echo json_encode($response);