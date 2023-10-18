var rowsPerPage = 10;
var currentPage = 1;
var numRows = $('#my-table tbody tr').length;
var numPages = Math.ceil(numRows / rowsPerPage);
function SystemPagination(){
       var pagination = '<div class="pagination-container justify-center md:justify-between items-center gap-2 mt-4">'; 
              
       pagination += '<ul class="flex items-center justify-center gap-2 flex-wrap">';

       pagination += '<button class="prev-btn text-xs text-grey font-medium py-[7px] px-4 border border-gray-300/40 rounded-full transition-all disabled:cursor-not-allowed disabled:bg-gray-200">Prev</button>';

       pagination += '<ul class="pagination flex items-center justify-center gap-2 flex-wrap">';

      for (var i = 1; i <= numPages; i++) {
          pagination += '<a href="#" class="page text-xs text-grey font-medium py-[7px] px-4 border border-gray-300/40 rounded-full transition-all';
          if (i === currentPage) {
              pagination += ' active';
          }
          pagination += '">' + i + '</a>';
      }

       pagination += '</ul><button class="next-btn text-xs text-grey font-medium py-[7px] px-4 border border-gray-300/40 rounded-full transition-all disabled:cursor-not-allowed disabled:bg-gray-200">Next</button>';

       pagination += '</ul></div>';

  $('#pagination').html(pagination);

  // update pagination
  updatePagination();

  // show first page of table
  $('#my-table tbody tr').hide();
  $('#my-table tbody tr').slice(0, rowsPerPage).show();

  // handle pagination clicks
  $('#pagination').on('click', '.prev-btn', function(event) {
      event.preventDefault();
      if (currentPage > 1) {
          currentPage--;
          showPage(currentPage);
      }
  });
  $('#pagination').on('click', '.next-btn', function(event) {
      event.preventDefault();
      if (currentPage < numPages) {
        currentPage++;
        showPage(currentPage);
      }
  });
  $('#pagination').on('click', '.page', function(event) {
      event.preventDefault();
      currentPage = parseInt($(this).text());
      showPage(currentPage);
  });
}
function showPage(page) {
  var startRow = (page - 1) * rowsPerPage;
  var endRow = startRow + rowsPerPage;
  $('#my-table tbody tr').hide();
  $('#my-table tbody tr').slice(startRow, endRow).show();
  updatePagination();
}
function updatePagination() {
  // update active page
  $('.page').removeClass('active');
  $('.page').eq(currentPage - 1).addClass('active');
  
  // update disabled state of prev/next buttons
  $('.prev-btn, .next-btn').removeClass('disabled');
  if (currentPage === 1) {
      $('.prev-btn').addClass('disabled');
  }
  if (currentPage === numPages) {
      $('.next-btn').addClass('disabled');
  }

  // update pagination numbers
  $('.page').hide();
  
  var startPage = Math.max(1, currentPage - 2);
  var endPage = Math.min(numPages, startPage + 4);
  if (endPage - startPage < 4) {
      startPage = Math.max(1, endPage - 4);
  }
  for (var i = startPage; i <= endPage; i++) {
          $('.page').eq(i - 1).show();
  }

  // add ellipsis
  $('.ellipsis').hide();

  if (startPage > 1) {
      $('#pagination ul').find('.prev-btn').after('<li class="ellipsis list-none text-xs text-grey font-medium py-[7px] px-4 bg-white rounded-full cursor-default">...</li>');
  }
  if (endPage < numPages) {
      $('#pagination ul').find('.next-btn').before('<li class="ellipsis list-none text-xs text-grey font-medium py-[7px] px-4 bg-white rounded-full cursor-default">...</li>');
  }
}