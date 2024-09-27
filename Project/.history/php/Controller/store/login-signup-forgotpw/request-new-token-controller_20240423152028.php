<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Demo_Web_JWT/Project/php/Controller/utils/jwt_utils.php';
    try {
        $refreshToken = $_POST['refreshToken'];

// Verify the refresh token and convert it to an object
$verifyRefreshToken = json_decode(verifyJWT($refreshToken));

// Echo the verification result
echo json_encode($verifyRefreshToken);

// Check if the token verification was successful
if ($verifyRefreshToken->status == 'success') {
    // Access object properties directly
    $user_id = $verifyRefreshToken->user_id; // Ensure 'user_id' exists
    $role_id = $verifyRefreshToken->role_id; // Ensure 'role_id' exists

    // Request new tokens using the user and role IDs
    $newTokens = requestNewAccessToken($user_id, $role_id);

    // Echo the new tokens
    echo $newTokens;
} else {
    // Handle the case when the refresh token verification fails
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