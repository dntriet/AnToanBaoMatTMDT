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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous" />

    <!-- toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    
    <!-- css file -->
    <link rel="stylesheet" href="../../../css/style-components/base.css" />
    <link rel="stylesheet" href="../../../css/style-components/header.css" />
    <link rel="stylesheet" href="../../../css/style-components/footer.css"/> 
    <link rel="stylesheet" href="../../../css/style-components/pagination.css"/>

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
        <a href="../../store/homepage-shopping/homepage.php"><img src="../../../img/logo.png" /></a>
      </li>
      <!-- LOGO: End -->

      <!-- LINK (HOME, SHOP, CATEGORY,....): Start -->
      <ul class="nav-link">
        <li class="nav-link--item hover-underline"><a href="../homepage-shopping/homepage.php">TRANG CHỦ</a></li>
        <li class="nav-link--item hover-underline"><a href="../homepage-shopping/product_list.php">MUA SẮM</a></li>
        <li class="nav-link--item hover-underline"><a href="../blog-info/about-us.php">ABOUT US</a></li>
        <li class="nav-link--item hover-underline"><a href="../blog-info/blog.php">BLOGS</a></li>
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

        <!-- <li class="nav-icon--item hover-underline"><a href="../account-management/my-orders.php" class="order-not-login"></a></li> -->

        <!-- account -->
        <ul class="nav-icon--item primary-nav account">
        </ul>

        <!-- cart -->
        <li class="nav-icon--item">
          <a href="../cart/cart.php" class="hover-orange">
            <span class="material-symbols-outlined"> shopping_bag </span>
          </a>
        </li>
      </ul>
      <!-- ICON (ACCOUNT, CART): End -->
    </ul>

    <!-- <script src="../../../js/homepage-shopping/product_detail.js"></script> -->
    <script src="../../../js/header/header.js"></script>
    <!-- <script src="../../../js/store/account-management/account-management"></script> -->