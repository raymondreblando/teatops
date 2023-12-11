<?php
require_once '../../init.php';

$database->DBQuery("SELECT * FROM `orders` LEFT JOIN `payments` ON orders.payment_id=payments.payment_id WHERE orders.user_id = ? ORDER BY orders.order_id DESC", [$_SESSION['uid']]);
$myOrders = $database->fetchAll();   
foreach($myOrders as $myOrder):
?>
    <div class="searchArea">
      <div class="border border-white bg-white/60 rounded-md overflow-hidden">
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
              $database->DBQuery("SELECT * FROM `my_order` LEFT JOIN `menu` ON my_order.menu_id=menu.menu_id LEFT JOIN `price` ON my_order.p_id=price.p_id LEFT JOIN `category` ON menu.category_id=category.category_id WHERE my_order.order_id = ?", [$myOrder->order_id]);
              $myItems = $database->fetchAll();   
              foreach($myItems as $myItem):
          ?>
              <div class="flex justify-between py-2">
                <div class="flex gap-3">
                  <div class="w-12">
                    <img src="<?= SYSTEM_URL."/uploads/menu/".$myItem->menu_photo ?>" alt="<?= $myItem->menu_name ?>" class="h-12">
                  </div>
                  <div>
                    <p class="text-sm text-black font-semibold finder5"><?= $myItem->menu_name ?></p>
                    <p class="text-xs text-primary font-semibold finder5"><?= $myItem->category_name ?></p>
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