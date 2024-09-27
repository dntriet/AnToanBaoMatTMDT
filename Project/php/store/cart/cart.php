<?php
  session_start();
  $user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
  echo '<script> var user_id =' . $user_id . ';</script>';
?>
  <!-- Add particular css link to file: start -->
  <link rel="stylesheet" href="../../../css/store/cart.css" />
  <!-- Add particular css link to file: start -->
  <!-- page header: start -->
  <?php 
    $title = "Giỏ hàng";
    include("../header-footer-nav/header.php");
  ?>
  <!-- page header: end -->
  <!-- CART: START -->
  <div class="cart" method="get" action="checkout.php">
    <!-- CART-HEADER: Start -->
    <div class="cart-header">
      <h2>Giỏ hàng</h2>
      <a href="../homepage-shopping/product_list.php">
        <span class="material-symbols-outlined"> keyboard_backspace </span
        >Tiếp tục mua sắm
      </a>
    </div>
    <!-- CART-HEADER: End -->

    <!-- CART-BODY: Start -->
    <div class="cart-body">
      <!-- PRODUCT-LIST: Start -->
      <table class="product-list--cart">
        <!-- header -->
        <tr class="product-list--header">
          <th><p>Tên sản phẩm</p></th>
          <th><p>Giá</p></th>
          <th><p>SL</p></th>
          <th><p>Tổng tiền</p></th>
          <th></th>
        </tr>

        <!-- product -->
        <tbody class="product-list--body"> 
        
        </tbody>
        
      </table>
      <!-- PRODUCT-LIST: End -->

      <!-- SUBMIT-SECTION: Start -->
      <div class="submit-section flex">
        <!-- sub total: Start -->
          <div class="sub-total flex">
            <p>Tạm tính</p>
            <p><span class="sub-total--amount">143910</span> đ</p>
          </div>
        <!-- sub total: End -->

        <!-- total: Start -->
        <div class="total flex">
          <p>Tổng <small class="gray-text">(Bao gồm thuế VAT)</small></p>
          <p><span class="total-amount">143910</span> đ</p>
        </div>
        <!-- total: End -->

        <!-- checkout btn: Start -->
        <button 
          class="btn checkout-bnt pointer" 
          onclick="location.href='../checkout/checkout.php'">
            Tiến hành thanh toán
        </button>
        <!-- checkout btn: End -->
      </div>
      <!-- SUBMIT-SECTION: End -->
    </div>
    <!-- CART-BODY: End -->
  </div>
  <!-- CART: END -->

  <!-- EPMTY-CART: START -->
  <div class="empty-cart hidden">
    <img
    src="https://www.fudcoshop.com/pub/static/frontend/MageBig/martfury_layout04/en_GB/images/empty-cart.svg"
    class="empty-cart--img" />
    <p class="empty-cart--notification">
      Không có sản phẩm nào trong giỏ hàng
    </p>
    <a href="../homepage-shopping/product_list.php" class="btn empty-cart--shopping" >TIẾP TỤC MUA SẮM</a>
  </div>
  <!-- EPMTY-CART: END -->

  <!-- page footer: start -->
  <?php include("../header-footer-nav/footer.php");?>
  <!-- page footer: start -->

  <!-- js: start -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="../../../js/store/cart-checkout/cart/cart.js"></script>
  <!-- <script src="../../../js/homepage-shopping/product_detail.js"></script> -->
  <!-- js: end -->
<!-- push value to database: start -->
<?php

//check online payment
include "../../Controller/connect.php";
  global $conn;

  if(isset($_GET['partnerCode'])){
    $data_momo = [
      'id' => $_GET['id'],
      'partnerCode' => $_GET['partnerCode'],
      'orderId' => $_GET['orderId'],
      'requestId' => $_GET['requestId'],
      'amount' => $_GET['amount'],
      'orderInfo' => $_GET['orderInfo'],
      'orderType' => $_GET['orderType'],
      'transId' => $_GET['transId'],
      'resultCode' => $_GET['resultCode'],
      'message' => $_GET['message'],
      'payType' => $_GET['payType'],
      'responseTime' => $_GET['responseTime'],
      'extraData' => $_GET['extraData'],
      'signature' => $_GET['signature'],
      'paymentOption' => $_GET['paymentOption']
    ];

    //lưu vào momo data csdl
    $sql = "INSERT INTO momo_payment (order_id, partnerCode, orderId, requestId, amount, orderInfo, orderType, transId, resultCode, message, payType, responseTime, extraData, signature, paymentOption) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "isssissssssssss",  // Adjust data types accordingly
        $data_momo['id'],
        $data_momo['partnerCode'],
        $data_momo['orderId'],
        $data_momo['requestId'],
        $data_momo['amount'],
        $data_momo['orderInfo'],
        $data_momo['orderType'],
        $data_momo['transId'],
        $data_momo['resultCode'],
        $data_momo['message'],
        $data_momo['payType'],
        $data_momo['responseTime'],
        $data_momo['extraData'],
        $data_momo['signature'],
        $data_momo['paymentOption']
    );

    if($stmt->execute())
    {
    //Thay đổi trạng thái đơn hàng trong csdl
      if($data_momo['message'] != 'Successful.'){
        $sqlUpdateOrder='UPDATE ORDERS SET STATUS="Đã hủy" WHERE ORDER_ID=?';
        $buySql=$conn->prepare($sqlUpdateOrder);
        $buySql->bind_param("i", $data_momo['id']);
        $buySql->execute();
        $message = "Giao dịch bị hủy. Đặt hàng không thành công!";
      }
      else{
        $message = "Đặt hàng thành công!";
      }
     
        echo "
        <script>
        // Use JavaScript to remove query parameters from the URL
        if (window.history.replaceState) {
            // Modify the URL without a page reload
            var cleanUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
            window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
        }
        alert(".$message.");
        </script>
        ";
    }
  }

  $conn->close();

?>
<!-- push value to database: end -->