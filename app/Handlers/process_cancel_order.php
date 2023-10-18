<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);


$database->DBQuery("SELECT `order_id`, `user_id` FROM `orders` WHERE `order_id` = ? AND `user_id` = ?", [$identifier, $_SESSION['uid']]);

if($database->rowCount() > 0){
       $database->DBQuery("UPDATE `orders` SET `order_status`='Cancelled' WHERE `order_id` = ? AND `user_id` = ?", [$identifier, $_SESSION['uid']]);
       $functions->toast_message("Order successfully cancelled.", "success", "yes", "");
}else{
       $functions->toast_message("There is a problem cancelling your order. Please try again later.", "error", "no", "");
}

$database->closeConnection();