import { showToastr } from "../../admin/toastr.js";

$(document).ready(function() {
  // Get the URL parameters
  var urlParams = new URLSearchParams(window.location.search);

  // Check if the parameter exists, 
  if (urlParams.has('reset')) {
      // Get the value of reset
      var resetSuccessValue = urlParams.get('reset');
      if (resetSuccessValue == 1) {
        showToastr('success', 'Xác thực thành công. Mời đặt lại mật khẩu');
      }

      var currentUrl = window.location.href;

      // Check if the URL contains the reset_success parameter
      if (currentUrl.includes('reset')) {
          // Remove the reset parameter
          var updatedUrl = currentUrl.replace(/(\?|&)reset=[^&]*(&|$)/, '$1');

          // Use replaceState to update the URL without reloading the page
          window.history.replaceState({}, document.title, updatedUrl);
      }
  }

    //RESET PASSWORD
    $('.btn-confirm.btn-reset').on('click', function(e){
        var urlParams = new URLSearchParams(window.location.search);

        // Check if the parameter exists, 
        if (urlParams.has('userlogin')) {
            // Get the value of reset
            var userlogin = urlParams.get('userlogin');
            var new_password = document.getElementById("new_password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if(new_password !== '' && confirm_password !== ''){
                e.preventDefault();
              // gửi dữ liệu đăng nhập lên server
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "../../../php/controller/store/login-signup-forgotpw/account-controller.php", true);
              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
              var data = "userlogin=" + encodeURIComponent(userlogin) + 
              "&new_password=" + encodeURIComponent(new_password) + 
              "&confirm_password=" + encodeURIComponent(confirm_password) + 
              "&action=" + "get_newpassword";

              xhr.send(data);
              xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                  var response = JSON.parse(xhr.responseText);
                  console.log(response);
                  if (response.status === "success") {
                    var resetpw = '1';
                    var encode_resetpw = encodeURIComponent(resetpw);
                    // var encode_userlogin = encodeURIComponent(userlogin);
                    window.location.href = "../../../php/store/login-signup-forgot/Login.php?resetpw=" + encode_resetpw;  
                       
                  } else {
                    // Đăng nhập thất bại, hiển thị thông báo lỗi
                    showToastr('error', response.message);
                  }
                }
              };
            }
        }
    })

});
