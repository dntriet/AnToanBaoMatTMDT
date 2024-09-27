
<?php 
    $title = "Lấy lại mật khẩu";
    include("./login-head.php"); ?>
 
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GCFCN7G09K"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-GCFCN7G09K');
    </script>

    <div class="container bg-white rounded-4" style="height:480px;">
       
            <!-- SENDER -->
                <div class="text-center">
                    <h2 class="p-4 text-center">Quên mật khẩu?</h2>
                    <p>Nhập số điện thoại để xác minh và lấy lại mật khẩu</p>
                </div>
                <!-- <div class="form-floating col-12 m-1 mb-3">
                    <input class="form-control" type="text" id="userlogin" placeholder=" Tên đăng nhập" required
                        oninvalid="this.setCustomValidity('Vui lòng nhập tên đăng nhập.')"
                        oninput="this.setCustomValidity('')">
                    <label for="userlogin" class="form-label"> Tên đăng nhập</label>
                </div> -->
        <form>
            <div id="sender">
                <div class="form-floating col-12 m-1 mb-2">
                    <input class="form-control" type="text" id="phonenumber" placeholder=" Số điện thoại (+84...)" required pattern="\+84\d{9}"
                    oninvalid="this.setCustomValidity('Yêu cầu nhập số điện thoại có 10 số và bắt đầu =0.')" 
                    oninput="this.setCustomValidity('')">
                    <label for="phonenumber" class="form-label"> Số điện thoại</label>
                    <div id="recaptcha-container" style="margin: 10px auto 0; width: 80%;"></div>
                </div>

                <div class="btn-container col-12 m-1">
                    <button id="send" class="btn btn-confirm forget-pw" style="width: 100%;">Nhận mã OTP</button>
                    <a class="btn btn-cancel w-100" href="./Login.php">Quay lại</a>
                </div>
            </div>
        </form>   
        <form>
            <!-- VERIFIER  -->
            <div id="verifier" style="display: none">
                <div class="form-floating col-12 m-1 mb-2">
                    <input type="text" id="verificationcode" placeholder="Mã OTP" class="form-control" required
                    oninvalid="this.setCustomValidity('Yêu cầu nhập mã otp')" 
                    oninput="this.setCustomValidity('')">
                    <label for="verificationcode" class="form-label"> Mã OTP</label>
                </div>
                
                <div class="btn-container col-12 m-1">
                    <button type='submit' class="btn btn-confirm" id="verify" style="width: 100%;">Xác thực</button>
                </div>
            </div>
        </form> 
       
    </div>

    <!-- add toastr  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- add firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.12.1/firebase-auth-compat.js"></script>

    <!-- <script type="module" src="../../../js/store/account-management/ForgetPw.js"></script> -->

  <script>
  var userlogin;

  $(document).ready(function() {
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
      apiKey: "AIzaSyA4Ez_agCzylwE9gUeDE5GSF5eQsRNC85I",
      authDomain: "shoeshop-project.firebaseapp.com",
      projectId: "shoeshop-project",
      storageBucket: "shoeshop-project.appspot.com",
      messagingSenderId: "229488507707",
      appId: "1:229488507707:web:9acb3c501b75d3ca2a951e",
      measurementId: "G-8M8L95VDVX"
      };

    firebase.initializeApp(firebaseConfig);
    render();

    function render(){
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
    }

    // function for send message
    function phoneAuth(){
      var number = document.getElementById('phonenumber').value;
      firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult){
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        alert('Mã OTP đã được gửi đến điện thoại của bạn.');
        document.getElementById('sender').style.display = 'none';
        document.getElementById('verifier').style.display = 'block';
      }).catch(function(error){
          alert(error.message);
      });
    }
      // function for code verify
    function codeverify(){
      var code = document.getElementById('verificationcode').value;
      coderesult.confirm(code).then(function(){
        var reset = '1';
        var encode_reset = encodeURIComponent(reset);
        var encode_userlogin = encodeURIComponent(userlogin);
        window.location.href = "./ResetPassword.php?reset=" + encode_reset + "&userlogin=" + encode_userlogin;  
              
      }).catch(function(){
        alert('Mã không hợp lệ. Xác thực thất bại.');
      })
    }

    //KIỂM TRA SĐT CÓ TỒN TẠI TRONG HỆ THỐNG KHÔNG, NẾU CÓ THÌ TIẾN HÀNH XÁC THỰC SĐT
    $('.btn-confirm.forget-pw').on('click', function(e){
      // var userlogin = document.getElementById("userlogin").value;
      var phonenumber = document.getElementById("phonenumber").value;
      // var txt_userlogin = document.getElementById("userlogin");
      var txt_phonenumber = document.getElementById("phonenumber");

      if(txt_phonenumber.checkValidity()){
          e.preventDefault();
        // gửi dữ liệu đăng nhập lên server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../../Controller/store/login-signup-forgotpw/account-controller.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        var data = "phonenumber=" + encodeURIComponent(phonenumber) +
                  "&action=" + "forget_password";

        xhr.send(data);
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
              userlogin = (response.data).USER_LOGIN;
              
              phoneAuth();
            } else {
              // Đăng nhập thất bại, hiển thị thông báo lỗi
              alert(response.message);
            }
          }
        };
      }
      })

      //VERIFY OTP CODE
      $('#verify').on('click', function(e){
          e.preventDefault();
          codeverify();
      })
    });
    </script>
</body>

</html>

