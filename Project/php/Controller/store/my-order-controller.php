<?php
    include "../connect.php";

    function fetchOrders() {
        global $conn;
        $cusID = $_POST['cusID'];
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
    
        $sql = "SELECT order_id, order_date, telephone, orders.name,
                        orders.address, orders.pay, orders.status, orders.total_products,
                        total_price
                FROM orders, users
                WHERE STATUS != 'Đang mua hàng'
                AND orders.user_id = users.user_id
                AND orders.user_id = '$cusID'
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

    function searchOrder() {
        global $conn;
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $searchTerm = $_POST['searchTerm'];
            $cusID = $_POST['cusID'];
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
                    AND orders.user_id = '$cusID'
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

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    
        // Execute the corresponding function based on the action
        switch ($action) {
            case 'fetch':
                // Return the fetched data as JSON response
                echo json_encode(fetchOrders());
                break;
            case 'search':
                echo json_encode(searchOrder());
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified']);
    }
    
    $conn->close();
?>