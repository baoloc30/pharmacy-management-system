<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-user-edit"></i> Cập nhật thông tin khách hàng</h5>
            <a href="<?php echo BASE_URL; ?>customer/index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="editCustomerForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hoTen" id="hoTen"
                            value="<?php echo htmlspecialchars($customer['hoTen']); ?>" required>
                        <span class="text-danger small" id="hoTenError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="soDienThoai" id="soDienThoai"
                            value="<?php echo htmlspecialchars($customer['soDienThoai']); ?>" required>
                        <span class="text-danger small" id="sdtError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="<?php echo htmlspecialchars($customer['email'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngaySinh"
                            value="<?php echo $customer['ngaySinh'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control" name="gioiTinh">
                            <option value="Nam" <?php echo ($customer['gioiTinh'] ?? '') == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nu" <?php echo ($customer['gioiTinh'] ?? '') == 'Nu' ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khac" <?php echo ($customer['gioiTinh'] ?? '') == 'Khac' ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi"
                            value="<?php echo htmlspecialchars($customer['diaChi'] ?? ''); ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="ghiChu" rows="2"><?php echo htmlspecialchars($customer['ghiChu'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>customer/index" class="btn btn-secondary">
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
document.getElementById('editCustomerForm').addEventListener('submit', function(e) {
    let valid = true;
    const hoTen = document.getElementById('hoTen').value.trim();
    const sdt = document.getElementById('soDienThoai').value.trim();
    document.getElementById('hoTenError').textContent = '';
    document.getElementById('sdtError').textContent = '';
    if (!hoTen) { document.getElementById('hoTenError').textContent = 'Vui lòng không bỏ trống thông tin này'; valid = false; }
    if (!sdt) { document.getElementById('sdtError').textContent = 'Vui lòng không bỏ trống thông tin này'; valid = false; }
    else if (!/^[0-9]{10}$/.test(sdt)) { document.getElementById('sdtError').textContent = 'Vui lòng nhập đúng định dạng số điện thoại'; valid = false; }
    if (!valid) e.preventDefault();
});
</script>
