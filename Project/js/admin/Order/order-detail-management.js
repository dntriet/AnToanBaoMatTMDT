import {showToastr} from "../toastr.js";

var orderId;
const showOrderId= $('#orderId');
const showOrderStatus = $('.order-status');
const showOrderDate = $('.date-order span');

const showCusName = $('#cus-name');
const showCusTel = $('#cus-tel');
const showCusAdd = $('#cus-add'); //address
const showCusPay = $('#cus-pay');

const totalOrderCost = $('.cost.order');
const totalOrderPromotion = $('.cost.promotion');
const totalOrder = $('.cost.total');

$(document).ready(function() {
    const orderId =  new URLSearchParams(window.location.search).get('id');
    const url='../../php/admin/OrderDetail.php?id='+ orderId;    
    if(orderId !='') {
        fetchData_Customer(orderId);

    $('.btn-cancel').on('click', function() {
        if(confirm("Xác nhận hủy các thay đổi?")) {
            //window.location.href= url;  
            $(this).modal('hide'); 
        }
    });

     // Get the URL parameters
    var urlParams = new URLSearchParams(window.location.search);
    // Check if the parameter exists, 
    if (urlParams.has('update_status')) {
        // Get the value of update_status
        var update_status = urlParams.get('update_status');
        if (update_status == 1) {
            showToastr('success', 'Cập nhật trạng thái đơn hàng thành công');
        }
        var currentUrl = window.location.href;

        // Check if the URL contains the update_status_success parameter
        if (currentUrl.includes('update_status')) {
            // Remove the update_status parameter
            var updatedUrl = currentUrl.replace(/(\?|&)update_status=[^&]*(&|$)/, '$1');
            // Use replaceState to update the URL without reloading the page
            window.history.replaceState({}, document.title, updatedUrl);
        }
    }

    
    //thay đổi trạng thái đơn hàng
    $('#edit-order-status .btn-confirm').on('click', function(event) {
        event.preventDefault();
        var status1 = indexStatus(showOrderStatus.text());   
        if(confirm("Xác nhận thay đổi thông tin?")) {
            var form_data = {
                id: orderId,
                order_status: $("input[type='radio'][name='status-order']:checked").val()
            };

            
            if(form_data.order_status < status1) {         
                showToastr("error", "Trạng thái đơn hàng không hợp lệ. Không thể đổi về trạng thái trước đó!");       
                // alert("Trạng thái đơn hàng không hợp lệ. Không thể đổi về trạng thái trước đó!");      
            }
            else if (form_data.order_status == status1){         
                showToastr("error", "Trạng thái đơn hàng không thay đổi!!");    
                // alert("Trạng thái đơn hàng không thay đổi!");
                $('#edit-order-status').modal('hide');        
            }
            else {
                updateStatus(form_data);
                // window.location.href= url;                 
            }          
        }
          
    });
}

    else {
        showToastr("error", "Không lấy được id!");    
        console.error("Không lấy được id");
    }     



function fetchData_Customer(orderId) {
    $.ajax({
        url: "../../php/controller/admin/order-detail-controller.php",
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
                //thêm order date
                showOrderDate.text(`${row.order_date}`);

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
                    <td>${row.order_id}</td>
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
            showToastr("error", "Lỗi kết nối: fetch data order"); 
            console.error("Lỗi kết nối: fetch data order");
        }
    });        
    
}

function updateStatus(form_data) {
    $.ajax({
        url: "../../php/controller/admin/order-detail-controller.php",
        type: 'POST',
        data: {action:'updateStatus',order_status: form_data.order_status, id: form_data.id},
        dataType: 'json',
        success: function(result) {
            if(result==true) {
                // showToastr("success", "Cập nhật trạng thái đơn hàng thành công"); 
                // alert("Cập nhật thông tin thành công");  
                var update_status = '1';
                var encode_update_status = encodeURIComponent(update_status);
                window.location.href = '../../php/admin/OrderDetail.php?id='+ orderId + "&update_status=" + encode_update_status;       
            }
            else {
                showToastr("error", "Cập nhật trạng thái đơn hàng không thành công"); 
                // alert("Cập nhật thông tin không thành công");
            }
   
        },
        error: function() {
            showToastr("error", "Lỗi kết nối: cập nhật trạng thái"); 
            console.error("Lỗi kết nối: cập nhật trạng thái");
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

function indexStatus(status) {
    
    switch(status) {
        case 'Đang chuẩn bị hàng':
            return 1;
        case 'Đang giao hàng':
            return 2;
        case 'Giao thành công':
            return 3;
        case 'Đã hủy':
            return 4;
    }
}


})