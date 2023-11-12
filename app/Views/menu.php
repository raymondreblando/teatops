<?php
$page_title = "Our Menu";
$tab_active = "Menu";

require_once("./init.php");

include 'Partials/header.php';
?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">Our Menus</h3>
      <p class="font-medium text-center text-gray-700 mb-8" data-aos="fade-up">Steeped Perfection: Delve into a World of Flavor with Our Diverse Menu</p>

      <div class="max-w-[480px] flex items-center mx-auto mb-6 gap-3" data-aos="fade-up">
        <div class="w-full h-14 flex items-center bg-white px-6 rounded-md">
          <input type="text" id="searchDiv" class="w-full h-full font-medium bg-transparent outline-none placeholder:text-gray-600" placeholder="Search menu here.." autocomplete="off">
          <img src="<?php echo SYSTEM_URL ?>/public/icons/search-normal-linear.svg" alt="search" class="w-5 h-5">
        </div>
        <?php if(isset($_SESSION["uid"]) AND isset($_SESSION["loggedin"])): ?>
          <?php if($_SESSION["role"] == "968375857" AND $_SESSION["uid"] == "9d2744d8-90db-4736-a590-27de52a941ee"): ?>
            <a href="<?php echo SYSTEM_URL ?>/add-menu" class="bg-primary text-white py-3 px-4 rounded-full" title="Add New Menu"><i class="ri-add-fill"></i></a>
          <?php endif ?>
        <?php endif ?>
      </div>
      

      <div class="category-wrapper max-w-[750px] flex justify-start md:justify-center items-center gap-6 mx-auto overflow-x-auto mb-8" data-aos="fade-up">
      <?php if(isset($_SESSION["uid"]) AND isset($_SESSION["loggedin"])): ?>
          <?php if($_SESSION["role"] == "968375857" AND $_SESSION["uid"] == "9d2744d8-90db-4736-a590-27de52a941ee"): ?>
            <a href="<?php echo SYSTEM_URL ?>/add-category" class="group category">
              <div class="grid place-items-center w-12 h-12 rounded-full border-2 border-white group-[.active]:border-none">
                <i class="ri-add-fill"></i>
              </div>
              <p class="text-xs font-semibold text-center text-gray-700">Add</p>
            </a>
          <?php endif ?>
        <?php endif ?>
        <a href="javascript:void(0)" class="list" data-filter="all">
          <div class="group category active">
            <div class="grid place-items-center w-12 h-12 rounded-full border border-gray-300/50 group-[.active]:border-none">
              <img src="<?php echo SYSTEM_URL ?>/public/icons/halal_food.svg" alt="all" class="w-8 h-8">
            </div>
            <p class="text-xs font-semibold text-center text-gray-700">All</p>
          </div>
        </a>
        <?php
             $database->DBQuery("SELECT * FROM `category`");
             $category = $database->fetchAll();   
             foreach($category as $categories):
        ?>
            <a href="javascript:void(0)" class="list" data-filter="<?= $categories->category_id ?>">
                <div class="group category" >
                  <div class="grid place-items-center w-12 h-12 rounded-full border border-white">
                    <img src="<?= SYSTEM_URL."/uploads/category/".$categories->category_icon ?>" alt="<?= $categories->category_name ?>" class="w-8 h-8">
                  </div>
                  <p class="text-xs font-semibold text-center text-gray-700"><?= $categories->category_name ?></p>
                </div>
            </a>
        <?php endforeach ?>
      </div>

      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <?php 
            $database->DBQuery("SELECT * FROM `menu`");
            $menus = $database->fetchAll();
            foreach($menus as $menu):
        ?>
            <div class="searchArea itemBox <?= $menu->category_id ?>">
              <div class="menu-card relative bg-white/50 py-8 px-10 rounded-2xl">
                <span class="price-container-<?= $menu->menu_no ?> hidden absolute top-8 right-12 border-2 border-white bg-primary w-10 h-10 text-white text-[10px] font-medium rounded-full text-center leading-10 finder2">&#8369; <span class="size-price-<?= $menu->menu_no ?>"></span></span>
                <img src="<?= SYSTEM_URL."/uploads/menu/".$menu->menu_photo ?>" alt="tea" class="h-[150px] mb-3 mx-auto">
                <p class="text-[13px] text-black uppercase font-semibold text-center mt-2 mb-2 tracking-tighter finder1"><?= $menu->menu_name ?></p>
                
                <p class="text-[9px] uppercase font-bold mb-1 text-center tracking-tighter">Addons</p>
                <div class="flex flex-wrap justify-center items-center gap-2 mb-4">
                  <?php
                      $database->DBQuery("SELECT * FROM `addons` WHERE `category_id`=?", [$menu->category_id]);
                      if($database->rowCount() > 0){
                        foreach($database->fetchAll() as $addon){
                            echo '<span role="button" class="addons menu-addons addons-price-'. $menu->menu_no .'" data-name="'. $addon->addons_name .'" data-no="'. $menu->menu_no .'" data-price="'. $addon->addons_price .'">'.$addon->addons_name.'</span>';
                        }
                      }else{
                        echo '<p class="text-[10px] font-bold mb-1 text-center">No available addons</p>';
                      }
                  ?>
                </div>

                <p class="text-[9px] uppercase font-bold mb-1 text-center tracking-tighter">Choose a size</p>
                <div class="flex justify-center items-center gap-2 mb-4">
                  <?php
                      $database->DBQuery("SELECT * FROM `price` WHERE `category_id`=?", [$menu->category_id]);
                      foreach($database->fetchAll() as $size){
                        echo '<span role="button" class="menu-size menu-price-'. $menu->menu_no .'" data-id="'. $size->p_id .'" data-no="'. $menu->menu_no .'" data-price="'. $size->p_price .'">'. $size->p_size .'</span>';
                      }
                  ?>
                </div>
                <?php if(isset($_SESSION["uid"]) && isset($_SESSION["loggedin"])): ?>
                    <?php if($_SESSION["role"] == "968375857"): ?>
                      <button onclick="window.location.href='<?= SYSTEM_URL.'/update-menu/'.$menu->menu_id ?>'" class="block bg-primary text-white text-xs py-2 px-4 rounded-md mx-auto">Update Item</button>
                    <?php else: ?>
                      <?php if($menu->menu_stock > 0): ?>
                        <button data-id="<?= $menu->menu_id ?>" data-no="<?= $menu->menu_no ?>" class="saveOrder block bg-primary text-white text-xs py-2 px-4 rounded-md mx-auto">Order Now</button>
                      <?php else: ?>
                        <span class="block w-fit bg-gray-200 text-black text-xs py-2 px-4 rounded-md mx-auto">Sold Out</span>
                      <?php endif ?>
                    <?php endif ?>
                <?php else: ?>
                    <button class="login-btn block bg-primary text-white text-xs py-2 px-4 rounded-md mx-auto">Order Now</button>
                <?php endif ?>
              </div>
            </div>
        <?php endforeach ?>
      </div>
    </section>
  </main>

  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>