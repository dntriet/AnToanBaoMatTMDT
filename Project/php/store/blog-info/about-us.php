<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
?>
<link rel="stylesheet" href="../../../css/store/blog.css">
    
    <!-- Start of header -->
    <?php 
        $title = "About us";
        include("../header-footer-nav/header.php"); ?>
    <!-- End of header -->

    <!-- main section: start -->
    <div class="container-heading mb-5" style="background-color: #FDF5F5;">
      <div class="row">
        <h1 class="d-flex justify-content-center align-items-center display-4" style="height: 150px;">About Us</h1>
      </div>
    </div>

    <div class="container-fluid mb-5" style="height: 500px;">
        <div class="row m-auto" style="width: 95%; height: 100%;">

            <div class="col-md-12 col-lg-6" style="background: url(https://images.unsplash.com/photo-1593081891731-fda0877988da?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D) no-repeat center center/cover;">
            </div>

            <div class="col-md-12 col-lg-6 py-5 m-auto">
                <div class="media-content m-5">
                    <h3 class="align-left pb-3 display-6">Phương châm hoạt động</h3>
                    <div class="pb-3">
                        <p style="font-size: 20px;text-align:justify;">Tại đây, chúng tôi tận tâm đem đến những đôi giày chính hãng, phản ánh đầy đủ đam mê và phong cách sống năng động. Với cam kết về chất lượng và sự đa dạng, chúng tôi hy vọng bạn sẽ tìm thấy đôi giày hoàn hảo, không chỉ để thể thao mà còn để thể hiện phong cách riêng của mình. Hãy đồng hành cùng chúng tôi, vượt qua mọi thách thức và bước vào thế giới sôi động của giày thể thao Nike!
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="container-fluid mb-5" style="height: 550px;">
      <div class="row m-auto" style="width: 95%; height: 100%;">

          <div class="col-md-12 col-lg-7 py-5 m-auto">
              <div class="media-content m-5">
                  <h3 class="align-left pb-3 display-6">Giới thiệu cửa hàng</h3>
                  <div class="pb-3">
                      <p style="font-size: 20px;text-align:justify;">Chào mừng bạn đến với cửa hàng của chúng tôi - nơi đặc biệt dành cho những người yêu thể thao và đam mê phong cách sống năng động! Tại đây, chúng tôi tự hào giới thiệu một không gian mua sắm độc đáo, nơi bạn có thể tìm thấy những đôi giày thể thao Nike hàng đầu cùng với những sản phẩm phụ trợ thú vị.
                      </p>
                      <p style="font-size: 20px;text-align:justify;"> Chúng tôi cam kết mang đến cho bạn trải nghiệm mua sắm không chỉ là việc mua, mà còn là chuyến hành trình khám phá và tận hưởng đam mê thể thao qua từng bước chân. Hãy đến và khám phá cửa hàng của chúng tôi, nơi mà phong cách và động lực gặp gỡ, tạo nên không gian thăng hoa cho những người yêu thể thao và năng động!
                      </p>

                   </div>
              </div>
          </div>

          <div class="col-md-12 col-lg-5" style="background: url(https://images.unsplash.com/photo-1577283044639-db2f68e4a166?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D) no-repeat center center/cover;">
          </div>
          
      </div>
  </div>

    
  </div>
    <!-- main section: end -->

    <!-- Start of footer -->
    <?php include("../header-footer-nav/footer.php"); ?>
        <!-- End of footer -->