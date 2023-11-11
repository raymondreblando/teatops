// Execute when the document is ready 
$(document).ready(function () {
       AOS.init();
       SystemPagination();
       UpdateTotalAmount();

       // Search for table
       $('#searchTable').keyup(function () { 
              let $tableRow = $('#my-table tbody tr');
              let val = $.trim($(this).val()).replace(/ +/g,'').toLowerCase();
              $tableRow.show().filter(function(){
              let text = $(this).text().replace(/\s+/g,'').toLowerCase();
              return !~text.indexOf(val);
              }).hide();
       });

       // Search for folder
       $('#searchDiv').keyup(function () { 
              let matcher = new RegExp($(this).val(), 'i');
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
              let filterValue = $(this).val();
              filterTableByColumn('#my-table', 1, filterValue);
       });
       $('#filterDate').change(function () {
              let filterValue = $(this).val();
              filterTableByColumn('#my-table', 2, filterValue);
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
       $(".add-row-button").click(function () {
              const cellCount = $(this).data("cell-count");
              const tableName = $(this).data("table-name");
              addRow(cellCount, tableName);
       });

       function sumTotalPrice(menuNo){
              let totalAddonsPrice = 0;
              let totalSelectedMenuPrice = 0;

              $('.addons-price-'+menuNo+'').each(function () {
                     if ($(this).hasClass('selected')) {
                         let addonPrice = $(this).data('price');

                         totalAddonsPrice +=  addonPrice;
                     }
              });
              $('.menu-price-'+menuNo+'').each(function () {
                     if ($(this).hasClass('selected')) {
                         let menuPrice = $(this).data('price');

                         totalSelectedMenuPrice =  menuPrice;
                     }
              });

              return (totalSelectedMenuPrice + totalAddonsPrice);
       }
       $('.menu-size').click(function () { 
              let menuNo = $(this).data('no');

              $('.menu-price-'+menuNo+'').removeClass('selected');

              $(this).toggleClass('selected');

              $('.size-price-'+menuNo+'').text(sumTotalPrice(menuNo));
              $('.price-container-'+menuNo+'').removeClass('hidden');
       });
       $('.menu-addons').click(function () { 
              $(this).toggleClass('selected');

              let menuNo = $(this).data('no');
 
              $('.size-price-'+menuNo+'').text(sumTotalPrice(menuNo));
              $('.price-container-'+menuNo+'').removeClass('hidden');
       });
});
function filterTableByColumn(tableSelector, columnIdx, filterValue) {
       $(tableSelector + ' tbody tr').hide();
     
       $(tableSelector + ' tbody tr td:nth-child(' + columnIdx + ')').each(function () {
              let cellValue = $(this).text();
              if ((filterValue === 'all') || (filterValue === cellValue)) {
                     $(this).closest('tr').show();
              }
       });
}
function UpdateTotalAmount() {
       let totalAmount = 0;
   
       $('.items').each(function () {
           let price = parseFloat($(this).find('.item-price').text());
           let addons = parseFloat($(this).find('.addons-price').text());
           let quantity = parseInt($(this).find('.item-counter').text());
           
           if (!isNaN(price) && !isNaN(addons) && !isNaN(quantity)) {
               totalAmount += (price + addons) * quantity;
           }
       });
      
       $('#total-amount').text(totalAmount);
}
function addRow(cellCount, tableName) {
       const $table = $('#'+tableName+'');
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
   