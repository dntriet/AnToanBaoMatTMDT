/** @format */
// Chỉ cần sử dụng user_id (Nếu chưa đăng nhập thì null)
// console.log(user_id);

// test
// user_id = "KH0036";

$(document).ready(function () {
  displayCheckout(user_id);
});

// DISPLAY CUSTOMER INFOR: START
async function getLoginCheckout(user_id) {
  return $.ajax({
    type: "GET",
    url: "../../../../Project/php/store/checkout/checkoutDisplay.php?action=fetch",
    dataType: "json",
    data: { user_id: user_id },
    success: function (response) {},
    error: function (xhr, textStatus, err) {},
  });
}

function displayCustomerData(customerData) {
  //DISPLAY CUSTOMER INFOR: START
  // gender
  if (customerData.GENDER != null) {
    const gender = document.getElementById(`${customerData.GENDER}`);
    gender.checked = true;
  }

  // personal infor
  $(".customer-name").val(customerData.USER_NAME);
  $(".customer-phone").val(customerData.USER_TELEPHONE);

  // address
  // get address
  if (customerData.USER_ADDRESS) {
    var addressString = customerData.USER_ADDRESS;
    var myString = addressString.split(",");
    for (var i = 0; i < myString.length; i++) {
      myString[i] = myString[i].trim();
    }

    var address = {
      tinhThanh: "",
      quanHuyen: "",
      xaPhuong: "",
      duongAp: "",
    };
    address.duongAp = myString[0];
    if (myString.length == 4) {
      address.xaPhuong = myString[1];
      address.quanHuyen = myString[2];
      address.tinhThanh = myString[3];
    } else {
      address.quanHuyen = myString[1];
      address.tinhThanh = myString[2];
    }
    if (address.tinhThanh == "TP.HCM") {
      address.tinhThanh = "Thành phố Hồ Chí Minh";
    }

    // display address
    $("#city").val(address.tinhThanh);
    $("#district").val(address.quanHuyen);
    $("#ward").val(address.xaPhuong);
    $("#street").val(address.duongAp);
  }
  //DISPLAY CUSTOMER INFOR: END
}

function displayProductData(productData) {
  // DISPLAY PRODUCT: START
  var subTotal = 0;
  const tbProduct = $(".product-list--checkout");
  productData.forEach(function (row) {
    subTotal += row.PRICE * row.QUANTITY;
    var imageUrl = "data:image/png;base64," + row.FIRST_PICTURE;
    tbProduct.append(`<tr class="product-checkout">
        <td class="product-infor">
          <img
            alt="${row.PRODUCT_NAME}"
            class="product-img"
            src="${imageUrl}" />
          <div class="product-descr">
            <a href="#">${row.PRODUCT_NAME}</a>
            <small class="gray-text">Size ${row.SIZE}</small>
            <small>X${row.QUANTITY}</small>
          </div>
        </td>

        <td>${(row.PRICE * row.QUANTITY).toLocaleString("vi")}</td>
      </tr>`);
  });
  // DISPLAY PRODUCT: END

  // DISPLAY ORDER TOTAL: START
  // sub total
  const divSubTotal = $(".sub-total");
  divSubTotal.append(`<p>Tạm tính (${productData.length} sản phẩm)</p>
      <p>${subTotal.toLocaleString("vi")} đ</p>`);

  // total
  const divTotal = $(".total");
  divTotal.append(`<p>${subTotal.toLocaleString("vi")} đ</p>`);
  // DISPLAY ORDER TOTAL: END
}

async function displayCheckout(user_id) {
  if (user_id !== null) {
    var loginData = await getLoginCheckout(user_id);
    displayCustomerData(loginData.customerData);
    displayProductData(loginData.tableProductData);
  } else {
    displayProductData(localCart);
  }
}
// DISPLAY CUSTOMER INFOR: END

// CLICK BUY BTN: START
$("#buy-form").submit(function (e) {
  const name = $(".customer-name").val();
  const phone = $(".customer-phone").val();

  // gioi tinh
  const gender = $(".gender-radio")[0].checked === true ? "Nam" : "Nữ";

  // Dia chi
  const address = {
    tinhThanh: $("#city").val(),
    quanHuyen: $("#district").val(),
    xaPhuong: $("#ward").val(),
    duongAp: $("#street").val(),
  };

  // thoi gian
  const now = new Date();
  const date = `${now.getFullYear()}-${
    now.getMonth() + 1
  }-${now.getDate()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;

  // phuong thuc thanh toan
  const paymentMethod = $(`input[name="payment"]:checked`).val();

  buy(name, phone, gender, address, user_id, date, paymentMethod, localCart);

  if (paymentMethod == "cod") {
    alert("Đặt hàng thành công!");
    // window.location.href = "../../../../Project/php/store/cart/cart.php";
  }
  // else{
  //   window.location.href = "../../../../php/Controller/store/cart-checkout/checkout-controller.php?id=1";
  // }

  // xoa localstorage chua gio hàng khi ko đăng nhập
  localStorage.clear();
});

function buy(
  name,
  phone,
  gender,
  address,
  user_id,
  date,
  paymentMethod,
  localCart
) {
  $.ajax({
    url: "../../../../Project/php/store/checkout/checkoutBuy.php?action=fetch",
    // dataType: "json",
    data: {
      user_id: user_id,
      name: name,
      phone: phone,
      gender: gender,
      tinhThanh: address.tinhThanh,
      quanHuyen: address.quanHuyen,
      xaPhuong: address.xaPhuong,
      duongAp: address.duongAp,
      date: date,
      paymentMethod: paymentMethod,
      localCart: localCart,
    },
    type: "POST",
    success: function (response) {
      console.log(response);
    },
    error: function () {
      console.log(0);
    },
  });
}
// CLICK BUY BTN: END

// GET DATA FROM BD: END

// SELECT ADDRESS: START
// var citis = document.getElementById("city");
// var districts = document.getElementById("district");
// var wards = document.getElementById("ward");
// var Parameter = {
//   url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
//   method: "GET",
//   responseType: "application/json",
// };
// var promise = axios(Parameter);
// promise.then(function (result) {
//   renderCity(result.data);
// });

// function renderCity(data) {
//   for (const x of data) {
//     citis.options[citis.options.length] = new Option(x.Name, x.Id);
//   }
//   citis.onchange = function () {
//     districts.length = 1;
//     wards.length = 1;
//     if (this.value != "") {
//       const result = data.filter((n) => n.Id === this.value);

//       for (const k of result[0].Districts) {
//         districts.options[districts.options.length] = new Option(k.Name, k.Id);
//       }
//     }
//   };
//   districts.onchange = function () {
//     wards.length = 1;
//     const dataCity = data.filter((n) => n.Id === citis.value);
//     if (this.value != "") {
//       const dataWards = dataCity[0].Districts.filter(
//         (n) => n.Id === this.value
//       )[0].Wards;

//       for (const w of dataWards) {
//         wards.options[wards.options.length] = new Option(w.Name, w.Id);
//       }
//     }
//   };
// }
// SELECT ADDRESS: END
