<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
?>

<link rel="stylesheet" href="../../../css/store/blog-detail.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php 
        $title = "Blog";
        include("../header-footer-nav/header.php"); ?>

    <div class="container-heading blog-heading">
        <div class="breadcrumb-box">
             <!-- breadcrum -->
            <div class="row1">
                <nav class="blog-list-link" aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../homepage-shopping/homepage.php">Trang chủ</a></li>
                    <li><a class="breadcrumb-item" href="./blog.php">Blog</a></li>
                    <li><a class="breadcrumb-item active" href="#">Thông tin bài viết</a></li>
                </ul>
                </nav>
            </div>
            
            <div class="blog-title row2">
                <h4></h4>
            
                <div class="row3">
                    <div class="blog-author">
                        <p></p>
                    </div>
                    <div class="blog-date">
                        <p></p>
                    </div>
                </div>
            </div>
            

        </div>
        
        <div class="blog-img">
            <img src="">
        </div>
    </div>


    <div class="blog-content">
        <p></p>
    </div>
    


<script src="../../../js/blog/blog-detail-test.js"></script>
         <?php include("../header-footer-nav/footer.php"); ?>