<?php
$page_title = "Teatops";
$tab_active = "Homepage";

require_once("./init.php");

include 'Partials/header.php';

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="bg-light-pink">
    <?php include 'Partials/navigation.php'; ?>
    <section class="bg-light-pink overflow-hidden">
      <div class="w-[min(1200px,80%)] min-h-screen flex items-center flex-col md:flex-row mx-auto pt-24 pb-10">
        <div class="flex-1">
          <h1 class="text-7xl text-center md:text-left font-bold leading-[5rem] mb-6" data-aos="fade-up"><span class="text-primary">Milktea everyday</span> Teatops all the way</h1>
          <p class="w-[min(28rem,100%)] text-lg text-center md:text-left text-light-black font-ubuntu mb-12" data-aos="fade-up">Sip the stars: Indulge in milky magic with our exquisite milk tea creations.</p>
          <button onclick="window.location.href='<?php echo SYSTEM_URL ?>/menu'" class="block bg-primary text-white font-medium py-4 px-8 rounded-md mx-auto md:mx-0" data-aos="fade-up">Order Now</button>
        </div>
        <div class="flex-1">
          <img src="<?php echo SYSTEM_URL ?>/public/images/hero-image.svg" alt="hero image" class="w-full" data-aos="fade-up">
        </div>
      </div>
    </section>
    <!-- <img src="<?php echo SYSTEM_URL ?>/public/images/wave.svg" alt="wave"> -->
    <section class="w-[min(1200px,80%)] pt-4 pb-16 mx-auto overflow-hidden">
      <!-- <?php 
            $database->DBQuery("SELECT m.menu_id, m.menu_no, m.menu_name, m.menu_photo, m.category_id, c.category_name, SUM(mo.quantity) AS total_quantity FROM menu m JOIN my_order mo ON m.menu_id = mo.menu_id LEFT JOIN category c ON m.category_id=c.category_id GROUP BY m.menu_id, m.menu_name HAVING total_quantity >= 5 ORDER BY total_quantity DESC LIMIT 5");
            if($database->rowCount() > 0):
      ?>
            <h3 class="text-3xl text-center font-bold text-gray-800 mb-2" data-aos="fade-up">Best Seller</h3>
            <p class="font-medium text-center text-gray-700 mb-6" data-aos="fade-up">Embrace the Irresistible: Discover Why Our Best-Selling is the Talk of the Town</p>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-32">
              <?php foreach($database->fetchAll() as $bestSeller): ?>
                  <div class="menu-card relative bg-white/50 py-8 px-10 rounded-2xl" data-aos="fade-up">
                    <span class="price-container-<?= $bestSeller->menu_no ?> hidden absolute top-8 right-12 border-2 border-white bg-primary w-10 h-10 text-white text-[10px] font-medium rounded-full text-center leading-10 finder2">&#8369; <span class="size-price-<?= $bestSeller->menu_no ?>"></span></span>
                    <img src="<?= SYSTEM_URL."/uploads/menu/".$bestSeller->menu_photo ?>" alt="<?= $bestSeller->menu_name ?>" class="h-[150px] mb-3 mx-auto">
                    <p class="text-[13px] text-black uppercase font-semibold text-center mt-2 tracking-tighter finder1"><?= $bestSeller->menu_name ?></p>
                    <p class="text-[11px] text-primary uppercase font-bold text-center mb-2 tracking-tighter"><?= $bestSeller->category_name ?></p>
                    <input type="hidden" class="selected-size-<?= $bestSeller->menu_no ?>" hidden>
                    <p class="text-[9px] uppercase font-bold mb-1 text-center tracking-tighter">Choose a size</p>
                    <div class="flex justify-center items-center gap-2 mb-4">
                        <?php
                          $database->DBQuery("SELECT * FROM `price` WHERE `category_id`= ?", [$bestSeller->category_id]);
                          $sizes = $database->fetchAll();
                          foreach($sizes as $size):
                      ?>
                          <span role="button" data-id="<?= $size->p_id ?>" data-no="<?= $bestSeller->menu_no ?>" data-price="<?= $size->p_price ?>" class="menu-size"><?= $size->p_size ?></span>
                      <?php endforeach ?>
                    </div>
                    <?php if(isset($_SESSION["uid"]) && isset($_SESSION["loggedin"])): ?>
                        <?php if($bestSeller->menu_stock > 0): ?>
                          <button data-id="<?= $bestSeller->menu_id ?>" data-no="<?= $bestSeller->menu_no ?>" class="saveOrder block bg-primary text-white text-xs py-2 px-4 rounded-md mx-auto">Order Now</button>
                        <?php else: ?>
                          <span class="block w-fit bg-gray-200 text-black text-xs py-2 px-4 rounded-md mx-auto">Sold Out</span>
                        <?php endif ?>
                    <?php else: ?>
                        <button class="login-btn block bg-primary text-white text-xs py-2 px-4 rounded-md mx-auto">Order Now</button>
                    <?php endif ?>
                  </div>
              <?php endforeach ?>
            </div>
      <?php endif ?> -->

      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">Our Menus</h3>
      <p class="font-medium text-center text-gray-700 mb-12" data-aos="fade-up">Steeped Perfection: Delve into a World of Flavor with Our Diverse Menu</p>
      <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <?php 
            $database->DBQuery("SELECT * FROM `menu` m LEFT JOIN `category` c ON m.category_id=c.category_id ORDER BY m.menu_no DESC");
            $menus = $database->fetchAll();
            foreach($menus as $menu):
        ?>
            <div class="searchArea itemBox <?= $menu->category_id ?>">
              <div class="menu-card relative bg-white/50 py-8 px-10 rounded-2xl">
                <span class="price-container-<?= $menu->menu_no ?> hidden absolute top-8 right-12 border-2 border-white bg-primary w-10 h-10 text-white text-[10px] font-medium rounded-full text-center leading-10 finder2">&#8369; <span class="size-price-<?= $menu->menu_no ?>"></span></span>
                <img src="<?= SYSTEM_URL."/uploads/menu/".$menu->menu_photo ?>" alt="tea" class="h-[150px] mb-3 mx-auto">
                <p class="text-[13px] text-black uppercase font-semibold text-center mt-2 tracking-tighter finder1"><?= $menu->menu_name ?></p>
                <p class="text-[11px] text-primary uppercase font-bold text-center mb-2 tracking-tighter"><?= $menu->category_name ?></p>
                <?php 
                  $database->DBQuery("SELECT * FROM `addons` WHERE `category_id`=?", [$menu->category_id]);

                  if($database->rowCount() > 0){
                    echo '<p class="text-[9px] uppercase font-bold mb-1 text-center tracking-tighter">Addons</p>';
                  }
                ?>
                
                <div class="flex flex-wrap justify-center items-center gap-2 mb-4">
                  <?php
                      if($database->rowCount() > 0){
                        foreach($database->fetchAll() as $addon){
                            echo '<span role="button" class="addons menu-addons addons-price-'. $menu->menu_no .'" data-name="'. $addon->addons_name .'" data-no="'. $menu->menu_no .'" data-price="'. $addon->addons_price .'">'.$addon->addons_name.'</span>';
                        }
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
                    <?php if($_SESSION["role"] === "968375857"): ?>
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
      <a href="<?php echo SYSTEM_URL ?>/menu" class="block w-fit text-xs font-semibold mt-16 bg-white py-3 px-6 rounded-full mx-auto uppercase" data-aos="fade-down">Browse All</a>
    </section>
    <!-- <img src="<?php echo SYSTEM_URL ?>/public/images/wave-reverse.svg" alt="wave"> -->
    <section class="bg-light-pink overflow-hidden">
      <div class="w-[min(1200px,80%)] flex items-center flex-col md:flex-row mx-auto pb-10">
        <div class="flex-1 flex justify-center" data-aos="fade-right">
          <img src="<?php echo SYSTEM_URL ?>/public/images/contact-us.png" alt="contact image" class="w-[60%]">
        </div>
        <div class="flex-1" data-aos="fade-left">
          <h1 class="text-5xl text-center md:text-left font-bold mb-2">Get In Touch With Us</h1>
          <p class="text-lg text-center md:text-left text-light-black font-ubuntu mb-8">Stay in touch: We are happy to serve you</p>
          <p class="text-lg text-center md:text-left text-light-black font-bold font-ubuntu mb-2">Store Hours</p>
          <p class="text-base text-center md:text-left text-light-black font-ubuntu mb-2">11 AM - 9:00 PM Monday - Friday</p>
          <p class="text-base text-center md:text-left text-light-black font-ubuntu mb-8">11:30 AM - 8:30 PM Saturday</p>
          <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/call-bold.svg" alt="call" class="w-5 h-5">
            <p class="text-lg text-light-black font-ubuntu">+639531849449</p>
          </div>
          <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/sms-bold.svg" alt="email" class="w-5 h-5">
            <p class="text-lg text-light-black font-ubuntu">sartefrancisjohn@gmail.com</p>
          </div>
          <div class="flex items-center justify-center md:justify-start gap-2 mb-2">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/discover-bold.svg" alt="address" class="w-5 h-5">
            <p class="text-lg text-center md:text-left text-light-black font-ubuntu">San Juan Street. Centro Oriental, Polangui, Philippines, 4506</p>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include 'Partials/modal.php'; ?>
<?php include 'Partials/footer.php'; ?>