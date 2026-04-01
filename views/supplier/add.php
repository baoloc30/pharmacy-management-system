<style>
.med-label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;}
.med-input{width:100%;padding:10px 13px;border:1.5px solid #cbd5e1;border-radius:9px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box;font-family:inherit;transition:all .2s;}
.med-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.med-input.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);background:#fef2f2;}
.field-err{font-size:11px;color:#dc2626;font-weight:600;margin-top:4px;display:block;min-height:16px;}
</style>

<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:800px;margin:0 auto;">
  <div style="padding:16px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-plus" style="color:#fff;font-size:17px;"></i></div>
      <div>
        <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Thêm Nhà Cung Cấp</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Điền thông tin nhà cung cấp mới</div>
      </div>
    </div>
    <a href="<?php echo BASE_URL; ?>supplier/index" style="padding:7px 14px;border-radius:8px;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:6px;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.2)'"><i class="fas fa-arrow-left"></i> Quay lại</a>
  </div>
  
  <?php if(isset($error) && empty($field_errors)): ?>
  <div id="topErrorBanner" style="margin:20px 24px 0;padding:12px 16px;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;color:#b91c1c;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-exclamation-triangle" style="font-size:15px;"></i> <?php echo $error; ?>
  </div>
  <?php endif; ?>

  <div style="padding:24px;">
    <form method="POST" action="" novalidate>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        
        <div style="grid-column:1/-1;">
          <label class="med-label">Tên nhà cung cấp <span style="color:#ef4444;">*</span></label>
          <input type="text" name="tenNhaCC" class="med-input <?php echo isset($field_errors['tenNhaCC']) || isset($field_errors['general']) ? 'error' : ''; ?>" 
                 placeholder="VD: Công ty Dược phẩm TW1" value="<?php echo htmlspecialchars($supplier['tenNhaCC'] ?? ''); ?>" oninput="clearInlineError(this)">
          <span class="field-err"><?php echo $field_errors['tenNhaCC'] ?? ($field_errors['general'] ?? ''); ?></span>
        </div>
        <div>
          <label class="med-label">Số điện thoại <span style="color:#ef4444;">*</span></label>
          <input type="text" name="soDienThoai" class="med-input <?php echo isset($field_errors['soDienThoai']) || isset($field_errors['general']) ? 'error' : ''; ?>" 
                 placeholder="VD: 0912345678" value="<?php echo htmlspecialchars($supplier['soDienThoai'] ?? ''); ?>" oninput="clearInlineError(this)">
          <span class="field-err"><?php echo $field_errors['soDienThoai'] ?? ($field_errors['general'] ?? ''); ?></span>
        </div>
        <div>
          <label class="med-label">Email</label>
          <input type="email" name="email" class="med-input <?php echo isset($field_errors['email']) ? 'error' : ''; ?>" 
                 placeholder="VD: contact@duoctw1.vn" value="<?php echo htmlspecialchars($supplier['email'] ?? ''); ?>" oninput="clearInlineError(this)">
          <span class="field-err"><?php echo $field_errors['email'] ?? ''; ?></span>
        </div>
        <div>
          <label class="med-label">Mã số thuế</label>
          <input type="text" name="maSoThue" class="med-input" placeholder="Nhập MST..." value="<?php echo htmlspecialchars($supplier['maSoThue'] ?? ''); ?>">
        </div>
        <div>
          <label class="med-label">Người liên hệ</label>
          <input type="text" name="nguoiLienHe" class="med-input" placeholder="Tên người đại diện..." value="<?php echo htmlspecialchars($supplier['nguoiLienHe'] ?? ''); ?>">
        </div>

        <div style="grid-column:1/-1;">
          <label class="med-label">Địa chỉ</label>
          <input type="text" name="diaChi" class="med-input" placeholder="Địa chỉ trụ sở / kho hàng..." value="<?php echo htmlspecialchars($supplier['diaChi'] ?? ''); ?>">
        </div>
        <div style="grid-column:1/-1;">
          <label class="med-label">Ghi chú</label>
          <textarea name="ghiChu" class="med-input" rows="3" placeholder="Thông tin thêm về nhà cung cấp này..."><?php echo htmlspecialchars($supplier['ghiChu'] ?? ''); ?></textarea>
        </div>

        <div>
          <label class="med-label">Trạng thái <span style="color:#ef4444;">*</span></label>
          <select name="trangThai" class="med-input" style="cursor:pointer;">
              <option value="HoatDong" <?php echo (isset($supplier['trangThai']) && $supplier['trangThai'] == 'HoatDong') ? 'selected' : ''; ?>>Hoạt động (Được phép nhập kho)</option>
              <option value="NgungGiaoDich" <?php echo (isset($supplier['trangThai']) && $supplier['trangThai'] == 'NgungGiaoDich') ? 'selected' : ''; ?>>Ngừng giao dịch</option>
          </select>
        </div>
      </div>

      <div style="display:flex;gap:12px;justify-content:flex-end;padding-top:20px;margin-top:10px;border-top:1px solid #e2e8f0;">
        <a href="<?php echo BASE_URL; ?>supplier/index" style="padding:10px 24px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f1f5f9;color:#64748b;font-size:13px;font-weight:700;text-decoration:none;">Hủy bỏ</a>
        <button type="submit" style="padding:10px 28px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(21,128,61,.25);"><i class="fas fa-save" style="margin-right:5px;"></i> Lưu thông tin</button>
      </div>
    </form>
  </div>
</div>
</div>

<script>
function clearInlineError(input) {
    input.classList.remove('error');
    let errSpan = input.nextElementSibling;
    if(errSpan && errSpan.classList.contains('field-err')) {
        errSpan.textContent = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    let hasErrors = document.querySelector('.med-input.error') || document.getElementById('topErrorBanner');
    
    if (hasErrors) {
        setTimeout(function() {
            let topBanner = document.getElementById('topErrorBanner');
            if (topBanner) {
                topBanner.style.transition = 'opacity 0.5s ease';
                topBanner.style.opacity = '0';
                setTimeout(() => topBanner.style.display = 'none', 500);
            }

            let errSpans = document.querySelectorAll('.field-err');
            errSpans.forEach(span => {
                if (span.textContent.trim() !== '') {
                    span.style.transition = 'opacity 0.5s ease';
                    span.style.opacity = '0';
                    setTimeout(() => { 
                        span.textContent = ''; 
                        span.style.opacity = '1'; 
                    }, 500); 
                }
            });

            let errorInputs = document.querySelectorAll('.med-input.error');
            errorInputs.forEach(input => {
                input.classList.remove('error');
            });
            
        }, 3000); 
    }
});
</script>