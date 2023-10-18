<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
$value = $functions->validate($_POST['value']);

$database->DBQuery("UPDATE `orders` SET `order_status` = ? WHERE `order_id` = ?", [$value, $identifier]);
$functions->toast_message("Order status successfully change.", "success", "no", "");

$database->closeConnection();