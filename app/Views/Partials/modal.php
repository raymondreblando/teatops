<div class="modal">
  <div class="login-container">
    <div class="flex items-center justify-between border-b border-b-gray-300/40 pb-4">
      <p class="text-lg font-bold text-dark uppercase">Login</p>
      <button role="button" class="close-modal"><i class="ri-close-line"></i></button>
    </div>
    <div class="py-4">
      <p class="text-sm font-medium text-slate-500 mb-6">Provide your credentials to logged in.</p>
      
      <form autocomplete="off">
        <label for="username" class="block text-[12px] font-semibold text-gray-600 uppercase mb-1">Username</label>
        <input type="text" id="username" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-3">
        <label for="password" class="block text-[12px] font-semibold text-gray-600 uppercase mb-1">Password</label>
        <input type="password" id="password" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-4">
        <a href="<?= SYSTEM_URL ?>/forget-password" class="block text-xs text-primary text-right font-medium mb-4">Forget Password?</a>
        <button type="button" id="login" class="block text-sm w-full h-12 bg-primary text-white font-semibold uppercase rounded-md tracking-widest">Log In</button>
      </form>
      <p class="text-sm font-medium text-slate-500 text-center mt-6">Does not have an account? <span class="text-primary font-semibold cursor-pointer show-create-account">Create Account</span></p>
    </div>
  </div>
  <div class="signup-container">
    <div class="flex items-center justify-between border-b border-b-gray-300/40 pb-4">
      <p class="text-lg font-bold text-dark uppercase">Create Account</p>
      <button role="button" class="close-modal"><i class="ri-close-line"></i></button>
    </div>
    <div class="py-4">
      <p class="text-sm font-medium text-slate-500 mb-6">Create your account with just a few clicks.</p>
      
      <form autocomplete="off">
        <div class="custom-scroll max-h-[350px] overflow-y-auto mb-4 pr-2">
          <div class="grid grid-cols-2 gap-4 mb-3">
            <div>
              <label for="r_fullname" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Fullname</label>
              <input type="text" id="r_fullname" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="r_username" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Username</label>
              <input type="text" id="r_username" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="r_gender" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Gender</label>
              <select id="r_gender" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 text-slate-500 text-sm">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div>
              <label for="r_phone_number" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Phone Number</label>
              <input type="text" id="r_phone_number" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4" onkeypress="return isNumeric(event)" oninput="maxNumLength(this)" maxlength = "11">
            </div>
          </div>
          <div class="grid md:grid-cols-4 gap-3 mb-3">
            <div>
              <label for="r_street" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Street</label>
              <input type="text" id="r_street" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div>
              <label for="r_zone" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Zone #</label>
              <input type="text" id="r_zone" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div class="md:col-span-2">
              <label for="r_barangay" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Barangay</label>
              <input type="text" id="r_barangay" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div class="md:col-span-2">
              <label for="r_municipality" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Municipality</label>
              <input type="text" id="r_municipality" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
            <div class="md:col-span-2">
              <label for="r_province" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Province</label>
              <input type="text" id="r_province" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4">
            </div>
          </div>
          <label for="r_email" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Email</label>
          <input type="text" id="r_email" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-3">
          <div class="grid md:grid-cols-2 gap-4 mb-3">
            <div>
              <label for="r_password" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Password</label>
              <input type="password" id="r_password" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-1">
              <p class="text-xs font-medium">Must be 7 characters length</p>
            </div>
            <div>
              <label for="r_confirm_password" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Confirm Password</label>
              <input type="password" id="r_confirm_password" class="w-full h-10 border border-gray-300/400 rounded-md outline-none px-4 mb-1">
              <p class="text-xs font-medium">Must be 7 characters length</p>
            </div>
            <div>
              <label for="r_front_id" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Upload Front of ID</label>
              <input type="file" id="r_front_id" class="w-full h-10 text-xs  file:text-primary file:text-xs file:bg-light-pink file:border-none file:mt-2 border border-gray-300/400 rounded-md outline-none px-4" accept=".jpg, .jpeg, .png">
            </div>
            <div>
              <label for="r_back_id" class="block text-sm font-semibold text-gray-600 uppercase mb-1">Upload Back of ID</label>
              <input type="file" id="r_back_id" class="w-full h-10 text-xs  file:text-primary file:text-xs file:bg-light-pink file:border-none file:mt-2 border border-gray-300/400 rounded-md outline-none px-4" accept=".jpg, .jpeg, .png">
            </div>
          </div>
        </div>
        <button type="button" id="register" class="block w-full h-12 bg-primary text-white font-semibold rounded-md">Register</button>
      </form>
      <p class="text-sm font-medium text-slate-500 text-center mt-6">Already have an account created? <span class="text-primary font-semibold cursor-pointer show-login">Login Now</span></p>
    </div>
  </div>
</div>