<?php
// Include the database configuration file
include '../connect.php';

global $conn;

// Count orders have different status
$statuses = array("Đang chuẩn bị hàng", "Đang giao hàng", "Đã hủy");
$counts = array();

foreach ($statuses as $status) {
    $sql = "SELECT COUNT(*) as count FROM orders WHERE status = '$status'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $counts[$status] = $row['count'];
    } else {
        // Handle the query error if needed
        $counts[$status] = 0;
    }
}

// Count out of stock product
$out_of_stock_products = 0;
$sql = "SELECT COUNT(product_id) as count 
        FROM products
        WHERE product_id = (SELECT distinct product_id FROM product_size WHERE quantity = 0)
        ";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $out_of_stock_products = $row['count'];
}

// Calculate total year revenue and total year orders
$sql = "SELECT COUNT(*) as orders, SUM(total_price) as revenue 
        FROM orders
        WHERE year(order_date) = year(sysdate())
        and status = 'Giao thành công'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $total_year_revenue = $row['revenue'];
    $total_year_orders = $row['orders'];
}
else{
    $total_year_revenue = 0;
    $total_year_orders = 0;
}

// Calculate total month revenue and total month orders
$sql = "SELECT COUNT(*) as orders, SUM(total_price) as revenue 
        FROM orders
        WHERE year(order_date) = year(sysdate())
        and month(order_date) = month(sysdate())
        and status = 'Giao thành công'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $total_month_revenue = $row['revenue'];
    $total_month_orders = $row['orders'];
}
else{
    $total_month_revenue = 0;
    $total_month_orders = 0;
}

// fetch data to table best seller
$sql = "SELECT first_picture,A.product_name, total_quantity, A.price
        FROM product_pictures
        INNER JOIN 
        (   SELECT B.product_id, B.product_name, total_quantity, B.price
            FROM products
            INNER JOIN
            (   SELECT product_id, product_name, sum(quantity) AS total_quantity, price
                FROM order_detail
                WHERE order_id in (SELECT order_id FROM orders WHERE year(order_date) = year(sysdate()) and status = 'Giao thành công')
                GROUP BY product_id, product_name, price
                ORDER BY sum(quantity) desc
                LIMIT 5
            ) as B
            ON products.product_id = B.product_id
        ) as A
        ON product_pictures.product_id = A.product_id";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['first_picture'] = base64_encode($row['first_picture']); //end code image data
        $data[] = $row;
    }
}


// fetch data to year revenue area chart
$sql = "SELECT MONTH(order_date) as order_month, SUM(total_price) as revenue 
        FROM orders
        WHERE year(order_date) = year(sysdate())
        and status = 'Giao thành công'
        GROUP BY MONTH(order_date)
        ORDER BY MONTH(order_date) ASC";
$result = $conn->query($sql);

$area_chart_data = [];

// Initialize $area_chart_data with default values
for ($i = 1; $i <= 12; $i++) {
    $area_chart_data[] = 0;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['order_month'];
        $revenue = (float)$row['revenue'];

        // Assign revenue to the corresponding month
        $area_chart_data[$month - 1] = $revenue;
    }
}


// fetch data to year pie chart
$sql = "SELECT category_name, total_revenue
        FROM category
        LEFT JOIN 
            (
                SELECT category_id, sum(B.revenue) as total_revenue
                FROM products
                INNER JOIN 
                (
                    SELECT product_id, sum(price) as revenue
                    FROM order_detail
                    WHERE order_id in (SELECT order_id from orders where year(order_date) = year(sysdate()) and status = 'Giao thành công')
                    group by product_id
                ) as B
                ON products.product_id = B.product_id
                GROUP BY category_id
            ) as A
        ON category.category_id = A.category_id";
$result = $conn->query($sql);

$category_name = [];
$category_revenue = [];

// Initialize $pie_chart_data with default values

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category_name[] = $row['category_name'];
        if($row['total_revenue'] === null)
            $category_revenue[] = 0;
        else
            $category_revenue[] = $row['total_revenue'];
    }
}

$pie_chart_data = ['category_name'=> $category_name, 'revenue'=>$category_revenue];
// print_r($pie_chart_data);


$conn->close();

echo json_encode((['todo_list' => $counts, 
        'out_of_stock_products' => $out_of_stock_products,
        'year_revenue' => $total_year_revenue,
        'month_revenue' => $total_month_revenue,
        'year_orders' => $total_year_orders,
        'month_orders' => $total_month_orders,
        'data' => $data,
        'area_chart_data' => $area_chart_data,
        'pie_chart_data' => $pie_chart_data]));


   
?>



