<?php
    $title = "Chi tiết đơn hàng";
    include("admin-nav.php");
?>
<!--MAIN SECTION----START-->
<div class="admin-order-detail">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../../php/admin/admin-orders.php">Danh sách đơn hàng</a></li>
        <li class= "breadcrumb-item active" aria-current="page">Chi tiết đơn hàng #A123</li>
    </ol>

    <div class="customer-infomation">
        <h3>Mã đơn hàng: 
            <span class="order-status">Giao hàng thành công</span>
        </h3>
        <!--date order-->
        <div class="date-order">
            <i class="fa-solid fa-calendar"></i>
            <span>dd/mm/yyyy</span>
        </div>

        <!--Change status, button print, button save-->
        <div class="box-change_status-print-save">
            <div class="change-status">
                <span>Trạng thái đơn hàng</span>                
                <i class="fa-solid fa-angle-down"></i>

                <ul class="option-status">
                    <li>Đang xử lý</li>
                    <li>Giao hàng thành công</li>
                    <li>Đã hủy</li>  
                </ul>                      
            </div>

            <i class="fa-solid fa-print icon"></i>
            <i class="fa-solid fa-floppy-disk icon"></i>            
        </div>

        <!--3 boxes information of customer-->
        <ul class="info-customer">
            <li class="box-info" id="info-1">
            <i class="fa-solid fa-user icon-info"></i>
                    
                <ul class="info">
                    <li class="header-info">Thông tin người nhận</li>
                    <li>Họ tên: </li>
                    <li>SĐT: </li> 
                </ul>
            </li>
            
            <li class="box-info" id="info-2">
                <i class="fa-solid fa-location-dot icon-info"></i>
                    
                <ul class="info">
                    <li class="header-info">Địa chỉ người nhận</li>
                    <li> 123 ABC</li>
                </ul>
            </li>

            <li class="box-info" id="info-3">
            <i class="fa-solid fa-credit-card icon-info"></i>
                    
                <ul class="info">
                    <li class="header-info">Phương thức thanh toán</li>
                    <li>Momo: 09123456789</li>
                </ul>
            </li>


        </ul>
    </div>

    <!--Information of products in order-->
    <div class="order-infomation">
        <table>
            <th colspan="8">Sản phẩm</th>
            <tr>
                <td colspan="2">Mã đơn hàng</td>
                <td>Mã sản phẩm</td>
                <td>Kích thước</td>
                <td>Tên sản phẩm</td>
                <td>Hình ảnh</td>
                <td>Số lượng</td>
                <td>Tổng tiền</td>
            </tr>

            <tr>
                <td class="col-checkbox"><input type="checkbox"></td>
                <td>#A123</td>
                <td>SS001</td>
                <td>38</td>
                <td>Product name</td>
                <td>xem hình ảnh</td>
                <td>1</td>
                <td>$9999</td>
            </tr>
            <tr>
                <td class="col-checkbox"><input type="checkbox"></td>
                <td>#A123</td>
                <td>SS001</td>
                <td>38</td>
                <td>Product name</td>
                <td>xem hình ảnh</td>
                <td>1</td>
                <td>$9999</td>
            </tr>
            <tr>
                <td class="col-checkbox"><input type="checkbox"></td>
                <td>#A123</td>
                <td>SS001</td>
                <td>38</td>
                <td>Product name</td>
                <td>xem hình ảnh</td>
                <td>1</td>
                <td>$9999</td>
            </tr>
        </table>

        <!--Order cost-->
        <table class="order-cost">
            <tr>
                <td>Tổng tiền sản phẩm</td>
                <td class="cost order">$9999</td>
            </tr>

            <tr>
                <td>Khuyến mãi</td>
                <td class="cost promotion">$9999</td>
            </tr>

            <tr class="total-cost">
                <td>Tổng tiền thanh toán</td>
                <td class="cost total">$9999</td>
            </tr>
        </table>
    </div>
</div>
<!--MAIN SECTION----END-->