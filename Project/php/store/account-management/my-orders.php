<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if user is not logged in or role_id is not set
  header("Location:../login-signup-forgot/Login.php");
  exit();
}
?>
<?php
    $title = "Danh sách đơn hàng của tôi";
    include("../header-footer-nav/header.php");
?>

<!-- MAIN SECTION START -->
  <!-- NAVIGATION ACCOUNT START -->
    <?php include("../header-footer-nav/navigation-account.php");?>
  <!-- NAVIGATION ACCOUNT START -->
    
  <!--LIST-ORDERS START-->
    <div class="list-orders">
      <!--breadscrumb-->
      <ul class="breadcrumb-my-order">
        <li class="breadcrumb-current-page">Danh sách đơn hàng</li> / 
      </ul>

      <h2>Danh sách đơn hàng của tôi</h2>
      <!--search bar-->
      <div class="search-bar">
        <input type="text" name="" placeholder="Nhập mã đơn hàng" class="search-field" id="search">
      </div>
      <!--          -->

      <!-- Change table style. modified 10/28 by Quyen --> 
      <!--Table list orders--start-->
      <div class="store-table orders-list">
        <table>
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
              <th></th> 
          </tr>
          </thead>

          <tbody></tbody>
        </table>
      </div>
      <!--Table list orders--end-->
    
      <!--pagination--start-->
      <!-- <div class="pagination"  id="pagination-my-orders">
      </div> -->
      <!--pagiantion--end-->
    </div>
  <!--LIST-ORDERS END-->
</div>
<!--MAIN SECTION END-->
<script src="../../../js/my-order/my-order-management.js"></script>
<?php
    include("../header-footer-nav/footer.php");
?>
