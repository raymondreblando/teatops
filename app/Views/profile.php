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
          <input type="file" name="profile" id="profile_picture" class="dp-input" hidden>
          <img src="<?php echo SYSTEM_URL."/uploads/profile/".$user_data->profile ?>" alt="profile" class="profile-image w-[120px] h-[120px] rounded-full object-cover">
          <button class="upload-profile absolute bottom-0 right-4 w-8 h-8 flex items-center justify-center text-lg bg-white border-2 border-primary rounded-full" title="Upload New Profile">
            <i class="ri-upload-cloud-line"></i>
          </button>
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
            <div>
              <label for="street" class="block text-sm font-semibold text-gray-600 mb-1">Street</label>
              <input type="text" id="street" value="<?php echo $user_data->street ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="zone" class="block text-sm font-semibold text-gray-600 mb-1">Zone #</label>
              <input type="text" id="zone" value="<?php echo $user_data->zone ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="barangay" class="block text-sm font-semibold text-gray-600 mb-1">Barangay</label>
              <input type="text" id="barangay" value="<?php echo $user_data->barangay ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="municipality" class="block text-sm font-semibold text-gray-600 mb-1">Municipality</label>
              <input type="text" id="municipality" value="<?php echo $user_data->municipal ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="province" class="block text-sm font-semibold text-gray-600 mb-1">Province</label>
              <input type="text" id="province" value="<?php echo $user_data->province ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
              <input type="text" id="email" value="<?php echo $user_data->email ?>" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
          </div>
          <button type="button" id="updateProfile" class="block w-full h-12 bg-primary text-white rounded-md">Update Information</button>
        </form>
        <!-- <p class="text-xl text-black text-center font-semibold mb-6" data-aos="fade-up">Account Verification</p>
        <form autocomplete="off" class="mb-8" data-aos="fade-up">
          <label for="r_front_id" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Upload Front of ID</label>
          <input type="file" id="r_front_id" class="w-full h-10 text-xs  file:text-primary file:text-xs file:bg-light-pink file:border-none file:mt-2 bg-white border border-gray-300/400 rounded-md outline-none px-4 mb-3">
          <label for="r_back_id" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Upload Back of ID</label>
          <input type="file" id="r_back_id" class="w-full h-10 text-xs  file:text-primary file:text-xs file:bg-light-pink file:border-none file:mt-2 bg-white border border-gray-300/400 rounded-md outline-none px-4 mb-3">
          <button type="button" id="updateProfile" class="block w-full h-12 bg-primary text-white rounded-md">Upload</button>
        </form> -->
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