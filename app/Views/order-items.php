<?php
$page_title = "Order Details";
$tab_active = "Orders";

require_once("./init.php");

include 'Partials/header.php';

$redirect->checkLoggedIn(SYSTEM_URL);
$redirect->redirectNotAdmin(SYSTEM_URL);

$database->DBQuery("SELECT * FROM `orders` LEFT JOIN `payments` ON orders.order_id=payments.order_id LEFT JOIN `users` ON orders.user_id=users.user_id LEFT JOIN `role` ON users.role_id=role.role_id WHERE orders.order_id = ?", [$id]);

$order_summary = $database->fetch();

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="flex items-center justify-center bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">Order #<?php echo $id; ?></h3>
      <p class="font-medium text-center text-gray-700" data-aos="fade-up">Here are the additional order informations.</p>
      <p class="font-medium text-xs text-center text-gray-700 mb-8" data-aos="fade-up">The order was placed on <?= $functions->formatDateTime($order_summary->order_date, "M d, Y - h:s A") ?></p>

      <div class="max-w-[500px] mx-auto bg-white/50 rounded-2xl p-8">
        <div class="flex items-center justify-between gap-4 mb-6" data-aos="fade-up">
          <div class="w-max flex items-center gap-2">
            <img src="<?php echo SYSTEM_URL."/public/images/".$order_summary->gender.".svg" ?>" alt="profile" class="w-9 h-9">
            <div>
              <p class="text-sm text-black font-semibold"><?php echo $order_summary->fullname ?></p>
              <p class="text-sm text-slate-500 font-semibold"><?php echo $order_summary->role_name ?></p>
            </div>
          </div>
          <?php if($order_summary->order_status === "Pending"): ?>
            <!-- <button type="button" id="confirmOrder" data-id="<?php echo $order_summary->order_id ?>" class="flex items-center text-xs text-white font-semibold bg-emerald-600 py-2 px-4 rounded-md gap-2">
              <img src="<?php echo SYSTEM_URL ?>/public/icons/tick-circle-bold.svg" alt="check" class="w-5 h-5">
              Confirm Order
            </button> -->
          <?php endif ?>
        </div>
        <p class="text-sm text-black font-semibold mb-3" data-aos="fade-up">Order Details</p>
        <div class="flex items-center justify-between flex-wrap gap-4 mb-6" data-aos="fade-up">
          <div>
            <p class="text-sm text-gray-700 font-semibold">Order Type</p>
            <p class="text-xs text-gray-700 font-semibold"><?php echo $order_summary->order_type ?></p>
          </div>
          <div class="flex items-center gap-3">
            <!-- <img src="<?php echo SYSTEM_URL ?>/public/icons/gcash.png" alt="gcash" class="w-9 h-9"> -->
            <div>
              <p class="text-sm text-gray-700 font-semibold">Payment Method</p>
              <p class="text-xs text-gray-700 font-semibold">Paid via <?php echo $order_summary->payment_type ?></p>
            </div>
          </div>
          <div>
            <p class="text-sm text-gray-700 font-semibold">Order Amount</p>
            <p class="text-xs text-gray-700 font-semibold">&#8369;<?php echo $order_summary->amount ?></p>
          </div>
        </div>
        <p class="text-sm text-black font-semibold mb-3" data-aos="fade-up">Shipping Information</p>
        <div class="flex items-center justify-between flex-wrap gap-4 mb-6" data-aos="fade-up">
          <div class="flex items-center gap-3">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/location-bold.svg" alt="location" class="w-9 h-9">
            <div>
              <p class="text-sm text-gray-700 font-semibold">Shipping Address</p>
              <p class="text-xs text-gray-700 font-semibold"><?php echo $order_summary->address ?></p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/call-bold.svg" alt="phone" class="w-9 h-9">
            <div>
              <p class="text-sm text-gray-700 font-semibold">Contact Number</p>
              <p class="text-xs text-gray-700 font-semibold"><?php echo $order_summary->contact ?></p>
            </div>
          </div>
        </div>
        <p class="text-sm text-black font-semibold mb-3" data-aos="fade-up">Orderred Items</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-aos="fade-up">
          <?php
              $database->DBQuery("SELECT * FROM `my_order` LEFT JOIN `menu` ON my_order.menu_id=menu.menu_id LEFT JOIN `price` ON my_order.p_id=price.p_id LEFT JOIN `category` ON menu.category_id=category.category_id WHERE my_order.order_id = ? ORDER BY my_order.my_order_no DESC", [$order_summary->order_id]);
              $items = $database->fetchAll();   
              foreach($items as $item):
          ?>
              <div class="flex justify-between py-2">
                <div class="flex gap-3">
                  <div class="w-12">
                    <img src="<?php echo SYSTEM_URL."/uploads/menu/".$item->menu_photo ?>" alt="<?= $item->menu_name ?>" class="h-12">
                  </div>
                  <div>
                    <p class="text-sm text-black font-semibold"><?= $item->menu_name ?></p>
                    <p class="text-xs text-primary font-semibold"><?= $item->category_name ?></p>
                    <p class="text-[10px] text-gray-400 font-medium"><?= !empty($item->addons) ? 'With '. $item->addons : '' ?></p>
                    <div class="flex items-center gap-2">
                      <span class="bg-primary text-white text-[10px] uppercase px-[4px] leading-none"><?= $item->p_size ?></span>
                      <p class="text-xs text-slate-500">&#8369; <?= $item->p_price." x ".$item->quantity ?></p>
                    </div>
                  </div>
                </div>
              </div>
          <?php endforeach ?>
        </div>
      </div>
    </section>
  </main>

<?php include 'Partials/footer.php'; ?>