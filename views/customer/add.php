<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-user-plus"></i> Thêm khách hàng mới</h5>
            <a href="<?php echo BASE_URL; ?>customer/index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($data['error']) || isset($error)): ?>
                <div class="alert alert-danger server-alert"><i class="fas fa-exclamation-triangle"></i> <?php echo $data['error'] ?? $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="addCustomerForm" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hoTen" id="hoTen"
                            value="<?php echo htmlspecialchars($_POST['hoTen'] ?? ''); ?>">
                        <span class="text-danger small d-block" id="hoTenError"><?php echo $data['hoTen_error'] ?? ''; ?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="soDienThoai" id="soDienThoai"
                            value="<?php echo htmlspecialchars($_POST['soDienThoai'] ?? ''); ?>">
                        <span class="text-danger small d-block" id="sdtError"><?php echo $data['sdt_error'] ?? ''; ?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" name="ngaySinh" id="ngaySinh"
                            value="<?php echo $customer['ngaySinh'] ?? $_POST['ngaySinh'] ?? ''; ?>">
                        <span class="text-danger small d-block" id="ngaySinhError"><?php echo $data['ngaySinh_error'] ?? ''; ?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giới tính</label>
                        <select class="form-control" name="gioiTinh">
                            <option value="Nam">Nam</option>
                            <option value="Nu">Nữ</option>
                            <option value="Khac">Khác</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="diaChi"
                            value="<?php echo htmlspecialchars($_POST['diaChi'] ?? ''); ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="ghiChu" rows="2"><?php echo htmlspecialchars($_POST['ghiChu'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?php echo BASE_URL; ?>customer/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serverAlert = document.querySelector('.server-alert');
    if (serverAlert) {
        setTimeout(() => {
            serverAlert.style.transition = 'opacity 0.5s ease';
            serverAlert.style.opacity = '0';
            setTimeout(() => serverAlert.style.display = 'none', 500);
        }, 3000);
    }

    ['hoTenError', 'sdtError', 'ngaySinhError'].forEach(id => {
        const el = document.getElementById(id);
        if (el && el.textContent.trim() !== '') {
            setTimeout(() => el.textContent = '', 3000);
        }
    });

    document.getElementById('addCustomerForm').addEventListener('submit', function(e) {
        let valid = true;
        const hoTen = document.getElementById('hoTen').value.trim();
        const sdt = document.getElementById('soDienThoai').value.trim();
        const ngaySinh = document.getElementById('ngaySinh').value;

        document.getElementById('hoTenError').textContent = '';
        document.getElementById('sdtError').textContent = '';
        document.getElementById('ngaySinhError').textContent = '';

        if (!hoTen) {
            document.getElementById('hoTenError').textContent = 'Vui lòng không bỏ trống thông tin này';
            valid = false;
        }
        if (!sdt) {
            document.getElementById('sdtError').textContent = 'Vui lòng không bỏ trống thông tin này';
            valid = false;
        } else if (!/^[0-9]{10}$/.test(sdt)) {
            document.getElementById('sdtError').textContent = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)';
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
                ['hoTenError', 'sdtError', 'ngaySinhError'].forEach(id => {
                    document.getElementById(id).textContent = '';
                });
            }, 3000);
        } else {
            const saveBtn = document.getElementById('saveBtn');
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        }
    });
});
</script>