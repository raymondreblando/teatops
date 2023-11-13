<?php
require_once '../../init.php';

$totalAmount = $functions->validate($_POST['totalAmount']);
$orderType = $functions->validate($_POST['orderType']);
$paymentMethod = $functions->validate($_POST['paymentMethod']);

$database->DBQuery("SELECT `order_no`,`order_id` FROM `orders` ORDER BY `order_no` DESC LIMIT 1");
$getCurrentOrderID = $database->fetch();

if($database->rowCount() > 0){
       $orderID = $getCurrentOrderID->order_id + 1;
}else{
       $orderID = "10000001";
}

$database->DBQuery("SELECT * FROM `cart_items` WHERE `user_id` = ?", [$_SESSION['uid']]);
$cartItems = $database->fetchAll();
$cartItemTotal = $database->rowCount();

$stocksCheckAvailability = true;

foreach($cartItems as $cartItem){
       $database->DBQuery("SELECT `menu_id`,`menu_name`,`menu_stock` FROM `menu` WHERE `menu_id` = ?", [$cartItem->menu_id]);
       $menuStock = $database->fetch();

       if($cartItem->quantity > $menuStock->menu_stock){
              $functions->toast_message('Sorry, only '.$menuStock->menu_stock.' stocks of '.$menuStock->menu_name.' are available. Please reduce the quantity of your order.', "error", "no", "");
              $stocksCheckAvailability = false;
       }
}
if($stocksCheckAvailability === true){
       if($cartItemTotal > 0){
              if(empty($orderType)){
                     $functions->toast_message("Please select type of order.", "error", "no", "");
              }elseif(empty($paymentMethod)){
                     $functions->toast_message("Please select payment method.", "error", "no", "");
              }else{
                     
                            foreach($cartItems as $cartItem){
                                   $database->DBQuery("INSERT INTO `my_order` (`order_id`,`menu_id`,`p_id`,`quantity`,`addons`,`addonsPrice`) VALUES (?,?,?,?,?,?)", [$orderID, $cartItem->menu_id, $cartItem->p_id, $cartItem->quantity, $cartItem->addons, $cartItem->addonsPrice]);
                                   
                                   $database->DBQuery("SELECT `menu_id`,`menu_stock` FROM `menu` WHERE `menu_id` = ?", [$cartItem->menu_id]);
                                   $menuStock = $database->fetch();

                                   $newStocks = $menuStock->menu_stock - $cartItem->quantity;

                                   $database->DBQuery("UPDATE `menu` SET `menu_stock` = ? WHERE `menu_id` = ?", [$newStocks, $cartItem->menu_id]);
                                   
                            }
                            $database->DBQuery("INSERT INTO `orders` (`order_id`,`user_id`,`order_type`,`payment_id`,`order_date`) VALUES (?,?,?,?,?)", [ $orderID, $_SESSION['uid'], $orderType, RANDOM_ID, TODAYS]);
                            $database->DBQuery("INSERT INTO `payments` (`payment_id`,`order_id`,`payment_type`,`amount`,`date_pay`) VALUES (?,?,?,?,?)", [RANDOM_ID, $orderID, $paymentMethod, $totalAmount, TODAYS]);
                            $database->DBQuery("INSERT INTO `notification` (`n_id`,`n_from`,`n_to`,`n_msg`,`n_type`,`n_date`) VALUES (?,?,'Admin',?,'Orders',?)", [RANDOM_ID, $_SESSION['uid'], $_SESSION['fullname']." place a new order.", TODAYS]);
                            $database->DBQuery("DELETE FROM `cart_items` WHERE `user_id` = ?", [$_SESSION['uid']]);

                            $functions->toast_message("Your order are successfully save.", "success", "yes", "");   
                     
              }
       }else{
              $functions->toast_message("Your cart is empty.", "error", "no", "");
       }
}
$database->closeConnection();