<?php
$page_title = "Our Menu";
$tab_active = "Menu";

require_once("./init.php");

include 'Partials/header.php';

$database->DBQuery("SELECT * FROM `menu` WHERE `menu_id`=?",[$id]);
$menu_detail = $database->fetch(); 

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="flex items-center justify-center bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">Update Menu Details</h3>
      <p class="font-medium text-center text-gray-700 mb-12" data-aos="fade-up">To update the menu, kindly provide the need information below.</p>

      <div class="max-w-[700px] flex items-center mx-auto mb-6 gap-3" data-aos="fade-up">
        <form autocomplete="off" class="w-full">
          <div class="grid md:grid-cols-2 gap-4">
            <div class="upload-container h-[300px] relative bg-white rounded-lg cursor-pointer p-6">
              <input type="file" id="product_img" class="upload-input" hidden>
              <img src="<?php echo SYSTEM_URL."/uploads/menu/".$menu_detail->menu_photo ?>" alt="profile" class="upload-overview w-full h-full object-contain pointer-events-none" id="product_image">
              <div class="icon absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 pointer-events-none" hidden>
                <img src="<?php echo SYSTEM_URL ?>/public/icons/gallery-add-linear.svg" alt="gallery" class="w-10 h-10 mx-auto mb-2 pointer-events-none">
                <p class="text-sm font-semibold pointer-events-none text-center">Browse your device</p>
              </div>
            </div>
            <div>
              <label for="menu_name" class="block text-sm font-semibold text-gray-600 mb-1">Menu Name</label>
              <input type="text" id="menu_name" value="<?php echo $menu_detail->menu_name ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-4">
              <label for="category" class="block text-sm font-semibold text-gray-600 mb-1">Category</label>
              <select id="category" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 text-slate-500 text-sm mb-4">
                <option value="">Select Category</option>
                <?php 
                    $selected = $menu_detail->category_id;

                    $database->DBQuery("SELECT * FROM `category`");
                    foreach ($database->fetchAll() as $category) {
                      $options[$category->category_id] = $category->category_name;
                    };

                    foreach($options as $key => $value){
                      if($selected == $key){
                            echo '<option selected="selected" value="'.$key.'">'.$value.'</option>';
                      }else{
                            echo '<option value="'.$key.'">'.$value.'</option>';
                      }
                    }
                ?>
              </select>
              <div class="mb-4">
                <label for="stocks" class="block text-sm font-semibold text-gray-600 mb-1">Stocks</label>
                <input type="text" id="stocks" value="<?php echo $menu_detail->menu_stock ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
              </div>
              <button type="button" data-id="<?php echo $id; ?>" id="updateMenu" class="block w-full md:w-fit bg-primary text-white font-medium py-3 px-8 rounded-md">Update</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>