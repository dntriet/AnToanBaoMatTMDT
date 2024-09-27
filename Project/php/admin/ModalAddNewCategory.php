<!-- start of Modal of Add new elements-->
<!-- Modified 10/23/2023 by Quyen -->
<div class="modal fade modal-md add-new-container" id="add-new" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="#add-category" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" id="modal-form" class="add-new-category needs-validation" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add-category">Thêm mới danh mục</h1>
                    <!-- <button type="button" class="btn-close" aria-label="Close"></button> -->
                </div>

                <div class="modal-body">
                    <label for="category-name" class="form-label">Tên danh mục</label>
                    <input type="text" id="category-name" class="form-control" required>
                    <div class="invalid-feedback">
                        Yêu cầu nhập tên danh mục.
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