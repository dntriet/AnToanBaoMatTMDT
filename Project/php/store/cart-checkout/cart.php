   <!-- Add particular css link to file: start -->
    <link rel="stylesheet" href="../../../css/store/cart.css" />
   <!-- Add particular css link to file: start -->
   
   <!-- page header: start -->
    <?php 
      $title = "Giỏ hàng";
      include("../header-footer-nav/header.php");
    ?>
    <!-- page header: end -->

    <!-- CART-HEADER: Start -->
    <div class="cart">
      <div class="cart-header">
        <h2>Giỏ hàng</h2>
        <a href="#">
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
          <tr class="product">
            <!-- infor -->
            <td class="product-infor">
              <img
                class="product-img"
                src="https://bisuth-store-demo.myshopify.com/cdn/shop/products/14.4.png?v=1657703781" />
              <div class="product-descr">
                <a href="#">Tên sản phẩm</a>
                <small class="gray-text">Màu, size</small>
              </div>
            </td>

            <!-- price -->
            <td>199.000</td>

            <!-- amount -->
            <td>
              <div class="flex">
                <button class="amount-btn pointer">-</button>
                <input type="number" min="1" value="1" />
                <button class="amount-btn pointer">+</button>
              </div>
            </td>

            <!-- total -->
            <td>199.00</td>

            <!-- remove from cart -->
            <td>
              <button class="remove-btn pointer">
                <span class="material-symbols-outlined"> delete </span>
              </button>
            </td>
          </tr>

          <tr class="product">
            <!-- infor -->
            <td class="product-infor">
              <img
                class="product-img"
                src="https://bisuth-store-demo.myshopify.com/cdn/shop/products/14.4.png?v=1657703781" />
              <div class="product-descr">
                <a href="#">Tên sản phẩm</a>
                <small class="gray-text">Màu, size</small>
              </div>
            </td>

            <!-- price -->
            <td>199.000</td>

            <!-- amount -->
            <td>
              <div class="flex">
                <button class="amount-btn pointer">-</button>
                <input type="number" min="1" value="1" />
                <button class="amount-btn pointer">+</button>
              </div>
            </td>

            <!-- total -->
            <td>199.00</td>

            <!-- remove from cart -->
            <td>
              <button class="remove-btn pointer">
                <span class="material-symbols-outlined"> delete </span>
              </button>
            </td>
          </tr>

          <tr class="product">
            <!-- infor -->
            <td class="product-infor">
              <img
                class="product-img"
                src="https://bisuth-store-demo.myshopify.com/cdn/shop/products/14.4.png?v=1657703781" />
              <div class="product-descr">
                <a href="#">Tên sản phẩm</a>
                <small class="gray-text">Màu, size</small>
              </div>
            </td>

            <!-- price -->
            <td>199.000</td>

            <!-- amount -->
            <td>
              <div class="flex">
                <button class="amount-btn pointer">-</button>
                <input type="number" min="1" value="1" />
                <button class="amount-btn pointer">+</button>
              </div>
            </td>

            <!-- total -->
            <td>199.00</td>

            <!-- remove from cart -->
            <td>
              <button class="remove-btn pointer">
                <span class="material-symbols-outlined"> delete </span>
              </button>
            </td>
          </tr>
        </table>
        <!-- PRODUCT-LIST: End -->

        <!-- SUBMIT-SECTION: Start -->
        <div class="submit-section flex">
          <!-- sub total: Start -->
            <div class="sub-total flex">
              <p>Tạm tính</p>
              <p>183.000 đ</p>
            </div>
          <!-- sub total: End -->

          <!-- total: Start -->
          <div class="total flex">
            <p>Tổng <small class="gray-text">(Bao gồm thuế VAT)</small></p>
            <p>143.910 đ</p>
          </div>
          <!-- total: End -->

          <!-- checkout btn: Start -->
          <button class="btn checkout-bnt pointer" onclick="location.href='./checkout.php'">Tiến hành thanh toán</button>
          <!-- checkout btn: End -->
        </div>
        <!-- SUBMIT-SECTION: End -->
      </div>
      <!-- CART-BODY: End -->
    </div>

    <script src="../../../js/homepage-shopping/product_detail.js"></script>

    <!-- page footer: start -->
    <?php include("../header-footer-nav/footer.php");?>
    <!-- page footer: start -->
  </body>
</html>
