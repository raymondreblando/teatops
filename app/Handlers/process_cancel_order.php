<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);


$database->DBQuery("SELECT `order_id`, `user_id` FROM `orders` WHERE `order_id` = ? AND `user_id` = ?", [$identifier, $_SESSION['uid']]);

if($database->rowCount() > 0){
       $database->DBQuery("UPDATE `orders` SET `order_status`='Cancelled' WHERE `order_id` = ? AND `user_id` = ?", [$identifier, $_SESSION['uid']]);
       $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,?,'Admin',?,'Orders',?)", [RANDOM_ID, $_SESSION['uid'], $_SESSION['fullname']." cancel order #".$identifier." .", TODAYS]);
       $functions->toast_message("Order successfully cancelled.", "success", "yes", "");
}else{
       $functions->toast_message("There is a problem cancelling your order. Please try again later.", "error", "no", "");
}

$database->closeConnection();