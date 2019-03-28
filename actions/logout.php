<?php
    include_once 'check_user.php';
    
    session_destroy();
    echo 'Successfuly logout!';