<!-- CSS feat -->
    <link rel="stylesheet" href="../../css/admin/admin-orders.css"/>
    <link rel="stylesheet" href="../../css/admin/admin-order-detail.css"/>

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
    // $role_id = 1;
    $title = "Chi tiết đơn hàng";
    include("./AdminNavigation.php");
?>
<!--MAIN SECTION----START-->
<div class="admin-order-detail">
    <h2 class="section_heading">Chi tiết đơn hàng</h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../../php/admin/OrdersManagement.php">Danh sách đơn hàng</a></li>
        <li class= "breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
    </ol>

    <div class="customer-infomation">
        <h3>Mã đơn hàng: #
            <span id="orderId"></span>
            <span class="order-status"></span>
            <button class="btn-edit-info" data-bs-toggle="modal" data-bs-target="#edit-order-status">
                <i class="fa-solid fa-pen "></i>
            </button>
        </h3>
        <!--date order-->
        <div class="date-order">
            <i class="fa-solid fa-calendar"></i>
            Ngày đặt hàng: 
            <span></span>
        </div>

        <!--3 boxes information of customer-->
        <ul class="info-customer">
            <li class="box-info" id="info-1">
            <i class="fa-solid fa-user icon-info"></i>
                    
                <ul class="info">
                    <li class="header-info">Thông tin người nhận 
                    </li>
                    <li> 
                        Họ tên:
                        <span id="cus-name"></span>
                    </li>
                    <li> 
                        SĐT:
                        <span id="cus-tel"></span>
                    </li> 
                </ul>
            </li>
            
            <li class="box-info" id="info-2">
                <i class="fa-solid fa-location-dot icon-info"></i>
                    
                <ul class="info">
                    <li class="header-info">Địa chỉ người nhận
                    </li>
                    <li id="cus-add"></li>
                </ul>
            </li>

            <li class="box-info" id="info-3">
            <i class="fa-solid fa-credit-card icon-info"></i>
                    
                <ul class="info">
                    <li class="header-info">Phương thức thanh toán
                    </li>
                    <li id="cus-pay"></li>
                </ul>
            </li>


        </ul>
    </div>

    <!--Information of products in order-->
    <div class="order-infomation admin-table">
        <table>
            <thead>
                <td colspan="7">Sản phẩm</td>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Mã sản phẩm</th>
                    <th>Kích thước</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>

            <tbody class="tbody-product"></tbody>
        </table>
        <div class="order-cost-box">
            <!--Order cost-->
            <table class="order-cost">
                <tr>
                    <td>Tổng tiền sản phẩm</td>
                    <td class="cost order"></td>
                </tr>

                <tr>
                    <td>Khuyến mãi</td>
                    <td class="cost promotion"></td>
                </tr>

                <tr class="total-cost">
                    <td>Tổng tiền thanh toán</td>
                    <td class="cost total"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!--MAIN SECTION----END-->

<!--Modal edit customer's information-->
<?php
    include("./ModalEditOrderStatus.php");
?>
<!---->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="module" src="../../js/admin/Order/order-detail-management"></script>
