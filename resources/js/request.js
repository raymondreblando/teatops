const notification = new Notyf({duration: 4000, ripple: false, dismissible: true,position: {x: 'center', y: 'top',}});

function check_toast_identifier(response){
    if(response.identifier === "toast"){
        notification[response.type](response.message);
        if(response.reload === "yes"){
            setTimeout(function() {
                location.reload();
            }, 1000);
        }
    }else{
        $("#notification").html(response.value);
    }
}
function transferData(url, data){
       $.ajax({
              type: "POST",
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
              }
       });
}
$(document).on('click', '#login', function() {
       var form_data = new FormData();
       var username = $("#username").val();
       var password = $("#password").val();

       form_data.append("username", username);
       form_data.append("password", password);

       url = "app/Handlers/process_login.php";
       transferData(url, form_data);
});  
$(document).on('click', '#register', function() {
       var form_data = new FormData();
       var fullname = $("#r_fullname").val();
       var username = $("#r_username").val();
       var gender = $("#r_gender").val();
       var contact = $("#r_phone_number").val();
       var address = $("#r_address").val();
       var password = $("#r_password").val();
       var c_password = $("#r_confirm_password").val();

       form_data.append("fullname", fullname);
       form_data.append("username", username);
       form_data.append("gender", gender);
       form_data.append("contact", contact);
       form_data.append("address", address);
       form_data.append("password", password);
       form_data.append("c_password", c_password);
       
       url = "app/Handlers/process_registration.php";
       transferData(url, form_data);
});  
$(document).on('click', '#saveCategory', function() {
       var form_data = new FormData();
       var tableData = [];

       $('#my-table tbody tr').each(function () {
              var rowData = [];

              $(this).find('td').each(function () {
                     rowData.push($(this).text());
              });
              tableData.push(rowData);
       });

       if (tableData.length === 0) {
              notification.error("Please add size and price");
       }else{
              form_data.append('tableData', JSON.stringify(tableData));
              form_data.append("c_name", $("#category_name").val());
              form_data.append("c_image", $('#product_img').prop('files')[0]);

              url = "app/Handlers/process_category.php";
              transferData(url, form_data);
       }
});  
$(document).on('click', '#saveMenu', function() {
       var form_data = new FormData();
       var menu_name = $("#menu_name").val();
       var menu_category = $("#menu_category").val();
       var stocks = $("#stocks").val();
       var product_img = $('#product_img').prop('files')[0];
       
       form_data.append("menu_name", menu_name);
       form_data.append("menu_category", menu_category);
       form_data.append("stocks", stocks);
       form_data.append("product_img", product_img);

       url = "app/Handlers/process_menu.php";
       transferData(url, form_data);
});  
$(document).on('click', '#updateMenu', function() {
       var form_data = new FormData();
       var identifier = $(this).data('id');
       var menu_name = $("#menu_name").val();
       var menu_category = $("#category").val();
       var stocks = $("#stocks").val();
       var product_img = $('#product_img').prop('files')[0];
       
       form_data.append("identifier", identifier);
       form_data.append("menu_name", menu_name);
       form_data.append("menu_category", menu_category);
       form_data.append("stocks", stocks);
       form_data.append("product_img", product_img);

       url = "./../app/Handlers/process_menu_update.php";
       transferData(url, form_data);
});  
$(document).on('click', '#updateProfile', function() {
       var form_data = new FormData();
       var fullname = $("#fullname").val();
       var username = $("#username1").val();
       var gender = $("#gender").val();
       var phone_number = $("#phone_number").val();
       var address = $("#address").val();
       
       form_data.append("fullname", fullname);
       form_data.append("username", username);
       form_data.append("gender", gender);
       form_data.append("phone_number", phone_number);
       form_data.append("address", address);

       url = "app/Handlers/process_profile.php";
       transferData(url, form_data);
});  
$(document).on('click', '#changePassword', function() {
       var form_data = new FormData();
       var current_password_1 = $("#current_password_1").val();
       var new_password_1 = $("#new_password_1").val();
       var confirm_password_1 = $("#confirm_password_1").val();
       
       form_data.append("current_password_1", current_password_1);
       form_data.append("new_password_1", new_password_1);
       form_data.append("confirm_password_1", confirm_password_1);

       url = "app/Handlers/process_change_password.php";
       transferData(url, form_data);
});  
$(document).on('click', '.block_unblock', function() {
       var form_data = new FormData();
       var identifier = $(this).data('identifier');
       var value = $(this).data('value');
       
       form_data.append("identifier", identifier);
       form_data.append("value", value);

       url = "app/Handlers/process_block_unblock.php";
       transferData(url, form_data);
}); 
$(document).on('click', '.saveOrder', function() {
       var form_data = new FormData();
       var no = $(this).data('no');
       var identifier = $(this).data('id');
       var p_id = $('.selected-size-'+no+'').val();
       
       form_data.append("identifier", identifier);
       form_data.append("p_id", p_id);

       $.ajax({
              type: "POST",
              url: "app/Handlers/process_save_order_to_cart.php",
              data: form_data,
              dataType: 'json',
              cache: false,
              contentType: false,
              processData: false,
              success: function (response) {
                     check_toast_identifier(response);
                     $('#countCart').text(response.others);
                     if(response.others > 0){
                            $('#badgeCart').removeClass('hidden');
                     }
              }
       });
});  
$(document).on('click', '#confirmOrder', function() {
       var form_data = new FormData();
       var identifier = $(this).data('id');

       form_data.append("identifier", identifier);

       url = "./../app/Handlers/process_confirm_order.php";
       transferData(url, form_data);
});  
$(document).on('click', '.cancelOrder', function() {
       var form_data = new FormData();
       var identifier = $(this).data('id');

       form_data.append("identifier", identifier);

       url = "app/Handlers/process_cancel_order.php";
       transferData(url, form_data);
});  
$(document).on('click', '#placeOrder', function() {
       var form_data = new FormData();
       var totalAmount = $("#total-amount").text();
       var orderType = $("#order-type").val();
       var paymentMethod = $("#payment-method").val();

       form_data.append("totalAmount", totalAmount);
       form_data.append("orderType", orderType);
       form_data.append("paymentMethod", paymentMethod);

       url = "app/Handlers/process_place_order.php";
       transferData(url, form_data);
});  
$(document).on('change', '.changeStatus', function() {
       var form_data = new FormData();
       var identifier = $(this).data('id');
       var value = $(this).val();

       form_data.append("identifier", identifier);
       form_data.append("value", value);
       url = "app/Handlers/process_change_status.php";
       transferData(url, form_data);
});  
$(document).on('click', '.decrement', function() {
       var id = $(this).attr("id");
       var identifier = $(this).data("id");
       var counter = $('#items-counters-' + id);
       var currentValue = parseInt(counter.text());
   
       if (currentValue > 0) {
              newCountValue = currentValue - 1;
              counter.text(newCountValue);
              UpdateTotalAmount();
           
              var form_data = new FormData();
              form_data.append("identifier", identifier);
              form_data.append("newCountValue", newCountValue);
              $.ajax({
                     type: "POST",
                     url: "app/Handlers/process_quantity_update.php",
                     data: form_data,
                     dataType: 'json',
                     cache: false,
                     contentType: false,
                     processData: false
              });

              if(newCountValue === 0){
                     location.reload();
              }
       }
});      
$(document).on('click', '.increment', function() {
       var id = $(this).attr("id");
       var identifier = $(this).data("id");
       var counter = $('#items-counters-' + id);
       var currentValue = parseInt(counter.text());

       newCountValue = currentValue + 1;
       counter.text(newCountValue);
       UpdateTotalAmount();

       var form_data = new FormData();
       form_data.append("identifier", identifier);
       form_data.append("newCountValue", newCountValue);
       $.ajax({
              type: "POST",
              url: "app/Handlers/process_quantity_update.php",
              data: form_data,
              dataType: 'json',
              cache: false,
              contentType: false,
              processData: false
       });
});    