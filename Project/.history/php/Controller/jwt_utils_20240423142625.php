<?php
require "/php/Controller/vendor/autoload.php"
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
        http_response_code(200);
        $response = json_decode([
            'status' => 'success',
            'message' => "Xác thực thành công"
        ]);
        return $response;
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

function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

// Yêu cầu AccessToken mới khi Access Token hết hạn với điều kiện là Refresh Token cũ vẫn còn hạn. Trả về Access Token mới và Refresh Token mới.
function requestNewAccessToken($user_is, $refreshToken) {
    try {
        $decoded = JWT::decode($jwt, new Key($secretKey, "HS256"));
        if ((array) $decoded['user_id'] != $user_id) {
            http_response_code(401);
            $response = json_encode([
                'status' => 'error',
                'message' => 'Token không thuộc về User này'
            ]);
            return $response;
        }
        $role_id = $decoded['role_id'];
        $new_access_token = generateAccessToken($user_id, $role_id);
        $new_refresh_token = generateRefreshToken($user_id, $role_id);
        $response = json_decode([
            'accessToken' => $new_access_token,
            'refreshToken' => new_refresh_token
        ]);
        return $response;
    }
    catch (ExpiredException $e) {
        http_response_code(401);
        $response = json_encode([
            'status' => 'error',
            'message' => 'Token hết hạn'
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
?>