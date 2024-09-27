import { showToastr } from "./toastr.js";
var tbl_id, tbl_price, tbl_name, tbl_category_name, tbl_color, tbl_description, tbl_gender;
var formData;
var has_3_images, counter;
var closest_row;

$(document).ready(function () {
    var namePage = $('.section_heading').text();
    // Fetch data using AJAX
    // Initialize the page to 1
    var currentPage = 1;
    fetchData(currentPage);

    // when btn-add button is clicked
    $('.btn-add').click(function (event){
        formData = new FormData();
        $('h1.modal-title').text('Thêm mới ' + namePage);
        $('.btn-confirm').text('Thêm mới');

        // Clear the data and reset the form validation in the modal
        var modal = document.getElementById('add-new');
        modal.querySelector('form').reset(); // Reset the form

        $('#product-name').removeClass('is-invalid'); 
        Array.from(modal.querySelectorAll('.was-validated')).forEach((element) => {
            element.classList.remove('was-validated'); // Clear Bootstrap form validation classes
        });

        // Add the 'required' attribute
        $('#product-images').attr('required', 'required');

        // reset the size input into 1 row
        counter = 1;
        var tbody = $(".product-size-table tbody");
        tbody.empty();

        var newRowHtml = `
            <tr>
                <td>
                    <select id="product-size-${counter}" class="size form-select" required>
                        <option value="" disabled selected hidden></option>
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="41">41</option>
                        <option value="42">42</option>
                        <option value="43">43</option>
                        <option value="44">44</option>
                        <option value="45">45</option>
                    </select>
                    <div class="invalid-feedback">
                        Yêu cầu chọn kích thuớc (Mỗi kích thước được chọn 1 lần).
                    </div>
                </td>
                <td>
                    <input type="number" id="product-quantity-${counter}" class="quantity form-control" min="1" step="1" required pattern="[1-9]\d*">
                    <div class="invalid-feedback">
                        Yêu cầu nhập số lượng (số tự nhiên > 0).
                    </div>
                </td>
                <td>
                    <a href="#" class="btn-delete delete-size"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>`;

        // Append the new row HTML to the tbody
        tbody.append(newRowHtml);

        // reset image form-control
        $('.image-box').empty();

        has_3_images = false;


        fetchCategories('');
    })

    // Event listener for the "Edit" button
    $('.admin-table').on('click', '.btn-edit',function (e) {
        formData = new FormData();
        // e.preventDefault();
        
        // Get the closest row to the clicked button
        closest_row = $(this).closest('tr');

        // Get the datas from the row
        tbl_id = $.trim(closest_row.find('td:first').text());
        tbl_price = $.trim(closest_row.find('td:eq(3)').text());
        // tbl_phone = $.trim(closest_row.find('td:eq(2)').text());
        tbl_name = $.trim(closest_row.find('td:eq(2)').text());
        tbl_category_name = $.trim(closest_row.find('td:eq(4)').text());
        tbl_gender = $.trim(closest_row.find('td:eq(6)').text());
        tbl_color = $.trim(closest_row.find('td:eq(5)').text());
        tbl_description = $.trim(closest_row.find('td:eq(7)').text());

        // Remove the is-invalid class in form-controls
        var modal = document.getElementById('add-new');
        Array.from(modal.querySelectorAll('.is-invalid')).forEach((element) => {
            element.classList.remove('is-invalid'); // Clear Bootstrap form validation classes
        });
        $('#modal-form').removeClass('was-validated');
        // Remove the 'required' attribute
        $('#product-images').removeAttr('required');

        
        // reset image form-control
        fetchImages(tbl_id);
        fetchVariants(tbl_id);
        fetchCategories(tbl_category_name);

        //fetch data from admin-table into modal
        $('#product-name').val(tbl_name);
        // $('#product-username').prop('disabled', true);
        $('#product-price').val(tbl_price);
        $('#product-color').val(tbl_color);
        $('#product-description').val(tbl_description);
        // $('#product-address').val(tbl_address);

        $("select#product-gender option").filter(function() {
            return $(this).text() == tbl_gender;
          }).prop('selected', true);
          

          // Populate the modal form with the fetched product_name
        $('h1.modal-title').text('Thông tin ' + namePage);
        $('.btn-confirm').text('Thay đổi');
        
    });


    // EVENT BUTTON CLASS = ADD-SIZE IS CLICKED
    $("a.btn.add-size").on("click", function () {
        var tbody = $(".product-size-table tbody");

            // Check if the number of existing rows is less than 9
            if (tbody.find("tr").length < 9) {
                // Increment the counter for a unique ID
                counter++;

                // Create a new row with the specified HTML content and unique IDs
                var newRowHtml = `
                    <tr>
                        <td>
                            <select id="product-size-${counter}" class="size form-select" required>
                                <option value="" disabled selected hidden></option>
                                <option value="35">35</option>
                                <option value="36">36</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                            </select>
                            <div class="invalid-feedback">
                                Yêu cầu chọn kích thuớc (Mỗi kích thước được chọn 1 lần).
                            </div>
                        </td>
                        <td>
                            <input type="number" id="product-quantity-${counter}" class="quantity form-control" min="1" step="1" required pattern="[1-9]\d*">
                            <div class="invalid-feedback">
                                Yêu cầu nhập số lượng (số tự nhiên > 0).
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn-delete delete-size"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>`;

                // Append the new row HTML to the tbody
                tbody.append(newRowHtml);

            } else {
                // Optional: Show an alert or perform some action if the limit is reached
                alert('You have reached the maximum limit of rows.');
            }
    });


    // event listener for the 'delete-size' button in table
    $(".product-size-table").on("click", ".delete-size", function (e) {
        e.preventDefault();
            // Show a confirmation dialog
            if (confirm('Xác nhận xóa kích thước?')) {
                $(this).closest('tr').remove();
            }
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

    //delete
    //TODO: nên check điều kiên xóa ở csdl nữa
    // Event listener for the "Delete" button
    $('.admin-table').on('click', '.btn-delete.btn-table', function (e) {
        e.preventDefault();
        // Show a confirmation dialog
        if (confirm('Xác nhận xóa ' + namePage + ' ?')) {
            // Get the product_id from the first column of the row
            closest_row = $(this).closest('tr');
            tbl_id = closest_row.find('td:first').text();
            // User confirmed, proceed with deletion
            deleteProduct(tbl_id, closest_row);
        }
    });


    // khi thêm file vào input
    $('#product-images').on('change', function () {
        // Add the 'required' attribute
        $('#product-images').attr('required', 'required');
        var fileInput = $(this);
        var imageBox = $('.image-box');
        var invalidFeedback = $('.invalid-feedback.image');
    
        // Check the number of selected files
        var numberOfFiles = fileInput[0].files.length;
    
        // Clear previous content
        imageBox.empty();
    
        // Check form validation and add 'is-invalid' class if needed
        if (numberOfFiles !== 3) {
            fileInput.addClass('is-invalid');
            invalidFeedback.show();
            return;
        } else {
            has_3_images = true;
            
            //check file types
            var files = fileInput[0].files;
            
            for (var i = 0; i < 3; i++) {
                var fileName = files[i].name;
                var idxDot = fileName.lastIndexOf(".") + 1;
                var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                
                if (extFile !== "jpg" && extFile !== "jpeg" && extFile !== "png"){
                    fileInput.value = ''; // Clear the file input
                    fileInput.addClass('is-invalid');
                    invalidFeedback.show();
                    return;
                }
            }

            fileInput.removeClass('is-invalid');
            invalidFeedback.hide();

            formData = new FormData();
    
            // Display selected images
            for (var i = 0; i < 3; i++) {
                var file = fileInput[0].files[i];
                var reader = new FileReader();
                formData.append('product-images[]', file);
                
    
                // Closure to capture the file information.
                reader.onload = (function (theFile) {
                    return function (e) {
                        // Create an <img> element and set its source
                        var img = $('<img>')
                            .attr('src', e.target.result)
                            .attr('max-width', '100px')
                            .attr('height', '110px')
                            .css('object-fit', 'contain');
    
                        // Append the <img> element to the imageBox
                        imageBox.append(img);
                    };
                })(file);
    
                // Read in the image file as a data URL.
                reader.readAsDataURL(file);
            }
        }
        
    });

    
    // // Event listener for the "submit" button
    $('#modal-form').submit(function (event) { 
        event.preventDefault();
        var form = $(this);
        var btn_name = $('#modal-form .btn-confirm').text();
        // Create a temp_product object
        var name =  $.trim($('#product-name').val());
        var price =  $.trim($('#product-price').val());
        var category_id =  $.trim($('#product-categories').val());
        var color =  $.trim($('#product-color').val());
        var gender = $.trim($('#product-gender').val());
        var description =  $.trim($('#product-description').val());
        var product_variants = []; //store sizes and quantity of each size
        var isDuplicate = false; // check if there are more than 1 size has the same value
        var searchTerm = $('#search').val();

        formData.append('name', name);

        //function to push size, quantity from sizes and quantities into product_variants array
        $('.product-size-table tbody tr').each(function(index, row) {
            var sizeSelect = $(row).find('select[id^="product-size-"]');
            var quantityInput = $(row).find('input[id^="product-quantity-"]');

            var sizeValue = sizeSelect.val();
            var quantityValue = quantityInput.val();

            // Check for duplicate 'size' elements
            if (product_variants.some(item => item.size === sizeValue)) {
                isDuplicate = true;
                sizeSelect.addClass('is-invalid');
                return;
            } else {
                sizeSelect.removeClass('is-invalid');
            }

            if (sizeValue && quantityValue && !isDuplicate) {
                product_variants.push({
                    size: sizeValue,
                    quantity: quantityValue
                });
            }
        });


        // check form validation before call function insert or update product    
        Array.from(form).forEach(form_element => {
            if (form_element.checkValidity() === false 
            || isDuplicate === true
            || has_3_images === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            else 
            {
                if(btn_name.localeCompare("Thêm mới") === 0){
                    var action = "insert-images";
                    formData.append('action', action);

                    event.preventDefault();
                    insertProduct(name, price, category_id, color, gender, description, product_variants, searchTerm);
                    // event.stopPropagation();
                }
                else{
                    var update_images = false;

                    var files = $('#product-images')[0].files;
                    if (files.length > 0) {
                        update_images = true;
                            
                        var action = "update-images";
                        formData.append('action', action);
                    } 
                    event.preventDefault();
                    updateProduct(update_images, tbl_id, name, price, category_id, color, gender, description, product_variants, searchTerm);
                    // event.stopPropagation();
                }
            }
            form.addClass('was-validated');
        })
    });


});


// Function to fetch categories from the server
function fetchCategories(category_name) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {action: 'fetch-categories'},
        dataType: 'json',
        success: function (data) {
            var selectElement = $('#product-categories');
            selectElement.empty();
            selectElement.append(`<option value="" disabled selected hidden></option>`);
            
            data.forEach(function (row) {
                selectElement.append(
                    `<option value="${row.category_id}">${row.category_name}</option>`
            );});

            if(category_name.localeCompare('') !== 0){
                $('#product-categories option').filter(function() {
                    return $(this).text() == category_name;
                }).prop('selected', true);
            }
        },
        error: function () {
            showToastr('error', 'Load danh mục không thành công');
            console.error('Failed to fetch categories from the server.');
        }
    });
}

function fetchImages(id) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {action: 'fetch-images', id: id},
        dataType: 'json',
        success: function (data) {
            var imageBox = $('.image-box');
            
            imageBox.empty();
            var imageUrls = []; // Corrected variable name

            imageUrls.push('data:image/png;base64,' + data.first_picture);
            imageUrls.push('data:image/png;base64,' + data.second_picture);
            imageUrls.push('data:image/png;base64,' + data.third_picture);

            // Create an <img> element and set its source
            for (var i = 0; i < 3; i++) {
                var img = $('<img>')
                    .attr('src', imageUrls[i])
                    .attr('width', '100px')
                    .attr('height', '110px')
                    .css('object-fit', 'contain');

                // Append the <img> element to the imageBox
                imageBox.append(img);
            }

        },
        error: function () {
            showToastr('error', 'Load hình ảnh không thành công');
            console.error('Failed to fetch categories from the server.');
        }
    });
}

// Function to fetch variants from the server
function fetchVariants(product_id) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {action: 'fetch-variants', id: product_id},
        dataType: 'json',
        success: function (data) {
            // reset the size input into 1 row
        counter = 0;
        var tbody = $(".product-size-table tbody");
        tbody.empty();

        data.forEach(function (row) {
            counter++;
            tbody.append(`
                <tr>
                    <td>
                        <select id="product-size-${counter}" class="size form-select" required>
                            <option value="" disabled selected hidden></option>
                            <option value="35">35</option>
                            <option value="36">36</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="43">43</option>
                            <option value="44">44</option>
                            <option value="45">45</option>
                        </select>
                        <div class="invalid-feedback">
                            Yêu cầu chọn kích thuớc (Mỗi kích thước được chọn 1 lần).
                        </div>
                    </td>
                    <td>
                        <input value="${row.quantity}" type="number" id="product-quantity-${counter}" class="quantity form-control" min="1" step="1" required pattern="[1-9]\d*">
                        <div class="invalid-feedback">
                            Yêu cầu nhập số lượng (số tự nhiên > 0).
                        </div>
                    </td>
                    <td>
                        <a href="#" class="btn-delete delete-size"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>`);
            
            $("select#product-size-"+ counter+"  option").filter(function() {
                return $(this).text() == row.size;
              }).prop('selected', true);
        });
        
        },
        error: function () {
            showToastr('error', 'Load kích thước không thành công');
            console.error('Failed to fetch variants from the server.');
        }
    });
}




//function to fetch data in database to table
function fetchData(page){
    $.ajax({
        url: '../../php/controller/admin/product-controller.php', //TODO: nhớ sửa lại nếu đổi thành post
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
                var imageUrl = 'data:image/png;base64,' + row.first_picture;
                table_body.append(`
                   <tr>
                        <td>${row.product_id}</td>
                        <td><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                        <td>${row.product_name}</td>
                        <td>${row.price}</td>
                        <td>${row.category_name}</td>
                        <td>${row.color}</td>
                        <td>${row.gender}</td>
                        <td style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">${row.description}</td>
                        <td class="action">
                            <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#add-new"><i class="fa-solid fa-pen"></i></a>
                            <a href="#" class="btn-delete btn-table"><i class="fa-solid fa-trash"></i></a>
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

// Function to insert product into the database
function insertProduct (name, price, category_id, color, gender, description, product_variants, searchTerm) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {
            action: 'insert',
            name: name,
            price: price,
            category_id: category_id,
            color: color,
            gender: gender,
            description: description,
            product_variants: product_variants
        },
        dataType: 'json',
        success: function (result) {
            if (result.result === true) {
                insertImages(searchTerm);
                $('#add-new').modal('hide');
                
                showToastr('success', 'Thêm sản phẩm thành công');
            }
            else{
                showToastr('warning', 'Tên giày đã tồn tại');
                $('#product-name').addClass('is-invalid');
                $('#modal-form').addClass('was-validated');
            }
        },
        error: function () {
            showToastr('error', 'Thêm sản phẩm không thành công');
            console.error('Failed to insert product.');
        }
    });
    
}

// function to insert product images after product is inserted successfully
function insertImages (searchTerm) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            var current_page = parseInt($('.pagination a.active').data('page'));
            fetchSearchData(searchTerm, current_page);
        },
        error: function (error) {
            showToastr('error', 'Thêm ảnh không thành công');
            console.error('Error uploading files: ', error);
        }
    });
}


// update a product
function updateProduct (update_images, id, name, price, category_id, color, gender, description, product_variants, searchTerm) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {
            action: 'update',
            id: id,
            name: name,
            price: price,
            category_id: category_id,
            color: color,
            gender: gender,
            description: description,
            product_variants: product_variants
        },
        dataType: 'json',
        success: function (result) {
            if (result.result === true) {
                if(update_images){
                    updateImages();
                    $('#add-new').modal('hide');
                    showToastr('success', 'Cập nhật sản phẩm thành công');
                    var current_page = parseInt($('.pagination a.active').data('page'));
                    fetchSearchData(searchTerm, current_page);
                }
                else
                {
                    $('#add-new').modal('hide');
                    showToastr('success', 'Cập nhật sản phẩm thành công');
                    var current_page = parseInt($('.pagination a.active').data('page'));
                    fetchSearchData(searchTerm, current_page);
                }
            }
            else{
                $('#product-name').addClass('is-invalid');
                $('#modal-form').addClass('was-validated');
                showToastr('warning', 'Tên giày đã tồn tại');
            }
        },
        error: function () {
            showToastr('error', 'Cập nhật sản phẩm không thành công');
            console.error('Failed to update product.');
        }
    });
    
}

function updateImages () {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if (result.result === true) {
            }
        },
        error: function (error) {
            showToastr('error', 'Cập nhật ảnh không thành công');
            console.error('Error uploading files: ', error);
        }
    });
}

// Function to delete product by product_id
function deleteProduct(product_id, closest_row) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {action: 'delete', product_id: product_id },
        success: function () {
            closest_row.remove();
            showToastr('success', 'Xóa sản phẩm thành công');
        },
        error: function () {
            showToastr('error', 'Xóa sản phẩm không thành công');
            console.error('Failed to delete product.');
        }
    });
}
    

// Function to fetch data based on search term (product name)
function fetchSearchData(searchTerm, page) {
    $.ajax({
        url: '../../php/controller/admin/product-controller.php',
        type: 'POST',
        data: {action: 'search', searchTerm: searchTerm, page: page },
        dataType: 'json',
        success: function (response) {
            var data = response.data;
            var totalPages = response.totalPages;

            // Populate the table with fetched data
            var table_body = $('.admin-table table tbody');
            table_body.empty(); 

            data.forEach(function (row) {
                var imageUrl = 'data:image/png;base64,' + row.first_picture;
                table_body.append(`
                   <tr>
                        <td>${row.product_id}</td>
                        <td><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                        <td>${row.product_name}</td>
                        <td>${row.price}</td>
                        <td>${row.category_name}</td>
                        <td>${row.color}</td>
                        <td>${row.gender}</td>
                        <td style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">${row.description}</td>
                        <td class="action">
                            <a href="#" class="btn-edit" data-bs-toggle="modal" data-bs-target="#add-new"><i class="fa-solid fa-pen"></i></a>
                            <a href="#" class="btn-delete btn-table"><i class="fa-solid fa-trash"></i></a>
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



