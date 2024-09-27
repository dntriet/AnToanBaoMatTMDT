<?php
  session_start();
  $user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
  echo '<script> var user_id =' . $user_id . ';</script>';
?>

<link rel="stylesheet" href="../../../css/store/product_list.css">
<link rel="stylesheet" href="../../../css/style-components/pagination.css">

  <!-- Start of header -->
  <?php 
    $title = "Danh mục sản phẩm";
    include("../header-footer-nav/header.php"); ?>
  <!-- End of header -->

    <!-- PRODUCT-LIST--BODY: start -->
    <div class="product-list--body">
      <!-- CATEGORY-HEADER: START -->
      <div class="category-header">
        <!-- TITLE -->
        <h1 class="category-title">For Shoes</h1>
        <!-- breadcrum -->
        <nav class="product-list-link" aria-label="breadcrumb">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="./homepage.php">Trang chủ</a></li>
            <li><a class="breadcrumb-item active" href="#">Danh sách sản phẩm</a></li>
          </ul>
        </nav>
        <!-- DESCRIPTION -->
        <p class="category-search-intro">
          <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Non sit
          adipiscing at habitasse lorem volutpat id. Ipsum urna tortor tempus
          hendrerit mauris, diam, ante. Sit ultricies sed mauri-s, consequat.
          Urna, eu tortor, feugiat id in. Pulvinar sit quis nibh mauris non
          cursus blandit. Vel amet malesuada vulputate auctor enim vitae. Enim
          mi et, fermentum imperdiet. Faucibus tellus a tincidunt arcu proin
          mattis egestas varius amet. Tortor tellus lobortis ut pretium nunc
          elit, ornare. -->
        </p>
      </div>
      <!-- CATEGORY-HEADER: ENS -->

      <!--Khung Filter và Sản phẩm-->
      <div class="filter-product">
        <!--Khung Filter-->
        <!-- left-col: start -->
        <div class="shop-filter">
          <h3>Lọc theo</h3>

          <!-- accordion: start -->
          <div class="accordion" id="accordionPanelsStayOpenExample">
            <!-- collection: start -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <!-- accordion-item header:start -->
                <button
                  class="accordion-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseOne"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseOne">
                  Thể loại
                </button>
                <!-- accordion-item header:end -->
              </h2>

              <!-- accordion-item body: start  -->
              <div
                id="panelsStayOpen-collapseOne"
                class="accordion-collapse collapse show"
                aria-labelledby="panelsStayOpen-headingOne">
              </div>
              <!-- accordion-item body: start  -->
            </div>
            <!-- collection: end -->

            <!-- gender: start -->
            <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <!-- accordion-item header:start -->
                <button
                  class="accordion-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseOne"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseOne">
                  Giới tính
                </button>
                <!-- accordion-item header:end -->
              </h2>
              <!-- <h2 class="accordion-header" id="panelsStayOpen-headingOne"> -->
                <!-- accordion-item header:start -->
                <!-- <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#panelsStayOpen-collapseOne"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseOne">
                  Giới tính
                </button> -->
                <!-- accordion-item header:end -->
              <!-- </h2> -->

              <!-- accordion-item body: start  -->
              <div
                id="panelsStayOpen-collapseOne"
                class="accordion-collapse collapse show"
                aria-labelledby="panelsStayOpen-headingOne">
                <a style='cursor: pointer;' class="accordion-body categoryGender" id="Nam">Giày nam</a>
                <a style='cursor: pointer;' class="accordion-body categoryGender" id="Nữ">Giày nữ</a>
                <a style='cursor: pointer;' class="accordion-body categoryGender" id="Nam, nữ">Giày nam, nữ</a>
              </div>
              <!-- accordion-item body: start  -->
            </div>
            <!-- gender: end -->
          </div>
          <!-- accordion: end -->
            <div style="position: relative; height: 50px;">
              <button id="clearFilter">Bỏ chọn</button>
            </div>
        </div>
        <!-- left-col: end -->

        <!--Khung Sản phẩm-->
        <!-- right-col: star -->
        <div class="right-col">
          <!-- sort-option: start -->
          <select name="sort" id="sort">
            <option value="cheap-to-expensive" >Sắp xếp theo giá tăng dần</option>
            <option value="expensive-to-cheap">Sắp xếp theo giá giảm dần</option>
          </select>
          <!-- sort-option: end -->

          <p id="myTest"></p>

          <!-- product-list: start -->
          <div class="product-list">
          </div>
          <!-- product-list: end -->

          <div class="pagination m-5">
            <p id="loadMoreProductList">Xem thêm</p>
            <!-- <a href="#">&laquo;</a>
            <a class="active" href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <span class="ellipsis">...</span>
            <a href="#">10</a>
            <a href="#">&raquo;</a> -->
          </div>
        </div>
        <!-- right-col: end -->
      </div>
    </div>
    <!-- PRODUCT-LIST--BODY: end -->
  
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
    <script src="../../../js/homepage-shopping/product_list.js"></script>
    <!-- js: end -->

    <!-- Start of footer -->
    <?php include("../header-footer-nav/footer.php"); ?>
    <!-- End of footer -->