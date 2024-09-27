<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Demo_Web_JWT/Project/php/Controller/utils/jwt_utils.php';

    session_start();
    include("../../connect.php");
    global $conn;

    // Xử lý form đăng nhập
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $refreshToken = $_POST['refreshToken'];
        $verifyRefreshToken = json_decode(verifyJWT($accessToken));
        if ($verifyRefreshToken->status == 'success') {
            $user_id = $verifyRefreshToken->user_id;
            $role_id = $verifyRefreshToken->role_id;
            $newTokens = requestNewAccessToken($user_id, $role_id);
        }
        else {
            echo json_decode();
        }
    }
    else {

    }
?>