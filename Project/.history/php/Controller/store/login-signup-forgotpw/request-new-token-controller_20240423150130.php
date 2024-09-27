<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Demo_Web_JWT/Project/php/Controller/utils/jwt_utils.php';

    session_start();
    include("../../connect.php");
    global $conn;

    // Xử lý form đăng nhập
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accessToken = 
        $refreshToken = $_POST['refreshToken'];
    }
    else {

    }
?>