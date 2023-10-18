// Execute when the document is ready 
$(document).ready(function () {
       AOS.init();
       SystemPagination();
       UpdateTotalAmount();

       // Search for table
       $('#searchTable').keyup(function () { 
              var $tableRow = $('#my-table tbody tr');
              var val = $.trim($(this).val()).replace(/ +/g,'').toLowerCase();
              $tableRow.show().filter(function(){
              var text = $(this).text().replace(/\s+/g,'').toLowerCase();
              return !~text.indexOf(val);
              }).hide();
       });

       // Search for folder
       $('#searchDiv').keyup(function () { 
              var matcher = new RegExp($(this).val(), 'i');
              $('.searchArea').show().not(function(){
              return matcher.test($(this).find('.finder1, .finder2, .finder3, .finder4, .finder5').text());
              }).hide();
       });

       // Filter Category List
       $('.list').click(function () {
              const value = $(this).attr('data-filter');
              if (value == 'all') {
                     $('.itemBox').fadeIn('1500');
              } else {
                     $('.itemBox').not('.' + value).fadeOut("1500").css("display", "none");
                     $('.itemBox').filter('.' + value).fadeIn("1500").css("display", "block");
              }
       });
       $('.list').click(function () {
              $(this).find('.category').addClass('active');
              $(this).siblings().find('.category').removeClass('active');
       });

        // Filter Table
       $('#filterDropdown').change(function () {
              var filterValue = $(this).val();
              filterTableByColumn('#my-table', 1, filterValue);
       });
       $('#filterDate').change(function () {
              var filterValue = $(this).val();
              filterTableByColumn('#my-table', 2, filterValue);
       });

       $(".add-row-button").click(function () {
              const cellCount = $(this).data("cell-count");
              addRow(cellCount);
       });
          
       $("table").on("click", ".delete-row-button", function () {
              $(this).closest("tr").remove();
       });
          
       $("table").on("click", "td[contenteditable]", function () {
              const $cell = $(this);
              
              if ($cell.hasClass("placeholder")) {
                     $cell.text("").removeClass("placeholder");
              }
       });

       $('.menu-size').click(function () { 
              var no = $(this).data('no');
              var id = $(this).data('id');
              var price = $(this).data('price');
              
              $('.selected-size-'+no+'').val(id);
              $('.size-price-'+no+'').text(price);
              $('.price-container-'+no+'').removeClass('hidden');
       });
});

function filterTableByColumn(tableSelector, columnIdx, filterValue) {
       $(tableSelector + ' tbody tr').hide();
     
       $(tableSelector + ' tbody tr td:nth-child(' + columnIdx + ')').each(function () {
              var cellValue = $(this).text();
              if ((filterValue === 'all') || (filterValue === cellValue)) {
                     $(this).closest('tr').show();
              }
       });
}

function UpdateTotalAmount() {
       var totalAmount = 0;
   
       $('.items').each(function () {
           var price = parseFloat($(this).find('.item-price').text());
           var quantity = parseInt($(this).find('.item-counter').text());
           
           if (!isNaN(price) && !isNaN(quantity)) {
               totalAmount += price * quantity;
           }
       });
   
       $('#total-amount').text(totalAmount);
}
function addRow(cellCount) {
       const $table = $('#my-table');
       const $row = $("<tr>");
     
       for (let i = 0; i < cellCount; i++) {
         const $cell = $("<td>", {
           contenteditable: true,
           class: "text-sm py-4 px-4",
           "data-placeholder": "Type here",
         });
     
         $cell.text($cell.data("placeholder")).addClass("placeholder");
         $row.append($cell);
       }
       
       $row.append(
         '<td><button type="button" class="delete-row-button shrink-0 w-7 h-7 grid place-items-center bg-primary text-white rounded-full"><i class="ri-delete-bin-4-line"></i></button></td>'
       );
       $table.find("tbody").append($row);
}
   