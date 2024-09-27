<?php 
    $title = "Đặt lại mật khẩu";
    include("./login-head.php"); ?>
 
    <div class="container bg-white rounded-4" style="height:480px;">
        <form>
            <div class="text-center">
                <h2 class="p-4 text-center">Đặt lại mật khẩu</h2>
            </div>
            <div class="form-floating col-12 m-1 mb-3">
                <input class="form-control" type="password" id="new_password" placeholder=" Mật khẩu mới" required
                oninvalid="this.setCustomValidity('Vui lòng nhập mật khẩu mới.')" 
                    oninput="this.setCustomValidity('')">
                <label for="new_password" class="form-label"> Mật khẩu mới</label>
            </div>

            <div class="form-floating col-12 m-1 mb-4">
                <input class="form-control" type="password" id="confirm_password" placeholder=" Nhập lại mật khẩu mới" required 
                    oninvalid="this.setCustomValidity('Vui lòng nhập lại mật khẩu mới.')" 
                    oninput="this.setCustomValidity('')">
                <label for="confirm_password" class="form-label"> Nhập lại mật khẩu mới</label>
            </div>

            <div class="btn-container col-12 m-1">
                <button class="btn btn-confirm btn-reset" style="width: 100%;">Lưu thay đổi</button>
                <a class="btn btn-cancel w-100" href="Login.php">Đi đến Đăng nhập</a>
            </div>
            
        </form>
    </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="module" src="../../../js/store/account-management/ForgetPw.js"></script>
</body>

</html>



