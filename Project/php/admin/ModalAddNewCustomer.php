<!-- start of Modal of Add new elements-->
<!-- Modified 10/23/2023 by Quyen -->
<div class="modal fade modal-md add-new-container" id="add-new" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="#add-customer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-customer">Thêm mới khách hàng</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>

            <form action="" id="modal-form" class="add-new-customer need-validation" novalidate>
                <div class="modal-body">
                    <label for="customer-username" class="form-label">Tên đăng nhập</label>
                    <input type="text" id="customer-username" class="form-control">

                    <div class="">
                        <label for="customer-name" class="form-label">Tên khách hàng*</label>
                        <input type="text" id="customer-name" class="form-control" required>
                        <div class="invalid-feedback emp_name">
                            Yêu cầu nhập tên nhân viên.
                        </div>
                    </div>
                    
                    <div class="">
                        <label for="customer-phone" class="form-label">Điện thoại*</label>
                        <input type="tel" id="customer-phone" class="form-control" required pattern="^0[0-9]{9}$">
                        <div class="invalid-feedback phone">
                                Yêu cầu nhập điện thoại có 10 số và bắt đầu = 0.
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col">
                            <label for="customer-date-of-birth" class="form-label">Ngày sinh</label>
                            <input type="date" id="customer-date-of-birth" class="form-control">
                        </div>

                        <div class="col">
                            <label for="customer-gender" class="form-label">Giới tính</label>
                            <select id="customer-gender" class="form-select">
                                <option value="" disabled selected hidden></option>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                    </div>

                    <label for="customer-address" class="form-label">Địa chỉ</label>
                    <textarea id="customer-address" class="form-control"></textarea>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel admin">Hủy</button>
                    <button type="submit" class="btn btn-confirm admin">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of Modal of Add new elements-->