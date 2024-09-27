<?php
include('../cart/connect.php');
function getCheckoutData()
{
    global $conn;
    if (isset($_GET['user_id'])) {
        $user_id = $_GET["user_id"];
        // echo $user_id;

        $sqlCustomerData = "SELECT DISTINCT USER_NAME, USER_TELEPHONE, users.ADDRESS AS USER_ADDRESS, orders.ADDRESS AS ORDER_ADDRESS, GENDER
        FROM  orders
            INNER JOIN order_detail 
            ON order_detail.ORDER_ID = orders.ORDER_ID
            INNER JOIN users 
            ON orders.USER_ID = users.USER_ID
        WHERE orders.USER_ID='$user_id'";

        $sqlProductData = "SELECT PRODUCT_NAME, SIZE, QUANTITY, PRICE,  FIRST_PICTURE, ORDER_DETAIL_ID, STATUS
                        FROM orders 
                            INNER JOIN order_detail 
                            ON order_detail.ORDER_ID = orders.ORDER_ID
                            INNER JOIN product_pictures
                            ON order_detail.product_id = product_pictures.product_id
                        WHERE STATUS=\"Đang mua hàng\"
                            AND orders.USER_ID= '$user_id'";

        $customerData = $conn->query($sqlCustomerData);
        $productData = $conn->query($sqlProductData);

        if ($customerData && $customerData->num_rows > 0) {
            $dataCustomerData = $customerData->fetch_assoc();
        }

        $dataProductData = [];
        if ($productData->num_rows > 0) {
            while ($rowProductData = $productData->fetch_assoc()) {
                $rowProductData['FIRST_PICTURE'] = base64_encode($rowProductData['FIRST_PICTURE']); //end code image data
                $dataProductData[] = $rowProductData;
            }
        }

        $combinedResult = array(
            "customerData" => $dataCustomerData,
            "tableProductData" => $dataProductData
        );
        
        echo json_encode($combinedResult);
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified']);
    }
}

getCheckoutData();
// Đóng kết nối CSDL
$conn->close();