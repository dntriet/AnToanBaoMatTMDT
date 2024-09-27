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
    $title = "Đánh giá đơn hàng";
    include("../header-footer-nav/header.php");
?>

<!-- MAIN SECTION START -->
  <!-- NAVIGATION ACCOUNT START -->
  <?php include("../header-footer-nav/navigation-account.php");?>
<!-- NAVIGATION ACCOUNT START -->

<!--MY_ORDER-FEEDBACK START-->
  <div class="my-order-feedback store-table">
        <ul class="breadcrumb-my-order">
          <li><a href="my-orders.php">Danh sách đơn hàng</a> / </li>
          <li id="link-back-order-detail"></li>
          <li class="breadcrumb-current-page">Đánh giá đơn hàng</li>
        </ul>
      <form class="form-rating">
        <h2>Đánh giá đơn hàng</h2>

        <table class="my-order-rating">
          <thead>
            <th>#</th>
            <th colspan="2">Sản phẩm</th>
            <th>Kích thước</th>
            <th>Số lượng</th>
            <th>Giá</th>
          </thead>

          <tbody></tbody>
        </table>
      </form>
  </div>  
</div>    
<!--MY_ORDER-FEEDBACK END-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="module" src="../../../js/my-order/my-order-feedback-management.js"></script>
<?php
    include("ModalOrderFeedback.php");
    ?>
    
<?php
    include("../header-footer-nav/footer.php");
    
?>