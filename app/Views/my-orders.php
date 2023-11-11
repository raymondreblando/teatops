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

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php
             $database->DBQuery("SELECT * FROM `orders` LEFT JOIN `payments` ON orders.payment_id=payments.payment_id WHERE orders.user_id = ? ORDER BY orders.order_status DESC", [$_SESSION['uid']]);
             $myOrders = $database->fetchAll();   
             foreach($myOrders as $myOrder):
        ?>
            <div class="searchArea">
              <div class="border border-white bg-white/60 rounded-md overflow-hidden" data-aos="fade-up">
                <div class="relative border-b border-b-gray-300/40 py-4 px-6">
                  <div class="flex items-center justify-between mb-3">
                    <div>
                      <p class="text-sm text-black font-semibold finder1">Order #<?= $myOrder->order_id ?></p>
                      <p class="text-xs text-slate-500 finder2"><?= $functions->formatDateTime($myOrder->order_date, "M d, Y - h:s A") ?></p>
                    </div>
                    <div>
                      <?php if($myOrder->order_status === "Pending"): ?>
                        <button type="button" class="cancel-order-btn"><i class="ri-close-line pointer-events-none"></i></button>
                      <?php endif ?>
                    </div>
                  </div>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <p class="text-xs text-black font-semibold finder3">Paid via <?= $myOrder->payment_type ?></p>
                    </div>
                    <span class="finder4 order-status order-<?= strtolower($myOrder->order_status) ?>"><?= $myOrder->order_status ?></span>
                  </div>
                  <div class="cancel-order">
                    <p class="text-sm text-black font-semibold">Kindly confirm if you want to cancel this order?</p>
                    <div class="flex items-center gap-3">
                      <button data-id="<?= $myOrder->order_id ?>" class="cancelOrder confirm-btn text-xs text-white font-semibold bg-primary py-2 px-3 rounded-md">Confirm</button>
                      <button class="cancel-btn text-xs font-semibold bg-gray-200 py-2 px-3 rounded-md">Cancel</button>
                    </div>
                  </div>
                </div>
                <div class="border-b border-b-gray-300/40 py-4 px-6">
                  <?php
                      //  $database->DBQuery("SELECT * FROM `orders` WHERE orders.user_id = ?", [$_SESSION['uid']]);
                      $database->DBQuery("SELECT * FROM `my_order` LEFT JOIN `menu` ON my_order.menu_id=menu.menu_id LEFT JOIN `price` ON my_order.p_id=price.p_id WHERE my_order.order_id = ?", [$myOrder->order_id]);
                      $myItems = $database->fetchAll();   
                      foreach($myItems as $myItem):
                  ?>
                      <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-3">
                          <div class="grid place-items-center w-12">
                            <img src="<?= SYSTEM_URL."/uploads/menu/".$myItem->menu_photo ?>" alt="<?= $myItem->menu_name ?>" class="h-12">
                          </div>
                          <div>
                            <p class="text-sm text-black font-semibold finder5"><?= $myItem->menu_name ?></p>
                            <?php if($myItem->addonsPrice > 0): ?>
                              <p class="text-xs text-gray-400 font-semibold leading-none">With <?= $myItem->addons ?></p>
                            <?php endif ?>
                              <span class="bg-primary text-white text-[9px] uppercase px-[4px]"><?= $myItem->p_size ?></span>
                              <p class="text-xs text-slate-500">
                                &#8369; <span class="item-price"><?= $myItem->p_price ?></span>
                                <?php if($myItem->addonsPrice > 0): ?>
                                  + &#8369; <span class="addons-price"><?= $myItem->addonsPrice ?></span> for addons</p>
                                <?php endif ?>
                          </div>
                        </div>
                        <div class="text-center">
                          <p class="text-sm text-black font-semibold">Qty</p>
                          <p class="text-xs text-slate-500"><?= $myItem->quantity ?></p>
                        </div>
                      </div>
                  <?php endforeach ?>
                </div>
                <div class="flex justify-between py-5 px-6">
                  <p class="text-xs font-bold text-black uppercase">Amount Paid</p>
                  <p class="text-sm text-black font-bold">&#8369;<?= $myOrder->amount ?></p>
                </div>
              </div>
            </div>
        <?php endforeach ?>
      </div>
    </section>
  </main>

<?php include 'Partials/footer.php'; ?>