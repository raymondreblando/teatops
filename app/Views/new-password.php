<?php
$page_title = "Forget Password";

require_once("./init.php");

$database->DBQuery("SELECT `email`,`code` FROM `code` WHERE `email` = ? AND `code` = ?",[$email, $code]);
if($database->rowCount() === 0){
  $redirect->redirect(SYSTEM_URL."/forget-password");
}

include 'Partials/header.php';

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="min-h-screen grid place-items-center bg-light-pink px-6">
    <div class="max-w-[400px]">
      <h3 class="text-2xl text-black font-bold mb-2">New Account Password</h3>
      <p class="text-sm text-black/60 font-medium mb-8">You're almost there! To set a new password for your account, please follow the instructions below.</p>

      <form>
        <input type="password" id="f_new_password" placeholder="Enter new password" class="w-full h-12 text-sm text-black placeholder:text-black border-none outline-none px-6 mb-4">
        <input type="password" id="f_confirm_password" placeholder="Confirm password" class="w-full h-12 text-sm text-black placeholder:text-black border-none outline-none px-6 mb-4">
        <button type="button" id="save-new-password" data-email="<?php echo $email ?>" data-code="<?php echo $code ?>" class="text-xs text-white bg-primary py-2 px-4">Save Password</button>
      </div>
    </div>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>