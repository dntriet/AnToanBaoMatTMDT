import { showToastr } from "../../admin/toastr.js";

$(document).ready(function() {
    // EDIT ACCOUNT PROFILE-------------------------
    //EVENT WHEN OPEN MODAL
    $('#open-profile').on('click', function(){
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../php/controller/store/login-signup-forgotpw/account-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // Gửi dữ liệu 
        var data = 'action=' + encodeURIComponent('fetch_profile');
        
        xhr.send(data);
        // Xử lý khi có phản hồi từ server
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    $('#name-profile').val(response.data.USER_NAME);
                    $('#dateofbirth').val(response.data.BIRTHDAY);
                    $('#phonenumber').val(response.data.USER_TELEPHONE);
                    $('input[name="gioitinh"][value="' + response.data.GENDER + '"]').prop('checked', true);
                }
                else
                    // Đăng nhập thất bại, hiển thị thông báo lỗi
                    showToastr('error', response.message);
            }
        };
    })

    //EVENT WHEN CONFIRM EDIT
    $('#edit-profile .btn-confirm').on('click', function(e){
        // Lấy giá trị từ các trường nhập liệu
        var name = document.getElementById('name-profile').value;
        var dateOfBirth = document.getElementById('dateofbirth').value;
        var gender = document.querySelector('input[name="gioitinh"]:checked').value;
        var phoneNumber = document.getElementById('phonenumber').value;
        var phone_input = document.getElementById('phonenumber');

        if(name.localeCompare('') != 0  && phone_input.checkValidity()){
            e.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../../../php/controller/store/login-signup-forgotpw/account-controller.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // Gửi dữ liệu 
            var data = 'action=' + 'edit_profile' +
                    "&name=" + encodeURIComponent(name) +
                    '&phoneNumber=' + encodeURIComponent(phoneNumber) +
                    "&dateOfBirth=" + encodeURIComponent(dateOfBirth) +
                    "&gender=" + encodeURIComponent(gender);
            
            xhr.send(data);
            // Xử lý khi có phản hồi từ server
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        showToastr('success', response.message);
                        $('#edit-profile').modal('hide');
                    }
                    else
                        // Đăng nhập thất bại, hiển thị thông báo lỗi
                        showToastr('error', response.message);
                }
            };
        }
    })

    //EVENT WHEN CANCEL EDIT
    $('#edit-profile .btn-cancel').on('click', function(e){
        if(confirm('Những thay đổi của bạn sẽ không được lưu?')){
            $('#edit-profile').modal('hide');
        }
    })



    // EDIT ADDRESS-------------------------
    //EVENT WHEN OPEN MODAL
    $('#open-address').on('click', function(){
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../../../php/controller/store/login-signup-forgotpw/account-controller.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // Gửi dữ liệu 
        var data = 'action=' + encodeURIComponent('fetch_address');
        
        xhr.send(data);
        // Xử lý khi có phản hồi từ server
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    // Update modal fields with fetched data
                    $('#name').val(response.data.USER_NAME);
                    var address = response.data.ADDRESS;

                    // Split the address into parts using ','
                    if(address != null){
                        var addressParts = address.split(', ');

                        // Extract specific parts
                        var specificaddress = addressParts[0];
                        var district = addressParts[1];
                        var ward = addressParts[2];
                        var province = addressParts[3];

                        $('#specificaddress').val(specificaddress);
                        $('#district').val(district);
                        $('#ward').val(ward);
                        $('#province').val(province);
                    }
                    else{
                        $('#specificaddress').val('');
                        $('#district').val('');
                        $('#ward').val('');
                        $('#province').val('');
                    }
                }
                else
                    // Đăng nhập thất bại, hiển thị thông báo lỗi
                    showToastr('error', response.message);
            }
        }
    })

    //EVENT WHEN CONFIRM EDIT
    $('#edit-address .btn-confirm').on('click', function(e){
        var name = document.getElementById('name').value;
        // var phoneNumber = document.getElementById('phonenumber').value;
        var province = document.getElementById('province').value;
        var district = document.getElementById('district').value;
        var ward = document.getElementById('ward').value;
        var specificAddress = document.getElementById('specificaddress').value;
        if (name !== '' && province !== '' && ward !== '' && specificAddress !== '' && district !== '') 
        {
            e.preventDefault();
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../php/controller/store/login-signup-forgotpw/account-controller.php', true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // var data = 'action=' + 'edit_profile' +
            // '&name=' + encodeURIComponent(name) +
            // '&phoneNumber=' + encodeURIComponent(phoneNumber) +
            // "&dateOfBirth=" + encodeURIComponent(dateOfBirth) +
            // "&gender=" + encodeURIComponent(gender);

            var data = 'action=' + 'edit_address' +
            '&name=' + encodeURIComponent(name) +
            '&province=' + encodeURIComponent(province) +
            '&district=' + encodeURIComponent(district) +
            '&ward=' + encodeURIComponent(ward) +
            '&specificAddress=' + encodeURIComponent(specificAddress);

            xhr.send(data);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response from the server if needed
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        console.log(response);
                        $('#edit-address').modal('hide');
                        showToastr('success', response.message);
                    }
                    else
                        // Đăng nhập thất bại, hiển thị thông báo lỗi
                        showToastr('error', response.message);
                }
            };
        }
    })

    //EVENT WHEN CANCEL EDIT
    $('#edit-address .btn-cancel.btn-edit-address').on('click', function(e){
        if(confirm('Những thay đổi của bạn sẽ không được lưu?')){
            $('#edit-address').modal('hide');
        }
    })


    // EDIT PASSWORD-------------------------
    //EVENT WHEN CONFIRM EDIT
    $('#edit-pass .btn-confirm').on('click', function(e){
        var oldPassword = document.getElementById('oldpassword').value;
        var newPassword = document.getElementById('newpassword').value;
    
        if(oldPassword.localeCompare('') != 0 && newPassword.localeCompare('') != 0){
            e.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../../../php/controller/store/login-signup-forgotpw/account-controller.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("oldPassword=" + encodeURIComponent(oldPassword) 
                    + "&newPassword=" + encodeURIComponent(newPassword) + "&action=" + 'reset_password');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        $('#edit-pass').modal('hide');
                        showToastr('success', response.message);
                    }
                    else
                        // Đăng nhập thất bại, hiển thị thông báo lỗi
                        showToastr('error', response.message);
                }
            };
        }
    })
    
    //EVENT WHEN CANCEL EDIT
    $('#edit-pass .btn-cancel.btn-edit-pass').on('click', function(e){
        if(confirm('Những thay đổi của bạn sẽ không được lưu?')){
            $('#edit-pass').modal('hide');
        }
    })

    // LOGOUT------------------------- 
    $('#logout').on('click', function(){
        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the request method, URL, and set it to be asynchronous
        xhr.open('POST', '../../../php/controller/store/login-signup-forgotpw/account-controller.php', true);

        // Set the request header
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send("action="+"logout");
        // Set the callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                //TODO: Trờ về trang chủ lúc chưa đăng nhập
                window.location.href = '../../../php/store/homepage-shopping/homepage.php';
            }
        };
    })

});
