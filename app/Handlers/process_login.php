<?php
require_once '../../init.php';

$username = $functions->validate($_POST['username']);
$password = $functions->validate($_POST['password']);

if(empty($username) OR empty($password)){
    $functions->toast_message("Please provide your username and password.", "error", "no", "");
}elseif(empty($username)){
    $functions->toast_message("Please provide your username.", "error", "no", "");
}elseif(empty($password)){
    $functions->toast_message("Please provide your password.", "error", "no", "");
}else{
    $database->DBQuery("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?", [$username, md5($password)]);
    $user = $database->fetch();
    if($database->rowCount() > 0){
        if($user->active === "yes"){
            $_SESSION["loggedin"] = true;
            $_SESSION["uid"] = $user->user_id;
            $_SESSION["fullname"] = $user->fullname;
            $_SESSION["role"] = $user->role_id;
            $functions->html_fetch('<script>window.location.href = "'.SYSTEM_URL.'/menu";</script>');
        }else{
            $functions->toast_message("Your account has been block.", "error", "no", "");
        }
    }else{
        $functions->toast_message("Wrong username and password.", "error", "no", "");
    }
}

$database->closeConnection();