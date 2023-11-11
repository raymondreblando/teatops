<?php
$page_title = "Create Category";
$tab_active = "Menu";

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
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">Create New Category</h3>
      <p class="font-medium text-center text-gray-700 mb-8" data-aos="fade-up">To create a new category, kindly provide the need information below.</p>

      <div class="max-w-[400px] flex items-center mx-auto mb-6 gap-3" data-aos="fade-up">
        <form autocomplete="off" class="w-full">
          <label for="product_img" class="block text-sm font-semibold text-gray-600 mb-2">Category Icon</label>
          <div class="upload-container h-[250px] relative bg-white rounded-lg cursor-pointer mb-2 p-6">
            <input type="file" id="product_img" class="upload-input" hidden>
            <img src="" alt="profile" class="upload-overview w-full h-full object-contain pointer-events-none" id="product_image" hidden>
            <div class="icon absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 pointer-events-none">
              <img src="<?php echo SYSTEM_URL ?>/public/icons/gallery-add-linear.svg" alt="gallery" class="w-10 h-10 mx-auto mb-2 pointer-events-none">
              <p class="text-sm font-semibold pointer-events-none text-center">Browse your device</p>
            </div>
          </div>
          <label for="category_name" class="block text-sm font-semibold text-gray-600 mb-1">Category Name</label>
          <input type="text" id="category_name" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-4">
          
          <div class="bg-white rounded-md overflow-auto mb-4">
            <p class="text-center py-4">Category Size & Price</p>
            <table id="my-table-1" class="w-full border-collapse border-spacing-4 text-left whitespace-nowrap table-auto">
              <thead>
                <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Size</th>
                <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Price</th>
                <th width="18%" class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Action</th>
              </thead>
                <tbody></tbody>
            </table>
          </div>
          <div data-cell-count="2" data-table-name="my-table-1" class="add-row-button grid place-items-center mx-auto w-12 h-12 mb-3 rounded-full text-xl bg-primary cursor-pointer text-white group-[.active]:border-none">
            <i class="ri-add-circle-line"></i>
          </div>

          <div class="bg-white rounded-md overflow-auto mb-4">
            <p class="text-center py-4">Addons & Price</p>
            <table id="my-table-2" class="w-full border-collapse border-spacing-4 text-left whitespace-nowrap table-auto">
              <thead>
                <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Name</th>
                <th class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Price</th>
                <th width="18%" class="text-xs uppercase text-gray-700 py-4 px-4 border-b border-b-gray-300/40">Action</th>
              </thead>
                <tbody></tbody>
            </table>
          </div>
          <div data-cell-count="2" data-table-name="my-table-2" class="add-row-button grid place-items-center mx-auto w-12 h-12 mb-3 rounded-full text-xl bg-primary cursor-pointer text-white group-[.active]:border-none">
            <i class="ri-add-circle-line"></i>
          </div>

          <button type="button" id="saveCategory" class="block w-full bg-primary text-white font-medium py-3 px-8 rounded-md">Create</button>
        </form>
      </div>
    </section>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>