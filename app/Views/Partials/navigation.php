<?php

if(isset($_SESSION["uid"]) AND isset($_SESSION["loggedin"])){
       $database->DBQuery("SELECT * FROM `users` LEFT JOIN `role` ON users.role_id=role.role_id WHERE `user_id`=?",[$_SESSION["uid"]]);
       $user_data = $database->fetch();  
       
       $database->DBQuery("SELECT `cart_no` FROM `cart_items` WHERE `user_id`=?",[$_SESSION['uid']]);
       $cartCount = $database->rowCount();
}

?>
    <header class="fixed top-0 inset-x-0 bg-white/50 backdrop-blur-md z-10 border-b border-gray-300/40">
       <nav class="header__nav">
              <div class="flex items-center gap-2">
                     <img src="<?php echo SYSTEM_URL ?>/public/images/logo.png" alt="logo" class="hidden md:block w-10 h-10">
                     <p class="text-xl font-bold uppercase tracking-wider"><span class="text-primary">Tea</span>tops</p>
              </div>
              <div class="header__menu">
                     <button class="close-menu block md:hidden absolute top-6 right-10">
                            <i class="ri-close-line text-xl"></i>
                     </button>
                     <ul class="flex flex-col md:flex-row items-center gap-7">
                            <?php if(!isset($_SESSION["uid"]) AND !isset($_SESSION["loggedin"])): ?>
                                   <li><a href="<?php echo SYSTEM_URL ?>" class="header__link <?php echo $tab_active == 'Homepage' ? 'active' : '' ?>">Home</a></li>
                            <?php endif ?>

                            <li><a href="<?php echo SYSTEM_URL ?>/menu" class="header__link <?php echo $tab_active == 'Menu' ? 'active' : '' ?>">Menu</a></li>
                            
                            <?php if(isset($_SESSION["uid"]) AND isset($_SESSION["loggedin"])): ?>
                                   <?php if($_SESSION["role"] != "968375857"): ?>
                                          <li><a href="<?php echo SYSTEM_URL ?>/my_orders" class="header__link <?php echo $tab_active == 'My Orders' ? 'active' : '' ?>">My Orders</a></li>
                                          <li><a href="<?php echo SYSTEM_URL ?>/profile" class="header__link <?php echo $tab_active == 'Profile' ? 'active' : '' ?>">Profile</a></li>
                                          <div class="notification relative grid place-items-center w-9 h-9 bg-secondary/20 rounded-full cursor-pointer">
                                                 <img src="<?php echo SYSTEM_URL ?>/public/icons/bell.svg" alt="notification" class="w-4 h-4">

                                                 <?php 
                                                        $database->DBQuery("SELECT * FROM `notification` WHERE `n_seen`='no' AND `n_to`=?", [$_SESSION['uid']]);

                                                        if($database->rowCount() > 0){
                                                               echo '<span class="animate-ping absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>
                                                                      <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>';
                                                        }
                                                 ?>

                                                 <div class="hidden notification-dropdown absolute top-[160%] left-1/2 -translate-x-1/2 w-[220px] max-w-[220px] bg-white rounded-sm p-4 cursor-auto">
                                                        <p class="text-sm text-black font-semibold mb-2">Notifications</p>
                                                        <div class="custom-scroll max-h-[200px] overflow-y-auto">
                                                               <?php 
                                                                      $database->DBQuery("SELECT * FROM `notification` WHERE `n_to`=? ORDER BY `n_no` DESC", [$_SESSION['uid']]);
                                                                      if($database->rowCount() > 0){
                                                                             foreach($database->fetchAll() as $notification){
                                                                                    echo '<p class="text-xs text-gray-500 font-semibold py-2">'.$notification->n_msg.'</p>';
                                                                             }
                                                                      }else{
                                                                             echo '<p class="text-xs text-center text-gray-500 font-semibold py-2">No notification found!</p>';
                                                                      } 
                                                               ?>
                                                        </div>
                                                 </div>
                                          </div>
                                          <li class="relative">
                                                 <a href="<?php echo SYSTEM_URL ?>/cart" class="header__link">
                                                 <img src="<?php echo SYSTEM_URL ?>/public/icons/bag-2-linear.svg" alt="cart" class="w-5 h-5"></a>
                                                 <span id="badgeCart" class="<?php if($cartCount === 0){echo 'hidden';} ?> absolute -top-[6px] -right-[12px] bg-primary text-[9px] text-white font-semibold py-[4px] px-[6px] rounded-full pointer-events-none"><p id="countCart"><?php echo $cartCount; ?></p></span>
                                          </li>
                                   <?php else: ?>
                                          <li><a href="<?php echo SYSTEM_URL ?>/orders" class="header__link <?php echo $tab_active == 'Orders' ? 'active' : '' ?>">Orders</a></li>
                                          <li><a href="<?php echo SYSTEM_URL ?>/accounts" class="header__link <?php echo $tab_active == 'Accounts' ? 'active' : '' ?>">Accounts</a></li>
                                          <li><a href="<?php echo SYSTEM_URL ?>/profile" class="header__link <?php echo $tab_active == 'Profile' ? 'active' : '' ?>">Profile</a></li>

                                          <div class="notification relative grid place-items-center w-9 h-9 bg-secondary/20 rounded-full cursor-pointer">
                                                 <img src="<?php echo SYSTEM_URL ?>/public/icons/bell.svg" alt="notification" class="w-4 h-4">

                                                 <?php 
                                                        $database->DBQuery("SELECT * FROM `notification` WHERE `n_seen`='no' AND `n_to`='Admin'");

                                                        if($database->rowCount() > 0){
                                                               echo '<span class="animate-ping absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>
                                                                      <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>';
                                                        }
                                                 ?>

                                                 <div class="hidden notification-dropdown absolute top-[160%] left-1/2 -translate-x-1/2 w-[220px] max-w-[220px] bg-white rounded-sm p-4 cursor-auto">
                                                        <p class="text-sm text-black font-semibold mb-2">Notifications</p>
                                                        <div class="custom-scroll max-h-[200px] overflow-y-auto">
                                                               <?php 
                                                                      $database->DBQuery("SELECT `menu_name`,`menu_stock` FROM `menu` WHERE `menu_stock` < 20");
                                                                      if($database->rowCount() > 0){
                                                                             foreach($database->fetchAll() as $stock){
                                                                                    echo '<p class="text-xs text-gray-500 font-semibold py-2">The stocks for the '.$stock->menu_name.' is getting low.</p>';
                                                                             }
                                                                      }

                                                                      $database->DBQuery("SELECT * FROM `notification` WHERE `n_to`='Admin' ORDER BY `n_no` DESC");
                                                                      if($database->rowCount() > 0){
                                                                             foreach($database->fetchAll() as $notification){
                                                                                    echo '<p class="text-xs text-gray-500 font-semibold py-2">'.$notification->n_msg.'</p>';
                                                                             }
                                                                      }else{
                                                                             echo '<p class="text-xs text-center text-gray-500 font-semibold py-2">No notification found!</p>';
                                                                      } 
                                                               ?>
                                                        </div>
                                                 </div>
                                          </div>
                                   <?php endif ?>
                                   <li class="flex items-center gap-2">
                                          <img src="<?php echo SYSTEM_URL."/public/images/".strtolower($user_data->gender).".svg" ?>" alt="profile" class="w-9 h-9">
                                          <div>
                                                 <p class="text-sm text-black font-semibold"><?php echo $user_data->fullname ?></p>
                                                 <p class="text-xs text-slate-500"><?php echo $user_data->role_name ?></p>
                                          </div>
                                   </li>
                            <?php endif ?>
                     </ul>
                     <ul>
                            <?php if(isset($_SESSION["uid"]) AND isset($_SESSION["loggedin"])): ?>
                                   <button onclick="window.location.href='<?php echo SYSTEM_URL ?>/logout'" class="block w-fit bg-primary text-sm text-white uppercase font-medium py-3 px-8 rounded-md mx-auto">Log Out</button>
                            <?php else: ?>
                                   <button class="login-btn block w-fit bg-primary text-sm text-white uppercase font-medium py-3 px-8 rounded-md mx-auto">Log In</button>
                            <?php endif ?>  
                     </ul>
              </div>
       </nav>
</header>