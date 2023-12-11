<?php
$page_title = "Account Verify";
$tab_active = "Accounts";

require_once("./init.php");

include 'Partials/header.php';

$redirect->checkLoggedIn(SYSTEM_URL);
$redirect->redirectNotAdmin(SYSTEM_URL);

$database->DbQuery('SELECT * FROM `users` WHERE `user_id` = ?', [$id]);
$getUserData = $database->fetch();

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="flex items-center justify-center bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <div class="max-w-[700px] mx-auto mb-6 gap-3" data-aos="fade-up">
        <div class="flex items-center justify-between gap-3 mb-12">
          <div>
            <h4 class="text-lg font-semibold text-gray-800" data-aos="fade-up">Customer: <?php echo $getUserData->fullname ?></h4>
            <p class="font-medium text-gray-700" data-aos="fade-up">Review the uploaded valid id below.</p>
          </div>
          <div class="flex items-center gap-3">
            <button type="button" data-id="<?php echo $id ?>" data-value="Verified" class="verify-id verify block w-full bg-emerald-600 text-white py-2 px-4 rounded-md">Verify</button>
            <button type="button" data-id="<?php echo $id ?>" data-value="Rejected" class="verify-id reject block w-full bg-rose-600 text-white py-2 px-4 rounded-md">Reject</button>
          </div>
        </div>
        <div class="grid md:grid-cols-2 gap-">
          <img src="<?= SYSTEM_URL.'/uploads/identifier/'.$getUserData->front_id ?>" alt="Front Id Image" class="w-full">
          <img src="<?= SYSTEM_URL.'/uploads/identifier/'.$getUserData->back_id ?>" alt="Back Id Image" class="w-full">
        </div>
      </div>
    </section>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>