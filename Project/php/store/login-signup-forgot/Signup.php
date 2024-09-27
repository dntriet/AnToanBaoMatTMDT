
<?php 
    $title = "Đăng ký";
    include("login-head.php"); ?>

    <div class="container bg-white rounded-4"  style="height: 650px;">
        <form>
            <h2 class="p-4 text-center">ĐĂNG KÝ</h2>

            <div class="row g-3">
                <div class="col-12 form-floating">
                    <input class="form-control" type="text" id="name" placeholder=" Họ và tên" style="font-size: 12px;"required
                    oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')"
                    oninput="this.setCustomValidity('')">
                    <label for="name" class="form-label">Họ và tên</label>
                </div>

                <div class="col-12 form-floating">
                    <input class="form-control" type="tel" id="customerphone" placeholder=" Số điện thoại" required pattern="^0[0-9]{9}$"
                    oninvalid="this.setCustomValidity('Yêu cầu nhập số điện thoại có 10 số và bắt đầu =0')"
                    oninput="this.setCustomValidity('')">
                    <label for="customerphone" class="form-label"> Số điện thoại</label>
                </div>

                <div class="col-12 form-floating">
                    <input class="form-control" type="text" id="userlogin" placeholder=" Tên đăng nhập" style="font-size: 12px;"required pattern="^\S+$"
                    oninvalid="this.setCustomValidity('Vui lòng nhập tên tài khoản.')"
                    oninput="this.setCustomValidity('')">
                    <label for="userlogin" class="form-label">Tên đăng nhập</label>
                </div>

                <div class="col-12 form-floating" >
                    <input class="form-control" type="password" id="password" placeholder=" Mật khẩu"required
                    oninvalid="this.setCustomValidity('Vui lòng nhập mật khẩu.')"
                    oninput="this.setCustomValidity('')">
                    <label for="password" class="form-label"> Mật khẩu</label>
                </div>

                <div class="col-12 form-floating" >
                    <input class="form-control" type="password" id="repassword" placeholder=" Nhập lại mật khẩu" required
                    oninvalid="this.setCustomValidity('Vui lòng nhập lại mật khẩu.')"
                    oninput="this.setCustomValidity('')">
                    <label for="repassword" class="form-label"> Nhập lại mật khẩu</label>
                </div>

                <div class="col-12">
                    <button class="btn btn-confirm w-100">Đăng ký</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="module" src="../../../js/store/account-management/Signup.js"></script>
</body>

</html>
