<?php
require_once '../../init.php';

$fullname = $functions->validate($_POST['fullname']);
$username = $functions->validate($_POST['username']);
$gender = $functions->validate($_POST['gender']);
$contact = $functions->validate($_POST['contact']);
$address = $functions->validate($_POST['address']);
$email = $functions->validate($_POST['email']);
$password = $functions->validate($_POST['password']);
$c_password = $functions->validate($_POST['c_password']);

if(empty($fullname) OR empty($username) OR empty($gender) OR empty($contact) OR empty($address) OR empty($email) OR empty($password) OR empty($c_password)){
       $functions->toast_message("Please fill-up all the fields.", "error", "no", "");
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
       $functions->toast_message("Invalid email address.", "error", "no", "");
}elseif($password !== $c_password){
       $functions->toast_message("Passwords didn't match.", "error", "no", "");
}elseif(strlen($password) < 6){
       $functions->toast_message("Password must be more than 6 characters.", "error", "no", "");
}elseif(strlen($username) > 40){
       $functions->toast_message("Username must be 6-40 character Only!", "error", "no", "");
}else{
       $database->DBQuery("SELECT * FROM `users` WHERE `username`=?",[$username]);
       if($database->rowCount() > 0){
              $functions->toast_message("Username already taken. Try other username.", "error", "no", "");
       }else{
              $database->DBQuery("INSERT INTO `users` (`user_id`,`username`,`password`,`fullname`,`gender`,`contact`,`address`,`email`,`date_created`) VALUES (?,?,?,?,?,?,?,?,?)",[RANDOM_ID, $username, md5($password), $fullname, $gender, $contact, $address, $email, TODAYS]);
              $functions->toast_message("Successfully Register.", "success", "yes", "");
       }
}

$database->closeConnection();