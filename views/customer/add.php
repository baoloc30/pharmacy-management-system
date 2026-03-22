<style>
.cust-label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;}
.cust-input{width:100%;padding:10px 13px;border:1.5px solid #cbd5e1;border-radius:9px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box;font-family:inherit;transition:all .2s;}
.cust-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.cust-input.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);}
.cust-input.ok{border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.08);}
.field-err{font-size:11px;color:#ef4444;font-weight:600;margin-top:4px;display:block;min-height:16px;}
</style>

<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:720px;margin:0 auto;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-user-plus" style="color:#fff;font-size:17px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Thêm khách hàng mới</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Điền đầy đủ thông tin bên dưới</div>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>customer/index"
           style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:9px;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;text-decoration:none;">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <?php if (isset($error)): ?>
    <div style="margin:14px 24px 0;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;font-weight:600;">
        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="" id="addCustForm" style="padding:22px 24px;">

        <div style="display:flex;align-items:center;gap:8px;padding:7px 12px;border-radius:8px;background:#eff6ff;border-left:3px solid #2563eb;margin-bottom:16px;">
            <i class="fas fa-star" style="color:#2563eb;font-size:11px;"></i>
            <span style="font-size:12px;font-weight:700;color:#1d4ed8;text-transform:uppercase;letter-spacing:.3px;">Thông tin bắt buộc</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
            <div>
                <label class="cust-label">Họ tên <span style="color:#ef4444;">*</span></label>
                <input type="text" name="hoTen" id="hoTen" class="cust-input"
                    placeholder="Nhập họ và tên đầy đủ"
                    value="<?php echo htmlspecialchars($_POST['hoTen'] ?? ''); ?>"
                    oninput="validateHoTen()">
                <span class="field-err" id="hoTenError"></span>
            </div>
            <div>
                <label class="cust-label">Số điện thoại <span style="color:#ef4444;">*</span></label>
                <input type="text" name="soDienThoai" id="soDienThoai" class="cust-input"
                    placeholder="VD: 0901234567" maxlength="10"
                    value="<?php echo htmlspecialchars($_POST['soDienThoai'] ?? ''); ?>"
                    oninput="validateSdt()">
                <span class="field-err" id="sdtError"></span>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;padding:7px 12px;border-radius:8px;background:#f0fdf4;border-left:3px solid #16a34a;margin-bottom:16px;">
            <i class="fas fa-info-circle" style="color:#16a34a;font-size:11px;"></i>
            <span style="font-size:12px;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.3px;">Thông tin thêm (không bắt buộc)</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="cust-label">Email</label>
                <input type="email" name="email" class="cust-input"
                    placeholder="example@email.com"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            <div>
                <label class="cust-label">Ngày sinh</label>
                <input type="date" name="ngaySinh" class="cust-input"
                    value="<?php echo $_POST['ngaySinh'] ?? ''; ?>">
            </div>
            <div>
                <label class="cust-label">Giới tính</label>
                <select name="gioiTinh" class="cust-input" style="cursor:pointer;">
                    <option value="Nam" <?php echo ($_POST['gioiTinh'] ?? '') == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nu"  <?php echo ($_POST['gioiTinh'] ?? '') == 'Nu'  ? 'selected' : ''; ?>>Nữ</option>
                    <option value="Khac" <?php echo ($_POST['gioiTinh'] ?? '') == 'Khac' ? 'selected' : ''; ?>>Khác</option>
                </select>
            </div>
            <div>
                <label class="cust-label">Địa chỉ</label>
                <input type="text" name="diaChi" class="cust-input"
                    placeholder="Số nhà, đường, phường/xã..."
                    value="<?php echo htmlspecialchars($_POST['diaChi'] ?? ''); ?>">
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label class="cust-label">Ghi chú</label>
            <textarea name="ghiChu" class="cust-input" rows="2"
                placeholder="Ghi chú thêm về khách hàng..."
                style="resize:vertical;"><?php echo htmlspecialchars($_POST['ghiChu'] ?? ''); ?></textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
            <a href="<?php echo BASE_URL; ?>customer/index"
               style="padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
                <i class="fas fa-times"></i> Hủy bỏ
            </a>
            <button type="submit" id="submitBtn"
               style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(21,128,61,.3);">
                <i class="fas fa-save"></i> Lưu khách hàng
            </button>
        </div>
    </form>
</div>
</div>

<script>
function validateHoTen() {
    const val = document.getElementById('hoTen').value.trim();
    const inp = document.getElementById('hoTen');
    const err = document.getElementById('hoTenError');
    if (!val) { inp.className = 'cust-input error'; err.textContent = 'Vui lòng không bỏ trống thông tin này'; return false; }
    inp.className = 'cust-input ok'; err.textContent = ''; return true;
}
function validateSdt() {
    const val = document.getElementById('soDienThoai').value.trim();
    const inp = document.getElementById('soDienThoai');
    const err = document.getElementById('sdtError');
    if (!val) { inp.className = 'cust-input error'; err.textContent = 'Vui lòng không bỏ trống thông tin này'; return false; }
    if (!/^[0-9]{10}$/.test(val)) { inp.className = 'cust-input error'; err.textContent = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)'; return false; }
    inp.className = 'cust-input ok'; err.textContent = ''; return true;
}
document.getElementById('addCustForm').addEventListener('submit', function(e) {
    const v1 = validateHoTen(), v2 = validateSdt();
    if (!v1 || !v2) e.preventDefault();
});
<?php if (isset($error) && strpos($error, 'điện thoại') !== false): ?>
document.getElementById('soDienThoai').className = 'cust-input error';
document.getElementById('sdtError').textContent = '<?php echo addslashes($error); ?>';
<?php endif; ?>
</script>