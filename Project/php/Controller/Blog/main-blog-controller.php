<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
// Include the database configuration file
include '../connect.php';

$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
// Hợp lệ
else {
$sql_Blog = "SELECT BLOG_TITLE, CONTENT, BLOG_IMG FROM blog";

$resultBlog = $conn->query($sql_Blog);

// Thông tin blog
$dataBlog = [];

if ($resultBlog->num_rows > 0) {
    while ($rowBlog = $resultBlog->fetch_assoc()) {
        $rowBlog['BLOG_IMG'] = base64_encode($rowBlog['BLOG_IMG']); //end code image data
        $dataBlog[] = $rowBlog;
    }
}

echo json_encode($dataBlog);

// Đóng kết nối CSDL
$conn->close();

echo json_encode((['resultBlog' => $resultBlog, 
    ]));

}
?>