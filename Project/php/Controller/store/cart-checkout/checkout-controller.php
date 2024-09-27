<?php
include('../../connect.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/an_toan_va_bao_mat/Project/php/Controller/utils/jwt_utils.php';
global $conn;

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }
    //close connection
    curl_close($ch);
    return $result;
}

$accessToken = getBearerToken();
$verifyJWT = json_decode(verifyJWT($accessToken));
// Nếu access token được đính kèm trên Header khi gọi API ko hợp lệ
if ($verifyJWT->status == 'error') {
    echo json_encode($verifyJWT);
}
else {
//Kiểm tra phương thức thanh toán
if (isset($_POST['submit'])) {

    $name=$_POST['name'];
    $phone=$_POST['phone'];

    if (isset($_POST['payment'])) {
        $selectedPayment = $_POST['payment'];

        if ($selectedPayment === 'cod'){
            header('Location: ../../../store/cart/cart.php');
        }
        
        //Thanh toán bằng ATM MOMO
        if ($selectedPayment === 'momo-atm') {
              
        //         //Lấy số tiền cần thanh toán 
                $sql = "SELECT order_id, total_price FROM orders WHERE name = ? and telephone = ? 
                        order by order_id desc, order_date desc 
                        limit 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $name, $phone);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $order_id = $row['order_id'];
                    $total = $row['total_price'];
                    
                    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
                    $partnerCode = 'MOMOBKUN20180529';
                    $accessKey = 'klm05TvNBzhg7h7j';
                    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

                    $orderInfo = "Thanh toán qua MoMo";
                    $amount = $total;
                    $orderId = time() ."";
                    $redirectUrl = "http://localhost/IS207_WEB/IS207_WEB/Project/php/store/cart/cart.php?id=" . $order_id;
                    $ipnUrl = "http://localhost/IS207_WEB/IS207_WEB/Project/php/store/cart/cart.php?id=" . $order_id;
                    $extraData = "";

                    $partnerCode = $partnerCode;
                    $accessKey = $accessKey;
                    $serectkey = $secretKey;
                    $orderId = $orderId; // Mã đơn hàng
                    $orderInfo = $orderInfo;
                    $amount = $amount;
                    $ipnUrl = $ipnUrl;
                    $redirectUrl = $redirectUrl;
                    $extraData = $extraData;

                    $requestId = time() . "";
                    $requestType = "payWithATM";
                    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
                    //before sign HMAC SHA256 signature
                    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $serectkey);
                    $data = array('partnerCode' => $partnerCode,
                        'partnerName' => "Test",
                        "storeId" => "MomoTestStore",
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature);
                    $result = execPostRequest($endpoint, json_encode($data));
                    $jsonResult = json_decode($result, true);  // decode json

                    //Just a example, please check more in there

                    header('Location: ' . $jsonResult['payUrl']);
                }
            }
        }
        //Thanh toán bằng VÍ MOMO - QUÉT MÃ QR
        if ($selectedPayment === 'momo-wallet') {
               //Lấy số tiền cần thanh toán 
               $sql = "SELECT order_id, total_price FROM orders WHERE name = ? and telephone = ? 
               order by order_id desc, order_date desc 
               limit 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $name, $phone);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $order_id = $row['order_id'];
                    $total = $row['total_price'];

                    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
                    $partnerCode = 'MOMOBKUN20180529';
                    $accessKey = 'klm05TvNBzhg7h7j';
                    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

                    $orderInfo = "Thanh toán qua MoMo";
                    $amount = $total;
                    $orderId = time() ."";
                    $redirectUrl = "http://localhost/IS207_WEB/IS207_WEB/Project/php/store/cart/cart.php?id=" . $order_id;
                    $ipnUrl = "http://localhost/IS207_WEB/IS207_WEB/Project/php/store/cart/cart.php?id=" . $order_id;
                    $extraData = "";

                    $partnerCode = $partnerCode;
                    $accessKey = $accessKey;
                    $serectkey = $secretKey;
                    $orderId = $orderId; // Mã đơn hàng
                    $orderInfo = $orderInfo;
                    $amount = $amount;
                    $ipnUrl = $ipnUrl;
                    $redirectUrl = $redirectUrl;
                    $extraData = $extraData;

                    $requestId = time() . "";
                    $requestType = "captureWallet";
                    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
                    //before sign HMAC SHA256 signature
                    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $serectkey);
                    $data = array('partnerCode' => $partnerCode,
                        'partnerName' => "Test",
                        "storeId" => "MomoTestStore",
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature);
                    $result = execPostRequest($endpoint, json_encode($data));
                    $jsonResult = json_decode($result, true);  // decode json

                    //Just a example, please check more in there

                    header('Location: ' . $jsonResult['payUrl']);
                }
            }
           
        }
    
$conn->close();
}
?>

