import { showToastr } from "./toastr.js";
var tbl_category_id, tbl_category_name;
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
        $('#category-name').removeClass('is-invalid'); //remove class is-invalid if the form was validated before

        Array.from(modal.querySelectorAll('.was-validated')).forEach((element) => {
            element.classList.remove('was-validated'); // Clear Bootstrap form validation classes
        });
    })

    // when submit #modal-form
    $('#modal-form').submit(function (event) { 
        event.preventDefault();
    
        var form = $(this);
        var btn_name = $('#modal-form .btn-confirm').text();
        var categoryName = $('#category-name').val();
        var searchTerm = $('#search').val();
    
        if(btn_name.localeCompare("Thêm mới") == 0){
            //insert 
            Array.from(form).forEach(form_element => {
            
                if (form_element.checkValidity() === false) {
                    $('.invalid-feedback').html('Yêu cầu nhập tên danh mục');
                    event.stopPropagation();
                } else 
                    insertCategory(categoryName, searchTerm);
                
                form.addClass('was-validated');
            })
        }
        else{
            //update
            Array.from(form).forEach(form_element => {
            
                if (form_element.checkValidity() === false) {
                    $('.invalid-feedback').html('Yêu cầu nhập tên danh mục!');
                    event.stopPropagation();
                } 
                else 
                    updateCategory(categoryName, searchTerm);
        
                form.addClass('was-validated');
            })
        }

        
    });

    // Event listener for the "Delete" button
    $('.admin-table').on('click', '.btn-delete', function (e) {
        e.preventDefault();

        // Show a confirmation dialog
        if (confirm('Xác nhận xóa ' + namePage + ' ?')) {
            // Get the category_id from the first column of the row
            var categoryId = $(this).closest('tr').find('td:first').text();
            closest_row = $(this).closest('tr');
            // User confirmed, proceed with deletion
            deleteCategory(categoryId, closest_row);
        }
    });


    // Event listener for the "Edit" button
    $('.admin-table').on('click', '.btn-edit',function (e) {
        e.preventDefault();

        // Get the closest row to the clicked button
        var closest_row = $(this).closest('tr');
        // Get the datas from the row
        tbl_category_id = closest_row.find('td:first').text();
        tbl_category_name = closest_row.find('td:eq(1)').text();

        // Remove the is-invalid class in form-controls
        var modal = document.getElementById('add-new');
        Array.from(modal.querySelectorAll('.is-invalid')).forEach((element) => {
            element.classList.remove('is-invalid'); // Clear Bootstrap form validation classes
        });
        
        $('#category-name').val(tbl_category_name);
        // Populate the modal form with the fetched category_name
        $('h1.modal-title').text('Thông tin ' + namePage);
        $('.btn-confirm').text('Thay đổi');

    });

    // Event listener for the "Search" button
    $('#search').on('keyup', function () {
        var searchTerm = $('#search').val();

        // Fetch data based on the search term
        if(searchTerm.localeCompare('') != 0)
            fetchSearchData(searchTerm, currentPage);
        else
            fetchData(currentPage);
    });

})

//function to fetch data in database to table
function fetchData(page){
    $.ajax({
        url: '../../php/controller/admin/category-controller.php', //TODO: nhớ sửa lại nếu đổi thành post
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
                        <td>${row.category_id}</td>
                        <td>${row.category_name}</td>
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


// Function to insert category into the database
function insertCategory(categoryName, searchTerm) {
    $.ajax({
        url: '../../php/controller/admin/category-controller.php',
        type: 'POST',
        data: { action: 'insert', category_name: categoryName },
        dataType: 'json',
        success: function (result) {
        if (result === true) {
            // Category inserted successfully, close the modal and perform any other necessary actions
            $('#add-new').modal('hide');

            showToastr('success', 'Thêm danh mục thành công');

            var current_page = parseInt($('.pagination a.active').data('page'));
            fetchSearchData(searchTerm, current_page); //TODO: lúc reload thì hiện trang của sp đc thêm hay reload trang hiện tại thoi?
            
        } 
        else {

            // Category name exists, show an error message
            $('#category-name').addClass('is-invalid');//TODO: border-color of form-control is not change into red
            $('.invalid-feedback').html('Danh mục đã có trong hệ thống!');
            // $('#modal-form').addClass('was-validated');
            showToastr('warning', 'Danh mục đã có trong hệ thống!');
        }
        },
        error: function () {
            showToastr('error', 'Thêm danh mục không thành công');
            console.error('Failed to insert category.');
        }
    });
}


// function to update a category
function updateCategory(categoryName, searchTerm){
    // check if the new category name is the old category name
    if(categoryName.localeCompare(tbl_category_name) != 0){
        // Check if the category name already exists
        $.ajax({
            url: '../../php/controller/admin/category-controller.php',
            type: 'POST',
            data: { action: 'update', category_name: categoryName, category_id: tbl_category_id },
            dataType: 'json',
            success: function (result) {
                if (result == true) {
                    // Category inserted successfully, close the modal and perform any other necessary actions
                    $('#add-new').modal('hide');
        
                    showToastr('success', 'Cập nhật danh mục thành công');

                    var current_page = parseInt($('.pagination a.active').data('page'));
                    fetchSearchData(searchTerm, current_page); //TODO: lúc reload thì hiện trang của sp đc thêm hay reload trang hiện tại thoi?
                } 
                else {
                    // Category name exists, show an error message
                    $('#category-name').addClass('is-invalid');//TODO: border-color of form-control is not change into red
                    $('.invalid-feedback').html('Danh mục đã có trong hệ thống!');
                    $('#modal-form').addClass('was-validated');
                    showToastr('warning', 'Danh mục đã có trong hệ thống');
                }
                },
                error: function () {
                    showToastr('error', 'Cập nhật danh mục không thành công');
                    console.error('Failed to insert category.');
                }
        });
    }
    else{
        showToastr('success', 'Cập nhật danh mục thành công');
        $('#add-new').modal('hide');
    }
}

// Function to delete category by category_id
function deleteCategory(categoryId, closest_row) {
    $.ajax({
        url: '../../php/controller/admin/category-controller.php',
        type: 'POST',
        data: { action: 'delete', category_id: categoryId },
        success: function (result) {
                closest_row.remove();
                showToastr('success', 'Xóa danh mục thành công');
        },
        error: function () {
            showToastr('error', 'Xóa danh mục không thành công');
            console.error('Failed to delete category.');
        }
    });
}


// Function to fetch data based on search term (category name)
function fetchSearchData(searchTerm, page) {
    $.ajax({
        url: '../../php/controller/admin/category-controller.php',
        type: 'POST',
        data: { action: 'search', searchTerm: searchTerm, page: page },
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;

            var table_body = $('.admin-table table tbody');
            table_body.empty();

            data.forEach(function (row) {
                // Append rows to the table
                table_body.append(`
                    <tr>
                        <td>${row.category_id}</td>
                        <td>${row.category_name}</td>
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

