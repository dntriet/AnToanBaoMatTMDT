<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
    include "../connect.php";

function fetchOrders() {
    global $conn;

    $records_per_page = 20;

    if (isset($_POST['page'])&& is_numeric($_POST['page'])) {
        $page = intval($_POST['page']);
    }else {
        $page = 1;
    }

    $totalRecordsQuery = "SELECT COUNT(*) as total FROM orders";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    $totalPages = ceil($totalRecords / $records_per_page);

    $offset = ($page - 1) * $records_per_page;

    $sql = "SELECT DISTINCT order_id, order_date, telephone, orders.name,
                            orders.address, orders.pay, orders.status, orders.total_products,
                            total_price 
            FROM orders
            WHERE STATUS != 'Đang mua hàng'
            LIMIT $offset, $records_per_page";
    
    $result = mysqli_query($conn, $sql);

    $data = [];

    if($result ->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    $response = array(
        'data' => $data,
        'totalPages' => $totalPages
    );

    return $response;
}

function deleteOrder() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $orderId = trim($_POST['order_id'], " ");

        //todo: add constraint in database on delete cascade table product_img;
        //todo: cannot delete because a lot of constraint
        $sql1 = "SELECT * FROM orders WHERE order_id like '$orderId'";
        $result1 = $conn->query($sql1);
        if($result1){
            $sql2 = "DELETE FROM orders WHERE order_id like '$orderId'";
            $result2 = $conn->query($sql2);
            return $result2;
        }
        else return  ['result' => false];
    }
    else
        return ['result' => false];
}

function searchOrder() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $searchTerm = $_POST['searchTerm'];
        $records_per_page = 20;

        if (isset($_POST['page']) && is_numeric($_POST['page'])) {
            $page = intval($_POST['page']);
        } else {
            $page = 1;
        }

        $totalRecordsQuery = "SELECT COUNT(*) as total
                            FROM orders
                            WHERE order_id LIKE '%$searchTerm'";
        $totalRecordsResult = $conn->query($totalRecordsQuery);
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
        
        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $records_per_page);
        
        
        // Calculate the offset for the query
        $offset = ($page - 1) * $records_per_page;

        $sql = "SELECT order_id, order_date, telephone, orders.name,
        orders.address, orders.pay, orders.status, orders.total_products,
        total_price 
                FROM orders
                WHERE order_id LIKE '%$searchTerm'
                AND orders.status != 'Đang mua hàng'
                LIMIT $offset, $records_per_page";
            $result = mysqli_query($conn, $sql);

        $data = [];

        if($result ->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        $response = array(
            'data' => $data,
            'totalPages' => $totalPages
        );

        return $response;      

    }
}

function filterStatus(){
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chosen_status = $_POST['chosen_status'];
        $records_per_page = 20;

        switch($chosen_status) {
            case 'prepare':
                $order_status = 'Đang chuẩn bị hàng';
                break;
            case 'shipping':
                $order_status = 'Đang giao hàng';
                break;
            case 'order-success':
                $order_status = 'Giao thành công';
                break;
            case 'order-cancel':
                $order_status = 'Đã hủy';
                break;
            default:
                $order_status = '';
                break;
            
        }
        if (isset($_POST['page']) && is_numeric($_POST['page'])) {
            $page = intval($_POST['page']);
        } else {
            $page = 1;
        }

        $totalRecordsQuery = "SELECT COUNT(*) as total
                            FROM orders
                            WHERE orders.status = '$order_status'";
        $totalRecordsResult = $conn->query($totalRecordsQuery);
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
        
        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $records_per_page);
        
        
        // Calculate the offset for the query
        $offset = ($page - 1) * $records_per_page;

        $sql = "SELECT order_id, order_date, telephone, orders.name,
        orders.address, orders.pay, orders.status, orders.total_products,
        total_price 
                FROM orders
                WHERE orders.status = '$order_status'
                LIMIT $offset, $records_per_page";
            $result = mysqli_query($conn, $sql);

        $data = [];

        if($result ->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        $response = array(
            'data' => $data,
            'totalPages' => $totalPages
        );

        return $response;      

    }
}

function filterDate() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $records_per_page = 20;

        if (isset($_POST['page']) && is_numeric($_POST['page'])) {
            $page = intval($_POST['page']);
        } else {
            $page = 1;
        }

        $totalRecordsQuery = "SELECT COUNT(*) as total
                            FROM orders
                            WHERE order_date between '$fromdate' and '$todate'";
        $totalRecordsResult = $conn->query($totalRecordsQuery);
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
        
        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $records_per_page);
        
        
        // Calculate the offset for the query
        $offset = ($page - 1) * $records_per_page;

        $sql = "SELECT order_id, order_date, telephone, orders.name,
        orders.address, orders.pay, orders.status, orders.total_products,
        total_price 
                FROM orders
                WHERE order_date between '$fromdate' and '$todate'
                AND orders.status != 'Đang mua hàng'
                LIMIT $offset, $records_per_page";
            $result = mysqli_query($conn, $sql);

        $data = [];

        if($result ->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        $response = array(
            'data' => $data,
            'totalPages' => $totalPages
        );

        return $response;      

    }    
}

//
$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
// Hợp lệ
else {

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Execute the corresponding function based on the action
    switch ($action) {
        case 'fetch':
            // Return the fetched data as JSON response
            echo json_encode(fetchOrders());
            break;
        case 'delete':
            echo json_encode(deleteOrder());
            break;
        case 'search':
            echo json_encode(searchOrder());
            break;
        case 'filterstatus':
            echo json_encode(filterStatus());
            break;
        case 'filterdate':
            echo json_encode(filterDate());
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