<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Demo_Web_JWT/Project/php/Controller/utils/jwt_utils.php';
    try {
        $refreshToken = $_POST['refreshToken'];
        $verifyRefreshToken = json_decode(verifyJWT($refreshToken));
        echo json_encode($verifyRefreshToken);
        if ($verifyRefreshToken->status == 'success') {
            $user_id = $verifyRefreshToken->user_id;
            $role_id = $verifyRefreshToken->role_id;
            $newTokens = requestNewAccessToken($user_id, $role_id);
            echo $newTokens;
        } else {
            http_response_code(401); // Set HTTP response code to unauthorized
            echo json_encode(['status' => 'error', 'message' => 'Invalid refresh token']);
        }
    }
    catch (Exception $e) {
        http_response_code(404);
        $response = json_encode([
            'status' => 'error',
            'message' => 'Something went wrong'
        ]);
        echo $response;
    }
    // // Xử lý form đăng nhập
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $refreshToken = $_POST['refreshToken'];
    //     $verifyRefreshToken = json_decode(verifyJWT($accessToken));
    //     if ($verifyRefreshToken->status == 'success') {
    //         $user_id = $verifyRefreshToken->user_id;
    //         $role_id = $verifyRefreshToken->role_id;
    //         $newTokens = requestNewAccessToken($user_id, $role_id);
    //         echo $newTokens;
    //     }
    // }
    // else {
    //     http_response_code(404);
    //     $response = json_encode([
    //         'status' => 'error',
    //         'message' => 'Something went wrong'
    //     ]);
    //     echo $response;
    // }
?>