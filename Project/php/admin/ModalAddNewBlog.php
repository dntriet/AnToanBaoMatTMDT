<!-- Modified 10/23/2023 by Quyen -->
<div class="modal fade modal-md add-new-container" id="add-new" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="#add-blog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add-blog">Thêm mới Blog</h1>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <form action="" id="modal-form" class="add-new-blog needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="">
                            <label for="blog-name" class="form-label">Tên blog</label>
                            <input type="text" id="blog-name" class="form-control" required>
                            <div class="invalid-feedback">
                                Yêu cầu nhập tên blog (Không trùng với tên blog khác).
                            </div>
                        </div>
                    
                        <div class="">
                            <label for="blog-content" class="form-label">Nội dung</label>
                            <textarea id="blog-content" class="form-control" required></textarea>
                            <div class="invalid-feedback">
                                Yêu cầu nhập nội dung.
                            </div>
                        </div>
                        
                        <div class="">
                            <label for="author" class="form-label">Tác giả</label>
                            <input type="text" id="author" class="form-control" required>
                            <div class="invalid-feedback">
                                Yêu cầu nhập tác giả.
                            </div>
                        </div>
                        
                        <div class="">
                            <label for="blog-img" class="form-label">Hình ảnh</label>
                            <input type="file" id="blog-img" class="form-control" required>
                            <div class="image-box" style="width: 200px;"></div>
                            <div class="invalid-feedback">
                                Yêu cầu chọn 1 hình ảnh (.png, .jepg, .jpg).
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