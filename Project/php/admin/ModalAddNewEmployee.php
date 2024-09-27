<!-- start of Modal of Add new elements-->
<!-- Modified 10/23/2023 by Quyen -->
<div class="modal fade modal-md add-new-container" id="add-new" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="#add-employee" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add-employee">Thêm mới nhân viên</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>

            <form action="" id="modal-form" class="add-new-employee need-validation" novalidate>
                <div class="modal-body">

                    <div class="">
                        <label for="employee-username" class="form-label">Tên đăng nhập*</label>
                        <input type="text" id="employee-username" class="form-control" required>
                        <div class="invalid-feedback username">
                            Yêu cầu nhập tên đăng nhập (Không được trùng với người dùng khác).
                        </div>
                    </div>

                    <div class="pw-box">
                        <label for="employee-password" class="form-label">Mật khẩu (Lưu lại trước khi thêm)</label>
                        <input type="text" id="employee-password" class="form-control" disabled>
                        <a class="btn btn-filter generate-pw" style="width: 130px;font-weight: normal;">Tạo mật khẩu</a>
                    </div>

                    <div class="">
                        <label for="employee-name" class="form-label">Tên nhân viên*</label>
                        <input type="text" id="employee-name" class="form-control" required>
                        <div class="invalid-feedback emp_name">
                            Yêu cầu nhập tên nhân viên.
                        </div>
                    </div>

                    <div class="">
                        <label for="employee-phone" class="form-label">Điện thoại*</label>
                        <input type="tel" id="employee-phone" class="form-control" required pattern="^0[0-9]{9}$">
                        <div class="invalid-feedback phone">
                            Yêu cầu nhập điện thoại có 10 số và bắt đầu = 0.
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col">
                            <label for="employee-date-of-birth" class="form-label">Ngày sinh</label>
                            <input type="date" id="employee-date-of-birth" class="form-control">
                        </div>

                        <div class="col">
                            <label for="employee-gender" class="form-label">Giới tính</label>
                            <select id="employee-gender" class="form-select">
                                <option value="" disabled selected hidden>Chọn giới tính</option>
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                    
                    </div>

                    <label for="employee-address" class="form-label">Địa chỉ</label>
                            <textarea id="employee-address" class="form-control"></textarea>

                    <div class="">
                        <label for="employee-role" class="form-label">Vai trò*</label>
                        <select id="employee-role" class="form-select" required>
                            <option value="" disabled selected hidden>Chọn vai trò</option>
                            <option value="1">Quản lý</option>
                            <option value="2">Nhân viên</option>
                        </select>
                        <div class="invalid-feedback role">
                            Yêu cầu chọn vai trò.
                        </div>
                    </div>
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