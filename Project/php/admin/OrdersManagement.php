<!-- CSS feat -->
<link rel="stylesheet" href="../../css/admin/admin-orders.css"/>

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
    // $role_id =1;
    $title = "Danh sách đơn hàng";
    include("AdminNavigation.php");
?>

<!--MAIN SECTION----START-->
<div class="admin-orders">
    <h2 class="section_heading">Danh sách đơn hàng</h2>

    <ol class="breadcrumb">
        <li class= "breadcrumb-item active" aria-current="page">Danh sách đơn hàng</li>
    </ol>
    <!--Orders' date-->
    <div class="date-orders">
        <h6>
        <i class="fa-solid fa-calendar"></i>            
            Ngày hóa đơn
        </h6>

        <div class="input-date-range row">
            <div class="col-2">
                <label for="fromdate">Từ</label>
                <input type = "date" id="fromdate" class="input-date form-control" placeholder="Từ ngày">
            </div>
            <div class="col-2 p-0">
                <label for="todate">Đến</label>
                <input type = "date" id="todate" class="input-date form-control" placeholder="Đến ngày">
            </div>
            <div class="col-1">
                <button class="btn-admin btn-add" id="btn-filter-date" value="Tìm">Tìm</button>
            </div>
        </div>
    </div>

    <div class="status-search--flex">
        <!--Dropdown choose status for orders-->
        <select name="status" id="choose-status">
            <option value="">Trạng thái đơn hàng</option>
            <option value="prepare">Đang chuẩn bị hàng</option>
            <option value="shipping">Đang giao hàng</option>
            <option value="order-success">Giao thành công</option>
            <option value="order-cancel">Đã hủy</option>                 
        </select>
        
        <!--Search bar-->
        <div class="admin-search-container">
            <div class="search-bar-box">
                <input type="text" id="search" placeholder="Tìm kiếm theo mã đơn hàng" class="form-control ">
                <!--<a href="#" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></a>-->
            </div>
        </div>
    </div>

    <!--Table list orders-->
    <div class="admin-table">
        <table class="list-orders">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày hóa đơn</th>   
                    <th>SĐT</th>   
                    <th>Tên khách hàng</th>                  
                    <th>Địa chỉ</th>
                    <th>PTTT</th>   
                    <th>Trạng thái</th>   
                    <th>Tổng sản phẩm</th>   
                    <th>Tổng tiền</th>   
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    

    <!--Pagination-->
    <div class="pagination admin">
    </div>
</div>
<!--MAIN SECTION----END-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type = "module" src="../../js/admin/Order/order-management.js"></script>