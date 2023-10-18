<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
$newCountValue = $functions->validate($_POST['newCountValue']);

if($newCountValue > 0){
       $database->DBQuery("UPDATE `cart_items` SET `quantity`=? WHERE `cart_id` = ?", [$newCountValue, $identifier]);
}else{
       $database->DBQuery("DELETE FROM `cart_items` WHERE `cart_id` = ?", [$identifier]);
}

$database->closeConnection();