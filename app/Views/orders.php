<?php
$page_title = "Orders";
$tab_active = "Orders";

require_once("./init.php");

include 'Partials/header.php';

$redirect->checkLoggedIn(SYSTEM_URL);
$redirect->redirectNotAdmin(SYSTEM_URL);
?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <select id="filterDropdown" class="w-full md:w-48 h-12 rounded-md outline-none px-4 text-black text-sm">
          <option value="">Filter By</option>
          <option value="all">All Orders</option>
          <option value="Pending">Pending</option>
          <option value="Confirmed">Confirmed</option>
          <option value="Delivering">Delivering</option>
          <option value="Completed">Completed</option>
          <option value="Cancelled">Cancelled</option>
        </select>
        <div class="w-full md:w-auto flex items-center gap-4">
          <button class="search-btn grid place-items-center w-12 h-12 bg-white rounded-full">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/search-normal-linear.svg" alt="search" class="w-4 h-4">
          </button>
          <div class="relative w-full md:w-[10rem] h-12 grid place-items-center bg-white rounded-md px-6">
            <input type="date" id="filterDate" class="date-filter w-full text-xs appearance-none uppercase outline-none">
            <div class="absolute top-1/2 -translate-y-1/2 right-6 bg-white pointer-events-none">
              <img src="<?php echo SYSTEM_URL ?>/public/icons/calendar-2-linear.svg" alt="calendar" class="w-4 h-4 pointer-events-none">
            </div>
          </div>
        </div>
      </div>
      
      <div class="hidden searchbar fixed top-28 left-1/2 -translate-x-1/2 w-[min(18rem,90%)] items-center mx-auto mb-8 gap-3">
        <div class="w-full h-14 flex items-center bg-white px-6 rounded-md">
          <input type="text" id="searchTable" class="w-full h-full font-medium bg-transparent outline-none placeholder:text-gray-600" placeholder="Search orders here.." autocomplete="off">
          <img src="<?php echo SYSTEM_URL ?>/public/icons/search-normal-linear.svg" alt="search" class="w-5 h-5">
        </div>
      </div>

      <div class="bg-white rounded-md overflow-auto mb-4">
        <table id="my-table" class="w-full border-collapse border-spacing-4 text-left whitespace-nowrap table-auto">
          <thead>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40 hidden" hidden>Status</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40 hidden" hidden>Date</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Order #</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Date Order</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Fullname</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Type</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Payment</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Amount</th>
            <th width="18%" class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Action</th>
          </thead>
          <tbody>
            <?php
              $database->DBQuery("SELECT * FROM `orders` LEFT JOIN `payments` ON orders.order_id=payments.order_id LEFT JOIN `users` ON orders.user_id=users.user_id LEFT JOIN `role` ON users.role_id=role.role_id ORDER BY orders.order_no DESC");
              $orders = $database->fetchAll();   
              foreach($orders as $order):
            ?>
                <tr class="bg-white">
                  <td class="text-sm py-4 px-4 hidden" hidden><?= $order->order_status ?></td>
                  <td class="text-sm py-4 px-4 hidden" hidden><?= $functions->formatDateTime($order->order_date, "Y-m-d")  ?></td>
                  <td class="text-sm py-4 px-4"><?= $order->order_id ?></td>
                  <td class="text-sm py-4 px-4"><?= $functions->formatDateTime($order->order_date, "M d, Y - h:s A") ?></td>
                  <td class="text-sm py-4 px-4">
                    <div class="w-max flex items-center gap-2">
                      <img src="<?= SYSTEM_URL."/public/images/".$order->gender.".svg" ?>" alt="profile" class="w-9 h-9">
                      <div>
                        <p class="text-sm text-black font-semibold"><?= $order->fullname ?></p>
                        <p class="text-xs text-slate-500"><?= $order->role_name ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="text-sm py-4 px-4"><?= $order->order_type ?></td>
                  <td class="text-sm py-4 px-4"><?= $order->payment_type ?></td>
                  <td class="text-sm py-4 px-4">&#8369;<?= $order->amount ?></td>
                  <td class="text-sm py-4 px-4">
                    <div class="flex items-center gap-3">
                      <a href="<?= SYSTEM_URL."/order-details/". $order->order_id ?>" class="shrink-0 w-7 h-7 grid place-items-center bg-primary text-white rounded-full" title="Order Items">
                        <img src="<?= SYSTEM_URL ?>/public/icons/bag-2-linear.svg" alt="bag" class="w-4 h-4">
                      </a>
                      <div class="relative w-36 h-10 border border-gray-300/400 rounded-md px-4">
                        <select data-id="<?= $order->order_id ?>" class="changeStatus w-full h-10 outline-none text-black text-sm appearance-none">
                          <?php 
                              $selected = $order->order_status;
                              $options = array("Pending","Confirmed","Delivering","Completed","Cancelled");
                              foreach($options as $option){
                                if($selected == $option){
                                      echo '<option selected="selected" value="'.$option.'">'.$option.'</option>';
                                }else{
                                      echo '<option value="'.$option.'">'.$option.'</option>';
                                }
                              }
                          ?>
                        </select>
                        <img src="<?= SYSTEM_URL ?>/public/icons/arrow-down-linear.svg" alt="arrow" class="absolute top-1/2 -translate-y-1/2 right-4 w-4 h-4">
                      </div>
                    </div>
                  </td>
                </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <div id="pagination"></div>
    </section>
  </main>

<?php include 'Partials/footer.php'; ?>