<?php
require_once '../../init.php';

$f_email = $functions->validate($_POST['f_email']);

if(empty($f_email)){
    $functions->toast_message("Please provide your registered email address.", "error", "no", "");
}else{
    $database->DBQuery("SELECT `email` FROM `users` WHERE `email` = ?",[$f_email]);

    if($database->rowCount() > 0){
      $database->DBQuery("SELECT `email` FROM `code` WHERE `email` = ?",[$f_email]);

      $generatedCode = $functions->generatePin();

      if($database->rowCount() > 0){
        $database->DBQuery("UPDATE `code` SET `code` = ? WHERE `email` = ?", [$functions->generatePin(), $f_email]);
      }else{
        $database->DBQuery("INSERT INTO `code` (`code_id`,`email`,`code`) VALUES (?,?,?)", [RANDOM_ID, $f_email, $generatedCode]);
      }
      $email_send->sendEmail($f_email, "Verification Code", "Thank you for choosing our service. To complete the verification process, please use the following code: <br><br> Verification Code: ".$generatedCode." <br><br> Please enter this code on our platform to verify your email address. If you did not request this code, please ignore this email. <br><br> Thank you");
      $functions->toast_message("Reset Code successfully sent to your email", "success", "no", SYSTEM_URL."/code/verify/".$f_email);
    }else{
      $functions->toast_message("Provided email address not found on our system!", "error", "no", "");
    }
}