<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
$valueVerification = $functions->validate($_POST['valueVerification']);

$database->DBQuery("UPDATE `users` SET `id_verification`=? WHERE `user_id` = ?",[$valueVerification, $identifier]);
$functions->toast_message("Successfully ".$valueVerification, "success", "yes", "");

$database->closeConnection();