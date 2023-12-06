<?php
$page_title = "Account Verify";
$tab_active = "Accounts";

require_once("./init.php");

include 'Partials/header.php';

$redirect->checkLoggedIn(SYSTEM_URL);
$redirect->redirectNotAdmin(SYSTEM_URL);
?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="flex items-center justify-center bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <div class="max-w-[700px] mx-auto mb-6 gap-3" data-aos="fade-up">
        <div class="flex items-center justify-between gap-3 mb-12">
          <div>
            <h3 class="text-3xl font-semibold text-gray-800 mb-2" data-aos="fade-up">Account Verify</h3>
            <p class="font-medium text-gray-700" data-aos="fade-up">Review the uploaded valid id below.</p>
          </div>
          <div class="flex items-center gap-3">
            <button type="button" class="verify block w-full bg-emerald-600 text-white py-2 px-4 rounded-md">Verify</button>
            <button type="button" class="reject block w-full bg-rose-600 text-white py-2 px-4 rounded-md">Reject</button>
          </div>
        </div>
        <div class="grid md:grid-cols-2 gap-">
          <img src="<?= SYSTEM_URL ?>/public/images/Front.png" alt="Front Id Image" class="w-full">
          <img src="<?= SYSTEM_URL ?>/public/images/Back.png" alt="Back Id Image" class="w-full">
        </div>
      </div>
    </section>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>