/** @format */
$(document).ready(function () {
  // hien tuy chon tai khoan doi voi nguoi dung: bat dau
  const account = $(".account");
  function getRoleId(user_id) {
    if (user_id === null) {
      account.append(`<li class="sub-nav--item hover-underline">
      <a href="#" id="login">ĐĂNG NHẬP</a>
    </li>`);

      // $(".order-not-login").text("ĐƠN HÀNG");

      $("#login").click(function () {
        // Tạo URL mới với tham số truyền vào là tên sản phẩm
        var url = "../../store/login-signup-forgot/Login.php";

        // Chuyển hướng đến trang mới
        window.location.href = url;
      });
    }

    if (user_id != null) {
      $.ajax({
        type: "GET",
        url: "../../../../Project/php/store/header-footer-nav/headerGetRoleId.php?action=fetch",
        dataType: "json",
        data: { user_id: user_id },
        success: function (response) {
          // console.log(Number(response.ROLE_ID));
          var role_id = 0;
          if (response.result == "success") role_id = response.row.ROLE_ID;
          console.log(role_id);

          var nav = '';
          if( Number(role_id) == 1 )
          {
            nav += `<li class="sub-nav--item hover-underline">
                <a href="../../admin/Dashboard.php">QUẢN LÝ</a>
          </li>`
          }
          else if(Number(role_id) == 2){
            nav += `<li class="sub-nav--item hover-underline">
                <a href="../../admin/CategoriesManagement.php">QUẢN LÝ</a>
          </li>`
          }
          
          // const account = $(".account");
          const accountHTML = `<a>
        <span class="material-symbols-outlined"> account_circle </span>
      </a>
      <ul class="sub-nav">
        <li class="sub-nav--item hover-underline">
          <a href="../account-management/account-profile.php">TÀI KHOẢN</a>
        </li>
        ${ nav }
        <li class="sub-nav--item hover-underline">
          <a href="#" class="logout">LOG OUT</a>
        </li>
      </ul>`;

          account.append(accountHTML);
          // console.log($(".logout"));

          $(".logout").on("click", function () {
            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the request method, URL, and set it to be asynchronous
            xhr.open(
              "POST",
              "../../../php/Controller/store/login-signup-forgotpw/account-controller.php",
              true
            );

            // Set the request header
            xhr.setRequestHeader(
              "Content-Type",
              "application/x-www-form-urlencoded"
            );
            xhr.send("action=" + "logout");
            // Set the callback function to handle the response
            xhr.onreadystatechange = function () {
              if (xhr.readyState === 4 && xhr.status === 200) {
                //TODO: Trờ về trang chủ lúc chưa đăng nhập
                window.location.href =
                  "../../../../Project/php/store/homepage-shopping/homepage.php";
              }
            };
          });
        },
        error: function () {
          console.error("Failed to fetch data from the server.");
        },
      });
    }
  }
  getRoleId(user_id);
  // hien tuy chon tai khoan doi voi nguoi dung: bat dau

  // Mở giỏ hàng
  $("#cartIcon").click(function () {
    // Tạo URL mới với tham số truyền vào là tên sản phẩm
    var url = "../../store/cart-checkout/cart.php";

    // Chuyển hướng đến trang mới
    window.location.href = url;
  });

  // Sự kiện khi tìm kiếm sản phẩm
  $("#search-product").keypress(function (event) {
    // Kiểm tra xem phím được nhấn có phải là phím Enter không (keyCode 13)
    if (event.which === 13) {
      // Lấy giá trị từ trường nhập liệu
      var searchProduct = $(this).val();

      if (searchProduct !== "") {
        // Tạo URL mới với tham số truyền vào là tên sản phẩm
        var url =
          "../../store/homepage-shopping/product_list.php?searchName=" +
          encodeURIComponent(searchProduct);

        // Chuyển hướng đến trang mới
        window.location.href = url;
      }
    }
  });
});
