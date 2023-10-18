<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
$value = $functions->validate($_POST['value']);


$database->DBQuery("SELECT `user_id` FROM `users` WHERE `user_id` = ?", [$identifier]);
if($database->rowCount() > 0){
       $database->DBQuery("UPDATE `users` SET `active`=? WHERE `user_id` = ?", [$value, $identifier]);
       if($value === "yes"){
              $functions->toast_message("Account successfully Unblock.", "success", "yes", "");
       }else{
              $functions->toast_message("Account successfully Block.", "success", "yes", "");
       }
}else{
       $functions->toast_message("There a problem in the account. Please try again later.", "error", "no", "");
}

$database->closeConnection();