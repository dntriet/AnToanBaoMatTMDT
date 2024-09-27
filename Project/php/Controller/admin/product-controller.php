<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
// Include the database configuration file
include '../connect.php';


//Fetch Product data
function fetchProducts() {
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
                        FROM products";
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalRecords / $records_per_page);


    // Calculate the offset for the query
    $offset = ($page - 1) * $records_per_page;

    // Fetch data from the database with pagination
    $sql = "SELECT DISTINCT products.product_id, products.product_name, products.color, 
                products.price, products.description, products.gender, 
                category.category_name, first_picture 
            FROM products, product_pictures, category
            WHERE products.category_id = category.category_id
            and products.product_id = product_pictures.product_id
            ORDER BY products.product_id 
            LIMIT $offset, $records_per_page";

    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['first_picture'] = base64_encode($row['first_picture']); //end code image data
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
    $sql = "SELECT COUNT(*) as count FROM products WHERE product_name like '$name'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    return  $row['count'] > 0;
}


function insertProduct() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = ($_POST['name']);
        $price = (int) ($_POST['price']);
        $category_id = (int) ($_POST['category_id']);
        $color = ($_POST['color']);
        $description = ($_POST['description']);
        $gender = ($_POST['gender']);
        $product_variants = ($_POST['product_variants']);

        if (!checkExist($name)) {
            // Use prepared statement to avoid SQL injection
            $sql1 = "INSERT INTO products (product_name, color, price, description, gender, category_id)
            VALUES (?, ?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param('ssissi', $name, $color, $price, $description, $gender, $category_id);
            $result1 = $stmt1->execute();
            $stmt1->close();

            if ($result1) {
                // Find PRODUCT_ID of the newly added product
                $sql = "SELECT product_id FROM products WHERE product_name like ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $name);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result) {
                    $row = $result->fetch_assoc();
                    $id = (int) $row['product_id'];

                    foreach ($product_variants as $variant) {
                        $size = (int)$variant['size'];
                        $quantity =(int)$variant['quantity'];

                        // Use prepared statement to avoid SQL injection
                        $sql2 = "INSERT INTO product_size (product_id, size, quantity) VALUES (?, ?, ?)";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bind_param('iii', $id, $size, $quantity);
                        $result2 = $stmt2->execute();
                        $stmt2->close();

                        if (!$result2) {
                            break;
                        }
                    }

                    if ($result2) {
                        return ['result' => true, 'message' => 'Thêm thành công'];
                    } else {
                        return (['result' => false, 'message' => 'Thêm product_size không thành công']);
                    }
                } else {
                    return (['result' => false, 'message' => 'Không tìm thấy product_id']);
                }
            } else {
                return (['result' => false, 'message' => 'Thêm bảng products không thành công']);
            }
        } else {
            return (['result' => false, 'message' => 'Tên sản phẩm đã tồn tại']);
        }
    } else {
        return (['result' => false, 'message' => 'Thêm không thành công. Không lấy được giá trị']);
    }
}



function insertImages(){
    global $conn; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = ($_POST['name']);

        $first_pic = $_FILES['product-images']['tmp_name'][0];
        $second_pic = $_FILES['product-images']['tmp_name'][1];
        $third_pic = $_FILES['product-images']['tmp_name'][2];

        $first_pic_blob = file_get_contents($first_pic);
        $second_pic_blob = file_get_contents($second_pic);
        $third_pic_blob = file_get_contents($third_pic);

        $sql = "SELECT product_id FROM products WHERE product_name like '$name' LIMIT 1";
        $result = $conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $id = (int) $row['product_id'];

            $sql = "INSERT INTO product_pictures (product_id, first_picture, second_picture, third_picture)
            VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isss', $id, $first_pic_blob, $second_pic_blob, $third_pic_blob);

            if ($stmt->execute()) 
                return (['result' => true, 'message' => 'Thêm product_pictures thành công']);
            else  
                return (['result' => false, 'message' => 'Thêm product_pictures không thành công']);
        }
        else
        return (['result' => false, 'message' => 'Không tìm thấy product_id']);
    }
    else 
        return(['result' => false, 'message' => 'Thêm không thành công. Không lấy được giá trị']);
}


//INSERT 
function updateProduct() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'], " ");
        $id = trim($_POST['id'], " ");
        $price = (int) ($_POST['price']);
        $category_id = (int) ($_POST['category_id']);
        $color = ($_POST['color']);
        $description = ($_POST['description']);
        $gender = ($_POST['gender']);
        $product_variants = ($_POST['product_variants']);

        // Use prepared statement to avoid SQL injection
        $sql = "SELECT COUNT(*) as count FROM products 
                WHERE product_name like ? AND product_id <> ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $isExist = $row['count'] > 0;
        $stmt->close();

        if (!$isExist) {
            // Use prepared statement to avoid SQL injection
            $sql = "UPDATE products
                     SET product_name = ?, color = ?, price = ?, description = ?, gender = ?, category_id = ?
                     WHERE product_id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssissii', $name, $color, $price, $description, $gender, $category_id, $id);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                return updateVariants($id, $product_variants);
            } else {
                return (['result' => false, 'message' => 'Cập nhật bảng products không thành công']);
            }
        } else {
            return (['result' => false, 'message' => 'Tên sản phẩm đã tồn tại']);
        }
    } else {
        return (['result' => false, 'message' => 'Cập nhật không thành công. Không lấy được giá trị']);
    }
}

function updateVariants($id, $variants) {
    global $conn;

    // Assuming $variants is an array with each element having 'size' and 'quantity' properties
    // and $data is the result of a select statement "SELECT size, quantity FROM product_size WHERE product_id = $id"
    $sql = "SELECT size, quantity FROM product_size WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Loop through $variants
        foreach ($variants as $variant) {
            $size = $variant['size'];
            $quantity = $variant['quantity'];

            // Check if the size exists in $data
            $sizeExists = false;
            foreach ($data as $existingData) {
                if ($existingData['size'] == $size) {
                    $sizeExists = true;

                    // Update the quantity if the size exists
                    // Use prepared statement to avoid SQL injection
                    $updateSql = "UPDATE product_size SET quantity = ? WHERE product_id = ? AND size = ?";
                    $stmtUpdate = $conn->prepare($updateSql);
                    $stmtUpdate->bind_param('iii', $quantity, $id, $size);
                    $updateResult = $stmtUpdate->execute();
                    $stmtUpdate->close();

                    if (!$updateResult) {
                        return ['result' => false, 'message' => 'Cập nhật product_size không thành công'];
                    }

                    break; // Exit the loop once the size is found
                }
            }

            // If the size does not exist in $data, insert a new entry
            if (!$sizeExists) {
                // Use prepared statement to avoid SQL injection
                $insertSql = "INSERT INTO product_size (product_id, size, quantity) VALUES (?, ?, ?)";
                $stmtInsert = $conn->prepare($insertSql);
                $stmtInsert->bind_param('iii', $id, $size, $quantity);
                $insertResult = $stmtInsert->execute();
                $stmtInsert->close();

                if (!$insertResult) {
                    return ['result' => false, 'message' => 'Cập nhật product_size không thành công'];
                }
            }
        }

        // Loop through $data to find sizes that need deletion
        foreach ($data as $existingData) {
            $existingSize = $existingData['size'];

            // Check if the existing size is not in $variants
            $sizeToDelete = true;
            foreach ($variants as $variant) {
                if ($variant['size'] == $existingSize) {
                    $sizeToDelete = false;
                    break; // Exit the loop once the size is found in $variants
                }
            }

            // If the size needs deletion, delete the entry
            if ($sizeToDelete) {
                // Use prepared statement to avoid SQL injection
                $deleteSql = "DELETE FROM product_size WHERE product_id = ? AND size = ?";
                $stmtDelete = $conn->prepare($deleteSql);
                $stmtDelete->bind_param('ii', $id, $existingSize);
                $deleteResult = $stmtDelete->execute();
                $stmtDelete->close();

                if (!$deleteResult) {
                    return ['result' => false, 'message' => 'Cập nhật product_size không thành công'];
                }
            }
        }
        return ['result' => true, 'message' => 'Cập nhật thành công'];
    }
    return ['result' => false, 'message' => 'Không có product_size thỏa yêu cầu'];
}

function updateImages(){
    global $conn; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = ($_POST['name']);
    
        $first_pic = $_FILES['product-images']['tmp_name'][0];
        $second_pic = $_FILES['product-images']['tmp_name'][1];
        $third_pic = $_FILES['product-images']['tmp_name'][2];
    
        $first_pic_blob = file_get_contents($first_pic);
        $second_pic_blob = file_get_contents($second_pic);
        $third_pic_blob = file_get_contents($third_pic);
    
        $sql = "SELECT product_id FROM products WHERE product_name LIKE ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $name);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
    
            if ($row) {
                $id = (int) $row['product_id'];
    
                $sql = "UPDATE product_pictures 
                        SET first_picture = ?, second_picture = ?, third_picture = ? 
                        WHERE product_id = ?";
    
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssi', $first_pic_blob, $second_pic_blob, $third_pic_blob, $id);
    
                if ($stmt->execute()) {
                    return ['result' => true, 'message' => 'Cập nhật product_pictures thành công'];
                } else {
                    return ['result' => false, 'message' => 'Cập nhật product_pictures không thành công'];
                }
            } else {
                return ['result' => false, 'message' => 'Không tìm thấy product_id'];
            }
        } else {
            return ['result' => false, 'message' => 'Không tìm thấy product_id'];
        }
    } else {
        return ['result' => false, 'message' => 'Không lấy được giá trị'];
    }
    
}


//DELETE
function deleteProduct() {
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = (int) trim($_POST['product_id'], " ");

        // Use prepared statement to avoid SQL injection
        $sql = "DELETE FROM product_pictures WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $productId);
        $result = $stmt->execute();
        $stmt->close();

        if ($result) {

            // Use prepared statement to avoid SQL injection
            $sql1 = "DELETE FROM product_size WHERE product_id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param('i', $productId);
            $result1 = $stmt1->execute();
            $stmt1->close();

            if($result1){
                // Use prepared statement to avoid SQL injection
                $sql2 = "DELETE FROM products WHERE product_id = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param('i', $productId);
                $result2 = $stmt2->execute();
                $stmt2->close();

                return $result2;
            }
            else
                return ['result' => false];
            
        } else 
            return ['result' => false];
    } else 
        return ['result' => false];
}


// //SEARCH
function searchProducts() {
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
        $totalRecordsQuery = "SELECT COUNT(*) as total FROM products WHERE product_name LIKE ?";
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

        // Use prepared statement to avoid SQL injection
        $sql = "SELECT DISTINCT products.product_id, products.product_name, products.color, 
                products.price, products.description, products.gender, category.category_name, first_picture 
                FROM products, product_pictures, category
                WHERE products.category_id = category.category_id
                AND products.product_id = product_pictures.product_id
                AND product_name LIKE ?
                ORDER BY products.product_id  
                LIMIT ?, ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $searchTerm, $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['first_picture'] = base64_encode($row['first_picture']); //end code image data
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


//FETCH category TABLE
function fetchCategories(){
    global $conn;

    $sql = "SELECT category_id, category_name FROM category";
    $result = $conn->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

// FETCH product_size TABLE
function fetchVariants()
{
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        // Use prepared statement to avoid SQL injection
        $sql = "SELECT size, quantity FROM product_size WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();
        return $data;
    }

    return ['result' => false];
}

// FETCH product_size TABLE
function fetchImages()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        // Use prepared statement to avoid SQL injection
        $sql = "SELECT first_picture, second_picture, third_picture FROM product_pictures WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['first_picture'] = base64_encode($row['first_picture']);
                $row['second_picture'] = base64_encode($row['second_picture']);
                $row['third_picture'] = base64_encode($row['third_picture']);
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
                echo json_encode(fetchProducts());
                break;
            case 'insert':
                echo json_encode(insertProduct());
                break;
            case 'insert-images':
                echo json_encode(insertImages());
                break;
            case 'delete':
                echo json_encode(deleteProduct());
                break;
            case 'update':
                echo json_encode(updateProduct());
                break;
            case 'update-images':
                echo json_encode(updateImages());
                break;
                case 'search':
                echo json_encode(searchProducts());
                break;
            case 'fetch-categories':
                echo json_encode(fetchCategories());
                break;
            case 'fetch-variants':
                echo json_encode(fetchVariants());
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

    // Close the database connection
    $conn->close();
}

?>
