<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_URL; ?>auth/updateProfile" id="profileForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mã nhân viên</label>
                                <input type="text" class="form-control" value="<?php echo $user['maNhanVien'] ?? ''; ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" value="<?php echo $user['tenDangNhap'] ?? ''; ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="hoTen" id="hoTen"
                                    value="<?php echo htmlspecialchars($user['hoTen'] ?? ''); ?>" required>
                                <span class="text-danger small" id="hoTenError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" name="ngaySinh"
                                    value="<?php echo $user['ngaySinh'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="soDienThoai" id="soDienThoai"
                                    value="<?php echo htmlspecialchars($user['soDienThoai'] ?? ''); ?>">
                                <span class="text-danger small" id="sdtError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                <span class="text-danger small" id="emailError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-control" name="gioiTinh">
                                    <option value="Nam" <?php echo ($user['gioiTinh'] ?? '') == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                                    <option value="Nu" <?php echo ($user['gioiTinh'] ?? '') == 'Nu' ? 'selected' : ''; ?>>Nữ</option>
                                    <option value="Khac" <?php echo ($user['gioiTinh'] ?? '') == 'Khac' ? 'selected' : ''; ?>>Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vai trò</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $user['vaiTro'] == 'QuanLy' ? 'Quản lý' : 'Nhân viên'; ?>" readonly>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="diaChi"
                                    value="<?php echo htmlspecialchars($user['diaChi'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?php echo BASE_URL; ?>home/<?php echo Session::get('role') == 'QuanLy' ? 'admin' : 'employee'; ?>"
                               class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    let valid = true;
    const hoTen = document.getElementById('hoTen').value.trim();
    const sdt = document.getElementById('soDienThoai').value.trim();
    const email = document.getElementById('email').value.trim();

    document.getElementById('hoTenError').textContent = '';
    document.getElementById('sdtError').textContent = '';
    document.getElementById('emailError').textContent = '';

    if (!hoTen) {
        document.getElementById('hoTenError').textContent = 'Vui lòng nhập họ tên';
        valid = false;
    }
    if (sdt && !/^[0-9]{10}$/.test(sdt)) {
        document.getElementById('sdtError').textContent = 'Số điện thoại chứa chữ cái hoặc không đủ 10 số';
        valid = false;
    }
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').textContent = 'Email sai định dạng';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>
