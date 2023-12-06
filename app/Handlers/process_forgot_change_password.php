<?php
require_once '../../init.php';

$email = $functions->validate($_POST['email']);
$code = $functions->validate($_POST['code']);
$new_password = $functions->validate($_POST['new_password']);
$confirm_password = $functions->validate($_POST['confirm_password']);

$database->DBQuery("SELECT * FROM `code` WHERE `email`=? AND `code`=?",[$email, $code]);
if($database->rowCount() > 0){
  if(empty($new_password)){
        $functions->toast_message("Please provide your new password.", "error", "no", "");
  }elseif(empty($confirm_password)){
          $functions->toast_message("Please confirm your new password.", "error", "no", "");
  }else{
    if(strlen($new_password) < 6){
        $functions->toast_message("Password must be more than 6 characters.", "error", "no", "");
    }elseif($new_password !== $confirm_password){
        $functions->toast_message("Confirm Passwords didn't match.", "error", "no", "");
    }else{
        $database->DBQuery("UPDATE `users` SET `password`=? WHERE `email`=?",[md5($new_password), $email]);
        $database->DBQuery("DELETE FROM `code` WHERE `email`=? AND `code`=?",[$email, $code]);
        $functions->toast_message("Password successfully save.", "success", "yes", SYSTEM_URL);
    }
  }
}else{
  $functions->toast_message("Sorry, there is a problem saving your new password. Please try again later.", "error", "no", "");
}

$database->closeConnection();