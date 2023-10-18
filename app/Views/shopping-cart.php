<?php
$page_title = "Cart";
$tab_active = "Cart";

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
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">Shopping Cart</h3>
      <p class="font-medium text-center text-gray-700 mb-8" data-aos="fade-up">Here is the summary of your orderred items.</p>

      <div class="max-w-[600px] mx-auto bg-white/60">
        <div class="border border-gray-300/40 rounded-md overflow-hidden" data-aos="fade-up">
          <div class="relative border-b border-b-gray-300/40 py-5 px-6">
            <p class="text-sm text-black font-semibold">Order Summary</p>
            <p class="text-xs text-slate-500">Here is the summary of items you have added to your cart.</p>
          </div>
          <div class="border-b border-b-gray-300/40 py-4 px-6">
            <?php 
                $database->DBQuery("SELECT * FROM `cart_items` LEFT JOIN `menu` ON cart_items.menu_id=menu.menu_id LEFT JOIN `price` ON cart_items.p_id=price.p_id WHERE `user_id`=? ORDER BY `cart_no` DESC", [$_SESSION['uid']]);
                $carts = $database->fetchAll();
                if($database->rowCount() > 0):
                  foreach($carts as $cart):
            ?>
                  <div class="items flex items-center justify-between py-2">
                    <div class="flex items-center gap-3">
                      <div class="grid place-items-center w-16">
                        <img src="<?= SYSTEM_URL."/uploads/menu/".$cart->menu_photo ?>" alt="<?= $cart->menu_name ?>" class="h-16">
                      </div>
                      <div>
                        <p class="text-sm text-black font-semibold leading-none"><?= $cart->menu_name ?></p>
                        <span class="bg-primary text-white text-[10px] uppercase px-[4px] leading-none"><?= $cart->p_size ?></span>
                        <p class="text-xs text-slate-500">&#8369; <span class="item-price"><?= $cart->p_price ?></span></p>
                      </div>
                    </div>
                    <div class="text-center">
                      <p class="text-sm text-black font-semibold">Qty</p>
                      <div class="flex items-center gap-4">
                        <button id="<?= $cart->cart_no ?>" data-id="<?= $cart->cart_id ?>" class="decrement minus-btn shrink-0 bg-gray-200 text-black text-xs font-semibold w-5 h-5 rounded-full"><i class="ri-subtract-line"></i></button>
                        <p id="items-counters-<?= $cart->cart_no ?>" class="item-counter text-xs text-slate-500"><?= $cart->quantity ?></p>
                        <button id="<?= $cart->cart_no ?>" data-id="<?= $cart->cart_id ?>" class="increment add-btn shrink-0 bg-gray-200 text-black text-xs font-semibold w-5 h-5 rounded-full"><i class="ri-add-line"></i></button>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              <?php else: ?>
                  <div class="min-h-[130px] flex flex-col items-center justify-center">
                    <img src="<?php echo SYSTEM_URL ?>/public/icons/icons8_shopping_bag.svg" alt="bag" class="w-8 h-8 mb-1">
                    <p class="text-sm text-black font-semibold mb-3">Your cart is empty</p>
                    <a href="<?php echo SYSTEM_URL ?>/menu" class="bg-light-pink text-xs text-primary font-semibold uppercase py-2 px-4 rounded-md">Add Item</a>
                  </div>
              <?php endif ?>
          </div>
          <div class="flex justify-between border-b border-b-gray-300/40 py-5 px-6">
            <p class="text-sm text-black">Amount Paid</p>
            <p class="text-sm text-black font-bold">&#8369; <span id="total-amount"></span></p>
          </div>
          <div class="relative border-b border-b-gray-300/40 py-5 px-6">
            <p class="text-sm text-black font-semibold">Payment Information</p>
            <p class="text-xs text-slate-500">Kindly select the order type and payment method you prefer.</p>
          </div>
          <form class="py-5 px-6">
            <label for="order_type" class="block text-sm font-semibold text-black mb-2">Type of Order</label>
            <div class="flex flex-wrap gap-3 mb-4">
              <input type="hidden" name="order_type" id="order-type">
              <div class="group order-type" role="button" data-value="Dine In">
                <img src="<?php echo SYSTEM_URL ?>/public/icons/selected.svg" alt="check" class="hidden group-[.selected]:block w-4 h-4 pointer-events-none">
                <p class="text-sm text-black font-semibold pointer-events-none">Dine In</p>
              </div>
              <div class="group order-type" role="button" data-value="Take Out">
                <img src="<?php echo SYSTEM_URL ?>/public/icons/selected.svg" alt="check" class="hidden group-[.selected]:block w-4 h-4 pointer-events-none">
                <p class="text-sm text-black font-semibold pointer-events-none">Take Out</p>
              </div>
              <div class="group order-type" role="button" data-value="Delivery">
                <img src="<?php echo SYSTEM_URL ?>/public/icons/selected.svg" alt="check" class="hidden group-[.selected]:block w-4 h-4 pointer-events-none">
                <p class="text-sm text-black font-semibold pointer-events-none">Delivery</p>
              </div>
            </div>
            <label for="payment_method" class="block text-sm font-semibold text-black mb-2">Payment Method</label>
            <div class="flex flex-wrap gap-3 mb-6">
              <input type="hidden" name="payment_method" id="payment-method">
              <div class="group pmethod" role="button" data-value="Over the Counter">
                <img src="<?php echo SYSTEM_URL ?>/public/icons/selected.svg" alt="check" class="hidden group-[.selected]:block w-4 h-4 pointer-events-none">
                <p class="text-sm text-black font-semibold pointer-events-none">Over the Counter</p>
              </div>
              <div class="group pmethod" role="button" data-value="Cash on Delivery">
                <img src="<?php echo SYSTEM_URL ?>/public/icons/selected.svg" alt="check" class="hidden group-[.selected]:block w-4 h-4 pointer-events-none">
                <p class="text-sm text-black font-semibold pointer-events-none">Cash on Delivery</p>
              </div>
            </div>
            <button type="button" id="placeOrder" class="w-full h-12 bg-primary text-white text-sm rounded-md">Place Order</button>
          </form>
        </div>
      </div>
    </section>
  </main>

<?php include 'Partials/footer.php'; ?>
