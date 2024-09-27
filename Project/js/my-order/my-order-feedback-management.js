import { showToastr } from "../admin/toastr.js";
$(document).ready(function() {
    const orderId =  new URLSearchParams(window.location.search).get('id');
    
    var linkOrderDetail = $('#link-back-order-detail');
    linkOrderDetail.append(`
        <a href="my-order-detail.php?id=${orderId}">Chi tiết đơn hàng</a> / 
    `);
    const url ='../../../php/store/account-management/my-order-feedback.php?id=' + orderId;
    showFormFb(orderId);
    $('#add-feedback').on('click', '.btn-cancel', function(event) {
        event.preventDefault();
        if(confirm("Những thay đổi của bạn sẽ không được lưu?")) {            
            $('#add-feedback').modal('hide');
        }
    })

    $('#add-feedback').on('click','.btn-close', function(event) {
        event.preventDefault();
        if(confirm("Những thay đổi của bạn sẽ không được lưu?")) {            
            $('#add-feedback').modal('hide');
        }
    })

    //fetch modal feedback
    $('.my-order-rating').on('click', '.btn-input-feedback',function(event) {
        event.preventDefault();
        var closest_row = $(this).closest('tr');
        var product_id = closest_row.find('td:first').text();

        $('#ModalproductID').val(product_id);
        $('#ModalproductID').text(product_id); 
        if($(this).text() == "Viết đánh giá") {
            console.log("rỗng");
            $('.input-feedback').text('');
            $("input[type='radio'][name='rating']").attr("checked", false);
        } else {
            console.log($(this).text());
          fetchCMT(orderId, product_id);   
        }
                             
            
    })

    $('#add-feedback').on('click','.btn-confirm', function(event){
        event.preventDefault();

        var product_id = $('#ModalproductID').val();
        var feedback_content = $('.input-feedback').val();
        var feedback_star = $("input[type='radio'][name='rating']:checked").val();

        var formdata = {
            orderId: orderId,
            productId: product_id,
            fb_content: feedback_content,
            fb_score: feedback_star
        }
        
        if(confirm("Xác nhận đánh giá đơn hàng?")) {
            event.preventDefault();
            addComment(formdata);
        }
    })
    


    function fetchCMT(orderId, product_id){
        $.ajax({
            url: "../../../php/Controller/store/my-order-feedback-controller.php",
            type: 'POST',
            data: { action:'feedcmt',
                orderId: orderId, productId: product_id},
            dataType: 'json',
            success: function (response) {   
                var data = response.data; //cmt
                var content = $('.input-feedback');
                if(!data) {
                    console.log("dữ liệu đánh giá rỗng!");
                }
                else {           
                    data.forEach(function(row){
                        var idStr = '#star'+row.score;               
                        $(idStr).attr('checked', true);
                        content.text(`${row.content}`);
                    });
                }
            },
            error: function() {
                showToastr('error', 'Lỗi kết nối');
                console.error("Lỗi kết nối: thêm đánh giá");
            }
        }); 
    }

    function addComment(formdata) {
        $.ajax({
            url: "../../../php/Controller/store/my-order-feedback-controller.php",
            type: 'POST',
            data: { action: 'feedback',
                    orderId: formdata.orderId,
                    productId: formdata.productId,
                    fb_content: formdata.fb_content,
                    fb_score: formdata.fb_score},
            dataType: 'json',
            success: function (result) {
                console.log(result);
                if(result.result===true){      
                    console.log('a');          
                    showToastr('success', 'Đánh giá thành công!');  
                    $('#add-feedback').modal('hide');  
                    showFormFb(orderId);
                }
                else {
                    showToastr('error', 'Thêm đánh giá không thành công!');
                }
            },
            error: function() {
                showToastr('error', 'Lỗi kết nối');
                console.error("Lỗi kết nối: thêm đánh giá");
            }
        });
    }

    function showFormFb(orderId) {
        $.ajax({
            url: "../../../php/Controller/store/my-order-feedback-controller.php",
            type: 'POST',
            data: {action:'fetch', orderId: orderId},
            dataType: 'json',
            success: function (response) {
                var data1= response.data1; //sản phẩm
                var data2 = response.data2; //cmt
                var listPro = $('.my-order-rating tbody');
                listPro.empty();
                var listProID = [];
                if(!data1) {console.log("dữ liệu sản phẩm rỗng")}
                else {
                    
                    data1.forEach(function(row) {
                        var imageUrl = 'data:image/png;base64,' + row.first_picture;
                        listProID.push(row.product_id);
                        listPro.append(`
                            <tr class="tbl-fb-row">
                                <td>${row.product_id}</td>
                                <td class="td-img"><div class="table-img" style="background-image: url(${imageUrl})"></div></td>
                                <td>${row.product_name}
                                <a href="#" class="btn-input-feedback pro-${row.product_id}" data-bs-toggle="modal" data-bs-target="#add-feedback">Viết đánh giá</a>                            
                                </td>
                                <td>${row.size}</td>
                                <td>${row.quantity}</td>
                                <td>${row.price}đ</td>
                            </tr>
                        `);
                    })                
                }
                
                if(!data2) {console.log("dữ liệu đánh giá rỗng")}
                else {                
                    data2.forEach(function(row) {
                        for(var i = 0; i < listProID.length; i++) {
                            if(row.product_id == listProID[i]) {
                                var classString = '.btn-input-feedback.pro-' + row.product_id;
                                $(classString).text("Sửa đánh giá");
                            }
                        }
                    });
                }    


            },
            error: function() {
                showToastr('error', 'Lỗi kết nối');
                console.error("Lỗi kết nối: fetch data feedback");
            }
        });    
    }


})