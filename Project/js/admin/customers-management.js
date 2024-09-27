import { showToastr } from "./toastr.js";
var tbl_id, tbl_login, tbl_name, tbl_phone, tbl_birthday, tbl_gender,
tbl_address, tbl_dayadd;
var closest_row;


$(document).ready(function () {
    var namePage = $('.section_heading').text();

    // Fetch data using AJAX
    // Initialize the page to 1
    var currentPage = 1;
    fetchData(currentPage);

    // when submit #modal-form
    $('#modal-form').submit(function (event) { 
        // e.preventDefault();
        var form = $(this);
        var btn_name = $('#modal-form .btn-confirm').text();
        // Create a temp_employee object
        var username =  $('#customer-username').val();
        var name =  $('#customer-name').val();
        var phone =  $('#customer-phone').val();
        var date_of_birth =  $('#customer-date-of-birth').val();
        var gender =  $('#customer-gender').val();
        var address =  $('#customer-address').val();
        var searchTerm = $('#search').val();

            //insert 
        Array.from(form).forEach(form_element => {
            if (form_element.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            else 
            {
                event.preventDefault();
                updatecustomer(username, name, phone, date_of_birth, gender, address,searchTerm);
                event.stopPropagation();
                
            }
            form.addClass('was-validated');
        })
    });

    // Event listener for the "Delete" button
    $('.admin-table').on('click', '.btn-delete', function (e) {
        e.preventDefault();

        // Show a confirmation dialog
        if (confirm('Xác nhận xóa ' + namePage + ' ?')) {
            // Get the customer_id from the first column of the row
            tbl_id = $(this).closest('tr').find('td:first').text();
            tbl_login = $(this).closest('tr').find('td:eq(1)').text();
            // User confirmed, proceed with deletion
            closest_row = $(this).closest('tr');
            deletecustomer(tbl_id, tbl_login, closest_row);
        }
    });


    // Event listener for the "Edit" button
    $('.admin-table').on('click', '.btn-edit',function (e) {
        // Get the closest row to the clicked button
        closest_row = $(this).closest('tr');
        // Get the datas from the row
        tbl_id = $.trim(closest_row.find('td:first').text());
        tbl_login = $.trim(closest_row.find('td:eq(1)').text());
        tbl_phone = $.trim(closest_row.find('td:eq(2)').text());
        tbl_name = $.trim(closest_row.find('td:eq(3)').text());
        tbl_birthday = $.trim(closest_row.find('td:eq(4)').text());
        tbl_gender = $.trim(closest_row.find('td:eq(5)').text());
        tbl_address = $.trim(closest_row.find('td:eq(6)').text());

        // Remove the is-invalid class in form-controls
        var modal = document.getElementById('add-new');
        Array.from(modal.querySelectorAll('.is-invalid')).forEach((element) => {
            element.classList.remove('is-invalid'); // Clear Bootstrap form validation classes
        });
        $('#modal-form').removeClass('was-validated');

        
        //fetch data from admin-table into modal
        $('#customer-username').val(tbl_login);
        $('#customer-username').prop('disabled', true);
        $('#customer-name').val(tbl_name);
        $('#customer-phone').val(tbl_phone);
        $('#customer-date-of-birth').val(tbl_birthday);
        $('#customer-address').val(tbl_address);

        $("select#customer-gender option").filter(function() {
            return $(this).text() == tbl_gender;
          }).prop('selected', true);

        // Populate the modal form with the fetched customer_name
        $('h1.modal-title').text('Thông tin ' + namePage);
        $('.btn-confirm').text('Thay đổi');
    });


    // Event listener for the "Search" button
    $('#search').on('keyup', function () {
        var searchTerm = $('#search').val();

        // Fetch data based on the search term
        if(searchTerm.localeCompare('') != 0)
            fetchSearchData(searchTerm, 1);
        else
            fetchData(1);
    });

})

//function to fetch data in database to table
function fetchData(page){
    $.ajax({
        url: '../../php/controller/admin/customer-controller.php', 
        type: 'POST',
        data: { action: 'fetch', page: page },
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            
            // Populate the table with fetched data
            var table_body = $('.admin-table table tbody');
            table_body.empty(); 

            data.forEach(function (row) {
                table_body.append(`
                    <tr>
                        <td> ${row.USER_ID} </td>
                        <td> ${row.USER_LOGIN} </td>
                        <td> ${row.USER_TELEPHONE} </td>
                        <td> ${row.USER_NAME} </td>
                        <td> ${row.BIRTHDAY} </td>
                        <td> ${row.GENDER} </td>
                        <td style="max-width: 130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"> ${row.ADDRESS} </td>
                        <td> ${row.DAY_ADD} </td>
                        <td class="action">
                            <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#add-new"><i class="fa-solid fa-pen"></i></a>
                            <a href="#" class="btn-delete"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);
        },
        error: function () {
            showToastr('error', 'Load dữ liệu không thành công');
            console.error('Failed to fetch data from the server.');
        }
    });
}

//function to update pagination and fetch the data based on the current page
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

// function to update a customer
function updatecustomer(username, name, phone, birthday, gender, address, searchTerm){
    $.ajax({
        url: '../../php/controller/admin/customer-controller.php',
        type: 'POST',
        data: {action: 'update', id: tbl_id, username: username, name : name, phone : phone, gender : gender, address : address, birthday : birthday},
        dataType: 'json',
        success: function (result) {
            $('#add-new').modal('hide');

            showToastr('success', 'Cập nhật khách hàng thành công');

            var current_page = parseInt($('.pagination a.active').data('page'));
            fetchSearchData(searchTerm, current_page); 
        },
        error: function () {
            showToastr('error', 'Cập nhật khách hàng không thành công');
            console.error('Failed to update customer.');
        }
    });
}

// Function to delete customer by customer_id
function deletecustomer(customerId, customerLogin, closest_row) {
    $.ajax({
        url: '../../php/controller/admin/customer-controller.php',
        type: 'POST',
        data: { action: 'delete', customer_id: customerId, customer_login: customerLogin },
        success: function () {
            closest_row.remove();
            showToastr('success', 'Xóa khách hàng thành công');
        },
        error: function () {
            showToastr('error', 'Xóa khách hàng không thành công');
            console.error('Failed to delete customer.');
        }
    });
}


// Function to fetch data based on search term (customer name)
function fetchSearchData(searchTerm, page) {
    $.ajax({
        url: '../../php/controller/admin/customer-controller.php',
        type: 'POST',
        data: { action: 'search', searchTerm: searchTerm, page: page },
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;

            var table_body = $('.admin-table table tbody');
            table_body.empty();

            data.forEach(function (row) {
                table_body.append(`
                    <tr>
                        <td> ${row.USER_ID} </td>
                        <td> ${row.USER_LOGIN} </td>
                        <td> ${row.USER_TELEPHONE} </td>
                        <td> ${row.USER_NAME} </td>
                        <td> ${row.BIRTHDAY} </td>
                        <td> ${row.GENDER} </td>
                        <td style="max-width: 130px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"> ${row.ADDRESS} </td>
                        <td> ${row.DAY_ADD} </td>
                        <td class="action">
                            <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#add-new"><i class="fa-solid fa-pen"></i></a>
                            <a href="#" class="btn-delete"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                `);
            });

            updatePagination(page, totalPages);
        },
        error: function () {
            showToastr('error', 'Load dữ liệu không thành công');
            console.error('Failed to fetch data from the server.');
        }
    });
}


