<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
// Include the database configuration file
include '../connect.php';

//FETCH DATA 
function fetchCategories() {
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
    $totalRecordsQuery = "SELECT COUNT(*) as total FROM category";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalRecords / $records_per_page);


    // Calculate the offset for the query
    $offset = ($page - 1) * $records_per_page;

    // Fetch data from the database with pagination
    $sql = "SELECT category_id, category_name FROM category LIMIT $offset, $records_per_page";
    $result = $conn->query($sql);

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

        // return ['data' => $data, 'totalPages' => $totalPages];
        return $response;
}

function insertCategory() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryName = $_POST['category_name'];

        $exist = checkCategory($categoryName);
        if ($exist) {
            return false;
        } else {
            // Use prepared statement to avoid SQL injection
            $sql = "INSERT INTO category (category_name) VALUES (?)";
            $stmt = $conn->prepare($sql);

            // Bind the parameter
            $stmt->bind_param('s', $categoryName);

            // Execute the statement
            $result = $stmt->execute();

            // Close the statement
            $stmt->close();

            return $result;
        }
    } else {
        return false;
    }
}

// UPDATE
function updateCategory() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryName = $_POST['category_name'];
        $categoryId = $_POST['category_id'];

        $exist = checkCategory($categoryName);
        if ($exist) {
            return false;
        } else {
            // Use prepared statement to avoid SQL injection
            $sql = "UPDATE category SET category_name = ? WHERE category_id = ?";
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bind_param('si', $categoryName, $categoryId);

            // Execute the statement
            $result = $stmt->execute();

            // Close the statement
            $stmt->close();

            return $result;
        }
    } else {
        return false;
    }
}

// DELETE
function deleteCategory() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoryId = $_POST['category_id'];

        // Use prepared statement to avoid SQL injection
        $sql = "DELETE FROM category WHERE category_id = ?";
        $stmt = $conn->prepare($sql);

        // Bind the parameter
        $stmt->bind_param('i', $categoryId);

        // Execute the statement
        $result = $stmt->execute();

        // Close the statement
        $stmt->close();
        
        return true;
    } else {
        return false;
    }
}


//CHECK VALIDATION
function checkCategory($categoryName) { 
    global $conn;
    // Check if the category name already exists
    $sql = "SELECT COUNT(*) as count FROM category WHERE category_name = '$categoryName'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        if($row['count'] > 0)
            return true;
        else
            return false;
        
    } else {
        // Error in the query
        return true;
    }
}

//SEARCH CATEGORIES
function searchCategories(){
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

        // Get the total number of records from the database using prepared statement
        $totalRecordsQuery = "SELECT COUNT(*) as total FROM category WHERE category_name LIKE ?";
        $stmt = $conn->prepare($totalRecordsQuery);
        $stmt->bind_param('s', $searchTerm);
        $stmt->execute();
        $totalRecordsResult = $stmt->get_result();
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $records_per_page);

        // Calculate the offset for the query
        $offset = ($page - 1) * $records_per_page;

        // Fetch data from the database with pagination using prepared statement
        $sql = "SELECT category_id, category_name FROM category WHERE category_name LIKE ? LIMIT ?, ?";
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

        // Close the prepared statement
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
                echo json_encode(fetchCategories());
                break;
            case 'insert':
                echo json_encode(insertCategory());
                break;
            case 'delete':
                echo json_encode(deleteCategory());
                break;
            case 'update':
                echo json_encode(updateCategory());
                break;
            case 'search':
                echo json_encode(searchCategories());
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



