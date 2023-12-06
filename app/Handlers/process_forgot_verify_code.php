<?php
require_once '../../init.php';

$email_address = $functions->validate($_POST['email_address']);
$verificationCode = $functions->validate($_POST['verificationCode']);

if(empty($verificationCode)){
    $functions->toast_message("Please provide your verification code.", "error", "no", "");
}else{
    $database->DBQuery("SELECT `email`, `code` FROM `code` WHERE `email` = ? AND `code` = ?",[$email_address, $verificationCode]);

    if($database->rowCount() > 0){
      $functions->toast_message("Verification Code successfully verified", "success", "no", SYSTEM_URL."/new-password/".$email_address."/".$verificationCode);
    }else{
      $functions->toast_message("Invalid verification code.", "error", "no", "");
    }
}