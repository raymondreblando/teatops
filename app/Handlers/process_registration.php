<?php
require_once '../../init.php';

$fullname = $functions->validate($_POST['fullname']);
$username = $functions->validate($_POST['username']);
$gender = $functions->validate($_POST['gender']);
$contact = $functions->validate($_POST['contact']);
$street = $functions->validate($_POST['r_street']);
$zone = $functions->validate($_POST['r_zone']);
$barangay = $functions->validate($_POST['r_barangay']);
$municipality = $functions->validate($_POST['r_municipality']);
$province = $functions->validate($_POST['r_province']);
$email = $functions->validate($_POST['email']);
$password = $functions->validate($_POST['password']);
$c_password = $functions->validate($_POST['c_password']);

if(empty($fullname) OR empty($username) OR empty($gender) OR empty($contact) OR empty($street) OR empty($zone) OR empty($barangay) OR empty($municipality) OR empty($province) OR empty($email) OR empty($password) OR empty($c_password)){
       $functions->toast_message("Please fill-up all the fields.", "error", "no", "");
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
       $functions->toast_message("Invalid email address.", "error", "no", "");
}elseif($password !== $c_password){
       $functions->toast_message("Passwords didn't match.", "error", "no", "");
}elseif(strlen($password) < 7){
       $functions->toast_message("Password must be more than 7 characters.", "error", "no", "");
}elseif(strlen($username) > 40){
       $functions->toast_message("Username must be 6-40 character Only!", "error", "no", "");
}else{
       if(empty($_FILES["r_front_id"]["name"])){
              $functions->toast_message("Please upload a picture of your front ID.", "error", "no", "");
       }elseif(empty($_FILES["r_back_id"]["name"])){
              $functions->toast_message("Please upload a picture of your back ID.", "error", "no", "");
       }else{
              $allowTypes = array('jpg', 'jpeg', 'png');
              $filename_1 = $_FILES["r_front_id"]["name"];
              $filename_2 = $_FILES["r_back_id"]["name"];
              $fileSize_1 = $_FILES["r_front_id"]["size"];
              $fileSize_2 = $_FILES["r_back_id"]["size"];
              $uploadDir = "../../uploads/identifier/";
              $getFileExt_1 = pathinfo($filename_1, PATHINFO_EXTENSION);
              $getFileExt_2 = pathinfo($filename_2, PATHINFO_EXTENSION);
              $newFilename_1 = $functions->randomString(25)  ."." . $getFileExt_1;
              $newFilename_2 = $functions->randomString(25)  ."." . $getFileExt_2;
              if(!in_array($getFileExt_1, $allowTypes)){
                     $functions->notification("Uploaded front ID image not Supported", "error", "no", "");
              }elseif(!in_array($getFileExt_2, $allowTypes)){
                     $functions->notification("Uploaded back ID image not Supported", "error", "no", "");
              }else{
                     move_uploaded_file($_FILES["r_front_id"]["tmp_name"], $uploadDir . $newFilename_1);
                     move_uploaded_file($_FILES["r_back_id"]["tmp_name"], $uploadDir . $newFilename_2);
                     $database->DBQuery("SELECT * FROM `users` WHERE `username`=?",[$username]);
                     if($database->rowCount() > 0){
                            $functions->toast_message("Username already taken. Try other username.", "error", "no", "");
                     }else{
                            $database->DBQuery("INSERT INTO `users` (`user_id`,`username`,`password`,`email`,`fullname`,`gender`,`contact`,`street`,`zone`,`barangay`,`municipal`,`province`,`front_id`,`back_id`,`date_created`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[RANDOM_ID, $username, md5($password), $email,  $fullname, $gender, $contact, $street, $zone, $barangay, $municipality, $province, $newFilename_1, $newFilename_2, TODAYS]);
                            $functions->toast_message("Successfully Register.", "success", "yes", "");
                     }
              }
       }
}

$database->closeConnection();