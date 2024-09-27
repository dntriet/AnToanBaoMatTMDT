import { showToastr } from "../../admin/toastr.js";

$(document).ready(function () {
    $('.btn-confirm').click(function (event){
        // Lấy giá trị từ các trường nhập liệu
        var name = document.getElementById('name').value;
        var customerphone = document.getElementById('customerphone').value;
        var userlogin = document.getElementById('userlogin').value;
        var password = document.getElementById('password').value;
        var repassword = document.getElementById('repassword').value;
        var input_phone = document.getElementById('customerphone');

        if(name.localeCompare('') != 0 
        && customerphone.localeCompare('') != 0
        && userlogin.localeCompare('') != 0
        && password.localeCompare('') != 0
        && repassword.localeCompare('') != 0
        && input_phone.checkValidity()){
            event.preventDefault();
            // Kiểm tra mật khẩu nhập lại
            if (password !== repassword) {
                showToastr('error', 'Mật khẩu không khớp. Vui lòng nhập lại.');
            }
            else{
                var name= encodeURIComponent(name), 
                userlogin=  encodeURIComponent(userlogin),
                customerphone= encodeURIComponent(customerphone),
                password=  encodeURIComponent(password);
            
                $.ajax({
                    url: '../../../php/controller/store/login-signup-forgotpw/signup-controller.php',
                    type: 'POST',
                    data: { name:name, 
                            userlogin:userlogin, 
                            customerphone:customerphone, 
                            password:password },
                    success: function (response) {
                        if(response == true){
                            var signup = '1';
                            var encode_signup = encodeURIComponent(signup);
                            window.location.href = "../../../php/store/login-signup-forgot/Login.php?signup=" + encode_signup;  
                        }
                        else
                            showToastr('error', 'Đăng ký không thành công. Tên người dùng đã tồn tại');
                    },
                    error: function () {
                        showToastr('error', 'Đăng ký không thành công.');
                    }
                });
            }
        }
    })
});
