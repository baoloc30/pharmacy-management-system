<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($success) || isset($data['success'])): ?>
                        <?php $successMsg = $success ?? $data['success']; ?>
                        <div class="toast-notification" id="toastSuccess">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo $successMsg; ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_URL; ?>auth/updateProfile" id="profileForm" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mã nhân viên</label>
                                <input type="text" class="form-control" value="<?php echo $user['maNhanVien'] ?? ''; ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control editable-input" name="hoTen" id="hoTen"
                                    value="<?php echo htmlspecialchars($user['hoTen'] ?? ''); ?>" readonly>
                                <span class="text-danger small d-block" id="hoTenError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control editable-input" name="ngaySinh" id="ngaySinh"
                                    value="<?php echo $user['ngaySinh'] ?? ''; ?>" readonly>
                                <span class="text-danger small d-block" id="ngaySinhError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-control editable-input" name="gioiTinh" disabled>
                                    <option value="Nam" <?php echo ($user['gioiTinh'] ?? '') == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                                    <option value="Nu" <?php echo ($user['gioiTinh'] ?? '') == 'Nu' ? 'selected' : ''; ?>>Nữ</option>
                                    <option value="Khac" <?php echo ($user['gioiTinh'] ?? '') == 'Khac' ? 'selected' : ''; ?>>Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control editable-input" name="soDienThoai" id="soDienThoai"
                                    value="<?php echo htmlspecialchars($user['soDienThoai'] ?? ''); ?>" readonly>
                                <span class="text-danger small d-block" id="sdtError"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control editable-input" name="email" id="email"
                                    value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                                <span class="text-danger small d-block" id="emailError"></span>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control editable-input" name="diaChi"
                                    value="<?php echo htmlspecialchars($user['diaChi'] ?? ''); ?>" readonly>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?php echo BASE_URL; ?>home/<?php echo Session::get('role') == 'QuanLy' ? 'admin' : 'employee'; ?>"
                               class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy bỏ
                            </a>
                            <button type="button" class="btn btn-warning" id="editBtn">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </button>
                            <button type="submit" class="btn btn-primary d-none" id="saveBtn">
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
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editBtn').addEventListener('click', function() {
        document.querySelectorAll('.editable-input').forEach(el => {
            el.removeAttribute('readonly');
            el.removeAttribute('disabled');
        });
        
        this.classList.add('d-none');
        document.getElementById('saveBtn').classList.remove('d-none');
        document.getElementById('hoTen').focus();
    });

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });

    const toastSuccess = document.getElementById('toastSuccess');
    if (toastSuccess) {
        setTimeout(() => {
            toastSuccess.classList.add('show');
        }, 100);

        setTimeout(() => {
            toastSuccess.classList.remove('show');
            setTimeout(() => toastSuccess.remove(), 400); 
        }, 3000);
    }

    document.getElementById('profileForm').addEventListener('submit', function(e) {
        let valid = true;
        const hoTen = document.getElementById('hoTen').value.trim();
        const sdt = document.getElementById('soDienThoai').value.trim();
        const email = document.getElementById('email').value.trim();
        const ngaySinh = document.getElementById('ngaySinh').value;

        ['hoTenError', 'sdtError', 'emailError', 'ngaySinhError'].forEach(id => document.getElementById(id).textContent = '');

        if (!hoTen) {
            document.getElementById('hoTenError').textContent = 'Vui lòng nhập họ tên';
            valid = false;
        }
        if (sdt && !/^[0-9]{10}$/.test(sdt)) {
            document.getElementById('sdtError').textContent = 'Số điện thoại không được chứa chữ cái hoặc không đủ 10 số';
            valid = false;
        }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').textContent = 'Email sai định dạng';
            valid = false;
        }

        if (ngaySinh) {
            const selectedDate = new Date(ngaySinh);
            const today = new Date();
            today.setHours(0, 0, 0, 0); 
            
            if (selectedDate > today) {
                document.getElementById('ngaySinhError').textContent = 'Ngày sinh không được lớn hơn ngày hiện tại';
                valid = false;
            }
        }
        
        if (!valid) {
            e.preventDefault();
            setTimeout(() => {
                ['hoTenError', 'sdtError', 'emailError', 'ngaySinhError'].forEach(id => document.getElementById(id).textContent = '');
            }, 3000);
            return false;
        }
        
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    });
});
</script>

<style>
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ffffff;
        border-left: 5px solid #48bb78;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        padding: 16px 24px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9999;
        transform: translateX(150%);
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .toast-notification.show {
        transform: translateX(0);
    }

    .toast-notification i {
        color: #48bb78;
        font-size: 24px;
    }

    .toast-notification span {
        color: #2d3748;
        font-weight: 500;
        font-size: 15px;
    }
</style>