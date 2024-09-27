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
    $title = "Thống kê";
    include("AdminNavigation.php");
?>
    <!-- end: admin navigation -->
    
    <link rel="stylesheet" href="../../css/admin/Dashboard.css">

    <!-- start: main section -->
    <div class="section">
        <h2 class="section_heading">Thống kê</h2>
        
        <!-- start: button section -->
        <div class="section_top-content dashboard">
        </div>
        <!-- end: button section -->

        <!-- start: section_botton-content -->
        <div class="section_bottom-content">
            <!-- start: to do lists -->
            <div class="todo-container card">
                <div class="card-body">
                    <p class="card-title container-heading">Danh sách cần làm</p>
                    <div class="row">
                        <div class="col pending-box">
                            <p class="number-display">0</p>
                            <p>Đang chuẩn bị hàng</p>
                        </div>

                        <div class="col delivering-box">
                            <p class="number-display">0</p>
                            <p>Đang giao hàng</p>
                        </div>

                        <div class="col canceling-box">
                            <p class="number-display">0</p>
                            <p>Đã hủy</p>
                        </div>

                        <div class="col out-of-stock-box">
                            <p class="number-display">0</p>
                            <p>Sản phẩm hết hàng</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: to do lists -->
                
            <div id="export-area">
            <!-- start: overview -->
                <div class="overview-container">
                    <p class="container-heading">Tổng quan</p>

                    <div class="row gap-4">
                        <div class="card col total-year-revenue">
                            <div class="card-body">
                                <p>Tổng doanh thu theo năm</p>
                                <p class="number-display">20000 đ</p>
                            </div>
                        </div>

                        <div class="card col total-month-revenue">
                            <div class="card-body">
                                <p>Tổng doanh thu theo tháng</p>
                                <p class="number-display">20000 đ</p>
                            </div>
                        </div>

                        <div class="card col total-year-orders">
                            <div class="card-body">
                                <p>Tổng số đơn hàng theo năm</p>
                                <p class="number-display">20000 đ</p>
                            </div>
                        </div>

                        <div class="card col total-month-orders">
                            <div class="card-body">
                                <p>Tổng số đơn hàng theo tháng</p>
                                <p class="number-display">300</p>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end: overview -->


            <div class="row">
                <!-- start: revenue by categories chart -->
                <div class="col-6 revenue-by-categories-pie-chart-container" >
                    <p class="container-heading">Doanh thu theo loại sản phẩm</p>

                    <!-- Donut Chart -->
                    <div class="card shadow mb-4 mt-2">
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4">
                                <canvas id="myPieChart" style="height:380px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: revenue by categories chart -->

                <!-- start: best seller table -->
                <div class="col-6 best-seller" >
                    <p class="container-heading">Sản phẩm bán chạy trong năm</p>

                    <div class="admin-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Giá</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- end: best seller table -->
            </div>
            
            <!-- start: statistic line chart -->
            <div class="statistic-graph-container">
                <div class="col revenue-line-chart-container" >
                    <p class="container-heading">Thống kê doanh thu</p>

                    <!-- Area Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart" style="height: 400px"></canvas>
                            </div>
                        </div>
                    </div>

                            
                </div>
            </div>
            <!-- end: statistic line chart -->
        </div>
    </div>
    <!-- end: section bottom content -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
    <script type="module" src="../../js/admin/dashboard-management.js"></script>
    
</body>
</html>

