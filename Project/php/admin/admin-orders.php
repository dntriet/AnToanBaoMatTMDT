<?php
    $title = "Danh sách đơn hàng";
    include("admin-nav.php");
?>

<!--MAIN SECTION----START-->
<div class="admin-orders">
    <ol class="breadcrumb">
        <li class= "breadcrumb-item active" aria-current="page">Danh sách đơn hàng</li>
    </ol>
    <!--Orders' date-->
    <div class="date-orders">
        <i class="fa-solid fa-calendar"></i>
        <span>dd/mm/yyyy - dd/mm/yyyy</span>
    </div>

    <!--Dropdown choose status for orders-->
    <div class="choose-status">
            <span>Trạng thái đơn hàng</span>                
            <i class="fa-solid fa-angle-down"></i>

            <ul class="list-status">
                <li>Đang xử lý</li>
                <li>Giao hàng thành công</li>
                <li>Đã hủy</li>  
            </ul>                      
    </div>
    
    <!--Search bar-->
    <div class="search-bar">    
        <input type="text" name="" placeholder="Tìm kiếm đơn hàng..." class="search-field">
        <a href="#" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></a>            
    </div>

    <!--Table list orders-->
    <table class="list-orders">
        <th colspan="10">Danh sách đơn hàng</th>
        <tr>
            <td><input type="checkbox"></td>   
            <td>Mã đơn hàng</td>
            <td>Ngày hóa đơn</td>   
            <td>SĐT</td>   
            <td>Tên khách hàng</td>                  
            <td>Địa chỉ</td>
            <td>PTTT</td>   
            <td>Trạng thái</td>   
            <td>Tổng sản phẩm</td>   
            <td>Tổng tiền</td>   
        </tr>

        <tr>
            <td><input type="checkbox"></td>
            <td>A123</td>
            <td>dd/mm/yyy</td>   
            <td>0912345678</td>   
            <td>ABC DEF GHIJK</td>                  
            <td>123 ABCD</td>
            <td>Momo</td>   
            <td>Giao hàng thành công</td>   
            <td>3</td>   
            <td>$9999</td> 
        </tr>
    </table>

    <!--Pagination-->
    <div class="pagination admin">
        <a href="#">&laquo;</a>
        <a class="active" href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">&raquo;</a>
    </div>
</div>
<!--MAIN SECTION----END-->