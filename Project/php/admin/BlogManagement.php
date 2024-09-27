<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
            if($role_id != 1 && $role_id != 2){
                header("Location: ../store/login-signup-forgot/Login.php");
                exit();
            }

        } else {
            // Redirect to login page if user is not logged in or role_id is not set
            header("Location: ../store/login-signup-forgot/Login.php");
            exit();
        }
        // $role_id = 1; //nhớ xóa đi
        $title = "Quản lý Blogs";
        include("AdminNavigation.php");
    ?>
    <!-- end: admin navigation -->
    

    <!-- start: main section -->
    <div class="section">
        <h2 class="section_heading">Blogs</h2>
        
        <!-- start: search bar, button section -->
        <div class="section_top-content">

            <div class="top-content left">
                <div class="admin-search-container">
                    <div class="search-bar-box">
                        <input type="text" id="search" placeholder="Tìm kiếm..." class="form-control ">
                        <!-- <a href="#" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></a> -->
                    </div>
                </div>
            </div>

            <div class="top-content right">
                <button class="btn-admin btn-add" data-bs-toggle="modal" data-bs-target="#add-new">
                    <i class="fa-solid fa-plus"></i>Thêm mới
                </button>
            </div>
        </div>
        <!-- end: search bar, button section -->

        <!-- start: section_botton-content -->
        <div class="section_bottom-content">
            <!-- start: admin table -->
            <div class="admin-table">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Tên blog</th>
                            <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                Nội dung</th>
                            <th>Người viết</th>
                            <th>Ngày thêm</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- end: admin table -->

            <!-- start: pagination in admin -->
            <div class="pagination admin">
                <a href="#">&laquo;</a>
                <a class="active" href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
            </div>
            <!-- end: pagination in admin -->
        </div>
        <!-- end: section_botton-content -->
    </div>
    <!-- end: main section -->


    <!-- start of Modal of Add new elements. Modified 10/22/2023 by Quyen -->
    <?php include("ModalAddNewBlog.php"); ?>
    <!-- end of Modal of Add new elements-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type = "module" src="../../js/blog/blog-admin.js"></script>
</body>
</html>
