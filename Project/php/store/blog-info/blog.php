<?php session_start();
$user_id = isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null';
echo '<script> var user_id =' . $user_id . ';</script>';
?>

<link rel="stylesheet" href="../../../css/store/blog.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    
    <!-- Start of header -->
    <?php 
        $title = "Blog";
        include("../header-footer-nav/header.php"); ?>
    <!-- End of header -->

     <!-- Main section: start -->
     <div class="container-heading mb-5 mt-3 blog-heading">
        <!-- <div class="row"> -->
            <!-- <h1 class="d-flex justify-content-center align-items-center">Blogs</h1> -->
            <h1 class="heading">Blog</h1>
            <!-- breadcrum -->
            <nav class="blog-list-link" aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../homepage-shopping/homepage.php">Trang chủ</a></li>
                <li><a class="breadcrumb-item active" href="#">Blog</a></li>
            </ul>
            </nav>
        <!-- </div> -->
    </div>

    

    <div class="main-section-body mb-5 mt-5">
        <!-- BLOG: START -->
        <div class="blog">
        </div>
        <!-- BLOG: END -->
    </div>
    <!-- Main section: start -->

    <!-- Start of footer -->
    <script src="../../../js/blog/main-blog.js"></script>
    <?php include("../header-footer-nav/footer.php"); ?>
        <!-- End of footer -->