<div class="modal modal-md fade " id="add-feedback" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="#add-order-feedback">
    <div class="modal-dialog">
        <div class="modal-content">

            <!--Header-->
            <div class="modal-header">
                <h4 class="modal-title">Đánh giá sản phẩm 
                    <span id="ModalproductID"></span>
                </h4>
                <button type="button" class="btn-close"></button>
            </div>
            
            <form action class="add-order-feedback">
                <!--Body-->
                <div class="modal-body">                  
                    <div class="rating-star">
                            Chất lượng sản phẩm
                            <div class="stars">
                            <input type="radio" id="star5" name="rating" value=5>
                            <label for="star5" class="fa-solid fa-star"></label>
                            <input type="radio" id="star4" name="rating" value=4>
                            <label for="star4" class="fa-solid fa-star"></label>
                            <input type="radio" id="star3" name="rating" value=3>
                            <label for="star3" class="fa-solid fa-star"></label>
                            <input type="radio" id="star2" name="rating" value=2>
                            <label for="star2" class="fa-solid fa-star"></label>
                            <input type="radio" id="star1" name="rating" value=1>
                            <label for="star1" class="fa-solid fa-star"></label>
                            </div>
                        </div>
                
                    <textarea type="text" placeholder="Nhận xét sản phẩm*" class="input-feedback" required></textarea>
                </div>

                <!--Footer-->
                <div class="modal-footer edit">
                    <button type="button" class="btn btn-cancel">Hủy</button>
                    <input type="submit" class="btn btn-confirm" value="Xác nhận">
                </div>
            </form>
        </div>
    </div>
</div>
