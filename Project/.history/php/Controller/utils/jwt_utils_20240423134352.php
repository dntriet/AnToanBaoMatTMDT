<?php
require "../../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secretKey = "demo_web_jwt";

// Hàm Tạo AccessToken từ userId và hết hạn trong 1 tiếng - Access Token
function generateAccessToken($user_id, $role_id, $expiryInSeconds = 3600) {
    global $secretKey;
    $payload = [
        'iat' => time(), // thời điểm tạo
        'exp' => time() + $expiryInSeconds, // thời điểm hết hạn
        'sub' => $user_id, // nội dung bên trong AccessToken
        'role' => $role_id // 
    ];
    return JWT::encode($payload, $secretKey, 'HS256');
}

// Hàm tạo Refresh Token giống như Access Token nhưng thời gian hết hạn xa hơn. - Refresh Token
function generateRefreshToken($user_id, $role_id, $expiryInDays = 14) {
    global $secretKey;
    $payload = [
        'iat' => time(), // thời điểm tạo
        'exp' => time() + ($expiryInDays * 86400), // thời điểm hết hạn
        'sub' => $user_id, // nội dung bên trong RefreshToken
        'role' => $role_id // 
    ];
    return JWT::encode($payload, $secretKey, 'HS256');
}

// Hàm xác thực và giải mã JWT
function verifyJWT($jwt) {
    global $secretKey;
    try {
        $decoded = JWT::decode($jwt, new Key($secretKey, "HS256"));
        return null;
    }
    catch (ExpiredException $e) {
        http_response_code(401);
        $response = json_encode([
            'status' => 'error',
            'message' => 'Hết hạn phiên làm việc'
        ]);
        return $response;
    }
    catch (Exception $e) {
        http_response_code(404);
        $response = json_encode([
            'status' => 'error',
            'message' => 'Something went wrong'
        ]);
        return $response;
    }
}

function requestNewAccessToken($user_is, $refreshToken) {
    $decoded = JWT::decode($jwt, new Key($secretKey, "HS256"));
}
?>