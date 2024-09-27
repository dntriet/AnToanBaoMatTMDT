import { showToastr } from "../../admin/toastr.js";

$(document).ready(function () {
  // Get the URL parameters
  var urlParams = new URLSearchParams(window.location.search);

  // Check if the parameter exists,
  if (urlParams.has("signup")) {
    // Get the value of signup
    var signupSuccessValue = urlParams.get("signup");

    // Now you can use signupSuccessValue as needed
    // console.log('signup_success value:', signupSuccessValue);

    // Example: Show a message if signup_success is 1
    if (signupSuccessValue == 1) {
      showToastr("success", "Đăng ký thành công.");
    }

    // Get the current URL
    var currentUrl = window.location.href;

    // Check if the URL contains the signup_success parameter
    if (currentUrl.includes("signup")) {
      // Remove the signup parameter
      var updatedUrl = currentUrl.replace(/(\?|&)signup=[^&]*(&|$)/, "$1");

      // Use replaceState to update the URL without reloading the page
      window.history.replaceState({}, document.title, updatedUrl);
    }
  }

  if (urlParams.has("resetpw")) {
    // Get the value of resetpw
    var resetpwSuccessValue = urlParams.get("resetpw");
    if (resetpwSuccessValue == 1) {
      showToastr("success", "Đặt lại mật khẩu thành công.");
    }

    // Get the current URL
    var currentUrl = window.location.href;

    if (currentUrl.includes("resetpw")) {
      // Remove the resetpw parameter
      var updatedUrl = currentUrl.replace(/(\?|&)resetpw=[^&]*(&|$)/, "$1");

      window.history.replaceState({}, document.title, updatedUrl);
    }
  }

  $(".btn-confirm").on("click", function (e) {
    var userlogin = document.getElementById("userlogin").value;
    var pass = document.getElementById("pass").value;

    if (userlogin.localeCompare("") != 0 && pass.localeCompare("") != 0) {
      e.preventDefault();
      // gửi dữ liệu đăng nhập lên server
      var xhr = new XMLHttpRequest();
      xhr.open(
        "POST",
        "../../../php/controller/store/login-signup-forgotpw/login-controller.php",
        true
      );
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      var data =
        "userlogin=" +
        encodeURIComponent(userlogin) +
        "&pass=" +
        encodeURIComponent(pass);
      xhr.send(data);
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            //Phân quyền
            var role = response.role;

            var login = "1";
            var encode_login = encodeURIComponent(login);
            window.location.href =
              "../../../php/store/homepage-shopping/homepage.php?login=" +
              encode_login;
            // if (role === 'admin') {
            //     // Link tới admin
            //     window.location.href = "#";
            // } else if (role === 'staff') {
            //     // Link tới staff
            //     window.location.href = "#";
            // } else {
            //     // Link tới User
            //     window.location.href = "#";
            // }
          } else {
            // Đăng nhập thất bại, hiển thị thông báo lỗi
            showToastr("error", response.message);
            console.log(response);
          }
        }
      };
    }
  });
});
