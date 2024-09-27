
$(document).ready(function() {
    var currentpage = 1;
    //user_id =  new URLSearchParams(window.location.search).get('id');
    // user_id='KH0038'; //giả sử
    
    fetchData(user_id, currentpage);

    //SEARCH ORDER
    $('#search').on('keyup', function () {
        var searchTerm = $('#search').val();

        // Fetch data based on the search term
        if(searchTerm.localeCompare('') != 0)
            fetchSearchData(searchTerm, 1, user_id);
        else
            fetchData(user_id, 1);
    });
});

function fetchData(cusID, page) {
    $.ajax({
        url: "../../../php/Controller/store/my-order-controller.php",
        type: 'POST',
        data: {action:'fetch', cusID: cusID, page: page},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            if(!response.data) console.log("du lieu rong");
            
            var table_body = $('.store-table table tbody');
            table_body.empty();

            
            data.forEach(function (row) {
                table_body.append(`
                <tr>
                    <td>${row.order_id}</td>
                    <td>${row.order_date}</td>
                    <td>${row.telephone}</td>
                    <td>${row.name}</td>
                    <td style="max-width: 130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">${row.address}</td>
                    <td>${row.pay}</td>
                    <td>${row.status}</td>
                    <td>${row.total_products}</td>
                    <td>${row.total_price}</td>
                    <td><a href="./my-order-detail.php?id=${row.order_id}" class="link-to-detail"><i class="fa-solid fa-eye"></i></a></td>
                </tr>
                `);
            });

            updatePagination(page, totalPages);
        },
        error: function() {
            console.error("Loi ket noi");
        }
    });
}

function updatePagination(currentPage, totalPages) {

    // Clear existing pagination links
    $('.pagination').empty();
  
    // Add "Previous" link
    $('.pagination').append(`<a href="#" data-page="${currentPage - 1}">&laquo;</a>`);
  
    // Add numbered links
    for (var i = 1; i <= totalPages; i++) {
        var activeClass = (i === currentPage) ? 'active' : '';
        $('.pagination').append(`<a class="${activeClass}" href="#" data-page="${i}">${i}</a>`);
    }
  
    // Add "Next" link
    $('.pagination').append(`<a href="#" data-page="${currentPage + 1}">&raquo;</a>`);
  
    // Use event delegation for click events on pagination links
    $('.pagination').on('click', 'a', function(event) {
        event.preventDefault();
        var clickedPage = parseInt($(this).data('page'));
    
        if (!isNaN(clickedPage)) {
            fetchData(clickedPage);
        }
    });
  }

function fetchSearchData(searchTerm, page, cusID) {
    $.ajax({
        url: '../../../php/Controller/store/my-order-controller.php',
        type: 'POST',
        data: {action:'search', searchTerm: searchTerm, page: page, cusID: cusID},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            console.log(response.totalPages);
            if(!response.data) console.log("du lieu rong");
            
            var table_body = $('.store-table table tbody');
            table_body.empty();

            
            data.forEach(function (row) {
                table_body.append(`
                    <tr>
                        <td>${row.order_id}</td>
                        <td>${row.order_date}</td>
                        <td>${row.telephone}</td>
                        <td>${row.name}</td>
                        <td style="max-width: 130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">${row.address}</td>
                        <td>${row.pay}</td>
                        <td>${row.status}</td>
                        <td>${row.total_products}</td>
                        <td>${row.total_price}</td>
                        <td><a href="./my-order-detail.php?id=${row.order_id}" class="link-to-detail"><i class="fa-solid fa-eye"></i></a></td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);            
        },
        error: function() {
            console.error('Failed to fetch data from the server.');
        }
    });
}