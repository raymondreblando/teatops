<?php
$page_title = "Accounts";
$tab_active = "Accounts";

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
      <div class="flex items-center justify-between gap-4 mb-6">
        <select id="filterDropdown" class="w-full md:w-48 h-12 rounded-md outline-none px-4 text-black text-sm">
          <option value="">Filter By</option>
          <option value="all">All Accounts</option>
          <option value="yes">Active Accounts</option>
          <option value="no">Block Accounts</option>
        </select>
        <button class="search-btn grid place-items-center w-12 h-12 bg-white rounded-full">
          <img src="<?php echo SYSTEM_URL ?>/public/icons/search-normal-linear.svg" alt="search" class="w-4 h-4">
        </button>
      </div>
      
      <div class="hidden searchbar fixed top-28 left-1/2 -translate-x-1/2 w-[min(18rem,90%)] items-center mx-auto mb-8 gap-3">
        <div class="w-full h-14 flex items-center bg-white px-6 rounded-md">
          <input type="text" id="searchTable" class="w-full h-full font-medium bg-transparent outline-none placeholder:text-gray-600" placeholder="Search orders here.." autocomplete="off">
          <img src="<?php echo SYSTEM_URL ?>/public/icons/search-normal-linear.svg" alt="search" class="w-5 h-5">
        </div>
      </div>

      <div class="bg-white rounded-md overflow-auto mb-6">
        <table id="my-table" class="w-full border-collapse border-spacing-4 text-left whitespace-nowrap">
          <thead>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40 hidden" hidden>Active</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">No.</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Fullname</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Gender</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Contact Number</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Address</th>
            <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">ID</th>
            <th width="13%" class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Action</th>
          </thead>
          <tbody>
            <?php
                $number = 1;
                $database->DBQuery("SELECT * FROM `users` LEFT JOIN `role` ON users.role_id=role.role_id WHERE users.built_in = 'no' ORDER BY users.user_no DESC");
                $accounts = $database->fetchAll();   
                foreach($accounts as $account):
            ?>
              <tr class="bg-white">
                <td class="text-sm py-4 px-4 hidden" hidden><?= $account->active ?></td>
                <td class="text-sm py-4 px-4"><?= $number++ ?></td>
                <td class="text-sm py-4 px-4">
                  <div class="flex items-center gap-2">
                    <img src="<?= SYSTEM_URL."/public/images/".$account->gender.".svg" ?>" alt="profile" class="w-9 h-9">
                    <div>
                      <p class="text-sm text-black font-semibold"><?= $account->fullname ?></p>
                      <p class="text-xs text-slate-500"><?= $account->role_name ?></p>
                    </div>
                  </div>
                </td>
                <td class="text-sm py-4 px-4"><?= $account->gender ?></td>
                <td class="text-sm py-4 px-4"><?= $account->contact ?></td>
                <td class="text-sm py-4 px-4"><?= $account->address ?></td>
                <td class="text-sm py-4 px-4">
                  <a href="<?= SYSTEM_URL ?>/id/<?= $account->user_id ?>" class="text-[10px] text-primary font-semibold uppercase bg-light-pink py-2 px-3 rounded-sm">View ID</a>
                </td>
                <td class="text-sm py-4 px-4">
                  <?php if($account->active === "no"): ?>
                      <button type="button" data-value="yes"  data-identifier="<?= $account->user_id ?>" class="block_unblock block w-full bg-emerald-600 text-white py-2 px-4 rounded-md">Unblock Account</button>
                  <?php else: ?>
                        <button type="button" data-value="no" data-identifier="<?= $account->user_id ?>" class="block_unblock block w-full bg-rose-500 text-white py-2 px-4 rounded-md">Block Account</button>
                  <?php endif ?>
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