<?php
    include('./connect.php');
    
    function removeProduct(){
        global $conn;
        $id = intval($_GET["id"]);
        $sqlDeleteProduct = "DELETE FROM order_detail
                        WHERE ORDER_DETAIL_ID=".$id;
        if(mysqli_query($conn, $sqlDeleteProduct)){
            echo "Update Succesfully";
        }
    }
    removeProduct();
?>