<?php
$page_title = "My Orders";
$tab_active = "My Orders";

require_once("./init.php");

include 'Partials/header.php';

$redirect->checkLoggedIn(SYSTEM_URL);
$redirect->redirectNotCustomer(SYSTEM_URL);
?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">My Order History</h3>
      <p class="font-medium text-center text-gray-700 mb-8" data-aos="fade-up">Here are the list of orders you have placed.</p>

      <div class="max-w-[480px] flex items-center mx-auto mb-8 gap-3" data-aos="fade-up">
        <div class="w-full h-14 flex items-center bg-white px-6 rounded-md">
          <input type="text" id="searchDiv" class="w-full h-full font-medium bg-transparent outline-none placeholder:text-gray-600" placeholder="Search orders here.." autocomplete="off">
          <img src="<?php echo SYSTEM_URL ?>/public/icons/search-normal-linear.svg" alt="search" class="w-5 h-5">
        </div>
      </div>

      <div id="reload-div" class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        
      </div>
    </section>
  </main>

<?php include 'Partials/footer.php'; ?>
<script>
  $(document).ready(function () {
    getMyOrderList();
  });
  setInterval(() => {
    getMyOrderList();
  }, 5000);
</script>