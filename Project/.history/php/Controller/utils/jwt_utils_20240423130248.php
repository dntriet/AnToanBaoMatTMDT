<?php
require ("../../vendor/autoload.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secretKey = "demo_web_jwt";

// Hàm Tạo JWT từ userId và hết hạn trong 1 tiếng - Session Token
function generateJWT($user_id, $role_id, $expiryInSeconds = 3600) {
    global $secretKey;
    $payload = [
        'iat' => time(), // thời điểm tạo
        'exp' => time() + $expiryInSeconds, // thời điểm hết hạn
        'sub' => $user_id, // nội dung bên trong JWT
        'role' => $role_id // 
    ];
    return JWT::encode($payload, $secretKey, 'HS256');
}

// Hàm tạo Refresh Token giống như JWT nhưng thời gian hết hạn xa hơn. - Refresh Token
function generateRefreshToken($user_id, $role_id, $expiryInDays = 14) {
    global $secretKey;
    $payload = [
        'iat' => time(), // thời điểm tạo
        'exp' => time() + ($expiryInDays * 86400), // thời điểm hết hạn
        'sub' => $user_id, // nội dung bên trong JWT
        'role' => $role_id // 
    ];
    return JWT::encode($payload, $secretKey, 'HS256');
}

// Hàm xác thực và giải mã JWT
function verifyJWT($jwt) {
    global $secretKey;
    try {
        $decoded = JWT::decode($jwt, new Key($secretKey, "HS256"));
        return (array) $decoded;
    }
    catch (Exception $e) {
        return null; // invalid JWT
    }
}
?>