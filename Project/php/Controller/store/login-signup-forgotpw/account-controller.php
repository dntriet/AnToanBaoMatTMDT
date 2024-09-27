<?php
// Include the database configuration file
session_start();
include '../../connect.php';

function editAddress() {
    global $conn;

    // Kiểm tra xem request có phải là POST không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form chỉnh sửa địa chỉ
        // $user_id = 'KH17028633';
        // $user_id='KH0006'; //lấy để test chức năng
        $user_id = $_SESSION['user_id'];
        $name = $_POST['name'];
        // $phoneNumber = $_POST['phonenumber'];
        $province = $_POST['province'];
        $district = $_POST['district'];
        $ward = $_POST['ward'];
        $specificAddress = $_POST['specificAddress'];
        $address = $specificAddress . ', ' . $district . ', ' . $ward . ', ' . $province;
        // Update user information in the database
        $sql = "UPDATE users SET USER_NAME=?, ADDRESS=? WHERE USER_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $address, $user_id);
        $result = $stmt->execute();

        // Kiểm tra và trả về kết quả cập nhật mới
        if ($result) {
            return (['status' => 'success', 'message' => 'Cập nhật địa chỉ thành công']);
        } else {
            return (['status' => 'error', 'message' => 'Cập nhật địa chỉ không thành công']);
        }
    }
    else
        return (['status' => 'error', 'message' => 'Cập nhật địa chỉ không thành công']);
}

function editProfile(){
    global $conn;
    // Kiểm tra xem request có phải là POST không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // $user_id = 'KH17028633';
        // $user_id='KH0006';//id mẫu thoi
        $user_id = $_SESSION['user_id'];
        $name = $_POST["name"];
        $dateOfBirth = $_POST["dateOfBirth"];
        $gender = $_POST["gender"];
        $phonenumber = $_POST['phoneNumber'];

        // Chuẩn bị và thực thi truy vấn SQL để cập nhật thông tin người dùng
        $sql = "UPDATE users SET USER_NAME=?, USER_TELEPHONE=?, BIRTHDAY=?, GENDER=? WHERE USER_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $phonenumber, $dateOfBirth, $gender, $user_id);
        $stmt->execute();

        // Kiểm tra và trả về kết quả
        if ($stmt->affected_rows > 0) {
            // Cập nhật thành công, có thể thực hiện các hành động khác nếu cần
            return(['status' => 'success', 'message' => 'Cập nhật thông tin thành công']);
        } else {
            // Cập nhật thất bại
            return(['status' => 'error', 'message' => 'Cập nhật thông tin không thành công.']);
        }
    }
    else
    return (['status' => 'error', 'message' => 'Cập nhật thông tin không thành công']);
}


function fetchAddress(){
    global $conn;
    // Kiểm tra xem request có phải là POST không
    // $user_id = 'KH17028633';
    // $user_id='KH0006';//id mẫu thoi
    $user_id = $_SESSION['user_id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT USER_NAME, ADDRESS FROM users WHERE USER_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response = array('status' => 'success', 'message' => 'Lấy địa chỉ thành công', 'data' => $data);
            return $response;
        } else 
            return(['error' => 'Lấy địa chỉ không thành công']);
    }
    else
        return (['status' => 'error', 'message' => 'Lấy địa chỉ không thành công']);
}

function fetchProfile(){
    global $conn;
    // $user_id = $_POST['user_id'];
    // $user_id = 'KH17028633';
    // $user_id='KH0006';//id mẫu thoi
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT USER_NAME, USER_TELEPHONE, BIRTHDAY, GENDER FROM users WHERE USER_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $response = array('status' => 'success', 'message' => 'Lấy thông tin thành công', 'data' => $data);
        return $response;
    } else {
        return (['status' => 'error', 'message' => 'Không thể lấy thông người dùng']);
    }
}


function editPassword(){
    global $conn;

    // Kiểm tra xem request có phải là POST không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Nhận dữ liệu từ yêu cầu AJAX
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        // $user_id = 'KH17028633';
        // $user_id='KH0006'; //lấy để test chức năng
        $user_id = $_SESSION['user_id'];

        // Chuẩn bị và thực thi truy vấn SQL để kiểm tra mật khẩu cũ
        $sql = "SELECT users.USER_LOGIN, USER_PASSWORD FROM users, login 
                WHERE USER_ID = ? 
                AND users.USER_LOGIN = login.USER_LOGIN";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra kết quả truy vấn mật khẩu cũ
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userlogin = $row['USER_LOGIN'];
            $passwordFromDB = $row['USER_PASSWORD'];
            if(password_verify($oldPassword, $passwordFromDB)){
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                // Mật khẩu cũ đúng, tiến hành cập nhật mật khẩu mới
                $updateSql = "UPDATE login SET USER_PASSWORD = ? WHERE USER_LOGIN = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $hashedPassword, $userlogin);
                $updateResult = $updateStmt->execute();

                // Kiểm tra và trả về kết quả cập nhật mật khẩu mới
                if ($updateResult) {
                    return (['status' => 'success', 'message' => 'Cập nhật mật khẩu thành công']);
                } else {
                    return (['status' => 'error', 'message' => 'Lỗi cập nhật mật khẩu: ' . $updateStmt->error]);
                }
            }
            else
                return (['status' => 'error', 'message' => 'Mật khẩu hiện tại không hợp lệ']);
            
        } else 
            // Mật khẩu cũ không đúng
            return (['status' => 'error', 'message' => 'Không tìm thấy người dùng']);
        
    } else {
        return (['status' => 'error', 'message' => 'Cập nhật mật khẩu không thành công']);
    }
}

function logout(){
    session_start();

    // Destroy the session data
    session_destroy();

    // Return a response to indicate successful logout
    return (['status' => 'success']);
}

function forgetPassword(){
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form
        // $userLogin = $_POST['userlogin'];
        $phoneNumber = $_POST['phonenumber'];
        if (substr($phoneNumber, 0, 3) === '+84') {
            // If yes, replace '+84' with '0'
            $phoneNumber = '0' . substr($phoneNumber, 3);
        }

        // Kiểm tra tên đăng nhập và số điện thoại trong cơ sở dữ liệu
        $sql = "SELECT * FROM users WHERE USER_TELEPHONE = '$phoneNumber' LIMIT 1";
        $result = $conn->query($sql);
        $data = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row;
            return (['status' => 'success','message' => 'Xác thực thành công', 'data'=> $data]);
        } else {
            // Tên đăng nhập hoặc số điện thoại không đúng, hiển thị thông báo
            return (['status' => 'error', 'message' => 'Tên đăng nhập hoặc số điện thoại không đúng.']);
        }
    }
    return (['status' => 'error', 'message' => 'Tên đăng nhập hoặc số điện thoại không đúng.']);
}

function getNewPassword(){
    global $conn;
    // Lấy thông tin từ form đặt lại mật khẩu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userLogin = $_POST["userlogin"];
        $newPassword = $_POST["new_password"];
        $confirmPassword = $_POST["confirm_password"];
    
        // Kiểm tra mật khẩu mới và xác nhận mật khẩu mới
        if ($newPassword == $confirmPassword) {
            // Thực hiện cập nhật mật khẩu mới trong cơ sở dữ liệu
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            //prepared statement
            $updateSql = "UPDATE login SET USER_PASSWORD = ? WHERE USER_LOGIN= ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("ss", $hashedPassword, $userLogin);
            $stmt->execute();
            $stmt->close();
            return (['status' => 'success', 'message' => 'Đặt lại mật khẩu thành công']);
        } else {
            return (['status' => 'error', 'message' => 'Mật khẩu không trùng khớp. Mời nhập lại']);
        }
    }
    return (['status' => 'error', 'message' => 'Đặt lại mật khẩu không thành công']);
}


// Check the action parameter in the request
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Execute the corresponding function based on the action
    switch ($action) {
        case 'fetch_profile':
            // Return the fetched data as JSON response
            echo json_encode(fetchProfile());
            break;
        case 'edit_profile':
            // Return the fetched data as JSON response
            echo json_encode(editProfile());
            break;
        case 'fetch_address':
            // Return the fetched data as JSON response
            echo json_encode(fetchAddress());
            break;
        case 'edit_address':
            // Return the fetched data as JSON response
            echo json_encode(editAddress());
            break;
        case 'reset_password':
            // Return the fetched data as JSON response
            echo json_encode(editPassword());
            break;
        case 'forget_password':
            // Return the fetched data as JSON response
            echo json_encode(forgetPassword());
            break;
        case 'get_newpassword':
            // Return the fetched data as JSON response
            echo json_encode(getNewPassword());
            break;
        case 'logout':
            // Return the fetched data as JSON response
            echo json_encode(logout());
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} else {
    echo json_encode([ 'status' => 'error', 'message' => 'Action not specified']);
}
// Close the database connection
$conn->close();
?>




