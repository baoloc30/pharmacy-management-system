<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-edit"></i> Chỉnh sửa thuốc</h5>
            <a href="<?php echo BASE_URL; ?>medicine/index" class="btn btn-secondary btn-sm">
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
                        <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-control" name="maDanhMuc" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['maDanhMuc']; ?>"
                                    <?php echo $medicine['maDanhMuc'] == $cat['maDanhMuc'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['tenDanhMuc']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên thuốc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tenThuoc"
                            value="<?php echo htmlspecialchars($medicine['tenThuoc']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="donViTinh"
                            value="<?php echo htmlspecialchars($medicine['donViTinh']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="giaBan" id="giaBan"
                            value="<?php echo $medicine['giaBan']; ?>" min="1" required>
                        <span class="text-danger small" id="giaBanError"></span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Xuất xứ</label>
                        <input type="text" class="form-control" name="xuatXu"
                            value="<?php echo htmlspecialchars($medicine['xuatXu'] ?? ''); ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Thành phần</label>
                        <textarea class="form-control" name="thanhPhan" rows="2"><?php echo htmlspecialchars($medicine['thanhPhan'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Công dụng</label>
                        <textarea class="form-control" name="congDung" rows="2"><?php echo htmlspecialchars($medicine['congDung'] ?? ''); ?></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Cách dùng</label>
                        <textarea class="form-control" name="cachDung" rows="2"><?php echo htmlspecialchars($medicine['cachDung'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>medicine/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const giaBan = parseFloat(document.getElementById('giaBan').value);
    document.getElementById('giaBanError').textContent = '';
    if (!giaBan || giaBan <= 0) {
        document.getElementById('giaBanError').textContent = 'Giá bán thuốc phải là số dương';
        e.preventDefault();
    }
});
</script>
