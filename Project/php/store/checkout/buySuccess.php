<!-- @format -->
  <!-- BODY HEADER: Start -->
  <?php 
    $title = "Thanh toán";
    include("../header-footer-nav/header.php");
  ?>
  <!-- BODY HEADER: End -->

  <!-- BODY: START --> 
  <div style="height:60vh;display: flex;flex-direction: column;justify-content: center;">
    <h1 style="text-align: center; font-size: 45px">Đặt hàng thành công!</h1>
    <div class="icon" style="text-align: center">
      <ion-icon
      name="checkmark-circle-outline"
      style="font-size: 60px; color: #126b00"></ion-icon>
    </div>
  </div>
  <!-- BODY: END -->

  <!-- PAGE FOOTER : START -->
  <?php include('../header-footer-nav/footer.php');?>
  <!-- PAGE FOOTER : END -->

<?php
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
      //Cập nhật thông tin đơn hàng
      $sqlUpdateOrder='UPDATE ORDERS SET STATUS="Đang chuẩn bị hàng", PAY="MoMo" WHERE ORDER_ID=?';
      $buySql=$conn->prepare($sqlUpdateOrder);
      $buySql->bind_param("i", $data_momo['id']);
      if($buySql->execute()){
        echo "
        <script>
        // Use JavaScript to remove query parameters from the URL
        if (window.history.replaceState) {
            // Modify the URL without a page reload
            var cleanUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
            window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
        }
        </script>
        ";
      }
    }
  }

  $conn->close();
?>

