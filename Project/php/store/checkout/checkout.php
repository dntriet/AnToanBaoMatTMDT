<?php
  session_start();
  $user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
  echo '<script> var user_id =' . $user_id . ';</script>';
?>
    <!-- Add particular css link to file: start -->
      <link rel="stylesheet" href="../../../css/store/checkout.css" />
    <!-- Add particular css link to file: start -->

    <!-- BODY HEADER: Start -->
    <?php 
      $title = "Thanh toán";
      include("../header-footer-nav/header.php");
    ?>
    <!-- BODY HEADER: End -->

    <!-- CHECKOUT'S MAIN CONTENT: Start -->
    <div class="checkout">
      <!-- CHECKOUT HEADER: Start -->
      <div class="checkout-header">
        <h2>Thanh toán</h2>
        <a href="#" onclick="location.href='../cart/cart.php'">
          <span class="material-symbols-outlined"> keyboard_backspace </span
          >Quay về giỏ hàng
        </a>
      </div>
      <!-- CHECKOUT's HEADER: End -->

      <!-- CHECKOUT BODY: Start -->
      <!-- <form action="checkoutBuy.php" method="get"> -->
      <form action="../../Controller/store/cart-checkout/checkout-controller.php" method="post" id="buy-form">
        <div class="checkout-body flex">
          <!-- INFOR FORM: Start -->
          <div class="left-col" style="width: 50%;">
            <div class="infor-form flex flex-col">
              <!-- GENDER: Start -->
              <div class="gender flex">
                <div>
                  <input
                    class="square-radio gender-radio"
                    type="radio"
                    name="gender"
                    id="Nam"
                    required/>
                  <label for="${inputGenderId}">Nam</label>
                </div>
                <div>
                  <input
                    class="square-radio gender-radio"
                    type="radio"
                    name="gender"
                    id="Nữ"
                    required/>
                  <label for="${inputGenderId}">Nữ</label>
                </div>
              </div>
              <!-- GENDER: End -->

              <!-- NAME: Start -->
              <input
                type="text"
                placeholder="Họ tên*"
                id="name"
                name="name"
                required
                class="input-char customer-name" 
                aria-required="true"/>
              <!-- NAME: End -->

              <!-- PHONE NUMBER: Start -->
              <input
                type="tel"
                placeholder="SĐT*"
                id="phone"
                name="phone"
                aria-required="true"
                required
                class="input-char customer-phone" 
                pattern="(\+84|0)\d{7,10}"/>
              <!-- PHONE NUMBER: End -->

              <!-- ADDRESS: Start -->
              <div class="address width-50-30">
                <!-- City -->
                <input
                  type="text"
                  class="input-char"
                  id="city"
                  name="city"
                  placeholder="Tỉnh/Thành*"
                  required/>

                  <input
                  type="text"
                  class="input-char"
                  id="district"
                  name="district"
                  placeholder="Quận/Huyện*"
                  required/>
                </select>
              </div>

              <div class="address width-50-50">
                <input
                  type="text"
                  class="input-char"
                  id="ward"
                  name="ward"
                  placeholder="Xã/Phường*"
                  required/>
                <input
                  type="text"
                  placeholder="Ấp, Hẻm, số nhà,...*"
                  required
                  id="street"
                  name="street"
                  class="input-char address-text" />
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
                    <!-- <img src="../../../img/footer_image/paypal.png" />Pay Pal -->
                    <img src="https://cdn-icons-png.flaticon.com/512/5229/5229335.png" />COD
                  </div>
                  <input
                    type="radio"
                    value="cod"
                    class="square-radio"
                    name="payment" 
                    id="cod"
                    required/>
                </div>
              </div>

              <!-- master card -->

              <!-- <div class="payment">
                <div class="payment-header flex vertical-center">
                  <div class="flex vertical-center">
                    <img src="../../../img/footer_image/mastercard.png" />Master Card
                  </div>
                  <input
                    type="radio"
                    value="paypal"
                    class="square-radio"
                    name="payment"
                    required />
                </div>
              </div> -->

              <!-- atm momo -->
              <div class="payment">
                <!-- header -->
                <div class="payment-header flex vertical-center">
                  <div class="flex vertical-center">
                    <img src="../../../img/footer_image/momo.png" />ATM MOMO
                  </div>
                  <input
                    type="radio"
                    value="momo-atm"
                    class="square-radio"
                    name="payment"
                    id="momo-atm"
                    required/>
                </div>
              </div>

              <!-- ví momo -->
              <div class="payment">
                <!-- header -->
                <div class="payment-header flex vertical-center">
                  <div class="flex vertical-center">
                    <img src="../../../img/footer_image/momo.png" />VÍ MOMO
                  </div>
                  <input
                    type="radio"
                    value="momo-wallet"
                    class="square-radio"
                    name="payment"
                    id="momo-wallet"
                     required/>
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
              <!-- PRODUCT LIST HERE -->
            </table>
            <!-- PRODUCT LIST: End -->

            <!-- BUY SECTION: Start -->
            <div class="buy-section">
              <!-- sub total -->

              <div class="sub-total flex">
                <!-- SUB TOTAL HERE -->
              </div>

              <!-- total -->
              <div class="total flex">
                <p>Tổng <small>(bao gồm VAT)</small></p>
                <!-- TOTAL HERE -->
              </div>

              <!-- buy -->
              <input class="buy-btn btn" name="submit" type="submit" value="Mua"/>

              <!-- <input class="buy-btn btn" name="payUrl" type="submit" value="Thanh toán qua MoMo"/> -->
              <!-- accept rule -->
              <input type="checkbox" id="accept-rule" required/>
              <label for="accept-rule" class="gray-text"
                ><small>
                  Tôi đồng ý chính sách bảo mật của cửa hàng.</small
                ></label
              >
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

    <!-- js: start -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../../js/store/cart-checkout/cart/cart.js"></script>
    <script type="text/javascript" src="../../../js/store/cart-checkout/checkout/checkout.js"></script>
    <!-- js: end -->


    