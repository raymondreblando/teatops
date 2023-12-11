<?php
require_once '../../init.php';

$current_password_1 = $functions->validate($_POST['current_password_1']);
$new_password_1 = $functions->validate($_POST['new_password_1']);
$confirm_password_1 = $functions->validate($_POST['confirm_password_1']);

if(empty($current_password_1)){
       $functions->toast_message("Please provide your current password.", "error", "no", "");
}elseif(empty($new_password_1)){
       $functions->toast_message("Please provide new password.", "error", "no", "");
}elseif(empty($confirm_password_1)){
       $functions->toast_message("Please confirm your new password.", "error", "no", "");
}else{
       $database->DBQuery("SELECT * FROM `users` WHERE `password`=? AND `user_id`=?",[md5($current_password_1), $_SESSION['uid']]);
       if($database->rowCount() > 0){
              if(strlen($new_password_1) < 7){
                     $functions->toast_message("Password must be more than 7 characters.", "error", "no", "");
              }elseif($new_password_1 !== $confirm_password_1){
                     $functions->toast_message("Confirm Passwords didn't match.", "error", "no", "");
              }else{
                     $database->DBQuery("UPDATE `users` SET `password`=? WHERE `user_id`=?",[md5($new_password_1), $_SESSION['uid']]);
                     $functions->toast_message("Password successfully change.", "success", "yes", "");
              }
       }else{
              $functions->toast_message("Incorrect current password.", "error", "no", "");
       }
}

$database->closeConnection();