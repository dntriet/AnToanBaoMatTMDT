<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
?>
    <link rel="stylesheet" href="../../../css/store/question_page_style.css">
    
    <!-- Start of header -->
    <?php 
        $title = "Hỗ trợ";
        include("../header-footer-nav/header.php"); ?>

    
    <!-- End of header -->
    <h2>HỖ TRỢ</h2>

    <div class="contentBox">
        <div class="contentBox__Left">
            <div class="Content">
                <h4>ĐỔI HOẶC HỦY ĐƠN HÀNG</h4>
                <p>
                    Điều kiện: Thực hiện hủy đơn đặt hàng trong vòng 60 phút kể từ khi đặt hàng.<br>
                    Cách thức thực hiện:<br>
                    Cách 1: Khách hàng truy cập website, đăng nhập và truy cập vào đơn hàng. Nếu khách hàng không đăng
                    nhập
                    thì cần cung cấp mã đặt hàng từ email xác nhận. Tiếp theo, khách hàng ấn nút “Hủy” để thực hiện thao
                    tác
                    hủy đơn đặt hàng.<br>
                    Cách 2: Khách hàng gọi điện thoại trực tiếp cho cửa hàng và làm theo hướng dẫn của nhân viên hỗ trợ
                    hủy
                    đơn đặt hàng.<br>
                    Đối với trường hợp quá thời hạn 60 phút, khách hàng có thể gửi lại sản phẩm (đơn hàng vẫn chưa bị
                    mở,
                    tem nhãn và niêm phong còn đầy đủ) thông qua việc gọi thông báo cho cửa hàng, chúng tôi sẽ kiểm tra
                    và
                    hoàn lại tiền sản phẩm.
                </p>
            </div>

            <div class="Related_Questions">
                <p>Các câu hỏi liên quan:</p>
                <ul style="list-style-type:disc">
                    <li><a href="#">Các phương thức thanh toán.</a></li>
                    <li><a href="#">Quy định bảo hành.</a></li>
                </ul>
            </div>
        </div>


        <div class="line">
            <svg height="800px" width="2px">
                <line x1="0" y1="0" x2="0" y2="590" style="stroke:black; stroke-width: 3px;" />
            </svg>

            <hr>
        </div>

        <div class="contentBox__Right">
            <div class="centerBox">
                <img src="../../../img/chat.png" alt="">
                <p>EMAIL</p>
                <p>215215xx@gm.uit.edu.vn</p>
            </div>
            <div class="centerBox">
                <img src="../../../img/telephone.png" alt="">
                <p>ĐIỆN THOẠI</p>
                <p>0913567184</p>
            </div>
            <div class="centerBox">
                <img src="../../../img/location.png" alt="">
                <p>ĐỊA CHỈ</p>
                <p>Khu phố 6, P.Linh Trung, Tp.Thủ Đức, Tp.Hồ Chí Minh</p>
            </div>
        </div>
    </div>

    <!-- TODO: hr of footer disappears -->
    <!-- Start of footer -->
        <?php include("../header-footer-nav/footer.php"); ?>
    <!-- End of footer -->
</body>

</html>