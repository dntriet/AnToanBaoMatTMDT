<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
// Include the database configuration file
include '../connect.php';

//FETCH DATA
function fetchCustomers() {
    global $conn;

    // Define the number of records per page
    $records_per_page = 20;

    // Get the current page number from the URL
    if (isset($_POST['page']) && is_numeric($_POST['page'])) {
        $page = intval($_POST['page']);
    } else {
        $page = 1;
    }

    // Get the total number of records from the database
    $totalRecordsQuery = "SELECT COUNT(*) as total 
                          FROM users, login
                          WHERE users.user_login = login.user_login
                          and role_id = 3";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalRecords / $records_per_page);


    // Calculate the offset for the query
    $offset = ($page - 1) * $records_per_page;

    // Fetch data from the database with pagination
    $sql = "SELECT * 
            FROM users, login
            WHERE users.user_login = login.user_login
            and role_id = 3
            LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Create an associative array with multiple values
    $response = array(
        'data' => $data,
        'totalPages' => $totalPages
    );

        //return ['data' => $data, 'totalPages' => $totalPages];
        return $response;
}


//UPDATE 
function updateCustomer() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = ($_POST['id']);
        $name = ($_POST['name']);
        $phone = ($_POST['phone']);
        $birthday = ($_POST['birthday']);
        $gender = ($_POST['gender']);
        $address = ($_POST['address']);

        // Use prepared statement to avoid SQL injection
        $sql = "UPDATE users 
                SET user_name = ?, user_telephone = ?, birthday = ?, gender = ?, address = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $name, $phone, $birthday, $gender, $address, $id);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {
            return ['result' => true, 'message' => 'Cập nhật thành công'];
        } else {
            return ['result' => false, 'message' => 'Cập nhật không thành công'];
        }
    } else {
        return ['result' => false, 'message' => 'Cập nhật không thành công'];
    }
}

// //DELETE
function deleteCustomer() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customerId = trim($_POST['customer_id'], " ");
        $customerLogin = trim($_POST['customer_login'], " ");

        // Use prepared statement to avoid SQL injection
        $sql1 = "DELETE FROM users WHERE user_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('s', $customerId);
        $result1 = $stmt1->execute();
        $stmt1->close();

        if ($result1) {
            $sql2 = "DELETE FROM login WHERE user_login = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param('s', $customerLogin);
            $result2 = $stmt2->execute();
            $stmt2->close();

            return $result2;
        } else {
            return ['result' => false];
        }
    }

    return ['result' => false];
}

// //SEARCH CATEGORIES
function searchCustomers() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $searchTerm = '%' . $_POST['searchTerm'] . '%';
        $records_per_page = 20;

        // Get the current page number from the URL
        if (isset($_POST['page']) && is_numeric($_POST['page'])) {
            $page = intval($_POST['page']);
        } else {
            $page = 1;
        }

        // Use prepared statement to avoid SQL injection
        $totalRecordsQuery = "SELECT COUNT(*) as total  
                            FROM users, login
                            WHERE users.user_login = login.user_login
                            and role_id = 3
                            and user_name LIKE ?";

        $stmt = $conn->prepare($totalRecordsQuery);
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        $totalRecordsResult = $stmt->get_result();
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
        $stmt->close();

        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $records_per_page);

        // Calculate the offset for the query
        $offset = ($page - 1) * $records_per_page;

        // Fetch data from the database with pagination using prepared statement
        $sql = "SELECT * 
                FROM users, login
                WHERE users.user_login = login.user_login
                and role_id = 3 and user_name LIKE ?
                LIMIT ?, ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $searchTerm, $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        // Create an associative array with multiple values
        $response = array(
            'data' => $data,
            'totalPages' => $totalPages
        );

        $stmt->close();
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
else {
    // Check the action parameter in the request
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Execute the corresponding function based on the action
        switch ($action) {
            case 'fetch':
                // Return the fetched data as JSON response
                echo json_encode(fetchCustomers());
                break;
            case 'delete':
                echo json_encode(deleteCustomer());
                break;
            case 'update':
                echo json_encode(updateCustomer());
                break;
            case 'search':
                echo json_encode(searchCustomers());
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



