<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-user-edit"></i> Chỉnh sửa tài khoản nhân viên</h5>
            <a href="<?php echo BASE_URL; ?>employee/index" class="btn btn-secondary btn-sm">
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

            <form method="POST" action="" id="editEmployeeForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hoTen" id="hoTen"
                            value="<?php echo htmlspecialchars($employee['hoTen']); ?>" required>
                        <span class="text-danger small" id="hoTenError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['tenDangNhap']); ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vai trò</label>
                        <select class="form-control" name="vaiTro">
                            <option value="NhanVien" <?php echo $employee['vaiTro'] == 'NhanVien' ? 'selected' : ''; ?>>Nhân viên</option>
                            <option value="QuanLy" <?php echo $employee['vaiTro'] == 'QuanLy' ? 'selected' : ''; ?>>Quản lý</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="soDienThoai" id="soDienThoai"
                            value="<?php echo htmlspecialchars($employee['soDienThoai'] ?? ''); ?>">
                        <span class="text-danger small" id="sdtError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="<?php echo htmlspecialchars($employee['email'] ?? ''); ?>">
                        <span class="text-danger small" id="emailError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngaySinh"
                            value="<?php echo $employee['ngaySinh'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control" name="gioiTinh">
                            <option value="Nam" <?php echo ($employee['gioiTinh'] ?? '') == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nu" <?php echo ($employee['gioiTinh'] ?? '') == 'Nu' ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khac" <?php echo ($employee['gioiTinh'] ?? '') == 'Khac' ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi"
                            value="<?php echo htmlspecialchars($employee['diaChi'] ?? ''); ?>">
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>employee/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy chỉnh sửa
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('editEmployeeForm').addEventListener('submit', function(e) {
    let valid = true;
    ['hoTenError','sdtError','emailError'].forEach(id => document.getElementById(id).textContent = '');
    if (!document.getElementById('hoTen').value.trim()) {
        document.getElementById('hoTenError').textContent = 'Vui lòng nhập họ tên';
        valid = false;
    }
    const sdt = document.getElementById('soDienThoai').value.trim();
    if (sdt && !/^[0-9]{10}$/.test(sdt)) {
        document.getElementById('sdtError').textContent = 'Số điện thoại không hợp lệ';
        valid = false;
    }
    const email = document.getElementById('email').value.trim();
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').textContent = 'Email sai định dạng';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>
