import { showToastr } from "./toastr.js";
var tbl_id, tbl_login, tbl_name, tbl_phone, tbl_birthday, tbl_gender,
tbl_address, tbl_dayadd, tbl_role_name, add_password = "";
var closest_row;


$(document).ready(function () {
    var namePage = $('.section_heading').text();

    // Fetch data using AJAX
    // Initialize the page to 1
    var currentPage = 1;
    fetchData(currentPage);

    // when btn-add button is clicked
    $('.btn-add').click(function (event){
        $('h1.modal-title').text('Thêm mới ' + namePage);
        $('.btn-confirm').text('Thêm mới');

        // Clear the data and reset the form validation in the modal
        var modal = document.getElementById('add-new');
        modal.querySelector('form').reset(); // Reset the form

        $('#employee-username').removeClass('is-invalid'); //remove class is-invalid if the form was validated before
        $('#employee-username').prop('disabled', false);
        Array.from(modal.querySelectorAll('.was-validated')).forEach((element) => {
            element.classList.remove('was-validated'); // Clear Bootstrap form validation classes
        });

        $('.pw-box').show();
        $('#employee-password').val('');
    })

    $('.generate-pw').on('click', function(e){
        e.preventDefault();
        console.log('a');
        var characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var password = '';

        for (var i = 0; i < 10; i++) {
            var index = Math.floor(Math.random() * characters.length);
            password += characters.charAt(index);
        }
        add_password= password;
        $('#employee-password').val(password);
    })

    // when submit #modal-form
    $('#modal-form').submit(function (event) { 
        event.preventDefault();
        var form = $(this);
        var btn_name = $('#modal-form .btn-confirm').text();
        // Create a temp_employee object
        var username =  $('#employee-username').val();
        var name =  $('#employee-name').val();
        var phone =  $('#employee-phone').val();
        var date_of_birth =  $('#employee-date-of-birth').val();
        var gender =  $('#employee-gender').val();
        var address =  $('#employee-address').val();
        var role =  $('#employee-role').val();
        var searchTerm = $('#search').val();

            //insert 
        Array.from(form).forEach(form_element => {

            if (form_element.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            else 
            {
                if(btn_name.localeCompare("Thêm mới") === 0){
                    if(add_password == "")
                        showToastr("warning", "Hãy tạo mật khẩu cho nhân viên");
                    else{
                        event.preventDefault();
                        insertemployee(username, name, add_password, phone, date_of_birth, gender, address, role, searchTerm);
                        event.stopPropagation();
                    }
                }
                else{
                    event.preventDefault();
                    updateemployee(username, name, phone, date_of_birth, gender, address, role, searchTerm);
                    event.stopPropagation();
                }
            }
            form.addClass('was-validated');
        })
    });

    // Event listener for the "Delete" button
    $('.admin-table').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        // Show a confirmation dialog
        if (confirm('Xác nhận xóa ' + namePage + ' ?')) {
            // Get the employee_id from the first column of the row
            tbl_id = $(this).closest('tr').find('td:first').text();
            tbl_login = $(this).closest('tr').find('td:eq(1)').text();
            closest_row = $(this).closest('tr');
            // User confirmed, proceed with deletion
            deleteemployee(tbl_id, tbl_login, closest_row);
        }
    });


    // Event listener for the "Edit" button
    $('.admin-table').on('click', '.btn-edit',function (e) {
        e.preventDefault();

        $('.pw-box').hide();

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
        tbl_role_name = $.trim(closest_row.find('td:eq(8)').text());

        // Remove the is-invalid class in form-controls
        var modal = document.getElementById('add-new');
        Array.from(modal.querySelectorAll('.is-invalid')).forEach((element) => {
            element.classList.remove('is-invalid'); // Clear Bootstrap form validation classes
        });
        $('#modal-form').removeClass('was-validated');

        //fetch data from admin-table into modal
        $('#employee-username').val(tbl_login);
        $('#employee-username').prop('disabled', true);
        $('#employee-name').val(tbl_name);
        $('#employee-phone').val(tbl_phone);
        $('#employee-date-of-birth').val(tbl_birthday);
        $('#employee-address').val(tbl_address);

        $("select#employee-gender option").filter(function() {
            return $(this).text() == tbl_gender;
          }).prop('selected', true);

        $("select#employee-role option").filter(function() {
            return $(this).text() == tbl_role_name;
          }).prop('selected', true);

        // Populate the modal form with the fetched employee_name
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
        url: '../../php/controller/admin/employee-controller.php', 
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
                        <td> ${row.NAME_ROLE} </td>
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


// Function to insert employee into the database
function insertemployee(username, name, password, phone, birthday, gender, address, role, searchTerm) {
    $.ajax({
        url: '../../php/controller/admin/employee-controller.php',
        type: 'POST',
        data: {
            action: 'insert', 
            username : username, 
            name : name, 
            password : password,
            phone : phone, 
            gender : gender, 
            address : address, 
            birthday : birthday, 
            role : role},
        dataType: 'json',
        success: function (result) {
            if (result.result === true) {
                $('#add-new').modal('hide');

                showToastr('success', 'Thêm nhân viên thành công');

                var current_page = parseInt($('.pagination a.active').data('page'));
                fetchSearchData(searchTerm, current_page); 
            } 
            else {
                // employee name exists, show an error message
                $('#employee-username').addClass('is-invalid');
                $('#modal-form').addClass('was-validated');

                showToastr('warning', 'Tên đăng nhập đã tồn tại');
            }
        },
            error: function () {
                showToastr('error', 'Thêm nhân viên không thành công');
                console.error('Failed to insert employee.');
        }
    });
}

// function to update a employee
function updateemployee(username, name, phone, birthday, gender, address, role, searchTerm){
    $.ajax({
        url: '../../php/controller/admin/employee-controller.php',
        type: 'POST',
        data: {action: 'update', id: tbl_id, username: username, name : name, phone : phone, gender : gender, address : address, birthday : birthday, role : role},
        dataType: 'json',
        success: function (result) {
            $('#add-new').modal('hide');

            showToastr('success', 'Cập nhật nhân viên thành công');

            var current_page = parseInt($('.pagination a.active').data('page'));
            fetchSearchData(searchTerm, current_page); 
        },
        error: function () {
            showToastr('error', 'Cập nhật nhân viên không thành công');
            console.error('Failed to insert employee.');
        }
    });
}

// Function to delete employee by employee_id
function deleteemployee(employeeId, employeeLogin, closest_row) {
    $.ajax({
        url: '../../php/controller/admin/employee-controller.php',
        type: 'POST',
        data: {action: 'delete', employee_id: employeeId, employee_login: employeeLogin },
        success: function () {
            closest_row.remove();
            showToastr('success', 'Xóa nhân viên thành công');
        },
        error: function () {
            showToastr('error', 'Xóa nhân viên không thành công');
            console.error('Failed to delete employee.');
        }
    });
}


// Function to fetch data based on search term (employee name)
function fetchSearchData(searchTerm, page) {
    $.ajax({
        url: '../../php/controller/admin/employee-controller.php',
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
                        <td> ${row.NAME_ROLE} </td>
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
