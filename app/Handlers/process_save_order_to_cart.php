<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
$p_id = $functions->validate($_POST['p_id']);

$database->DBQuery("SELECT `cart_no` FROM `cart_items` WHERE `user_id`=?",[$_SESSION['uid']]);
$cartCount = $database->rowCount() + 1;

if(empty($identifier)){
       $functions->toast_message("There is a problem saving your order. Please try again later.", "error", "no", "");
}elseif(empty($p_id)){
       $functions->toast_message("Please choose product size.", "error", "no", "");
}else{
       $database->DBQuery("SELECT * FROM `cart_items` WHERE `user_id`=? AND `menu_id` = ? AND `p_id` = ?",[$_SESSION['uid'], $identifier, $p_id]);
       if($database->rowCount() > 0){
              $functions->toast_message("This product and the selected sized are already on your cart.", "error", "no", $cartCount);
       }else{
              $database->DBQuery("INSERT INTO `cart_items` (`cart_id`,`user_id`,`menu_id`,`p_id`) VALUES (?,?,?,?)",[RANDOM_ID, $_SESSION['uid'], $identifier, $p_id]);
              $functions->toast_message("Order successfully added.", "success", "no", $cartCount);
       }
}

$database->closeConnection();