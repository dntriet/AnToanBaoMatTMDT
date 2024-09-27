<?php
    require ("../../utils/jwt_utils.php");

    session_start();
    include("../../connect.php");
    global $conn;

    // Xử lý form đăng nhập
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form đăng nhập
        $userlogin = $_POST['userlogin'];
        $password = $_POST['pass'];

        // Sử dụng Prepared Statements để ngăn chặn SQL injection
        $sql = "SELECT COUNT(*) as count, user_password, role_id, user_login 
                FROM login 
                WHERE user_login = ?
                GROUP BY user_password, role_id, user_login";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userlogin);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the query was successful
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                $passwordFromDatabase = $row['user_password'];

                // Kiểm tra mật khẩu nhập từ form với mật khẩu đã hash
                if (password_verify($password, $passwordFromDatabase)) {
                    $sql = "SELECT user_id FROM users WHERE USER_LOGIN = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $userlogin);

                    // Thực hiện truy vấn
                    $stmt->execute();
                    // Lấy kết quả
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $data = $result->fetch_assoc();
                        // Phân quyền
                        // session_start();
                        $_SESSION['user_id'] = $data['user_id'];
                        $_SESSION['role_id'] = $row['role_id'];
                        $user_id = $data['user_id'];
                        $role_id = $row['role_id'];
                        $session_token = generateJWT($user_id, $role_id);
                        $refresh_token = generateRefreshToken($user_id, $role_id);
                        $stmt->close();
                        if ($role_id == 1) 
                            // Người dùng có quyền Admin
                            echo json_encode(['status' => 'success', 'role' => 'admin', 'message' =>'Đăng nhập thành công']);
                        elseif ($role_id == 2) 
                            // Người dùng có quyền Staff
                            echo json_encode(['status' => 'success', 'role' => 'staff', 'message' =>'Đăng nhập thành công']);
                        else
                            // Người dùng có quyền User 
                            echo json_encode(['status' => 'success', 'role' => 'user', 'message' =>'Đăng nhập thành công']);
                        
                    // }
                    // else
                    //     echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy người dùng.']);
                    
                } else {
                    // Mật khẩu không đúng
                    echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
                }
            }  
            else echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
        } 
        else echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
    } 
    else 
        // Đăng nhập thất bại
        echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
    
    
    $conn->close();
?>