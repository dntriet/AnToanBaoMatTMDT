<?php
    include "../connect.php";

    function fetchFeedback() {
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['orderId'];
        }


        $sql1 ="SELECT order_detail.product_id, order_detail.product_name, order_detail.size,
            order_detail.quantity, order_detail.price, order_detail.order_id, first_picture
                    FROM order_detail, product_pictures
                    WHERE order_detail.product_id = product_pictures.product_id
                    AND order_detail.order_id = ?;";
        //sql injection
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('i', $id);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $stmt1->close();

        //lấy mã khách hàng
        $sql2 = "SELECT ORDERS.USER_ID
                    FROM ORDERS
                    WHERE ORDERS.ORDER_ID = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $stmt2->close();
        if($result2 ->num_rows == 1) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $MAKH = $row['USER_ID'];
            }
        }

        $sql = "SELECT product_id
                    FROM COMMENT
                    WHERE COMMENT.USER_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $MAKH);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $data1 = []; //product
        $data2 = []; //cmt
        
        if($result1 ->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $row['first_picture'] = base64_encode($row['first_picture']);
                $data1[] = $row;
            }
        }

        if($result ->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data2[] = $row;
            }
        }
        if($data2) {
            $response = array(
                'data1' => $data1,
                'data2' => $data2
            );            
        } else {
            $response = array(
                'data1' => $data1,
                'data2' => null
            ); 
        }


        return $response;   
    }

    function addFeedback() {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['orderId'];
            $productId = $_POST['productId'];
            $fb_content = $_POST['fb_content'];
            $fb_score = $_POST['fb_score'];  
        }

        //get user_id
        $sql1 = "SELECT ORDERS.USER_ID, ORDERS.NAME FROM ORDERS WHERE ORDERS.ORDER_ID = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('i', $orderId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $stmt1->close();

        if($result1 ->num_rows > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $userID = strval($row1['USER_ID']);
                $userName = strval($row1['NAME']);
            }
        }
        

        //get product name
        $sql2 = "SELECT PRODUCT_NAME FROM PRODUCTS WHERE PRODUCT_ID = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('i', $productId);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $stmt2->close();

        if($result2 ->num_rows === 1) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $productName = strval($row['PRODUCT_NAME']);
            }
        }
        
        $sql3 = "SELECT * FROM COMMENT WHERE PRODUCT_ID = ? AND USER_ID = ?";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param('is', $productId, $userID);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $stmt3->close();

        $cmtDay = strval(date("Y-m-d"));
        if($result3 ->num_rows == 0){
            $sql = "INSERT INTO comment (PRODUCT_ID, USER_ID, PRODUCT_NAME, USER_NAME, CONTENT, CMT_DAY, SCORE) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isssssi', $productId, $userID, $productName, $userName, $fb_content, $cmtDay ,$fb_score);
            $result = $stmt->execute();
            $stmt->close();
        }
        else {
            $sql = "UPDATE COMMENT
                    SET CONTENT = ?, SCORE = ?
                    WHERE PRODUCT_ID = ? AND USER_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('siis', $fb_content, $fb_score, $productId, $userID);
            
            $result = $stmt->execute();
            $stmt->close();
        }
        if($result) {
            return ['result' => true, 'message' => 'Thêm thành công'];
        } else {
            return ['result' => false, 'message' => 'Thêm không thành công'];
        }
        // 
    }
    function fetchCMT(){
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['orderId'];
            $productId = $_POST['productId'];
        }
        //lấy mã khách hàng
        $sql1 = "SELECT ORDERS.USER_ID
                    FROM ORDERS
                    WHERE ORDERS.ORDER_ID = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('i', $orderId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $stmt1->close();
        if($result1 ->num_rows == 1) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $MAKH = $row['USER_ID'];
            }
        }

        //lấy cmt
        $sql2 = "SELECT score, content, product_id
        FROM COMMENT
        WHERE COMMENT.USER_ID = ?
        AND COMMENT.PRODUCT_ID = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('si', $MAKH, $productId);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $stmt2->close();

        $data = [];

        if($result2 ->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $data[] = $row;
            }
        }

        $response = array(
            'data' => $data
        );            


        return $response;   
    }
    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    
        // Execute the corresponding function based on the action
        switch ($action) {
            case 'fetch':
                // Return the fetched data as JSON response
                echo json_encode(fetchFeedback());
                break;
            case 'feedback':
                echo json_encode(addFeedback());
                break;
            case 'feedcmt':
                echo json_encode(fetchCMT());
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action not specified']);
    }
$conn->close();    
?>