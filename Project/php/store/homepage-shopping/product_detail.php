<?php
  session_start();
  $user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
  echo '<script> var user_id =' . $user_id . ';</script>';
?>
  
  <link rel="stylesheet" href="../../../css/store/product_detail.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- Start of header -->
  <?php 
    $title = "Chi tiết sản phẩm";
    include("../header-footer-nav/header.php"); ?>
  <!-- End of header -->

    <!--Product Detail Nav-->
    <!-- PRODUCT DETAIL'S BODY: START -->
    <div class="product-detail--body">
      <div class="product-nav">
        <h1></h1>
      </div>
      <div class="main-info">
        <!--Khung giới thiệu ảnh sản phẩm-->
        <div class="product-image">
          <div class="product-main-img">
            <img src="" />
          </div>
        </div>
        <!--Khung giới thiệu thông tin sản phẩm-->
        <div class="product-info">
          <div class="product-name"><h2></h2></div>
          <div class="product-price"><h3></h3></div>
          <div class="product-rating">
            <ion-icon name="star"></ion-icon><ion-icon name="star"></ion-icon
            ><ion-icon name="star"></ion-icon><ion-icon name="star"></ion-icon
            ><ion-icon name="star"></ion-icon>
          </div>
          <div class="product-category">
            <h4>Phân loại: </h4>
            <p></p>
          </div>

          <div class="product-size">
            <h4>Kích cỡ:</h4>

            <div class="size">
            </div>
          </div>
          <div class="product-quantity">
            <h4>Số lượng:</h4>
            <div class="quantity">
              <span class="minus change-amount-btn">-</span>
              <span class="number">1</span>
              <span class="plus change-amount-btn">+</span>
            </div>
          </div>
          <div class="shopping-btn">
            <button class="btn btn-cancel">Thêm vào giỏ hàng</button>
            <button class="btn btn-confirm" >Mua ngay</button>
          </div>
        </div>
      </div>
      <!--Khung mô tả và đánh giá-->
      <!-- TAG BTN: start -->
      <nav>
        <div class="nav nav-tabs description" id="nav-tab" role="tablist">
          <button
            class="nav-link active tag-btn"
            id="nav-home-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-home"
            type="button"
            role="tab"
            aria-controls="nav-home"
            aria-selected="true">
            Mô tả
          </button>
          <button
            class="nav-link tag-btn"
            id="nav-contact-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-contact"
            type="button"
            role="tab"
            aria-controls="nav-contact"
            aria-selected="false">
            Review
          </button>
        </div>
      </nav>
      <!-- TAG BTN: start -->

      <!-- TAG-CONTENT: start -->
      <div class="tab-content" id="nav-tabContent">
        <!-- description's content: start -->
        <div
          class="tab-pane fade show active"
          id="nav-home"
          role="tabpanel"
          aria-labelledby="nav-home-tab">

          <!-- Ai đó hãy sữa giùm style chỗ này đc ko :))) -->
          <div class='description-container'> 
              <div class="description-box">
                <p style="flex: 1;"></p>
              </div>
              <div class="image-container">
                <div class="img-box mb-4">
                  <img class="" src="" alt="" id="second_img" width="500px" height="662.5px">
                </div>
          
                <div class="img-box">
                  <img src="" alt="" id="third_img" width="500px" height="662.5px">
                </div>
              </div>
          </div>
          <!-- Ai đó hãy sữa giùm chỗ này đc ko :))) -->
          
        </div>
        <!-- description's content: end -->

        <!-- detail's content:start -->
        <div
          class="tab-pane fade"
          id="nav-profile"
          role="tabpanel"
          aria-labelledby="nav-profile-tab">
          <div class="tab-content">
            <p></p>
            <p></p>
          </div>
        </div>
        <!-- detail's content:end -->

        <!-- review's content: start -->
        <div
          class="tab-pane fade"
          id="nav-contact"
          role="tabpanel"
          aria-labelledby="nav-contact-tab">
          <!-- header: start -->
          <div class="rating-header">
            <h4>Đánh giá</h4>

            <!-- star: start -->
            <div class="rating">
              <!-- rating scrore -->
              <div class="rating-score">
                <h5></h5>
                <div class="rating-icon">
                </div>
              </div>
              <!-- amount of review -->
              <div class="people-rate-num">
                <small></small>
              </div>
            </div>
            <!-- star: start -->
          </div>
          <!-- header: end -->

          <!-- PERSONAL RATING: Star -->
          <div class="review-list">
          </div>
          <!-- PERSONAL RATING: End -->
        </div>
        <!-- review's content: end -->
      </div>
      <!-- TAG-CONTENT: end -->
    </div>
    <!-- PRODUCT DETAIL'S BODY: END -->

    <script>
      // add amount
      const plus = document.querySelector(".plus"),
        minus = document.querySelector(".minus"),
        number = document.querySelector(".number");
      let a = 1;
      plus.addEventListener("click", () => {
        a++;
        number.innerText = a;
      });
      minus.addEventListener("click", () => {
        if (a > 1) {
          a--;
          number.innerText = a;
        }
      });
    </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <script type="module" src="../../../js/homepage-shopping/product_detail.js"></script>

    <!-- bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>

<!-- Start of footer -->
<?php include("../header-footer-nav/footer.php"); ?>
    <!-- End of footer -->
