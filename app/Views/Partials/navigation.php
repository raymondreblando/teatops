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
                                   <?php if($_SESSION["role"] !== "968375857"): ?>
                                          <li><a href="<?php echo SYSTEM_URL ?>/my_orders" class="header__link <?php echo $tab_active == 'My Orders' ? 'active' : '' ?>">My Orders</a></li>
                                          <li><a href="<?php echo SYSTEM_URL ?>/profile" class="header__link <?php echo $tab_active == 'Profile' ? 'active' : '' ?>">Profile</a></li>
                                          <li class="relative">
                                                 <a href="<?php echo SYSTEM_URL ?>/cart" class="header__link">
                                                 <img src="<?php echo SYSTEM_URL ?>/public/icons/bag-2-linear.svg" alt="cart" class="w-5 h-5"></a>
                                                 <span id="badgeCart" class="<?php if($cartCount === 0){echo 'hidden';} ?> absolute -top-[6px] -right-[12px] bg-primary text-[9px] text-white font-semibold py-[4px] px-[6px] rounded-full pointer-events-none"><p id="countCart"><?php echo $cartCount; ?></p></span>
                                          </li>
                                   <?php else: ?>
                                          <li><a href="<?php echo SYSTEM_URL ?>/orders" class="header__link <?php echo $tab_active == 'Orders' ? 'active' : '' ?>">Orders</a></li>
                                          <li><a href="<?php echo SYSTEM_URL ?>/accounts" class="header__link <?php echo $tab_active == 'Accounts' ? 'active' : '' ?>">Accounts</a></li>
                                          <li><a href="<?php echo SYSTEM_URL ?>/profile" class="header__link <?php echo $tab_active == 'Profile' ? 'active' : '' ?>">Profile</a></li>
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
              <ul class="flex items-center md:hidden">
                     <button class="menu-btn">
                            <i class="ri-menu-line font-semibold text-xl"></i>
                     </button>
              </ul>
       </nav>
</header>