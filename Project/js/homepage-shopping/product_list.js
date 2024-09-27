/** @format */

// Fetch data using AJAX
$(document).ready(function () {
    // Lấy giá trị của tham số "gender"
    var optionGender = getParameterByName('gender');

  // Lấy giá trị của tham số "searchName"
  var optionName = getParameterByName("searchName");

  $.ajax({
    url: "../../controller/homepage-shopping/product_list-controller.php?action=fetch",
    type: "GET",
    dataType: "json",
    success: function (data) {
      let countProductCanLoad = 0;
      let countProductHasDisplayed = 0;
      let limitOfProduct = 9;

      // Đưa dữ liệu các thể loại giày
      data.tableCategory.forEach(function (row) {
        $("#panelsStayOpen-collapseOne").append(`
                    <a style='cursor: pointer;' class="accordion-body categoryProduct" 
                    id="${row.category_id}">${row.category_name}</a>
                `);
      });

      // Hàm thực hiện tìm kiếm
      function searchInString(productName, optionName) {
        // Kiểm tra xem optionName có trong productName không
        var isOptionInProduct = productName
          .toLowerCase()
          .includes(optionName.toLowerCase());

        return isOptionInProduct;
      }

      let optionCategory = 0;
      $(".categoryProduct").click(function () {
        optionCategory = $(this).attr("id");

        $(".product-list").empty();

        // Truyền dữ liệu lên giao diện website
        limitOfProduct = 9;
        InsertData(data.tableProduct, optionGender, optionCategory);
      });

      $(".categoryGender").click(function () {
        optionGender = $(this).attr("id");

        $(".product-list").empty();

        // Truyền dữ liệu lên giao diện website
        limitOfProduct = 9;
        InsertData(data.tableProduct, optionGender, optionCategory);
      });

      // Hàm truyền dữ liệu lên màn hình.
      function InsertData(data, optionGender, optionCategory) {
        countProductCanLoad = 0;

        data.some(function (row) {
          // Không thực hiện ở vòng lặp này
          if (
            optionName !== null &&
            searchInString(row.product_name, optionName) === false
          ) {
            return false;
          }

          // Không thực hiện ở vòng lặp này
          if (optionGender !== null && optionGender !== row.gender) {
            return false;
          }

          // Không thực hiện ở vòng lặp này
          if (optionCategory !== 0 && optionCategory !== row.category_id) {
            return false;
          }

          countProductCanLoad++;

          if (countProductHasDisplayed === limitOfProduct) {
            $(".pagination p").show();
            return false;
          }

          countProductHasDisplayed++;
          var imageUrl = "data:first_picture/png;base64," + row.first_picture;
          var moneyString = formatNumber(row.price);
          $(".product-list").append(`
                        <div class="product-detail">
                            <div class="product-img--container">
                                <img src="${imageUrl}" id="${row.product_id}">
                            </div>
                            <a href="#">${row.product_name}</a> 
                            <p id="${row.gender}">${moneyString} VND</p>
                        </div>
                    `);
        });

        // Nút "Xem thêm" bị ẩn
        if (countProductCanLoad <= limitOfProduct) {
          $(".pagination p").hide();
        }

        countProductHasDisplayed = 0;
      }

      // Sự kiện khi ấn vào nút "Xem thêm"
      $(".pagination p").click(function () {
        limitOfProduct *= 2;

        $(".product-list").empty();
        InsertData(data.tableProduct, optionGender, optionCategory);

        if (limitOfProduct >= countProductCanLoad) {
          $(this).hide();
          limitOfProduct = 9;
        }
      });

      $("#clearFilter").click(function () {
        // Xóa các lựa chọn phân loại.
        $("#panelsStayOpen-collapseOne a").removeClass("active");
        $("#panelsStayOpen-collapseTwo a").removeClass("active");
        // Xóa danh sách sản phẩm được hiện thị.
        $(".product-list").empty();
        optionGender = null;
        optionCategory = 0;
        InsertData(data.tableProduct, optionGender, optionCategory);
      });

      // Hàm sắp xếp theo cột "price"
      function SapXepTheoGiaTien(data, condition) {
        data.sort(function (firstRow, secondRow) {
          var columnA = firstRow.price;
          var columnB = secondRow.price;

          if (condition === "asc") return columnA - columnB; // Sắp xếp tăng dần
          return columnB - columnA; // Sắp xếp giảm dần
        });
      }

      // Truyền dữ liệu lên giao diện website
      limitOfProduct = 9;
      InsertData(data.tableProduct, optionGender, optionCategory);

      $("#sort").val("cheap-to-expensive");

      // Xử lý sự kiện khi giá trị của select thay đổi
      $("#sort").change(function () {
        // Lấy giá trị được chọn
        var selectedValue = $(this).val();

        // Xóa danh sách sản phẩm được hiện trên giao diện
        $(".product-list").empty();

        if (selectedValue === "cheap-to-expensive")
          SapXepTheoGiaTien(data.tableProduct, "asc");
        else if (selectedValue === "expensive-to-cheap")
          SapXepTheoGiaTien(data.tableProduct, "desc");
        else if (selectedValue === "male") optionGender = "Nam";
        else if (selectedValue === "female") optionGender = "Nữ";
        else optionGender = "Nam, nữ";

        // Truyền dữ liệu lên giao diện website
        limitOfProduct = 9;
        InsertData(data.tableProduct, optionGender, optionCategory);
      });

      // Xử lí khi ấn vào phân loại giày.
      $(".categoryProduct").click(function () {
        // Loại bỏ lớp "active" từ tất cả các thẻ a
        $("#panelsStayOpen-collapseOne a").removeClass("active");

        // Thêm lớp "active" cho thẻ a được click
        $(this).addClass("active");
      });

      // Xử lí khi ấn vào phân loại giới tính.
      $(".categoryGender").click(function () {
        // Loại bỏ lớp "active" từ tất cả các thẻ a
        $("#panelsStayOpen-collapseTwo a").removeClass("active");

        // Thêm lớp "active" cho thẻ a được click
        $(this).addClass("active");
      });
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

  $(".product-list").on("click", ".product-detail", function () {
    let productName = $(this).find("a").text();

    // Tạo URL mới với tham số truyền vào là tên sản phẩm
    var url =
      "../../store/homepage-shopping/product_detail.php?product=" +
      encodeURIComponent(productName);

    // Chuyển hướng đến trang mới
    window.location.href = url;
  });

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
