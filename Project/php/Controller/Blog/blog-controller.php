<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
include "../connect.php";


//Fetch Product data
function fetchBlog() {
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
                        FROM blog";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalRecords / $records_per_page);


    // Calculate the offset for the query
    $offset = ($page - 1) * $records_per_page;

    // Fetch data from the database with pagination
    $sql = "SELECT DISTINCT BLOG_ID, BLOG_TITLE, USER_ID, USER_NAME, CONTENT, BLOG_DAY, BLOG_IMG 
            FROM blog
            ORDER BY BLOG_ID
            LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['BLOG_IMG'] = base64_encode($row['BLOG_IMG']); //end code image data
            $data[] = $row;
        }
    }

    // Create an associative array with multiple values
    $response = array(
        'data' => $data,
        'totalPages' => $totalPages
    );
        return $response;
}

//CHECK VALIDATION
function checkExist($name) { 
    global $conn;
    $name = trim($name, " ");
    // Check if the category name already exists
    // $user_login = trim(mysqli_real_escape_string($conn, $employee['username']). " ");
    $sql = "SELECT COUNT(*) as count FROM blog WHERE BLOG_TITLE like '$name'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    return  $row['count'] > 0;
} 
    
function insertBlog() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $user_id = 'KH0034'; //dùng để test
        $user_name = ($_POST['username']);
        $content = ($_POST['content']);
        $name = ($_POST['name']);

        $pic = $_FILES['blog-img']['tmp_name'];
        $pic_blob = file_get_contents($pic);

        $exist = checkBlog($name);
        if ($exist) {
            return false;
        } else {

            $sql = "INSERT INTO blog (USER_ID, USER_NAME, BLOG_DAY, CONTENT, BLOG_IMG, BLOG_TITLE)
            VALUES (?, ?, sysdate(), ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Bind the parameter
            $stmt->bind_param('sssss', $user_id, $user_name, $content, $pic_blob, $name);

            // Execute the statement
            $result = $stmt->execute();

            // Close the statement
            $stmt->close();

            if($result)
                return true;
            else
                return false;
        }
    } else {
        return false;
    }
}

function checkBlog($name) { 
    global $conn;
    // Check if the category name already exists
    $sql = "SELECT COUNT(*) as count FROM blog WHERE BLOG_TITLE = '$name'";
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


//INSERT 
function updateBlog() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id = ($_POST['id']);
        $user_id = 'KH0034'; //dùng để test
        $user_name = ($_POST['username']);
        $content = ($_POST['content']);
        $name = ($_POST['name']);

        $sql = "SELECT COUNT(*) as count FROM blog 
                WHERE BLOG_TITLE like ? AND BLOG_ID <> ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $isExist = $row['count'] > 0;
        $stmt->close();

        if (!$isExist) {
            if(isset($_FILES['blog-img']['tmp_name'])){
                $pic = $_FILES['blog-img']['tmp_name'];
                $pic_blob = file_get_contents($pic);

                $sql = "UPDATE blog
                SET USER_ID = ?, USER_NAME = ?, BLOG_DAY = sysdate(), CONTENT = ?, BLOG_IMG = ?, BLOG_TITLE = ?
                WHERE BLOG_ID = ?";
       
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssssi', $user_id, $user_name, $content, $pic_blob, $name, $id);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) 
                    return true;
                 else 
                    return false;
            }
            else{
                $sql = "UPDATE blog
                SET USER_ID = ?, USER_NAME = ?, BLOG_DAY = sysdate(), CONTENT = ?, BLOG_TITLE = ?
                WHERE BLOG_ID = ?";
       
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssi', $user_id, $user_name, $content, $name, $id);
                $result = $stmt->execute();
                $stmt->close();

                if ($result) 
                    return true;
                 else 
                    return false;
            }
        } else 
            return false;
    } else 
        return false;
}


//DELETE
function deleteBlog() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Id = trim($_POST['id'], " ");

        $sql1 = "DELETE FROM blog WHERE BLOG_ID = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param('i', $Id);
        $result1 = $stmt1->execute();
        $stmt1->close();

        if ($result1) {

            return ['result' => true];
        } else {
            return ['result' => false];
        }
    } 
}


// //SEARCH
function searchBlog() {
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

        $totalRecordsQuery = "SELECT COUNT(*) as total FROM blog WHERE BLOG_TITLE LIKE ?";
        $stmtTotal = $conn->prepare($totalRecordsQuery);
        $stmtTotal->bind_param('s', $searchTerm);
        $stmtTotal->execute();
        $totalRecordsResult = $stmtTotal->get_result();
        $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
        $stmtTotal->close();

        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $records_per_page);

        // Calculate the offset for the query
        $offset = ($page - 1) * $records_per_page;

        $sql = "SELECT BLOG_ID, BLOG_TITLE, USER_ID, USER_NAME, CONTENT, BLOG_DAY, BLOG_IMG 
            FROM blog
            where BLOG_TITLE like ?
            ORDER BY BLOG_ID
            LIMIT ?, ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $searchTerm, $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['BLOG_IMG'] = base64_encode($row['BLOG_IMG']); //end code image data
                $data[] = $row;
            }
        }

        $response = array(
            'data' => $data,
            'totalPages' => $totalPages
        );
        $stmt->close();
        return $response;
    }
}


// FETCH product_size TABLE
function fetchImages()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $sql = "SELECT BLOG_IMG FROM blog WHERE BLOG_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['BLOG_IMG'] = base64_encode($row['BLOG_IMG']);
               $data = $row;
            }
        }

        $stmt->close();
        return $data;
    }

    return ['result' => false];
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
                echo json_encode(fetchBlog());
                break;
            case 'insert':
                echo json_encode(insertBlog());
                break;
            
            case 'delete':
                echo json_encode(deleteBlog());
                break;
            case 'update':
                echo json_encode(updateBlog());
                break;
            case 'search':
            echo json_encode(searchBlog());
            break;
            case 'fetch-images':
                echo json_encode(fetchImages());
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
        }
    } 
    else 
    {
        echo json_encode(['success' => false, 'message' => 'Action not specified']);
    }
}

// Close the database connection

?>

