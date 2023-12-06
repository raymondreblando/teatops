<?php
$page_title = "Verification Code";

require_once("./init.php");

$database->DBQuery("SELECT `email` FROM `code` WHERE `email` = ?",[$email]);
if($database->rowCount() === 0){
  $redirect->redirect(SYSTEM_URL."/forget-password");
}

include 'Partials/header.php';

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="min-h-screen grid place-items-center bg-light-pink px-6">
    <div class="max-w-[400px]">
      <h3 class="text-2xl text-black text-center font-bold mb-2">Enter Verification Code</h3>
      <p class="text-sm text-black/60 text-center font-medium mb-12">To ensure the security of your account, we need to verify your identity. Please enter the verification code sent to your registered email address.</p>
      <p id="email_address" class="text-sm text-black/60 text-center font-medium mb-2"><?php echo $email ?></p>

      <form>
        <div class="flex justify-between gap-3 py-4 px-6 mb-6">
          <input type="text" class="code-input w-full h-16 text-xl text-black text-center font-bold placeholder:text-black border-none outline-none py-2 px-4" maxLength="1">
          <input type="text" class="code-input w-full h-16 text-xl text-black text-center font-bold placeholder:text-black border-none outline-none py-2 px-4" maxLength="1">
          <input type="text" class="code-input w-full h-16 text-xl text-black text-center font-bold placeholder:text-black border-none outline-none py-2 px-4" maxLength="1">
          <input type="text" class="code-input w-full h-16 text-xl text-black text-center font-bold placeholder:text-black border-none outline-none py-2 px-4" maxLength="1">
        </div>
        <button type="button" id="verify-code" class="block text-xs text-white bg-primary py-4 px-8 mx-auto">Verify Code</button>
      </form>
    </div>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>