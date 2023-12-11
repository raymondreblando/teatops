$(document).ready(function () {
   $('#input-loader').hide();
});
const notification = new Notyf({
   duration: 4000,
   ripple: false,
   dismissible: true,
   position: { x: 'center', y: 'top' },
});
function isNumeric(evt) {
   var theEvent = evt || window.event;
   var key = theEvent.keyCode || theEvent.which;
   key = String.fromCharCode(key);
   var regex = /[0-9]|\./;
   if (!regex.test(key)) {
     theEvent.returnValue = false;
     if (theEvent.preventDefault) theEvent.preventDefault();
   }
}
function check_toast_identifier(response) {
   if (response.identifier === 'toast') {
      notification[response.type](response.message);
      if (response.reload === 'yes') {
         setTimeout(function () {
            location.reload();
         }, 1000);
      }
   } else {
      $('#notification').html(response.value);
   }
}
function transferData(url, data) {
   $.ajax({
      type: 'POST',
      url: url,
      data: data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
         console.log(response);
         check_toast_identifier(response);
      },
      error: function (response) {
         console.log(response);
      }
   });
}
function getMyOrderList(){
   $.ajax({
      type: 'GET',
      url: 'app/Handlers/process_my_order_list.php',
      success: function (response) {
         $('#reload-div').html(response);
         addEvent(".cancel-order-btn", "click", (e) => {
            const parent = e.target.parentElement.parentElement.parentElement;
            const cancelContainer = parent.querySelector(".cancel-order");
            cancelContainer.classList.add("show");
         }, "all")
      },
      error: function(response){
        console.log(response);
      }
    });
}
$(document).on('click', '#login', function () {
   let form_data = new FormData();
   let username = $('#username').val();
   let password = $('#password').val();

   form_data.append('username', username);
   form_data.append('password', password);

   url = 'app/Handlers/process_login.php';
   transferData(url, form_data);
});
$(document).on('click', '#register', function () {
   let form_data = new FormData();
   let fullname = $('#r_fullname').val();
   let username = $('#r_username').val();
   let gender = $('#r_gender').val();
   let contact = $('#r_phone_number').val();
   let r_street = $('#r_street').val();
   let r_zone = $('#r_zone').val();
   let r_barangay = $('#r_barangay').val();
   let r_municipality = $('#r_municipality').val();
   let r_province = $('#r_province').val();
   let email = $('#r_email').val();
   let password = $('#r_password').val();
   let c_password = $('#r_confirm_password').val();
   let r_front_id = $('#r_front_id').prop('files')[0];
   let r_back_id = $('#r_back_id').prop('files')[0];

   form_data.append('fullname', fullname);
   form_data.append('username', username);
   form_data.append('gender', gender);
   form_data.append('contact', contact);
   form_data.append('r_street', r_street);
   form_data.append('r_zone', r_zone);
   form_data.append('r_barangay', r_barangay);
   form_data.append('r_municipality', r_municipality);
   form_data.append('r_province', r_province);
   form_data.append('email', email);
   form_data.append('password', password);
   form_data.append('c_password', c_password);
   form_data.append('r_front_id', r_front_id);
   form_data.append('r_back_id', r_back_id);

   url = 'app/Handlers/process_registration.php';
   transferData(url, form_data);
});
$(document).on('click', '#verify-email', function () {
   $('#verify-email').hide();
   $('#input-loader').show();
   let form_data = new FormData();
   form_data.append('f_email', $('#f_email').val());

   $.ajax({
      type: 'POST',
      url: 'app/Handlers/process_forgot_verify_email.php',
      data: form_data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
         check_toast_identifier(response);

         if(response.others.length > 1){
            window.location.href = response.others;
         }

         $('#input-loader').hide();
         $('#verify-email').show();
      }
   });
});
$(document).on('click', '#save-new-password', function () {
   let form_data = new FormData();
   let email = $(this).data('email');
   let code = $(this).data('code');
   let new_password = $('#f_new_password').val();
   let confirm_password = $('#f_confirm_password').val();

   form_data.append('email', email);
   form_data.append('code', code);
   form_data.append('new_password', new_password);
   form_data.append('confirm_password', confirm_password);

   $.ajax({
      type: 'POST',
      url: './../../app/Handlers/process_forgot_change_password.php',
      data: form_data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
         check_toast_identifier(response);

         if(response.others.length > 1){
            window.location.href = response.others;
         }
      },
      error: function(response){
         console.log(response);
      }
   });
});
$(document).on('click', '#verify-code', function () {
   let verificationCode = '';
   $('.code-input').each(function() {
      verificationCode += $(this).val();
   });

   let form_data = new FormData();
   form_data.append('email_address', $('#email_address').text());
   form_data.append('verificationCode', verificationCode);

   $.ajax({
      type: 'POST',
      url: './../../app/Handlers/process_forgot_verify_code.php',
      data: form_data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
         check_toast_identifier(response);

         if(response.others.length > 1){
            window.location.href = response.others;
         }
      },
      error: function (response) {
         console.log(response);
      },
   });
});
$(document).on('click', '#saveCategory', function () {
   let form_data = new FormData();
   let tableDataOne = [];
   let tableDataTwo = [];

   function getTableData(tableData, tableName) {
      $('#' + tableName + ' tbody tr').each(function () {
         let rowData = [];

         $(this)
            .find('td')
            .each(function () {
               rowData.push($(this).text());
            });
         tableData.push(rowData);
      });
   }

   getTableData(tableDataOne, 'my-table-1');
   getTableData(tableDataTwo, 'my-table-2');

   if (tableDataOne.length === 0) {
      notification.error('Please add size and price');
   } else {
      form_data.append('tableDataOne', JSON.stringify(tableDataOne));
      form_data.append('tableDataTwo', JSON.stringify(tableDataTwo));
      form_data.append('c_name', $('#category_name').val());
      form_data.append('c_image', $('#product_img').prop('files')[0]);

      url = 'app/Handlers/process_category.php';
      transferData(url, form_data);
   }
});
$(document).on('click', '#saveMenu', function () {
   let form_data = new FormData();
   let menu_name = $('#menu_name').val();
   let menu_category = $('#menu_category').val();
   let stocks = $('#stocks').val();
   let product_img = $('#product_img').prop('files')[0];

   form_data.append('menu_name', menu_name);
   form_data.append('menu_category', menu_category);
   form_data.append('stocks', stocks);
   form_data.append('product_img', product_img);

   url = 'app/Handlers/process_menu.php';
   transferData(url, form_data);
});
$(document).on('click', '#updateMenu', function () {
   let form_data = new FormData();
   let identifier = $(this).data('id');
   let menu_name = $('#menu_name').val();
   let menu_category = $('#category').val();
   let stocks = $('#stocks').val();
   let product_img = $('#product_img').prop('files')[0];

   form_data.append('identifier', identifier);
   form_data.append('menu_name', menu_name);
   form_data.append('menu_category', menu_category);
   form_data.append('stocks', stocks);
   form_data.append('product_img', product_img);

   url = './../app/Handlers/process_menu_update.php';
   transferData(url, form_data);
});
$(document).on('click', '#updateProfile', function () {
   let form_data = new FormData();
   let fullname = $('#fullname').val();
   let username = $('#username1').val();
   let gender = $('#gender').val();
   let phone_number = $('#phone_number').val();
   let street = $('#street').val();
   let zone = $('#zone').val();
   let barangay = $('#barangay').val();
   let municipality = $('#municipality').val();
   let province = $('#province').val();
   let email = $('#email').val();
   let profile_picture = $('#profile_picture').prop('files')[0];

   form_data.append('fullname', fullname);
   form_data.append('username', username);
   form_data.append('gender', gender);
   form_data.append('phone_number', phone_number);
   form_data.append('street', street);
   form_data.append('zone', zone);
   form_data.append('barangay', barangay);
   form_data.append('municipality', municipality);
   form_data.append('province', province);
   form_data.append('email', email);
   form_data.append('profile_picture', profile_picture);

   url = 'app/Handlers/process_profile.php';
   transferData(url, form_data);
});
$(document).on('click', '#changePassword', function () {
   let form_data = new FormData();
   let current_password_1 = $('#current_password_1').val();
   let new_password_1 = $('#new_password_1').val();
   let confirm_password_1 = $('#confirm_password_1').val();

   form_data.append('current_password_1', current_password_1);
   form_data.append('new_password_1', new_password_1);
   form_data.append('confirm_password_1', confirm_password_1);

   url = 'app/Handlers/process_change_password.php';
   transferData(url, form_data);
});
$(document).on('click', '.block_unblock', function () {
   let form_data = new FormData();
   let identifier = $(this).data('identifier');
   let value = $(this).data('value');

   form_data.append('identifier', identifier);
   form_data.append('value', value);

   url = 'app/Handlers/process_block_unblock.php';
   transferData(url, form_data);
});
$(document).on('click', '.saveOrder', function () {
   let form_data = new FormData();
   let no = $(this).data('no');
   let identifier = $(this).data('id');
   let p_id = '';
   let selectedAddons = [];
   let totalAddonsPrice = 0;

   $('.addons-price-' + no + '').each(function () {
      if ($(this).hasClass('selected')) {
         let addonName = $(this).data('name');
         let addonPrice = $(this).data('price');
         
         totalAddonsPrice +=  addonPrice;
         selectedAddons.push({ name: addonName });
      }
   });
   $('.menu-price-' + no + '').each(function () {
      if ($(this).hasClass('selected')) {
         p_id = $(this).data('id');
      }
   });

   let combineSelectedAddons = selectedAddons
      .map((addon) => addon.name)
      .join(',');

   form_data.append('identifier', identifier);
   form_data.append('p_id', p_id);
   form_data.append('addonsPrice', totalAddonsPrice);
   form_data.append('addons', combineSelectedAddons);

   $.ajax({
      type: 'POST',
      url: 'app/Handlers/process_save_order_to_cart.php',
      data: form_data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
         check_toast_identifier(response);
         $('#countCart').text(response.others);
         if (response.others > 0) {
            $('#badgeCart').removeClass('hidden');
         }
      },
      error: function (response) {
         console.log(response);
      },
   });
});
function checkQuantity(){
   let paymentType = $('#payment-method').val();

   if(paymentType == "Cash on Delivery"){
      let totalQuantity = 0;
      $('.item-counter').each(function () {
         totalQuantity += parseInt($(this).text(), 10);
      });
      if(totalQuantity > 10){
         $('#codMessage').removeClass('hidden');
         $('#placeOrder').addClass('hidden');
         return true;
      }else{
         $('#codMessage').addClass('hidden');
         $('#placeOrder').removeClass('hidden');
         return false;
      }
   }else{
      $('#codMessage').addClass('hidden');
      $('#placeOrder').removeClass('hidden');
   }
}
$(document).on('click', '.pmethod', function () {
   checkQuantity();
});
$(document).on('click', '#confirmOrder', function () {
   let form_data = new FormData();
   let identifier = $(this).data('id');

   form_data.append('identifier', identifier);

   url = './../app/Handlers/process_confirm_order.php';
   transferData(url, form_data);
});
$(document).on('click', '.cancelOrder', function () {
   let form_data = new FormData();
   let identifier = $(this).data('id');

   form_data.append('identifier', identifier);

   url = 'app/Handlers/process_cancel_order.php';
   transferData(url, form_data);
});
$(document).on('click', '#placeOrder', function () {
   let form_data = new FormData();
   let totalAmount = $('#total-amount').text();
   let orderType = $('#order-type').val();
   let paymentMethod = $('#payment-method').val();

   form_data.append('totalAmount', totalAmount);
   form_data.append('orderType', orderType);
   form_data.append('paymentMethod', paymentMethod);

   url = 'app/Handlers/process_place_order.php';
   transferData(url, form_data);
});
$(document).on('change', '.changeStatus', function () {
   let form_data = new FormData();
   let identifier = $(this).data('id');
   let value = $(this).val();

   form_data.append('identifier', identifier);
   form_data.append('value', value);
   url = 'app/Handlers/process_change_status.php';
   transferData(url, form_data);
});
$(document).on('click', '.notification', function () {
   $.ajax({
      type: 'POST',
      url: 'app/Handlers/process_notification_seen.php',
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
   });
});
$(document).on('click', '.decrement', function () {
   let id = $(this).attr('id');
   let identifier = $(this).data('id');
   let counter = $('#items-counters-' + id);
   let currentValue = parseInt(counter.text());

   if (currentValue > 0) {
      newCountValue = currentValue - 1;
      counter.text(newCountValue);
      UpdateTotalAmount();
      checkQuantity();

      let form_data = new FormData();
      form_data.append('identifier', identifier);
      form_data.append('newCountValue', newCountValue);
      $.ajax({
         type: 'POST',
         url: 'app/Handlers/process_quantity_update.php',
         data: form_data,
         dataType: 'json',
         cache: false,
         contentType: false,
         processData: false,
      });

      if (newCountValue === 0) {
         location.reload();
      }
   }
});
$(document).on('click', '.increment', function () {
   let id = $(this).attr('id');
   let identifier = $(this).data('id');
   let counter = $('#items-counters-' + id);
   let currentValue = parseInt(counter.text());

   newCountValue = currentValue + 1;
   counter.text(newCountValue);
   UpdateTotalAmount();
   checkQuantity();

   let form_data = new FormData();
   form_data.append('identifier', identifier);
   form_data.append('newCountValue', newCountValue);
   $.ajax({
      type: 'POST',
      url: 'app/Handlers/process_quantity_update.php',
      data: form_data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
   });
});
$(document).on('click', '.verify-id', function () {
   let form_data = new FormData();
   let identifier = $(this).data('id');
   let valueVerification = $(this).data('value');

   form_data.append('identifier', identifier);
   form_data.append('valueVerification', valueVerification);

   url = './../app/Handlers/process_id_verification.php';
   transferData(url, form_data);
});