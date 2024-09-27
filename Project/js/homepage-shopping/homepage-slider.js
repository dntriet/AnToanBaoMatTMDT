jQuery(document).ready(function ($) {
  var slideCount = $('#slider ul li').length;
  var slideWidth = $('#slider ul li').width();
  var slideHeight = $('#slider ul li').height();
  var sliderUlWidth = slideCount * slideWidth;

  $('#slider').css({ width: slideWidth, height: slideHeight });

  $('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

  $('#slider ul li:last-child').prependTo('#slider ul');

  function moveLeft() {
    $('#slider ul').animate({
      left: + slideWidth
    }, 200, function () {
      $('#slider ul li:last-child').prependTo('#slider ul');
      $('#slider ul').css('left', '');
    });
  };

  function moveRight() {
    $('#slider ul').animate({
      left: - slideWidth
    }, 200, function () {
      $('#slider ul li:first-child').appendTo('#slider ul');
      $('#slider ul').css('left', '');
    });
  };

  // Hàm để chuyển slide sang phải
  function moveRight() {
    $('#slider ul').animate({
      left: -slideWidth
    }, 200, function () {
      $('#slider ul li:first-child').appendTo('#slider ul');
      $('#slider ul').css('left', '');
    });
  };

  // Hàm để chuyển slide sang trái
  function moveLeft() {
    $('#slider ul').animate({
      left: slideWidth
    }, 200, function () {
      $('#slider ul li:last-child').prependTo('#slider ul');
      $('#slider ul').css('left', '');
    });
  };

  // Hàm để tự động chuyển slide sau 2 giây
  function autoMove() {
    setInterval(function () {
      moveRight();
    }, 3000);
  }

  // Gọi hàm autoMove khi trang được tải
  autoMove();

  $('#checkbox').change(function () {
    setInterval(function () {
      moveRight();
    }, 2500);
  });
});    
