<style>
.med-label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;}
.med-input{width:100%;padding:10px 13px;border:1.5px solid #cbd5e1;border-radius:9px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box;font-family:inherit;transition:all .2s;}
.med-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.field-err{font-size:11px;color:#ef4444;font-weight:600;margin-top:4px;display:block;min-height:16px;}
</style>

<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:860px;margin:0 auto;">

    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-edit" style="color:#fff;font-size:17px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Chỉnh sửa thuốc</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;"><?php echo htmlspecialchars($medicine['tenThuoc']); ?></div>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>medicine/index"
           style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:9px;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;text-decoration:none;">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <?php if (isset($error)): ?>
    <div style="margin:14px 24px 0;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;font-weight:600;">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="" style="padding:22px 24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="med-label">Danh mục <span style="color:#ef4444;">*</span></label>
                <select name="maDanhMuc" class="med-input" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['maDanhMuc']; ?>" <?php echo $medicine['maDanhMuc'] == $cat['maDanhMuc'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['tenDanhMuc']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="med-label">Tên thuốc <span style="color:#ef4444;">*</span></label>
                <input type="text" name="tenThuoc" class="med-input" value="<?php echo htmlspecialchars($medicine['tenThuoc']); ?>" required>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="med-label">Đơn vị tính <span style="color:#ef4444;">*</span></label>
                <input type="text" name="donViTinh" class="med-input" value="<?php echo htmlspecialchars($medicine['donViTinh']); ?>" required>
            </div>
            <div>
                <label class="med-label">Giá bán <span style="color:#ef4444;">*</span></label>
                <input type="number" name="giaBan" id="giaBan" class="med-input" value="<?php echo $medicine['giaBan']; ?>" min="1" required>
                <span class="field-err" id="giaBanError"></span>
            </div>
            <div>
                <label class="med-label">Xuất xứ</label>
                <input type="text" name="xuatXu" class="med-input" value="<?php echo htmlspecialchars($medicine['xuatXu'] ?? ''); ?>">
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label class="med-label">Thành phần</label>
            <textarea name="thanhPhan" class="med-input" rows="2" style="resize:vertical;"><?php echo htmlspecialchars($medicine['thanhPhan'] ?? ''); ?></textarea>
        </div>
        <div style="margin-bottom:14px;">
            <label class="med-label">Công dụng</label>
            <textarea name="congDung" class="med-input" rows="2" style="resize:vertical;"><?php echo htmlspecialchars($medicine['congDung'] ?? ''); ?></textarea>
        </div>
        <div style="margin-bottom:20px;">
            <label class="med-label">Cách dùng</label>
            <textarea name="cachDung" class="med-input" rows="2" style="resize:vertical;"><?php echo htmlspecialchars($medicine['cachDung'] ?? ''); ?></textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
            <a href="<?php echo BASE_URL; ?>medicine/index"
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
document.querySelector('form').addEventListener('submit', function(e) {
    const giaBan = parseFloat(document.getElementById('giaBan').value);
    document.getElementById('giaBanError').textContent = '';
    if (!giaBan || giaBan <= 0) {
        document.getElementById('giaBanError').textContent = 'Giá bán thuốc phải là số dương';
        e.preventDefault();
    }
});
</script>
