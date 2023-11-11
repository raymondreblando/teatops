<?php
require_once '../../init.php';

if($_SESSION['role'] === "968375857"){
      $database->DBQuery("UPDATE `notification` SET `n_seen` = 'yes' WHERE `n_to`='Admin'");
}else{
      $database->DBQuery("UPDATE `notification` SET `n_seen` = 'yes' WHERE `n_to`=?",[$_SESSION['uid']]);
}

$database->closeConnection();