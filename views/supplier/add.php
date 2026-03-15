<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-plus"></i> Thêm nhà cung cấp</h5>
            <a href="<?php echo BASE_URL; ?>supplier/index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên nhà cung cấp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tenNhaCC" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="soDienThoai">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã số thuế</label>
                        <input type="text" class="form-control" name="maSoThue">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" class="form-control" name="nguoiLienHe">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi">
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>supplier/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
