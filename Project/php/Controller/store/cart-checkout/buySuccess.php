<!-- @format -->
  <!-- BODY HEADER: Start -->
  <!-- @format -->
<?php
  // session_start();
  $user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
  echo '<script> var user_id =' . $user_id . ';</script>';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title; ?></title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- css file -->
    <link rel="stylesheet" href="../../../../css/style-components/base.css" />
    <link rel="stylesheet" href="../../../../css/style-components/header.css" />
    <link rel="stylesheet" href="../../../../css/style-components/footer.css"/> 
    <link rel="stylesheet" href="../../../../css/style-components/pagination.css"/>

    <!-- icon -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
      crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <script src="https://kit.fontawesome.com/f7fcb1a9ac.js"crossorigin="anonymous"></script>
    <!-- icon -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <!-- font-family -->
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap");
    </style>

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  </head>
  <body>
    <ul class="header">
      <!-- LOGO: start -->
      <li class="nav-logo">
        <a href="../../../store/homepage-shopping/homepage.php"><img src="../../../../img/logo.png" /></a>
      </li>
      <!-- LOGO: End -->

      <!-- LINK (HOME, SHOP, CATEGORY,....): Start -->
      <ul class="nav-link">
        <li class="nav-link--item hover-underline"><a href="../../../store/homepage-shopping/homepage.php">TRANG CHỦ</a></li>
        <li class="nav-link--item hover-underline"><a href="../../../store/homepage-shopping/product_list.php">MUA SẮM</a></li>
        <li class="nav-link--item hover-underline"><a href="../../../store/blog-info/about-us.php">ABOUT US</a></li>
        <li class="nav-link--item hover-underline"><a href="../../../../css/store/blog.css">BLOGS</a></li>
      </ul>
      <!-- LINK (HOME, SHOP, CATEGORY,....): End -->

      <!-- ICON (ACCOUNT, CART): Start -->
      <ul class="nav-icon">
        <!-- search -->
        <li class="nav-icon--item">
          <div class="search-box">
            <input type="text" class="search-bar" id="search-product" placeholder="Nhập tên giày để tìm kiếm">
            <a>
              <span class="material-symbols-outlined"> search </span>
            </a>
          </div>
        </li>

        <!-- account -->
        <ul class="nav-icon--item primary-nav account">
        </ul>

        <!-- cart -->
        <li class="nav-icon--item">
          <a href="../../../store/cart/cart.php">
            <span class="material-symbols-outlined"> shopping_bag </span>
          </a>
        </li>
      </ul>
      <!-- ICON (ACCOUNT, CART): End -->
    </ul>

    <!-- <script src="../../../js/homepage-shopping/product_detail.js"></script> -->
    <script src="../../../../js/header/header.js"></script>
  <!-- BODY HEADER: End -->

  <!-- BODY: START --> 
  <div style="height:60vh;display: flex;flex-direction: column;justify-content: center;">
    <h1 style="text-align: center; font-size: 45px">Đặt hàng thàng công!</h1>
    <div class="icon" style="text-align: center">
      <ion-icon
      name="checkmark-circle-outline"
      style="font-size: 60px; color: #126b00"></ion-icon>
    </div>
  </div>
  <!-- BODY: END -->

  <!-- PAGE FOOTER : START -->
  <!--FOOTER START-->
<link rel="stylesheet" href="../../../../css/style-components/footer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="FooterBox">
    <hr>
    <div class="FooterBox__one">
        <div class="FooterBox__one__left">
            <h3>Về chúng tôi</h3>
            <p><a href="#">Trang chủ</a></p>
            <p><a href="#">Cửa hàng</a></p>
            <p><a href="#">Thông tin</a></p>
            <p><a href="help-page.php">Liên hệ</a></p>
        </div>
        <div class="FooterBox__one__center">
            <h3>Khám phá</h3>
            <p><a href="question-page.php">Câu hỏi thường gặp</a></p>
            <p><a href="#">Vận chuyển & Hoàn trản</a></p>
            <p><a href="#">Điều khoản</a></p>
            <p><a href="#">Phương thức thanh toán</a></p>
        </div>
        <div class="FooterBox__one__right">
            <h3>Theo dõi</h3>
            <p><a href="#">Facebook <i class="fa-brands fa-square-facebook"></i></a></p>
            <p><a href="#">Instagram <i class="fa-brands fa-instagram"></i></a></p>
        </div>
    </div>
    <div class="FooterBox__two">
        <hr>
        <div class="FooterBox__two__rightpayment">
            <p>2022 ALL RIGHT RESERVE</p>
            <div>
                <img src="../../../../img/footer_image/visa.png" alt="">
                <img src="../../../../img/footer_image/paypal.png" alt="">
                <img src="../../../../img/footer_image/mastercard.png" alt="">
                <img src="../../../../img/footer_image/momo.png" alt="">
                <img src="../../../../img/footer_image/napas.png" alt="">
            </div>
        </div>
    </div>
</div>
<!--FOOTER END-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</body>

</html>
  <!-- PAGE FOOTER : END -->

<?php
  include "../../connect.php";
  require_once $_SERVER['DOCUMENT_ROOT'].'/Demo_Web_JWT/Project/php/Controller/utils/jwt_utils.php';
  
  global $conn;

  $accessToken = getBearerToken();
  $verifyJWT = json_decode(verifyJWT($accessToken));
  // Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
  if ($verifyJWT->status == 'error') {
      echo json_encode($verifyJWT);
  }
  else {
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
}
?>

