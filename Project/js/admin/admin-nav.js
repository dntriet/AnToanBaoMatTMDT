// Start:  add or remove active class base on url. Modified 11/18/2023 by Quyen
const currentLocation = location.href;
const menuItem = document.querySelectorAll('.nav-item');
const menuLength = menuItem.length;

for (let i = 0; i < menuLength; i++) {
  if (menuItem[i].href === currentLocation) {
    menuItem[i].className += ' active';
  }

  if (currentLocation.includes("OrderDetail.php") && i == 4) {
    menuItem[i].className += ' active';
  }
}

console.log(user_id);

// End:  add or remove active class base on url


$('#logout').click(function () {
  // Create an XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Define the request method, URL, and set it to be asynchronous
  xhr.open('POST', '../../php/controller/store/login-signup-forgotpw/account-controller.php', true);

  // Set the request header
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send("action=" + "logout");
  // Set the callback function to handle the response
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      //TODO: Trờ về trang chủ lúc chưa đăng nhập
      window.location.href = '../../php/store/homepage-shopping/homepage.php';
    }
  };
});