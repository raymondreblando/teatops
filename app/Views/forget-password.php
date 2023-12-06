<?php
$page_title = "Forget Password";

require_once("./init.php");

include 'Partials/header.php';

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="min-h-screen grid place-items-center bg-light-pink px-6">
    <div class="max-w-[400px]">
      <h3 class="text-2xl text-black font-bold mb-2">Reset Account Password</h3>
      <p class="text-sm text-black/60 font-medium mb-8">If you've forgotten your password, don't worry! We'll help you reset it. Please enter the email address associated with your account, and we'll send you a code to reset your password.</p>

      <div class="flex bg-white gap-3 py-4 px-6">
        <input type="text" id="f_email" placeholder="Enter account email address" class="w-full text-sm text-black placeholder:text-black border-none outline-none">
        <div id="input-loader">
          <div class="spinner-loader"></div>
        </div>
        <button type="button" id="verify-email" class="text-xs text-white bg-primary py-2 px-4">Send</button>
      </div>
    </div>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>