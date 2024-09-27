<!-- Start of edit address modal -->
    <!-- use modal of bootstrap to style edit profile. modified 10/27/2023 by Quyen -->
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="modal-profile" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header" style="border-bottom: none;">
                    <h1 class="modal-title fs-5" id="modal-profile">SỬA THÔNG TIN</h1>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row row-gap-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name-profile" placeholder="Họ và tên*" required
                                oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')"
                                oninput="this.setCustomValidity('')">
                                <label for="name-profile">Họ và tên*</label>
                            </div>

                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phonenumber" placeholder=" Số điện thoại*" required pattern="^0[0-9]{9}$"
                                    oninvalid="this.setCustomValidity('Yêu cầu nhập số điện thoại có 10 số và bắt đầu =0')"
                                    oninput="this.setCustomValidity('')">
                                
                                <label for="phonenumber"> Số điện thoại*</label>
                            </div>

                            <div class="form-floating">
                                <input type="date" class="form-control" id="dateofbirth">
                                <label for="dateofbirth">Ngày sinh*</label>
                            </div>

                            <div>
                                <input type="radio" id="nam" value="Nam" name="gioitinh">
                                <label for="radio1">Nam</label>

                                <input type="radio" id="nu" value="Nữ" name="gioitinh">
                                <label for="radio2">Nữ</label>

                            </div>

                            <div class="btn-container">
                                <button class="btn btn-confirm" style="width: 100%;">Lưu thay đổi</button>
                                <button class="btn btn-cancel" style="width: 100%;">Hủy</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of edit address modal -->