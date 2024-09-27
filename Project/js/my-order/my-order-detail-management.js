import {showToastr} from "../admin/toastr.js";
var orderId;
const showOrderId= $('#orderId');
const showOrderStatus = $('.order-status');
const showOrderDate = $('#date-create-order');

const showCusName = $('#cus-name');
const showCusTel = $('#cus-tel');
const showCusAdd = $('#cus-add'); //address
const showCusPay = $('#cus-pay');

const totalOrderCost = $('.cost.order');
const totalOrderPromotion = $('.cost.promotion');
const totalOrder = $('.cost.total');

$(document).ready(function() {
    const orderId =  new URLSearchParams(window.location.search).get('id');
    //const url='../../php/admin/OrderDetail.php?id='+ orderId; 
    fetchData_Customer(orderId);

    //link to feed back
    var btnFeedback = $('.order-option.feedback');
    btnFeedback.append(`
        <a href="../account-management/my-order-feedback.php?id=${orderId}" >
            <i class="fa-solid fa-star" style="color:#FEC30D"></i>
            ĐÁNH GIÁ
        </a>
    `);

    //hủy đơn hàng
    $('.order-selection').on('click', '.cancel-order', function(event) {
        event.preventDefault();
        if(confirm("Xác nhận hủy đơn hàng?")) {
            if(showOrderStatus.text() != 'Đang chuẩn bị hàng' && showOrderStatus.text() != 'Giao thành công') {
                showToastr("error", "Không thể hủy đơn hàng!");
                // alert("Không thể hủy đơn hàng!");
            }else {
                DeleteOrder(orderId);
            }
        }
    });
});

function DeleteOrder(orderId) {
    $.ajax({
        url: "../../../php/Controller/store/my-order-detail-controller.php",
        type: 'POST',
        data: {action:'delete',orderId: orderId},
        dataType: 'json',
        success: function (result) {
            if(result) {
                
                alert("Hủy đơn hàng thành công!");
                var url = '../../../php/store/account-management/my-orders.php';
                window.location.href = url;
            }
            else {
                showToastr("error", "Hủy đơn không thành công");
                // alert("Hủy đơn hàng không thành công");
            }
        },
        error: function() {
            showToastr("error", "Lỗi kết nối: hủy đơn hàng");
            console.error("Lỗi kết nối: hủy đơn hàng");
        }
    }); 
}

function fetchData_Customer(orderId) {
    $.ajax({
        url: "../../../php/Controller/store/my-order-detail-controller.php",
        type: 'POST',
        data: {action:'detail',orderId: orderId},
        dataType: 'json',
        success: function (response) {
            var data_cus = response.data1; //khách hàng
            var data_pro = response.data2; //sản phẩm
            if(!data_cus) console.log("dữ liệu khách hàng rỗng");
            if(!data_pro) console.log("dữ liệu sản phẩm rỗng");
            
            data_cus.forEach(function(row) {
                //thêm order_id
                showOrderId.text(`${row.order_id}`);
                //thêm order status
                showOrderStatus.text(`${row.status}`);
                var status = `${row.status}`;
                editStatus(status);
                if(status != 'Giao thành công') {
                    var btnFeedback = $('.order-option.feedback');
                    btnFeedback.css('display', 'none');
                }
                //thêm order date
                showOrderDate.append(`${row.order_date}`);

                //thêm thông tin khách hàng
                showCusName.append(`${row.name}`);
                showCusTel.append(`${row.telephone}`);
                showCusAdd.append(`${row.address}`);
                showCusPay.text(`${row.pay}`);

                //show order-cost
                totalOrderCost.append(`${row.total_price}đ`);
                totalOrderPromotion.append(`0đ`);
                totalOrder.append(`${row.total_price}đ`);
            });

            //thêm thông tin sản phẩm
            var table_pro = $('.tbody-product');
            data_pro.forEach(function(row) {
                var imageUrl = 'data:image/png;base64,' + row.first_picture;
                table_pro.append(`
                <tr>
                    <td>${row.product_id}</td>
                    <td>${row.size}</td>
                    <td>${row.product_name}</td>
                    <td><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                    <td>${row.quantity}</td>
                    <td>${row.price}</td>
                </tr>
                `);
            });
        },
        error: function() {
            showToastr("error", "Lỗi kết nối");
            console.error("Lỗi kết nối: fetch data order detail");
        }
    });    
}

function editStatus(status) {
    
    if(status == "Giao thành công") {
        showOrderStatus.addClass('success');
    }
    else if (status == "Đang chuẩn bị hàng" || status == "Đang giao hàng") {
        showOrderStatus.addClass('pending');
    }
    else if (status == "Đã hủy") {
        showOrderStatus.addClass('cancel');
    }
    else
        console.log("lỗi");
}