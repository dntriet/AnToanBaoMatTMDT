    <!-- Add particular css link to file: start -->
      <link rel="stylesheet" href="../../../css/store/checkout.css" />
    <!-- Add particular css link to file: start -->

    <!-- BODY HEADER: Start -->
    <?php 
      $title = "Thanh toán";
      include('../header-footer-nav/header.php');
    ?>
    <!-- BODY HEADER: End -->

    <!-- CHECKOUT'S MAIN CONTENT: Start -->
    <div class="checkout">
      <!-- CHECKOUT HEADER: Start -->
      <div class="checkout-header">
        <h2>Thanh toán</h2>
        <a href="#">
          <span class="material-symbols-outlined"> keyboard_backspace </span
          >Tiếp tục mua sắm
        </a>
      </div>
      <!-- CHECKOUT's HEADER: End -->

      <!-- CHECKOUT BODY: Start -->
      <form>
        <div class="checkout-body flex">
          <!-- INFOR FORM: Start -->
          <div class="left-col">
            <div class="infor-form flex flex-col">
              <!-- GENDER: Start -->
              <div class="gender flex">
                <div>
                  <input
                    class="square-radio"
                    type="radio"
                    name="gender"
                    id="nam" />
                  <label for="nam">Nam</label>
                </div>

                <div>
                  <input
                    class="square-radio"
                    type="radio"
                    name="gender"
                    id="nu" />
                  <label for="nu">Nữ</label>
                </div>
              </div>
              <!-- GENDER: End -->

              <!-- NAME: Start -->
              <input
                type="text"
                placeholder="Họ tên*"
                required
                class="input-char" />
              <!-- NAME: End -->

              <!-- PHONE NUMBER: Start -->
              <input
                type="number"
                placeholder="SĐT*"
                required
                class="input-char" />
              
              <!-- PHONE NUMBER: End -->

              <!-- ADDRESS: Start -->
              <div class="address width-50-30">
                <input
                  type="text"
                  placeholder="Tỉnh/Thành phố*"
                  required
                  class="input-char" />
                <input
                  type="text"
                  placeholder="Huyện/Phường*"
                  required
                  class="input-char" />
              </div>

              <div class="address width-50-50">
                <input
                  type="text"
                  placeholder="Tổ/Ấp*"
                  required
                  class="input-char" />
                <input
                  type="text"
                  placeholder="Hẻm, số nhà,...*"
                  required
                  class="input-char" />
              </div>             
              <!-- ADDRESS: End -->

              <!-- Required field: start -->
              <small class="gray-text">*Required field</small>
              <!-- Required field: End -->
            </div>
            <!-- OTHER ADDRESS: End -->

            <!-- PAYMENT: Start -->
            <div class="payment-section flex flex-col">
              <!-- paypal -->
              <div class="payment">
                <div class="payment-header flex vertical-center">
                  <div class="flex vertical-center">
                    <img src="../../../img/footer_image/paypal.png" />Pay Pal
                  </div>
                  <input
                    type="radio"
                    value="paypal"
                    class="square-radio"
                    name="payment" />
                </div>
              </div>

              <!-- master card -->

              <div class="payment">
                <div class="payment-header flex vertical-center">
                  <div class="flex vertical-center">
                    <img src="../../../img/footer_image/mastercard.png" />Master Card
                  </div>
                  <input
                    type="radio"
                    value="paypal"
                    class="square-radio"
                    name="payment" />
                </div>
              </div>

              <!-- Napas -->
              <div class="payment">
                <!-- header -->
                <div class="payment-header flex vertical-center">
                  <div class="flex vertical-center">
                    <img src="../../../img/footer_image/napas.png" />Napas
                  </div>
                  <input
                    type="radio"
                    value="paypal"
                    class="square-radio"
                    name="payment" />
                </div>
              </div>
            </div>
          </div>
          <!-- PAYMENT: Start -->

          <!-- BUY COLUMN: Start -->
          <div class="right-col">
            <!-- PRODUCT LIST: Start -->
            <table class="product-list--checkout">
              <!-- table col's name -->
              <tr class="col-name">
                <td>Sản phẩm</td>
                <td>Tổng</td>
              </tr>

              <!-- product -->
              <tr class="product-checkout">
                <td class="product-infor">
                  <img
                    class="product-img"
                    src="https://bisuth-store-demo.myshopify.com/cdn/shop/products/14.4.png?v=1657703781" />
                  <div class="product-descr">
                    <a href="#">Tên sản phẩm</a>
                    <small class="gray-text">Màu, size</small>
                    <small>X1</small>
                  </div>
                </td>

                <td>300.000</td>
              </tr>
              <!-- product -->
              <tr class="product-checkout">
                <td class="product-infor">
                  <img
                    class="product-img"
                    src="https://bisuth-store-demo.myshopify.com/cdn/shop/products/14.4.png?v=1657703781" />
                  <div class="product-descr">
                    <a href="#">Tên sản phẩm</a>
                    <small class="gray-text">Màu, size</small>
                    <small>X1</small>
                  </div>
                </td>

                <td>300.000</td>
              </tr>
              <!-- product -->
              <tr class="product-chekout">
                <td class="product-infor">
                  <img
                    class="product-img"
                    src="https://bisuth-store-demo.myshopify.com/cdn/shop/products/14.4.png?v=1657703781" />
                  <div class="product-descr">
                    <a href="#">Tên sản phẩm</a>
                    <small class="gray-text">Màu, size</small>
                    <small>X1</small>
                  </div>
                </td>

                <td>300.000</td>
              </tr>
            </table>
            <!-- PRODUCT LIST: End -->

            <!-- BUY SECTION: Start -->
            <div class="buy-section">
              <!-- sub total -->
              <div class="sub-total flex">
                <p>Tạm tính (3 sản phẩm)</p>
                <p>183.000 đ</p>
              </div>

              <!-- total -->
              <div class="total flex">
                <p>Tổng <small>(bao gồm VAT)</small></p>
                <p>143.910 đ</p>
              </div>

              <!-- buy -->
              <input class="buy-btn btn" type="submit" value="Mua" />
              <!-- accept rule -->
              <input type="checkbox" id="accept-rule" />
              <label for="accept-rule" class="gray-text"
                ><small>
                  Tôi đồng ý chính sách bảo mật của cửa hàng.</small
                ></label
              >
              <!-- avaliable pament method -->
            </div>
            <!-- BUY SECTION: Start -->

            <!-- AVAILABLE PAYMENT: Start -->
            <ul class="payment-list flex">
              <li>
                <img
                  class="payment-method img"
                  src="../../../img/footer_image/visa.png" />
              </li>
              <li>
                <img
                  class="payment-method img"
                  src="../../../img/footer_image/paypal.png" />
              </li>
              <li>
                <img
                  class="payment-method"
                  src="../../../img/footer_image/mastercard.png" />
              </li>
              <li>
                <img
                  class="payment-method img"
                  src="../../../img/footer_image/momo.png" />
              </li>
              <li>
                <img
                  class="payment-method img"
                  src="../../../img/footer_image/napas.png" />
              </li>
            </ul>
            <!-- AVAILABLE PAYMENT: Start -->
          </div>
        </div>
      </form>
      <!-- CHECKOUT BODY: End -->
    </div>
    <!-- CHECKOUT'S MAIN CONTENT: End -->

    <!-- page footer : start -->
      <?php include('../header-footer-nav/footer.php');?>
      <!-- page footer : end -->
  </body>
</html>
