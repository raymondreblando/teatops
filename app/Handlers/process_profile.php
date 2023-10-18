<?php
require_once '../../init.php';

$fullname = $functions->validate($_POST['fullname']);
$username = $functions->validate($_POST['username']);
$gender = $functions->validate($_POST['gender']);
$phone_number = $functions->validate($_POST['phone_number']);
$address = $functions->validate($_POST['address']);

if(empty($fullname) OR empty($username) OR empty($gender) OR empty($phone_number) OR empty($address)){
       $functions->toast_message("Please fill-up all the fields.", "error", "no", "");
}else{
       $database->DBQuery("SELECT * FROM `users` WHERE `user_id`=?",[$_SESSION['uid']]);
       $user_data = $database->fetch();
       if($database->rowCount() > 0){
              if($user_data->username === $username){
                     $database->DBQuery("UPDATE `users` SET `fullname`=?,`gender`=?,`contact`=?,`address`=? WHERE `user_id`=?",[$fullname, $gender, $phone_number, $address, $_SESSION['uid']]);
                     $functions->toast_message("Profile Successfully Updated.", "success", "yes", "");
              }else{
                     if(strlen($username) > 40){
                            $functions->toast_message("Username must be 6-40 character Only!", "error", "no", "");
                     }else{
                            $database->DBQuery("UPDATE `users` SET `username`=?,`fullname`=?,`gender`=?,`contact`=?,`address`=? WHERE `user_id`=?",[$username, $fullname, $gender, $phone_number, $address, $_SESSION['uid']]);
                            $functions->toast_message("Profile Successfully Updated.", "success", "yes", "");
                     }
              }
       }else{
              $functions->toast_message("There is a problem updating your information. Please refresh the page and try again.", "error", "no", "");
       }
}

$database->closeConnection();