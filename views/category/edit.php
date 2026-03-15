<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-edit"></i> Chỉnh sửa danh mục thuốc</h5>
            <a href="<?php echo BASE_URL; ?>category/index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="editCategoryForm">
                <div class="mb-3">
                    <label class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tenDanhMuc" id="tenDanhMuc"
                        value="<?php echo htmlspecialchars($category['tenDanhMuc']); ?>" required>
                    <span class="text-danger small" id="tenError"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control" name="moTa" rows="3"><?php echo htmlspecialchars($category['moTa'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select class="form-control" name="trangThai">
                        <option value="SuDung" <?php echo $category['trangThai'] == 'SuDung' ? 'selected' : ''; ?>>Đang dùng</option>
                        <option value="NgungSuDung" <?php echo $category['trangThai'] == 'NgungSuDung' ? 'selected' : ''; ?>>Ngừng dùng</option>
                    </select>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>category/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="button" class="btn btn-primary" onclick="confirmUpdate()">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal xác nhận -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Xác nhận cập nhật</h5></div>
            <div class="modal-body">Bạn có chắc chắn muốn cập nhật thông tin danh mục này không?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Từ chối</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('editCategoryForm').submit()">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmUpdate() {
    const ten = document.getElementById('tenDanhMuc').value.trim();
    document.getElementById('tenError').textContent = '';
    if (!ten) {
        document.getElementById('tenError').textContent = 'Chưa chọn đầy đủ thông tin. Vui lòng chọn lại!';
        return;
    }
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}
</script>
