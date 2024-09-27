
   <?php 
        session_start();
        $title = "Đăng nhập";
        include("./login-head.php"); ?>
 
    <div class="container bg-white rounded-4">
        <form method="post">
            <h2 class="p-4 text-center">ĐĂNG NHẬP</h2>

            <div class="row g-3">
                <div class="col-12 form-floating">
                    <input class="form-control" type="text" id="userlogin" placeholder=" Tên đăng nhập" style="font-size: 12px;" required
                        oninvalid="this.setCustomValidity('Vui lòng nhập tên đăng nhập.')"
                        oninput="this.setCustomValidity('')">
                    <label for="userlogin" class="form-label">Tên đăng nhập</label>
                </div>

                <div class="col-12 form-floating" >
                    <input class="form-control" type="password" id="pass" placeholder=" Mật khẩu"required
                        oninvalid="this.setCustomValidity('Vui lòng nhập mật khẩu.')"
                        oninput="this.setCustomValidity('')">
                    <label for="pass" class="form-label"> Mật khẩu</label>
                </div>

                <div class="col-6 d-inline">
                    <!-- <input type="checkbox" id="remember">
                    <label for="remember" class="form-label" style="color: var(--light-text);">Ghi nhớ mật khẩu</label> -->
                </div>

                <div class="col-6">
                    <a href="./Forgetpass1.php" class="float-end" style="color: var(--light-text);">Quên mật khẩu?</a>
                </div>

                <!-- <div id="messageContainer" class="messageContainer"></div> -->
                
                <div class="col-12">
                    <button class="btn btn-confirm w-100">Đăng nhập</button>
                </div>
                
                <div class="col-12 text-center">
                    <span style="color: var(--light-text);">Không có tài khoản?</span>
                    <a href="./Signup.php" style="color: var(--orange);"><b>Đăng kí ở đây</b></a>
                </div>
            </div>   
        </form>
    </div>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="module" src="../../../js/store/account-management/Login.js"></script>
</body>

</html>
