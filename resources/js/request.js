const notification = new Notyf({
   duration: 4000,
   ripple: false,
   dismissible: true,
   position: { x: 'center', y: 'top' },
});

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
         check_toast_identifier(response);
      },
      error: function (response) {
         console.log(response);
      },
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
   let address = $('#r_address').val();
   let password = $('#r_password').val();
   let c_password = $('#r_confirm_password').val();

   form_data.append('fullname', fullname);
   form_data.append('username', username);
   form_data.append('gender', gender);
   form_data.append('contact', contact);
   form_data.append('address', address);
   form_data.append('password', password);
   form_data.append('c_password', c_password);

   url = 'app/Handlers/process_registration.php';
   transferData(url, form_data);
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
   let address = $('#address').val();

   form_data.append('fullname', fullname);
   form_data.append('username', username);
   form_data.append('gender', gender);
   form_data.append('phone_number', phone_number);
   form_data.append('address', address);

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
