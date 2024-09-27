<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
include '../connect.php';


$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
// Hợp lệ
else {
// Check the product name parameter in the request
if (isset($_GET['blogTitle'])) {

    $blogTitle = $_GET['blogTitle'];

    $blogTitle = mysqli_real_escape_string($conn, $blogTitle);

    $sql_Blog = "SELECT BLOG_TITLE, CONTENT, BLOG_IMG, USER_NAME, BLOG_DAY FROM blog where BLOG_TITLE = '$blogTitle'";

    $resultBlog = $conn->query($sql_Blog);

    //Thông tin blog
    $dataBlog;

    if ($resultBlog && $resultBlog->num_rows > 0) {
        $dataBlog = $resultBlog->fetch_assoc();
        $dataBlog['BLOG_IMG'] = base64_encode($dataBlog['BLOG_IMG']); //end code image data
    }

    //echo json_encode($dataBlog);
    echo json_encode((['blogTitle' => $blogTitle, 
        'dataBlog' => $dataBlog,
]));
} else {
    echo json_encode(['success' => false, 'message' => 'Action not specified']);
}
// Đóng kết nối CSDL
$conn->close();
}

?>