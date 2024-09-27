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
$sql_Blog = "SELECT `BLOG_TITLE`, `USER_NAME`, `BLOG_IMG` FROM blog ORDER BY `BLOG_DAY` DESC LIMIT 3";

$sql_ProductBestSeller = "SELECT PRODUCT_NAME, PRICE, FIRST_PICTURE
                            FROM products INNER JOIN
	                            (select PRODUCT_ID FROM order_detail GROUP BY PRODUCT_ID ORDER BY sum(quantity) DESC LIMIT 8) AS DSSP
                                ON products.PRODUCT_ID=DSSP.PRODUCT_ID
                                INNER JOIN product_pictures ON products.PRODUCT_ID = product_pictures.PRODUCT_ID";

$sql_ProductNew = "SELECT PRODUCT_NAME, PRICE, FIRST_PICTURE 
                        FROM products INNER JOIN product_pictures 
                        ON products.PRODUCT_ID = product_pictures.PRODUCT_ID 
                        ORDER BY products.PRODUCT_ID DESC LIMIT 4";

$resultBlog = $conn->query($sql_Blog);
$resultProductBestSeller = $conn->query($sql_ProductBestSeller);
$resultProductNew = $conn->query($sql_ProductNew);

$dataBlog = [];
$dataProductBestSeller = [];
$dataProductNew = [];

if ($resultBlog->num_rows > 0) {
    while ($rowBlog = $resultBlog->fetch_assoc()) {
        $rowBlog['BLOG_IMG'] = base64_encode($rowBlog['BLOG_IMG']); //end code image data
        $dataBlog[] = $rowBlog;
    }
}

if ($resultProductBestSeller->num_rows > 0) {
    while ($rowProductBestSeller = $resultProductBestSeller->fetch_assoc()) {
        $rowProductBestSeller['FIRST_PICTURE'] = base64_encode($rowProductBestSeller['FIRST_PICTURE']); //end code image data
        $dataProductBestSeller[] = $rowProductBestSeller;
    }
}

if ($resultProductNew->num_rows > 0) {
    while ($rowProductNew = $resultProductNew->fetch_assoc()) {
        $rowProductNew['FIRST_PICTURE'] = base64_encode($rowProductNew['FIRST_PICTURE']); //end code image data
        $dataProductNew[] = $rowProductNew;
    }
}

$combinedResult = array(
    "tableBlog" => $dataBlog,
    "tableProductBestSeller" => $dataProductBestSeller,
    "tableProductNew" => $dataProductNew
);

echo json_encode($combinedResult);

// Close the database connection
$conn->close();

echo json_encode((['combinedResult' => $combinedResult, 
]));

}
?>