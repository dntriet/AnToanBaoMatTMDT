import {showToastr} from "../toastr.js";
var tbl_id;
var closest_row;
$(document).ready(function() {
    var currentpage = 1;
    fetchData(currentpage);

    //DELETE ORDER
    $('.admin-table').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        // Show a confirmation dialog
        if (confirm('Xác nhận xóa ?')) {
            // Get the employee_id from the first column of the row
            closest_row = $(this).closest('tr');
            tbl_id = closest_row.find('td:first').text();
            // User confirmed, proceed with deletion
            deleteOrder(tbl_id, closest_row);
        }
    });

    //SEARCH ORDER
    $('#search').on('keyup', function () {
        var searchTerm = $('#search').val();

        // Fetch data based on the search term
        if(searchTerm.localeCompare('') != 0)
            fetchSearchData(searchTerm, 1);
        else
            fetchData(1);
    });

    //LINK TO DETAIL
    $('.admin-table').on('click', '.btn-edit', function() {
        closest_row = $(this).closest('tr');
        tbl_id = closest_row.find('td:first').text();

        detailOrder(tbl_id);
    });

    //FILTER BY STATUS
    $('#choose-status').on('change', function() {
        let chosen_status = $(this).val();
        if(chosen_status=='') {
            fetchData(1);
        }
        else {
            filterStatus(chosen_status, 1);            
        }

    });

    //FILTER BY DATE RANGE
    // $('.input-date').datepicker({
    //     "dateFormat": "yy-mm-dd",
    //     "changeYear": true,
    //     "changeMonth": true
    // });

    $('#btn-filter-date').click(function() {
        
        var date_data = {
            fromdate: $('#fromdate').val(),
            todate: $('#todate').val(),
        }
        
        if(date_data.fromdate != '' && date_data.todate != '') {
            filterDateRange(date_data, 1);
        }
        else {
            fetchData(1);
        }
    });


});

function detailOrder(id) {
    $.ajax({
        url: "../../php/controller/admin/orders-controller.php",
        type: 'POST',
        data: {action: 'detail', id: id},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            if(!response.data) showToastr("error", "Dữ liệu rỗng"); 
        },
        error: function() {
            console.error("Loi ket noi");
            showToastr("error", "Lỗi kết nối"); 
        }        
    });
}

function fetchData(page) {
    $.ajax({
        url: "../../../Project/php/controller/admin/orders-controller.php",
        type: 'POST',
        data: {action:'fetch', page: page},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            if(!response.data) console.log("du lieu rong");
            
            var table_body = $('.admin-table table tbody');
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
                        <td class="action">
                            <a href='OrderDetail.php?id=${row.order_id}' class="btn-edit"><i class='fa-solid fa-pen'></i></a>
                            <button class='btn-delete'><i class='fa-solid fa-trash'></i></button>
                        </td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);
        },
        error: function() {
            console.error("Loi ket noi");
            showToastr("error", "Lỗi kết nối"); 
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

  function deleteOrder(order_id, closest_row){
    $.ajax({
        url: '../../php/controller/admin/orders-controller.php',
        type: 'POST',
        data: { action: 'delete',order_id: order_id },
        success: function () {
            showToastr("success", "Xóa đơn hàng #" + order_id + " thành công!"); 
            // alert("Xóa đơn hàng #" + order_id + " thành công!");
            closest_row.remove();
        },
        error: function () {
            showToastr("error", "Xóa đơn hàng không thành công"); 
            console.error('Failed to delete employee.');
        }
    });
  }

  function fetchSearchData(searchTerm, page) {
    $.ajax({
        url: '../../php/controller/admin/orders-controller.php',
        type: 'POST',
        data: {action:'search', searchTerm: searchTerm, page: page},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            // console.log(response.totalPages);
            if(!response.data) console.log("du lieu rong");
            
            var table_body = $('.admin-table table tbody');
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
                        <td class="action">
                            <a href='OrderDetail.php?id=${row.order_id}' class="btn-edit"><i class='fa-solid fa-pen'></i></a>
                            <button class='btn-delete'><i class='fa-solid fa-trash'></i></button>
                        </td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);            
        },
        error: function() {
            showToastr("error", "Lỗi kết nối"); 
            console.error('Failed to fetch data from the server.');
        }
    });
  }

function filterStatus(chosen_status, page) {
    $.ajax({
        url: '../../php/controller/admin/orders-controller.php',
        type: 'POST',
        data: {action:'filterstatus', chosen_status: chosen_status, page: page},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            // console.log(response.totalPages);
            if(!response.data) console.log("du lieu rong");
            
            var table_body = $('.admin-table table tbody');
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
                        <td class="action">
                            <a href='OrderDetail.php?id=${row.order_id}' class="btn-edit"><i class='fa-solid fa-pen'></i></a>
                            <button class='btn-delete'><i class='fa-solid fa-trash'></i></button>
                        </td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);   
        },
        error: function() {
            showToastr("error", "Lỗi kết nối"); 
            console.error('Failed to fetch data from the server.');
        }
    });
}

function filterDateRange(date_data, page) {
    $.ajax({
        url: '../../php/controller/admin/orders-controller.php',
        type: 'POST',
        data: {action:'filterdate', fromdate: date_data.fromdate, todate: date_data.todate, page: page},
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            // console.log(response.totalPages);
            if(!response.data) console.log("du lieu rong");
            
            var table_body = $('.admin-table table tbody');
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
                        <td class="action">
                            <a href='OrderDetail.php?id=${row.order_id}' class="btn-edit"><i class='fa-solid fa-pen'></i></a>
                            <button class='btn-delete'><i class='fa-solid fa-trash'></i></button>
                        </td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);   
        },
        error: function() {
            showToastr("error", "Lỗi kết nối"); 
            console.error('Failed to fetch data from the server.');
        }
    });
}