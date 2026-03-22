<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

  <!-- Header -->
  <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-pills" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Cập nhật đơn vị lẻ</div>
      <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Thiết lập bán lẻ theo viên/vỉ cho từng thuốc</div>
    </div>
  </div>

  <div style="padding:16px 24px 24px;">
    <?php if(isset($success)): ?>
    <div style="margin-bottom:14px;padding:11px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;color:#15803d;font-size:13px;font-weight:600;">
      <i class="fas fa-check-circle"></i> <?php echo $success; ?>
    </div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
    <div style="margin-bottom:14px;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;font-weight:600;">
      <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <!-- Hướng dẫn -->
    <div style="padding:12px 16px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:9px;font-size:13px;color:#1d4ed8;margin-bottom:16px;display:flex;align-items:flex-start;gap:10px;">
      <i class="fas fa-info-circle" style="margin-top:1px;flex-shrink:0;"></i>
      <span>Nhập <strong>Đơn vị lẻ</strong> (VD: Viên, Vỉ, Gói), <strong>Số lượng quy đổi</strong> (VD: 1 hộp = 14 viên) và <strong>Giá bán lẻ</strong>. Để trống nếu không bán lẻ.</span>
    </div>

    <form method="POST" action="" id="unitForm">
      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
          <thead>
            <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
              <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Tên thuốc</th>
              <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">ĐVT gốc</th>
              <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:right;">Giá gốc</th>
              <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Đơn vị lẻ</th>
              <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:center;">Số lượng quy đổi</th>
              <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Giá bán lẻ</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($medicines as $i => $m): ?>
            <tr style="background:<?php echo $i%2===0?'#fff':'#f0f7ff'; ?>;transition:background .15s;"
                onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i%2===0?'#fff':'#f0f7ff'; ?>'">
              <td style="padding:9px 14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
              <td style="padding:9px 14px;color:#475569;"><?php echo htmlspecialchars($m['donViTinh']); ?></td>
              <td style="padding:9px 14px;text-align:right;font-weight:600;color:#1e293b;"><?php echo formatCurrency($m['giaBan']); ?></td>
              <td style="padding:9px 14px;">
                <input type="text" name="donViLe[<?php echo $m['maThuoc']; ?>]"
                  value="<?php echo htmlspecialchars($m['donViLe'] ?? ''); ?>"
                  placeholder="VD: Viên, Vỉ, Gói"
                  style="width:110px;padding:7px 10px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13px;outline:none;"
                  onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
                  onblur="this.style.borderColor='#cbd5e1';this.style.boxShadow='none'">
              </td>
              <td style="padding:9px 14px;text-align:center;">
                <input type="number" name="soLuongQuyDoi[<?php echo $m['maThuoc']; ?>]"
                  value="<?php echo $m['soLuongQuyDoi'] ?? 1; ?>"
                  min="1" placeholder="VD: 14"
                  style="width:80px;padding:7px 10px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13px;outline:none;text-align:center;"
                  onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
                  onblur="this.style.borderColor='#cbd5e1';this.style.boxShadow='none'">
              </td>
              <td style="padding:9px 14px;">
                <input type="number" name="giaBanLe[<?php echo $m['maThuoc']; ?>]"
                  value="<?php echo $m['giaBanLe'] ?? ''; ?>"
                  min="0" placeholder="Giá lẻ"
                  style="width:120px;padding:7px 10px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13px;outline:none;"
                  onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
                  onblur="this.style.borderColor='#cbd5e1';this.style.boxShadow='none'">
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div style="display:flex;justify-content:flex-end;margin-top:16px;">
        <button type="submit"
          style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(21,128,61,.3);">
          <i class="fas fa-save"></i> Lưu cập nhật
        </button>
      </div>
    </form>
  </div>
</div>
</div>
