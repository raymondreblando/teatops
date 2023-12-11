<?php
require_once '../../init.php';

$fullname = $functions->validate($_POST['fullname']);
$username = $functions->validate($_POST['username']);
$gender = $functions->validate($_POST['gender']);
$phone_number = $functions->validate($_POST['phone_number']);
$street = $functions->validate($_POST['street']);
$zone = $functions->validate($_POST['zone']);
$barangay = $functions->validate($_POST['barangay']);
$municipality = $functions->validate($_POST['municipality']);
$province = $functions->validate($_POST['province']);
$email = $functions->validate($_POST['email']);

if(empty($fullname) OR empty($username) OR empty($gender) OR empty($phone_number) OR empty($street) OR empty($zone) OR empty($barangay) OR empty($municipality) OR empty($province) OR empty($email)){
       $functions->toast_message("Please fill-up all the fields.", "error", "no", "");
}else{
       $database->DBQuery("SELECT * FROM `users` WHERE `user_id`=?",[$_SESSION['uid']]);
       $user_data = $database->fetch();
       if($database->rowCount() > 0){
              if(!empty($_FILES["profile_picture"]["name"])){
                     $allowTypes = array('jpg', 'jpeg', 'png');
                     $filename = $_FILES["profile_picture"]["name"];
                     $fileSize = $_FILES["profile_picture"]["size"];
                     $uploadDir = "../../uploads/profile/";
                     $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
                     $newFilename = $functions->randomString(25)  ."." . $getFileExt;
                     if(!in_array($getFileExt, $allowTypes)){
                            $functions->notification("Uploaded profile picture not Supported", "error", "no", "");
                     }else{
                            if(strlen($username) > 40){
                                   $functions->toast_message("Username must be 6-40 character Only!", "error", "no", "");
                            }else{
                                   $database->DBQuery("SELECT `profile` FROM `users` WHERE `user_id`=?",[$_SESSION['uid']]);
                                   $getCurrentProfile = $database->fetch();

                                   if(strlen($getCurrentProfile->profile) > 15){
                                          unlink($uploadDir.$getCurrentProfile->profile);
                                   }

                                   move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uploadDir . $newFilename);
                                   $database->DBQuery("UPDATE `users` SET `username`=?,`email`=?,`fullname`=?,`gender`=?,`contact`=?,`street`=?,`zone`=?,`barangay`=?,`municipal`=?,`province`=?,`profile`=? WHERE `user_id`=?",[$username, $email, $fullname, $gender, $phone_number, $street, $zone, $barangay, $municipality, $province, $newFilename, $_SESSION['uid']]);
                                   $functions->toast_message("Profile Successfully Updated.", "success", "yes", "");
                            }
                     }
              }else{
                     $database->DBQuery("UPDATE `users` SET `username`=?,`email`=?,`fullname`=?,`gender`=?,`contact`=?,`street`=?,`zone`=?,`barangay`=?,`municipal`=?,`province`=? WHERE `user_id`=?",[$username, $email, $fullname, $gender, $phone_number, $street, $zone, $barangay, $municipality, $province, $_SESSION['uid']]);
                     $functions->toast_message("Profile Successfully Updated.", "success", "yes", "");
              }
       }else{
              $functions->toast_message("There is a problem updating your information. Please refresh the page and try again.", "error", "no", "");
       }
}

$database->closeConnection();