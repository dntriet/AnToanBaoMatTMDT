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
                <h4>QUY ĐỊNH BẢO HÀNH</h4>
                <p>
                <br>Cửa hàng sẽ chịu trách nhiệm và đảm bảo quyền lợi cho khách hàng đối với mọi sản phẩm theo quy định sau:<br>
                - Lỗi sản phẩm xuất phát từ lỗi vật liệu tạo nên sản phẩm (vải, da) hoặc do sản phẩm không đạt chất lượng (bong tróc keo, đường may).<br>
                - Thời hạn bảo hành là 1 năm kể từ ngày mua hàng, khách hàng cần có hộp sản phẩm, tem, giấy mua hàng hoặc mã đơn mà chúng tôi đã gửi vào email tại thời điểm đặt hàng.<br>
                - Lưu ý với sai sót về màu sắc và kích thước, khách hàng chỉ có thể đổi trong thời hạn 45 ngày kể từ khi mua hàng với tình trạng sản phẩm chưa được sử dụng.<br>
                <br>Khách hàng vui lòng tới cửa hàng để nhân viên kiểm tra và đổi lại cho khách hàng 1 sản phẩm mới hoàn toàn.
                </p>
            </div>

            <div class="Related_Questions">
                <p>Các câu hỏi liên quan:</p>
                <ul style="list-style-type:disc">
                    <li><a href="../blog-info/question-page-Phuong-thuc-thanh-toan.php">Các phương thức thanh toán.</a></li>
                    <li><a href="../blog-info/question-page-Kich-thuoc.php">Cách chọn kích thước.</a></li>
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