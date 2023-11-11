<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
$value = $functions->validate($_POST['value']);

$database->DBQuery("UPDATE `orders` SET `order_status` = ? WHERE `order_id` = ?", [$value, $identifier]);

$database->DBQuery("SELECT orders.order_id,orders.user_id,users.fullname FROM `orders` LEFT JOIN `users` ON orders.user_id=users.user_id WHERE orders.order_id = ?", [$identifier]);
$user_info = $database->fetch();

switch ($value) {  
      case 'Confirmed':
            $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,'Admin',?,?,'Status',?)", [RANDOM_ID, $user_info->user_id, "Your order #".$identifier.' has been confirmed.', TODAYS]);
            break;
      case 'Delivering':
            $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,'Admin',?,?,'Status',?)", [RANDOM_ID, $user_info->user_id, "Your order #".$identifier.' is currently in transit for delivery.', TODAYS]);
            break;
      case 'Completed':
            $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,'Admin',?,?,'Status',?)", [RANDOM_ID, $user_info->user_id, "Your order #".$identifier.' has been completed.', TODAYS]);
            break;
      case 'Cancelled':
            $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,'Admin',?,?,'Status',?)", [RANDOM_ID, $user_info->user_id, "Sorry, your order #".$identifier.' has been cancelled.', TODAYS]);
            break;
}

$functions->toast_message("Order status successfully change.", "success", "no", "");

$database->closeConnection();