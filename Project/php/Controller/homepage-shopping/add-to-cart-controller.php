<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
// Include the database configuration file
include '../connect.php';

// Lấy OrderID
function getOrderID($conn, $userID)
{
    $sql_KiemTraDonHang = "SELECT ORDER_ID FROM ORDERS WHERE USER_ID='$userID' AND STATUS='Đang mua hàng' LIMIT 1";

    $resultKiemTraDonHang = $conn->query($sql_KiemTraDonHang);

    $orderID = null;
    if ($resultKiemTraDonHang && $resultKiemTraDonHang->num_rows > 0) {
        $orderID = $resultKiemTraDonHang->fetch_assoc()['ORDER_ID'];
    }
    return $orderID;
}

//
$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
else {
    // Check the product name parameter in the request
    if (isset($_POST['userID']) && isset($_POST['productData'])) {
        // Nhận dữ liệu từ request POST
        $userID = $_POST['userID'];
        $productData = $_POST['productData'];
    
        $userID = mysqli_real_escape_string($conn, $userID);
    
        // Trích xuất thông tin sản phẩm từ mảng dữ liệu nhận được
        $productName = $productData['productName'];
        // $productPrice = $productData['productPrice'];
        $productSize = $productData['productSize'];
        $numberOfProduct = $productData['numberOfProduct'];
        // $productImage = $productData['productImage'];
    
        $productName = mysqli_real_escape_string($conn, $productName);
    
        $productSize = mysqli_real_escape_string($conn, $productSize);
    
        $numberOfProduct = mysqli_real_escape_string($conn, $numberOfProduct);
    
    
    
        // Khi chưa có giỏ hàng tồn tại trong csdl.
        if (getOrderID($conn, $userID) === null) {
            $sql_ThemHoaDon = "INSERT INTO orders(`USER_ID`, `STATUS`) VALUES ('$userID', 'Đang mua hàng');";
    
            if ($conn->query($sql_ThemHoaDon) !== TRUE) {
                echo json_encode(['success' => false, 'message' => 'Action not specified']);
            } else {
            }
        }
    
        $tempID = getOrderID($conn, $userID);
        $sql_ThemSanPham = "INSERT INTO order_detail(`ORDER_ID`,`PRODUCT_NAME`,`SIZE`,`QUANTITY`) VALUES ($tempID, '$productName', $productSize, $numberOfProduct)";
    
        if ($conn->query($sql_ThemSanPham) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Thực hiện thành công!']);
        } else {
            $errorMessage = $conn->error;
    
            // Kiểm tra xem thông điệp lỗi có chứa chuỗi từ trigger hay không
            if (strpos($errorMessage, 'Số lượng sản phẩm không đủ') !== false) {
                echo json_encode(['success' => false, 'message' => 'Trigger violation: Số lượng sản phẩm không đủ']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Action not specified: ' . $errorMessage]);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified']);
    }
    // Đóng kết nối CSDL
    $conn->close();
}
?>