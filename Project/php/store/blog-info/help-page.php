<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
?>
    <link rel="stylesheet" href="../../../css/store/help_page_sytle.css">
    <!-- Start of header -->
    <?php 
        $title = "Hỗ trợ";
        include("../header-footer-nav/header.php"); ?>

    
    <!-- End of header -->

    <div class="contentBox">
        <h2>HỖ TRỢ</h2>
        <div class="contentBox__Question">
            <div>
                <h3>CÁC CÂU HỎI THƯỜNG GẶP</h3>
                <hr>
            </div>

            <div class="questionBox">
                <div class="centerBox">
                    <h4>ĐẶT HÀNG</h4>
                    <p>Hủy đơn đặt hàng</p>
                    <p>Các phương thức thanh toán</p>
                </div>
                <div class="centerBox">
                    <h4>GIAO HÀNG</h4>
                    <p>Đối tác vận chuyển</p>
                    <p>Phí vận chuyển</p>
                </div>
                <div class="centerBox">
                    <h4>SẢN PHẨM</h4>
                    <p>Cách chọn kích thước</p>
                    <p>Quy định bảo hành</p>
                </div>
            </div>
        </div>

        <div class="contentBox__Contact">
            <div>
                <h3>LIÊN HỆ</h3>
                <hr>
            </div>

            <div class="contactBox">
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

    </div>

    <!-- Start of footer -->
        <?php include("../header-footer-nav/footer.php"); ?>
    <!-- End of footer -->
</body>

</html>