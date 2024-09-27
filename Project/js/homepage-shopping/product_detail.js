/** @format */
import {showToastr} from "../admin/toastr.js";
// console.log(user_id);
var myCart = [];
var quantityOfProduct = [];

if (window.location.href.includes("product_detail.php")) {
  if (localStorage.getItem("myCart") !== null)
    myCart = JSON.parse(localStorage.getItem("myCart"));

  // Fetch data using AJAX
  $(document).ready(function () {
    let productName;
    let productPrice;
    let numberOfProduct;
    let productSize;
    let productImage;

    $.ajax({
      url: "../../controller/homepage-shopping/product_detail-controller.php",
      type: "GET",
      dataType: "json",
      data: { product: getParameterByName("product") },
      success: function (data) {
        if (data) {
          let imageUrlFirst =
            "data:FIRST_PICTURE/png;base64," + data.productInfo.FIRST_PICTURE;
          let imageUrlSecond =
            "data:SECOND_PICTURE/png;base64," + data.productInfo.SECOND_PICTURE;
          let imageUrlThird =
            "data:THIRD_PICTURE/png;base64," + data.productInfo.THIRD_PICTURE;
          $(".product-main-img img").attr("src", imageUrlFirst);
          $(".product-info .product-name h2").text(
            data.productInfo.PRODUCT_NAME
          );
          $(".product-info .product-price h3").text(
            formatNumber(data.productInfo.PRICE) + " VND"
          );
          $(".product-category p").text(data.productInfo.CATEGORY_NAME);

          $(".tab-pane p").text(data.productInfo.DESCRIPTION);
          $(".tab-pane #second_img").attr("src", imageUrlSecond);
          $(".tab-pane #third_img").attr("src", imageUrlThird);

          data.tableProductSize.forEach(function (row) {
            var temp = [row.SIZE, row.QUANTITY];
            quantityOfProduct.push(temp);

            $(".size").append(`
              <button class="btn-size">${row.SIZE}</button>
            `);
          });

          let countComment = data.tableComment.length;
          let avgScore = 0;
          $(".people-rate-num").text(countComment + " lượt đánh giá");

          if (countComment > 0) {
            data.tableComment.forEach(function (row) {
              avgScore += Number(row.SCORE);
              $(".review-list").append(`
              <div class="person-review">
                <!-- star: start -->
                <div class="review-star">
                  <span>Điếm số: ${row.SCORE}/5.</span>
                </div>
                <!-- star: end -->

                <!-- comment: start -->
                <div class="review-text">
                  <p>${row.CONTENT}</p>
                </div>
                <!-- comment: end -->

                <!-- img: start -->
                <div class="review-img">
                  <div class="name-date">
                    <div class="name">
                      <p>${row.USER_NAME}</p>
                    </div>
                    <div class="date">
                      <p>${row.CMT_DAY}</p>
                    </div>
                  </div>
                </div>
                <!-- img: end -->
              </div>
            `);
            });
            avgScore = Math.round(avgScore / countComment);
            $(".rating-score h5").text(avgScore);
            $.each(Array(avgScore), function (index) {
              $(".rating-icon").append(`
                <ion-icon name="star"></ion-icon>
              `);
            });
          } else {
            $(".rating-score h5").text(0);
          }

          $(".btn-size").click(function () {
            productSize = $(this).text();
            // Loại bỏ lớp "active" từ tất cả các thẻ a
            $(".size .btn-size").removeClass("btn-active");

            // Thêm lớp "active" cho thẻ a được click
            $(this).addClass("btn-active");
          });

          $(".btn-cancel").click(function () {
            productName = $(".product-name").text();
            productPrice = $(".product-price").text();
            numberOfProduct = $(".number").text();
            productImage = $(".product-main-img img").attr("src");
            var success = false;

            quantityOfProduct.some(function (item) {
              if (item[0] === productSize) {
                if (Number(item[1]) >= Number(numberOfProduct)) {
                  success = true;
                  item[1] = Number(item[1]) - Number(numberOfProduct);
                } else {
                  success = false;
                }
                return true;
              }
            });

            if (
              productName &&
              productPrice &&
              productSize &&
              numberOfProduct &&
              productImage
            ) {
              if (success !== true) 
              // alert("Số lượng sản phẩm không đủ!");
              showToastr("warning", "Số lượng sản phẩm không đủ!")
              else {
                let tempProduct = {
                  productName: productName,
                  productPrice: productPrice,
                  productSize: productSize,
                  numberOfProduct: numberOfProduct,
                  productImage: productImage,
                };

                // Trường hợp không đăng nhập
                if (user_id === null) {
                  // Đưa sản phẩm được chọn vào giỏ hàng.
                  myCart.push(tempProduct);

                  localStorage.setItem("myCart", JSON.stringify(myCart));
                  showToastr("success", "Sản phẩm đã được thêm vào giỏ hàng")
                }
                // Trường hợp có đăng nhập.
                else {
                  $.ajax({
                    type: "POST",
                    url: "../../controller/homepage-shopping/add-to-cart-controller.php",
                    data: {
                      userID: user_id,
                      productData: tempProduct,
                    },
                    success: function (response) {
                      showToastr("success", "Sản phẩm đã được thêm vào giỏ hàng")
                      // alert("Thêm thành công!");
                    },
                    error: function (error) {
                      console.error("Đã xảy ra lỗi:", error);
                    },
                  });
                }
              }
            } else showToastr("warning", "Bạn chưa chọn kích thước!")
            // alert("Thiếu thông tin!");
          });

          $(".btn-confirm").click(function () {
            productName = $(".product-name").text();
            productPrice = $(".product-price").text();
            numberOfProduct = $(".number").text();
            productImage = $(".product-main-img img").attr("src");
            var success = false;

            quantityOfProduct.some(function (item) {
              if (item[0] === productSize) {
                if (Number(item[1]) >= Number(numberOfProduct)) {
                  success = true;
                  item[1] = Number(item[1]) - Number(numberOfProduct);
                } else {
                  success = false;
                }
                return true;
              }
            });

            if (
              productName &&
              productPrice &&
              productSize &&
              numberOfProduct &&
              productImage
            ) {
              if (success !== true) 
                showToastr("warning", "Số lượng sản phẩm không đủ!")
              // alert("Số lượng sản phẩm không đủ!");
              else {
                let tempProduct = {
                  productName: productName,
                  productPrice: productPrice,
                  productSize: productSize,
                  numberOfProduct: numberOfProduct,
                  productImage: productImage,
                };

                // Trường hợp không đăng nhập
                if (user_id === null) {
                  // Đưa sản phẩm được chọn vào giỏ hàng.
                  myCart.push(tempProduct);

                  // Lưu dữ liệu vào localStorage.
                  localStorage.setItem("myCart", JSON.stringify(myCart));
                  showToastr("success", "Sản phẩm đã được thêm vào giỏ hàng")
                }
                // Trường hợp có đăng nhập.
                else {
                  $.ajax({
                    type: "POST",
                    url: "../../controller/homepage-shopping/add-to-cart-controller.php",
                    data: {
                      userID: user_id,
                      productData: tempProduct,
                    },
                    success: function (response) {
                      showToastr("success", "Sản phẩm đã được thêm vào giỏ hàng")
                      // alert("Thêm thành công!");
                    },
                    error: function (error) {
                      console.error("Đã xảy ra lỗi:", error);
                    },
                  });
                }
                // Tạo URL mới với tham số truyền vào là tên sản phẩm
                // var url = '../../store/cart-checkout/cart.php';
                var url = "../../store/cart/cart.php";

                // Chuyển hướng đến trang mới
                window.location.href = url;
              }
            } else showToastr("warning", "Bạn chưa chọn kích thước")
            // alert("Thiếu thông tin!");
          });
        } else {
          console.error("Empty data received from the server.");
        }
      },
      error: function () {
        console.error("Failed to fetch data from the server.");
      },
    });

    function formatNumber(input) {
      let strNumber = String(input);

      // Split the string into groups of 3 characters from the right
      let chunks = [];
      while (strNumber.length > 0) {
        chunks.push(strNumber.slice(-3));
        strNumber = strNumber.slice(0, -3);
      }

      // Reverse the chunks and join them with dots
      let formattedStr = chunks.reverse().join(".");

      return formattedStr;
    }

    // Lấy tên sản phẩm từ URL
    function getParameterByName(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return "";
      return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
  });
} else if (window.location.href.includes("cart.php")) {
  // Chuyển giỏ hàng qua các file có dạng "cart.php"
  myCart = JSON.parse(localStorage.getItem("myCart"));
}

// Hàm lấy số sản phẩm có trong giỏ hàng.
function countProductInCart(myCart) {
  if (myCart !== null) return myCart.length;
  return 0;
}
