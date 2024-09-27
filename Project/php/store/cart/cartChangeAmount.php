<?php
// $product = legal_input($_POST['fullName']);
// connect to database
include('./connect.php');

function updateAmount(){
    global $conn;
    $inputId = intval($_GET["inputId"]);
    $inputVal = intval($_GET["inputVal"]);

    // prepare statement
    $sqlUpdateOrderDetail ="UPDATE order_detail SET QUANTITY = ? WHERE ORDER_DETAIL_ID = ?" ;

    $updateAmountSql=$conn->prepare($sqlUpdateOrderDetail);
    $updateAmountSql->bind_param("ii", $inputVal, $inputId);
    if($updateAmountSql->execute()){
        echo "Update Succesfully";
    }
}

// $conn -> close();
updateAmount();
?>