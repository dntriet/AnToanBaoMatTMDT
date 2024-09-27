<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
    include "../connect.php";

    function detailOrder() {
        global $conn;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['orderId'];
        }

            $sql1 = "SELECT order_id, order_date, telephone, orders.name,
            orders.address, orders.pay, orders.status, orders.total_products,
            total_price 
                    FROM orders
                    WHERE order_id = ?";
            //sql injection
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param('i', $id);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
    
            $sql2 ="SELECT order_detail.product_id, order_detail.product_name, order_detail.size,
            order_detail.quantity, order_detail.price, order_detail.order_id, first_picture
                    FROM order_detail, product_pictures
                    WHERE order_detail.product_id = product_pictures.product_id
                    AND order_detail.order_id = ?;";
            //sql injection
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('i', $id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt1->close();
            $stmt2->close();

            $data1 = [];
            $data2 =[];
            
            if($result1 ->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {
                    $data1[] = $row;
                }
            }
            if($result2 ->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result2)) {
                    $row['first_picture'] = base64_encode($row['first_picture']);
                    $data2[] = $row;
                }
            }

            $response = array(
                'data1' => $data1, //dữ liệu khách hàng
                'data2' => $data2 //dữ liệu sản phẩm
            );
    
            return $response;      
    }

    function updateStatus() {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status_get = $_POST['order_status'];
            $orderID = $_POST['id'];
            switch($status_get) {
                case 1:
                    $status = 'Đang chuẩn bị hàng';
                    break;
                case 2:
                    $status = 'Đang giao hàng';
                    break;
                case 3:
                    $status = 'Giao thành công';
                    break;
                case 4:
                    $status = 'Đã hủy';
                    break;
                default:
                    $status='';

            }

            //sql injection
            $sql = "UPDATE orders 
                    SET orders.status = ?
                    WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $status, $orderID);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }        
    }

    //
    $accessToken = getBearerToken();
    $verifyJWT = json_decode(verifyJWT($accessToken));
    // Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
    if ($verifyJWT->status == 'error') {
        echo json_encode($verifyJWT);
    }
    else {
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
        
            // Execute the corresponding function based on the action
            switch ($action) {
                case 'detail':
                    echo json_encode(detailOrder());
                    break;
                case 'updateStatus':
                    echo json_encode(updateStatus());
                    break;
                default:
                    echo json_encode(['success' => false, 'message' => 'Invalid action']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Action not specified']);
        }
        
        $conn->close();
    }
?>