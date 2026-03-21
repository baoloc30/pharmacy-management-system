<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:700px;margin:0 auto;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-edit" style="color:#fff;font-size:17px;"></i></div>
      <div>
        <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Chỉnh Sửa Nhà Cung Cấp</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;"><?php echo htmlspecialchars($supplier['tenNhaCC']); ?></div>
      </div>
    </div>
    <a href="<?php echo BASE_URL; ?>supplier/index" style="padding:7px 14px;border-radius:8px;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:6px;"><i class="fas fa-arrow-left"></i> Quay lại</a>
  </div>
  <?php if(isset($success)): ?><div style="margin:14px 22px 0;padding:11px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;color:#15803d;font-size:13px;"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div><?php endif; ?>
  <?php if(isset($error)): ?><div style="margin:14px 22px 0;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div><?php endif; ?>
  <div style="padding:22px;">
    <form method="POST" action="">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
        <div style="grid-column:1/-1;">
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Tên nhà cung cấp <span style="color:#dc2626;">*</span></label>
          <input type="text" name="tenNhaCC" value="<?php echo htmlspecialchars($supplier['tenNhaCC']); ?>" required style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Số điện thoại</label>
          <input type="text" name="soDienThoai" value="<?php echo htmlspecialchars($supplier['soDienThoai']??''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($supplier['email']??''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Mã số thuế</label>
          <input type="text" name="maSoThue" value="<?php echo htmlspecialchars($supplier['maSoThue']??''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Người liên hệ</label>
          <input type="text" name="nguoiLienHe" value="<?php echo htmlspecialchars($supplier['nguoiLienHe']??''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div style="grid-column:1/-1;">
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Địa chỉ</label>
          <input type="text" name="diaChi" value="<?php echo htmlspecialchars($supplier['diaChi']??''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
        <a href="<?php echo BASE_URL; ?>supplier/index" style="padding:9px 20px;border-radius:8px;border:1.5px solid #e2e8f0;background:#f1f5f9;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;">Hủy</a>
        <button type="submit" style="padding:9px 24px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;"><i class="fas fa-save"></i> Cập nhật</button>
      </div>
    </form>
  </div>
</div>
</div>
