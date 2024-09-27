<?php
// Kết nối đến cơ sở dữ liệu
include("../../connect.php");
global $conn;

// Xử lý form đăng kí
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form đăng kí
    $name = trim(urldecode($_POST['name']), " ");
    $userlogin = trim($_POST['userlogin'], " ");
    $customerphone = $_POST['customerphone'];
    $password = ($_POST['password']);
    $userid = generateUserId();
    //kiểm tra tên đăng nhập đã tồn tại chưa
    $sql = "SELECT COUNT(*) as count FROM login WHERE user_login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userlogin);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the query was successful
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['count'] == 0) {
            // Hash mật khẩu nhập vào
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Thực hiện thêm dữ liệu vào bảng 'login'
            $sql_login = "INSERT INTO `login` (USER_LOGIN, USER_PASSWORD, ROLE_ID) VALUES (?, ?, 3)";
            $stmt_login = $conn->prepare($sql_login);
            $stmt_login->bind_param("ss", $userlogin, $hashedPassword);
            $result_login = $stmt_login->execute();

            // if($result_login){
                // Thực hiện thêm dữ liệu vào bảng 'users'
                $sql_users = "INSERT INTO `users` (USER_ID, USER_LOGIN, USER_NAME, USER_TELEPHONE, DAY_ADD) VALUES (?, ?, ?, ?, now())";
                $stmt_users = $conn->prepare($sql_users);
                $stmt_users->bind_param("ssss", $userid, $userlogin, $name, $customerphone);
                $result_users = $stmt_users->execute();

                if ($result_users) 
                    echo true;
                else echo false; 
            // }
            // else 
            $stmt_users->close();
            $stmt_login->close();
        }
        else echo false;
    } else echo false;
}

function generateUserId($prefix = 'KH') {
    // Use a combination of prefix and a unique identifier (timestamp and random number)
    $uniqueId = time() . mt_rand(1000, 9999);

    // Concatenate the prefix and unique identifier to create the user_id
    $userId = $prefix . $uniqueId;

    return $userId;
}
$conn->close();
?>