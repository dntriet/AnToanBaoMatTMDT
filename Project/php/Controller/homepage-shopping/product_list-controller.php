<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
include '../connect.php';

function fetchProducts() {
    global $conn;
    
    $sql_Category = "SELECT category_id, category_name FROM category";

    $sql_Product = " SELECT products.product_id, product_name, gender, price, first_picture, category_id
                        FROM products
                        INNER JOIN product_pictures ON products.product_id = product_pictures.product_id
                        ORDER BY products.product_id";

    $resultCategory = $conn->query($sql_Category);
    $resultProduct = $conn->query($sql_Product);

    $dataProduct = [];
    $dataCategory = [];

    if ($resultCategory->num_rows > 0) {
        while ($rowCategory = $resultCategory->fetch_assoc()) {
            $dataCategory[] = $rowCategory;
        }
    }


    if ($resultProduct->num_rows > 0) {
        while ($rowProduct = $resultProduct->fetch_assoc()) {
            $rowProduct['first_picture'] = base64_encode($rowProduct['first_picture']); //end code image data
            $dataProduct[] = $rowProduct;
        }
    }

    $combinedResult = array(
        "tableCategory" => $dataCategory,
        "tableProduct" => $dataProduct
    );

    return $combinedResult;
}

$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
else {
    // Check the action parameter in the request
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    
        // Execute the corresponding function based on the action
        switch ($action) {
            case 'fetch':
                // Return the fetched data as JSON response
                echo json_encode(fetchProducts());
                break;
            
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified']);
}
    
    // Close the database connection
$conn->close();
}
?>