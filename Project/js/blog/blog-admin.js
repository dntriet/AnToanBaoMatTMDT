import {showToastr} from "../admin/toastr.js";
var tbl_id, tbl_title, tbl_username, tbl_content;
var formData;
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
        $('#blog-name').removeClass('is-invalid'); //remove class is-invalid if the form was validated before

        $('#blog-name').removeClass('is-invalid'); 
        Array.from(modal.querySelectorAll('.was-validated')).forEach((element) => {
            element.classList.remove('was-validated'); // Clear Bootstrap form validation classes
        });

        // Add the 'required' attribute
        $('#blog-images').attr('required', 'required');
        // reset image form-control
        $('.image-box').empty();
        formData = new FormData();
    });


    // when submit #modal-form
    $('#modal-form').submit(function (event) { 
        event.preventDefault();
    
        var form = $(this);
        var btn_name = $('#modal-form .btn-confirm').text();
        var blogName = $('#blog-name').val();
        var blogContent =  $('#blog-content').val();
        var userName = $('#author').val();
        var searchTerm = $('#search').val();

        formData.append('id', tbl_id);
        formData.append('name', blogName);
        formData.append('content', blogContent);
        formData.append('username', userName);
    
        Array.from(form).forEach(form_element => {
            if (form_element.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            else 
            {
                if(btn_name.localeCompare("Thêm mới") === 0){
                    var action = "insert";
                    formData.append('action', action);

                    event.preventDefault();
                    insertBlog(searchTerm);
                    event.stopPropagation();
                }
                else{
                    var action = "update";
                    formData.append('action', action);

                    event.preventDefault();
                    updateBlog(searchTerm);
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
            // Get the category_id from the first column of the row
            var blogId = $(this).closest('tr').find('td:first').text();
            closest_row = $(this).closest('tr');
            // User confirmed, proceed with deletion
            deleteBlog(blogId, closest_row);
        }
    });


    // Event listener for the "Edit" button
    $('.admin-table').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        formData = new FormData();

        // Get the closest row to the clicked button
        var closest_row = $(this).closest('tr');
        // Get the datas from the row
        tbl_id = $.trim(closest_row.find('td:first').text());
        tbl_title = $.trim(closest_row.find('td:eq(2)').text());
        tbl_content = $.trim(closest_row.find('td:eq(3)').text());
        tbl_username = $.trim(closest_row.find('td:eq(4)').text());
        // tbl_img = $.trim(closest_row.find('td:eq(2)').text());
       
        // Remove the is-invalid class in form-controls
        var modal = document.getElementById('add-new');
        Array.from(modal.querySelectorAll('.is-invalid')).forEach((element) => {
            element.classList.remove('is-invalid'); // Clear Bootstrap form validation classes
        });
        $('#blog-name').removeClass('is-invalid'); //remove class is-invalid if the form was validated before

        $('#modal-form').removeClass('was-validated');
        $('#blog-img').removeAttr('required');
        
        $('#blog-name').val(tbl_title);
        fetchImages(tbl_id);
        $('#blog-content').val(tbl_content);
        $('#author').val(tbl_username);
        // Populate the modal form with the fetched category_name
        $('h1.modal-title').text('Thông tin ' + namePage);
        $('.btn-confirm').text('Thay đổi');

    });

    // Event listener for the "Search" button
    $('#search').on('keyup', function () {
        var searchTerm = $('#search').val();

        // Fetch data based on the search term
        if(searchTerm !== 0)
            fetchSearchData(searchTerm, 1);
        else
            fetchData(1);
    });

    // Event listener for the "Cancel" button of modal
    $('.btn-cancel').on('click', function () {
        if (confirm('Những thay đổi của bạn sẽ không được lưu?')) {
            $('#add-new').modal('hide');
            // Clear the data and reset the form validation in the modal
            const modal = document.getElementById('add-new');
            modal.querySelector('form').reset(); // Reset the form

            Array.from(modal.querySelectorAll('.was-validated')).forEach((element) => {
            element.classList.remove('was-validated'); // Clear Bootstrap form validation classes
            });

        } else {
        // Do not dismiss the modal if the user clicks "Cancel" in the confirm box
        }
    });


    // khi thêm file vào input
    $('#blog-img').on('change', function () {
        $('#blog-img').attr('required', 'required');
        var fileInput = $(this);
        var imageBox = $('.image-box');
        var invalidFeedback = $('.invalid-feedback.image');

        // Check the number of selected files
        var numberOfFiles = fileInput[0].files.length;

        // Clear previous content
        imageBox.empty();

        // Check form validation and add 'is-invalid' class if needed
        if (numberOfFiles !== 1) {
            fileInput.addClass('is-invalid');
            invalidFeedback.show();
        } else {
            var file = fileInput[0].files[0];
            var fileName = file.name;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

            // Check file type
            if (extFile !== "jpg" && extFile !== "jpeg" && extFile !== "png") {
                fileInput.value = ''; // Clear the file input
                fileInput.addClass('is-invalid');
                invalidFeedback.show();
            } else {
                fileInput.removeClass('is-invalid');
                invalidFeedback.hide();

                formData = new FormData();

                // Display selected image
                var reader = new FileReader();
                formData.append('blog-img', file);

                // Closure to capture the file information.
                reader.onload = function (e) {
                    // Create an <img> element and set its source
                    var img = $('<img>')
                        .attr('src', e.target.result)
                        .attr('max-width', '200px')
                        .attr('height', '150px')
                        .css('object-fit', 'cover');

                    // Append the <img> element to the imageBox
                    imageBox.append(img);
                };

                // Read in the image file as a data URL.
                reader.readAsDataURL(file);
            }
        }
    });
        

})

//function to fetch data in database to table
function fetchData(page){
    $.ajax({
        url: '../../php/controller/Blog/blog-controller.php', 
        type: 'POST',
        data: {action: 'fetch', page: page },
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;

            // Populate the table with fetched data
            var table_body = $('.admin-table table tbody');
            table_body.empty(); 

            data.forEach(function (row) {
                var imageUrl = 'data:image/png;base64,' + row.BLOG_IMG;
                table_body.append(`
                <tr>
                <td>${row.BLOG_ID}</td>
                <td><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                <td>${row.BLOG_TITLE}</td>
                <td style="max-width: 300px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                    ${row.CONTENT} </td>
                <td>${row.USER_NAME}</td>
                <td>${row.BLOG_DAY}</td>
                <td class="action">
                    <a class = 'btn-edit' href="#" data-bs-toggle="modal" data-bs-target="#add-new"><i class="fa-solid fa-pen"></i></a>
                    <a class = 'btn-delete' href="#"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
                `);
            });

            updatePagination(page, totalPages);
        },
        error: function () {
            console.error('Failed to fetch data from the server.');
        }
    });
}

// function to insert blog images after blog is inserted successfully
function fetchImages(id) {
    $.ajax({
        url: '../../php/controller/Blog/blog-controller.php',
        type: 'POST',
        data: {action: 'fetch-images', id: id},
        dataType: 'json',
        success: function (data) {
            var imageBox = $('.image-box');
            
            imageBox.empty();
            var imageUrls = 'data:image/png;base64,' + data.BLOG_IMG;
          
            // Create an <img> element and set its source
           
                var img = $('<img>')
                    .attr('src', imageUrls)
                    .attr('width', '200px')
                    .attr('height', '150px')
                    .css('object-fit', 'cover');

                // Append the <img> element to the imageBox
                imageBox.append(img);
            

        },
        error: function () {
            console.error('Failed to fetch Blog from the server.');
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

// Function to insert blog into the database
function insertBlog (searchTerm)  {
    $.ajax({
        url: '../../php/controller/Blog/blog-controller.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if ($.trim(result) == 'true') {
                
                $('#add-new').modal('hide');
                
                var current_page = parseInt($('.pagination a.active').data('page'));
                fetchSearchData(searchTerm, current_page);
                showToastr('success', 'Thêm blog thành công');
            }
            else{
                showToastr('warning', 'Tên blog đã tồn tại');
                $('#blog-name').addClass('is-invalid');
                $('#modal-form').addClass('was-validated');
            }
        },
        error: function () {
            showToastr('error', 'Thêm blog không thành công');
            console.error('Failed to insert blog.');
        }
    });
    
}


// update a blog
function updateBlog (searchTerm) {
    $.ajax({
        url: '../../php/controller/Blog/blog-controller.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if ($.trim(result) == 'true') {
                
                $('#add-new').modal('hide');
                
                var current_page = parseInt($('.pagination a.active').data('page'));
                fetchSearchData(searchTerm, current_page);
                showToastr('success', 'Cập nhật blog thành công');
            }
            else{
                showToastr('warning', 'Tên blog đã tồn tại');
                $('#blog-name').addClass('is-invalid');
                $('#modal-form').addClass('was-validated');
            }
        },
        error: function () {
            showToastr('error', 'Cập nhật blog không thành công');
            console.error('Failed to update Blog.');
        }
    });
    
}

// Function to delete blog by blog_id
function deleteBlog(blog_id, closest_row) {
    $.ajax({
        url: '../../php/controller/Blog/blog-controller.php',
        type: 'POST',
        data: {action: 'delete', id: blog_id },
        success: function () {
            closest_row.remove();
            showToastr('success', 'Xóa blog thành công');
        },
        error: function () {
            showToastr('error', 'Xóa blog không thành công');
            console.error('Failed to delete blog.');
        }
    });
}
    
// Function to fetch data based on search term (blog name)
function fetchSearchData(searchTerm, page) {
    $.ajax({
        url: '../../php/Controller/Blog/blog-controller.php',
        type: 'POST',
        data: {action: 'search', searchTerm: searchTerm, page: page },
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;
            // Populate the table with fetched data
            var blog_body = $('.admin-table tbody');
            blog_body.empty(); 

            data.forEach(function (row) {
                var imageUrl = 'data:image/png;base64,' + row.BLOG_IMG;
                blog_body.append(`
                <tr>
                <td>${row.BLOG_ID}</td>
                <td><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                <td>${row.BLOG_TITLE}</td>
                <td style="max-width: 300px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                    ${row.CONTENT} </td>
                <td>${row.USER_NAME}</td>
                <td>${row.BLOG_DAY}</td>
                <td class="action">
                    <a class = 'btn-edit' href="#" data-bs-toggle="modal" data-bs-target="#add-new"><i class="fa-solid fa-pen"></i></a>
                    <a class = 'btn-delete' href="#" ><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
                `);
            });

            updatePagination(page, totalPages);
        },
        error: function () {
            
            console.error('Failed to fetch data from the server.');
        }
    });
}

