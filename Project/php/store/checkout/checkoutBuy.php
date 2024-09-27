<?php  
include('../cart/connect.php');
// function execPostRequest($url, $data)
// {
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//             'Content-Type: application/json',
//             'Content-Length: ' . strlen($data))
//     );
//     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//     //execute post
//     $result = curl_exec($ch);
//     // Check for cURL errors
//     if (curl_errno($ch)) {
//         // echo 'Curl error: ' . curl_error($ch);
//     }
//     //close connection
//     curl_close($ch);
//     return $result;
// }

function buy(){
    global $conn;
    if(isset($_POST['user_id'])){

    
    // GET INPUT: START
    $user_id=$_POST['user_id'];

    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $gender=$_POST['gender'];

    $city=$_POST['tinhThanh'];
    $district=$_POST['quanHuyen'];
    $ward=$_POST['xaPhuong'];
    $street=$_POST['duongAp'];
    $address=$street.", ".$district.", ".$ward.", ".$city;

    $date=$_POST['date'];
    // $date = date('Y-m-d H:i:s');
    
    $paymentMethod=$_POST['paymentMethod'];

    $localCart;
    if(isset($_POST['localCart'])){
        $localCart=json_decode(json_encode($_POST['localCart']), true);
    }

    // UPDATE TO DATA BASE: START
    // IF USER LOGIN
    if($user_id!==''){
        // AVOID SQP INJECTION: START
        // cap nhat len db TH nguoi dung dang nhap
        $sql_update_order_login="UPDATE ORDERS SET ADDRESS=?, 
        ORDER_DATE = ?,
        STATUS='Đang chuẩn bị hàng', 
        NAME=?, 
        TELEPHONE=?,
        PAY=? 
        WHERE USER_ID=? 
        AND STATUS='Đang mua hàng'";
        $buySql=$conn->prepare($sql_update_order_login);
        $buySql->bind_param("ssssss", $address, $date, $name, $phone, $paymentMethod, $user_id);
        $buy_result=$buySql->execute();
        // AVOID SQP INJECTION: END
    }else{
        // IF USER NOT LOGIN
        // update to order table
        $sql_update_order_local="INSERT INTO ORDERS (ADDRESS, NAME, TELEPHONE, STATUS , ORDER_DATE, PAY) VALUES (?, ?, ?, 'Đang chuẩn bị hàng', ?, ?)";
        $buySql=$conn->prepare($sql_update_order_local);
        $buySql->bind_param("sssss", $address, $name, $phone, $date, $paymentMethod);
        $buySql->execute();

        // update to order detail table
        $sqlOrderId_Local="SELECT DISTINCT ORDER_ID FROM orders
                        WHERE USER_ID IS NULL
                        AND TELEPHONE=?
                        AND NAME=?
                        AND ADDRESS=?
                        AND STATUS = 'Đang chuẩn bị hàng'
                        AND ORDER_DATE=?
                        LIMIT 1";

        // prepare stament to avoid sqli
        $OrderId_smt=$conn->prepare($sqlOrderId_Local);
        $OrderId_smt->bind_param("ssss", $phone, $name,  
        $address, $date);
        $OrderId_smt->execute();
        
        // get orderId
        $orderId_NotFecth=$OrderId_smt->get_result();
        $localOrderId = intval($orderId_NotFecth->fetch_assoc()['ORDER_ID']);

        foreach($localCart as $row){
            // lay du lieu tu hang
            $product_name=$row["PRODUCT_NAME"];
            $size=intval($row["SIZE"]);
            $quantity=intval($row["QUANTITY"]);

            $sql_update_OrderDetail="INSERT INTO order_detail (order_id, product_name, size, quantity) VALUES (?, ?, ?, ?)";

            $update_OrderDetail_smt=$conn->prepare($sql_update_OrderDetail);
            $update_OrderDetail_smt->bind_param("isii", $localOrderId, $product_name, $size, $quantity);

            $update_result=$update_OrderDetail_smt->execute();
        }
    }
}
    
}

buy();
?>