<style>
.cust-label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;}
.cust-input{width:100%;padding:10px 13px;border:1.5px solid #cbd5e1;border-radius:9px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box;font-family:inherit;transition:all .2s;}
.cust-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.cust-input.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);}
.field-err{font-size:11px;color:#ef4444;font-weight:600;margin-top:4px;display:block;min-height:16px;}
</style>

<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:720px;margin:0 auto;">

    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user-edit" style="color:#fff;font-size:17px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Cập nhật khách hàng</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;"><?php echo htmlspecialchars($customer['hoTen']); ?></div>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>customer/index"
           style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:9px;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;text-decoration:none;">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <?php if (isset($success)): ?>
    <div style="margin:14px 24px 0;padding:11px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;color:#15803d;font-size:13px;font-weight:600;">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
    </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
    <div style="margin:14px 24px 0;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;font-weight:600;">
        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="" id="editCustomerForm" style="padding:22px 24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="cust-label">Họ tên <span style="color:#ef4444;">*</span></label>
                <input type="text" name="hoTen" id="hoTen" class="cust-input"
                    value="<?php echo htmlspecialchars($customer['hoTen']); ?>" required>
                <span class="field-err" id="hoTenError"></span>
            </div>
            <div>
                <label class="cust-label">Số điện thoại <span style="color:#ef4444;">*</span></label>
                <input type="text" name="soDienThoai" id="soDienThoai" class="cust-input"
                    value="<?php echo htmlspecialchars($customer['soDienThoai']); ?>" maxlength="10" required>
                <span class="field-err" id="sdtError"></span>
            </div>
            <div>
                <label class="cust-label">Email</label>
                <input type="email" name="email" class="cust-input"
                    value="<?php echo htmlspecialchars($customer['email'] ?? ''); ?>">
            </div>
            <div>
                <label class="cust-label">Ngày sinh</label>
                <input type="date" name="ngaySinh" class="cust-input"
                    value="<?php echo $customer['ngaySinh'] ?? ''; ?>">
            </div>
            <div>
                <label class="cust-label">Giới tính</label>
                <select name="gioiTinh" class="cust-input" style="cursor:pointer;">
                    <option value="Nam" <?php echo ($customer['gioiTinh'] ?? '') == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nu" <?php echo ($customer['gioiTinh'] ?? '') == 'Nu' ? 'selected' : ''; ?>>Nữ</option>
                    <option value="Khac" <?php echo ($customer['gioiTinh'] ?? '') == 'Khac' ? 'selected' : ''; ?>>Khác</option>
                </select>
            </div>
            <div>
                <label class="cust-label">Địa chỉ</label>
                <input type="text" name="diaChi" class="cust-input"
                    value="<?php echo htmlspecialchars($customer['diaChi'] ?? ''); ?>">
            </div>
        </div>
        <div style="margin-bottom:20px;">
            <label class="cust-label">Ghi chú</label>
            <textarea name="ghiChu" class="cust-input" rows="2" style="resize:vertical;"><?php echo htmlspecialchars($customer['ghiChu'] ?? ''); ?></textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
            <a href="<?php echo BASE_URL; ?>customer/index"
               style="padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
                <i class="fas fa-times"></i> Hủy bỏ
            </a>
            <button type="submit"
               style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(21,128,61,.3);">
                <i class="fas fa-save"></i> Cập nhật
            </button>
        </div>
    </form>
</div>
</div>

<script>
document.getElementById('editCustomerForm').addEventListener('submit', function(e) {
    let valid = true;
    const hoTen = document.getElementById('hoTen').value.trim();
    const sdt = document.getElementById('soDienThoai').value.trim();
    document.getElementById('hoTenError').textContent = '';
    document.getElementById('sdtError').textContent = '';
    if (!hoTen) {
        document.getElementById('hoTenError').textContent = 'Vui lòng không bỏ trống thông tin này';
        document.getElementById('hoTen').className = 'cust-input error';
        valid = false;
    }
    if (!sdt) {
        document.getElementById('sdtError').textContent = 'Vui lòng không bỏ trống thông tin này';
        document.getElementById('soDienThoai').className = 'cust-input error';
        valid = false;
    } else if (!/^[0-9]{10}$/.test(sdt)) {
        document.getElementById('sdtError').textContent = 'Vui lòng nhập đúng định dạng số điện thoại';
        document.getElementById('soDienThoai').className = 'cust-input error';
        valid = false;
    }
    if (!valid) e.preventDefault();
});
</script>
