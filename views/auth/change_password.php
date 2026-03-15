<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-key"></i> Đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_URL; ?>auth/changePassword" class="change-password-form">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                            <span class="text-danger small" id="oldPasswordError"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <span class="text-danger small" id="newPasswordError"></span>
                            <small class="text-muted">Ít nhất 6 ký tự</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <span class="text-danger small" id="confirmPasswordError"></span>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?php echo BASE_URL; ?>home/<?php echo Session::get('role') == 'QuanLy' ? 'admin' : 'employee'; ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('.change-password-form').addEventListener('submit', function(e) {
    ['oldPasswordError','newPasswordError','confirmPasswordError'].forEach(id => document.getElementById(id).textContent = '');
    const old = document.getElementById('old_password').value.trim();
    const nw = document.getElementById('new_password').value.trim();
    const cf = document.getElementById('confirm_password').value.trim();
    let hasError = false;

    if (!old) { document.getElementById('oldPasswordError').textContent = 'Vui lòng nhập mật khẩu hiện tại'; hasError = true; }
    if (!nw) { document.getElementById('newPasswordError').textContent = 'Vui lòng nhập mật khẩu mới'; hasError = true; }
    else if (nw.length < 6) { document.getElementById('newPasswordError').textContent = 'Mật khẩu mới phải có ít nhất 6 ký tự'; hasError = true; }
    if (!cf) { document.getElementById('confirmPasswordError').textContent = 'Vui lòng nhập lại mật khẩu mới'; hasError = true; }
    else if (nw !== cf) { document.getElementById('confirmPasswordError').textContent = 'Mật khẩu xác nhận không trùng khớp'; hasError = true; }

    if (hasError) { e.preventDefault(); return; }
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
});
</script>
