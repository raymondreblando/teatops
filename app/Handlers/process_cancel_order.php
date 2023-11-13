<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);


$database->DBQuery("SELECT `order_id`, `user_id` FROM `orders` WHERE `order_id` = ? AND `user_id` = ?", [$identifier, $_SESSION['uid']]);

if($database->rowCount() > 0){
       $database->DBQuery("SELECT * FROM `my_order` WHERE `order_id` = ?", [$identifier]);
       foreach($database->fetchAll() as $orderItem){
              $database->DBQuery("SELECT `menu_id`,`menu_stock` FROM `menu` WHERE `menu_id` = ?", [$orderItem->menu_id]);
              $menuStock = $database->fetch();

              $newStocks = $menuStock->menu_stock + $orderItem->quantity;

              $database->DBQuery("UPDATE `menu` SET `menu_stock` = ? WHERE `menu_id` = ?", [$newStocks, $orderItem->menu_id]);
       }

       $database->DBQuery("UPDATE `orders` SET `order_status`='Cancelled' WHERE `order_id` = ? AND `user_id` = ?", [$identifier, $_SESSION['uid']]);
       $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,?,'Admin',?,'Orders',?)", [RANDOM_ID, $_SESSION['uid'], $_SESSION['fullname']." cancel order #".$identifier." .", TODAYS]);
       $functions->toast_message("Order successfully cancelled.", "success", "yes", "");
}else{
       $functions->toast_message("There is a problem cancelling your order. Please try again later.", "error", "no", "");
}

$database->closeConnection();