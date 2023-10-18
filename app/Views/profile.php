<?php
$page_title = "Profile";
$tab_active = "Profile";

require_once("./init.php");

include 'Partials/header.php';

$redirect->checkLoggedIn(SYSTEM_URL);

?>
<body>
  <?php include 'Partials/loader.php'; ?>
  <main class="bg-light-pink min-h-screen">
    <?php include 'Partials/navigation.php'; ?>
    <section class="w-[min(1200px,80%)] pt-28 pb-12 mx-auto overflow-hidden">
      <h3 class="text-3xl text-center font-semibold text-gray-800 mb-2" data-aos="fade-up">My Profile</h3>
      <p class="text-sm font-medium text-center text-gray-700 mb-8" data-aos="fade-up">Manage your personal information, change profile picture and manage account security</p>

      <div class="max-w-[500px] mx-auto pb-8">
        <div class="relative w-max mx-auto mb-6" data-aos="fade-up">
          <input type="file" name="profile" class="dp-input" hidden>
          <img src="<?php echo SYSTEM_URL."/public/images/".strtolower($user_data->gender).".svg" ?>" alt="profile" class="profile-image w-[120px] h-[120px] rounded-full object-cover">
          <!-- <button class="upload-profile absolute bottom-0 right-4 bg-white rounded-full">
            <img src="<?php echo SYSTEM_URL ?>/public/icons/refresh-circle-bold.svg" alt="refresh" class="w-7 h-7">
          </button> -->
        </div>
        <p class="text-xl text-black text-center font-semibold mb-6" data-aos="fade-up">Manage Personal Information</p>
        <form autocomplete="off" class="mb-8" data-aos="fade-up">
          <div class="grid grid-cols-2 gap-4 mb-3">
            <div>
              <label for="fullname" class="block text-sm font-semibold text-gray-600 mb-1">Fullname</label>
              <input type="text" id="fullname" value="<?php echo $user_data->fullname ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="username" class="block text-sm font-semibold text-gray-600 mb-1">Username</label>
              <input type="text" id="username1" value="<?php echo $user_data->username ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="gender" class="block text-sm font-semibold text-gray-600 mb-1">Gender</label>
              <select id="gender" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 text-slate-500 text-sm">
                <?php 
                    $selected = $user_data->gender;
                    $options = array("Male","Female");
                    foreach($options as $option){
                      if($selected == $option){
                            echo '<option selected="selected" value="'.$option.'">'.$option.'</option>';
                      }else{
                            echo '<option value="'.$option.'">'.$option.'</option>';
                      }
                    }
                ?>
              </select>
            </div>
            <div>
              <label for="phone_number" class="block text-sm font-semibold text-gray-600 mb-1">Phone Number</label>
              <input type="text" id="phone_number" value="<?php echo $user_data->contact ?>"  class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
          </div>
          <label for="address" class="block text-sm font-semibold text-gray-600 mb-1">Address</label>
          <input type="text" id="address" value="<?php echo $user_data->address ?>"  class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-3">
          <button type="button" id="updateProfile" class="block w-full h-12 bg-primary text-white rounded-md">Update Information</button>
        </form>
        <p class="text-xl text-black text-center font-semibold mb-6" data-aos="fade-up">Manage Account Security</p>
        <form autocomplete="off" data-aos="fade-up">
          <label for="current_password_1" class="block text-sm font-semibold text-gray-600 mb-1">Current Account Password</label>
          <input type="password" id="current_password_1" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-4">
          <label for="new_password_1" class="block text-sm font-semibold text-gray-600 mb-1">New Account Password</label>
          <input type="password" id="new_password_1" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-4">
          <label for="confirm_password_1" class="block text-sm font-semibold text-gray-600 mb-1">Confirm Account Password</label>
          <input type="password" id="confirm_password_1" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-4">
          <button type="button" id="changePassword" class="block w-full h-12 bg-primary text-white rounded-md">Change Account Password</button>
        </form>
      </div>
    </section>
  </main>

<?php include 'Partials/footer.php'; ?>