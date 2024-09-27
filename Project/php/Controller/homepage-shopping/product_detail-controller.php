<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
// Include the database configuration file
include '../connect.php';

$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
else {
// Check the product name parameter in the request
if (isset($_GET['product'])) {

    $productName = $_GET['product'];

    $productName = mysqli_real_escape_string($conn, $productName);

    $sqlProductInfo = "SELECT PRODUCT_NAME, PRICE, DESCRIPTION, CATEGORY_NAME, FIRST_PICTURE, SECOND_PICTURE, THIRD_PICTURE
                        FROM PRODUCTS, PRODUCT_PICTURES, CATEGORY
                        WHERE PRODUCTS.PRODUCT_NAME='$productName'
                            AND PRODUCTS.PRODUCT_ID = PRODUCT_PICTURES.PRODUCT_ID
                            AND PRODUCTS.CATEGORY_ID = CATEGORY.CATEGORY_ID";

    $sqlProductSize = "SELECT SIZE, QUANTITY
                        FROM PRODUCTS, PRODUCT_SIZE
                        WHERE PRODUCTS.PRODUCT_NAME='$productName'
                            AND PRODUCTS.PRODUCT_ID = PRODUCT_SIZE.PRODUCT_ID
                        ORDER BY SIZE ASC";

    $sqlComment = "SELECT PRODUCT_NAME, USER_NAME, CONTENT, CMT_DAY, SCORE
                        FROM COMMENT
                        WHERE COMMENT.PRODUCT_NAME='$productName'
                        ORDER BY CMT_DAY DESC";

    $resultProductInfo = $conn->query($sqlProductInfo);
    $resultProductSize = $conn->query($sqlProductSize);
    $resultComment = $conn->query($sqlComment);

    // Thông tin sản phẩm
    if ($resultProductInfo && $resultProductInfo->num_rows > 0) {
        $dataProductInfo = $resultProductInfo->fetch_assoc();
        $dataProductInfo['FIRST_PICTURE'] = base64_encode($dataProductInfo['FIRST_PICTURE']); //end code image data
        $dataProductInfo['SECOND_PICTURE'] = base64_encode($dataProductInfo['SECOND_PICTURE']); //end code image data
        $dataProductInfo['THIRD_PICTURE'] = base64_encode($dataProductInfo['THIRD_PICTURE']); //end code image data
    }

    // Thông tin size sản phẩm
    $dataProductSize = [];
    if ($resultProductSize && $resultProductSize->num_rows > 0) {
        while ($rowProductSize = $resultProductSize->fetch_assoc()) {
            $dataProductSize[] = $rowProductSize;
        }
    }

    // Các bình luận
    $dataComment = [];
    if ($resultComment && $resultComment->num_rows > 0) {
        while ($rowComment = $resultComment->fetch_assoc()) {
            $dataComment[] = $rowComment;
        }
    }

    $combinedResult = array(
        "productInfo" => $dataProductInfo,
        "tableProductSize" => $dataProductSize,
        "tableComment" => $dataComment
    );

    echo json_encode($combinedResult);
} else {
    echo json_encode(['success' => false, 'message' => 'Action not specified']);
}
// Đóng kết nối CSDL
$conn->close();
}
?>