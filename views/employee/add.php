<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-user-plus"></i> Tạo tài khoản nhân viên</h5>
            <a href="<?php echo BASE_URL; ?>employee/index" class="btn btn-secondary btn-sm">
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

            <form method="POST" action="" id="addEmployeeForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hoTen" id="hoTen" required>
                        <span class="text-danger small" id="hoTenError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tenDangNhap" id="tenDangNhap" required>
                        <span class="text-danger small" id="usernameError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="matKhau" id="matKhau" required>
                        <span class="text-danger small" id="passError"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vai trò</label>
                        <select class="form-control" name="vaiTro">
                            <option value="NhanVien">Nhân viên</option>
                            <option value="QuanLy">Quản lý</option>
                        </select>
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
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngaySinh">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control" name="gioiTinh">
                            <option value="Nam">Nam</option>
                            <option value="Nu">Nữ</option>
                            <option value="Khac">Khác</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi">
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>employee/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Tạo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
    let valid = true;
    ['hoTenError','usernameError','passError'].forEach(id => document.getElementById(id).textContent = '');

    if (!document.getElementById('hoTen').value.trim()) {
        document.getElementById('hoTenError').textContent = 'Vui lòng nhập đầy đủ thông tin';
        valid = false;
    }
    if (!document.getElementById('tenDangNhap').value.trim()) {
        document.getElementById('usernameError').textContent = 'Vui lòng nhập đầy đủ thông tin';
        valid = false;
    }
    if (!document.getElementById('matKhau').value) {
        document.getElementById('passError').textContent = 'Vui lòng nhập đầy đủ thông tin';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>
