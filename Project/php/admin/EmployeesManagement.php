    <!-- start: admin navigation -->
    <?php 
        session_start();
        ob_start();
    
        // Check if user is logged in and role_id is set in the session
        if (isset($_SESSION['user_id']) && isset($_SESSION['role_id'])) {
            $user_id = $_SESSION['user_id'];
            $role_id = $_SESSION['role_id'];
            // $user_name = $_SESSION['user_name']; //user_name phải tự tìm hay có trong session?

            // Include the specific dashboard based on the role
            if($role_id != 1){
                header("Location: ../store/login-signup-forgot/Login.php");
                exit();
            }
    
        } else {
            // Redirect to login page if user is not logged in or role_id is not set
            header("Location: ../store/login-signup-forgot/Login.php");
            exit();
        }
        // $role_id = 1;
        $title = "Quản lý nhân viên";
        include("AdminNavigation.php");
    ?>
    <!-- end: admin navigation -->
    
    <!-- start: main section -->
    <div class="section">
        <h2 class="section_heading">Nhân viên</h2>
        
        <!-- start: search bar, button section -->
            <?php include("SectionTopContent.php"); ?>
        <!-- end: search bar, button section -->

        <!-- start: section_botton-content -->
        <div class="section_bottom-content">
            <!-- start: admin table -->
            <div class="admin-table">
                <table >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên đăng nhập</th>
                            <th>Điện thoại</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">Địa chỉ</th>
                            <th>Ngày thêm</th>
                            <th>Vai trò</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- end: admin table -->

            <!-- start: pagination in admin -->
            <div class="pagination admin">
            </div>
            <!-- end: pagination in admin -->
        </div>

    </div>
    <!-- end: main section -->


    <!-- start of Modal of Add new elements. Modified 10/22/2023 by Quyen -->
    <?php include("ModalAddNewEmployee.php"); ?>
    <!-- end of Modal of Add new elements-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="../../js/admin/common.js"></script>
    <script type="module" src="../../js/admin/employees-management.js"></script>
</body>
</html>
