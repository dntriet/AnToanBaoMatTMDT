<!-- Start of edit address modal -->
    <!-- use modal of bootstrap to style edit address. modified 10/27/2023 by Quyen -->
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="edit-address" tabindex="-1" aria-labelledby="modal-address" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header" style="border-bottom: none;">
                    <h1 class="modal-title fs-5" id="modal-address">ĐỊA CHỈ</h1>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row row-gap-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" placeholder=" Họ và tên*" required
                                    oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')"
                                    oninput="this.setCustomValidity('')">
                                <label for="name"> Họ và tên*</label>
                            </div>
                    
                            <div class="form-floating">
                                <input type="text" class="form-control" id="specificaddress" placeholder="  Địa chỉ (Số nhà, tên đường...)*" required
                                    oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ.')"
                                    oninput="this.setCustomValidity('')">
                                <label for="specificaddress"> Địa chỉ (Số nhà, tên đường...)*</label>
                            </div>
                    
                            <div class="form-floating">
                                <input type="text" class="form-control h-50" id="district" placeholder=" Quận/huyện*" required
                                    oninvalid="this.setCustomValidity('Vui lòng nhập quận huyện.')"
                                    oninput="this.setCustomValidity('')">
                                <label for="district"> Quận/Huyện*</label>
                            </div>

                            <div class="form-floating">
                                <input type="text" class="form-control h-50" id="ward" placeholder=" Xã/Phường*" required
                                    oninvalid="this.setCustomValidity('Vui lòng nhập xã phường.')"
                                    oninput="this.setCustomValidity('')">
                                <label for="ward"> Xã/Phường*</label>
                            </div>
                    
                            <div class="form-floating">
                                <input type="text" class="form-control" id="province" placeholder=" Tỉnh*" required
                                    oninvalid="this.setCustomValidity('Vui lòng nhập tỉnh/thành phố.')"
                                    oninput="this.setCustomValidity('')">
                                <label for="province"> Tỉnh/TP*</label>
                            </div>

                            <div class="btn-container">
                                <button class="btn btn-confirm" style="width: 100%;">Lưu thay đổi</button>
                                <button class="btn btn-cancel btn-edit-address" style="width: 100%;">Hủy</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of edit address modal -->