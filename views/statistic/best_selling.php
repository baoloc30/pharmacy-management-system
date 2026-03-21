<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-fire" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Thuốc Bán Chạy</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Thống kê theo tháng</div>
    </div>
  </div>
</div>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">Chọn tháng / năm</span>
  </div>
  <div style="padding:16px 20px;">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
      <div style="min-width:160px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tháng</label>
        <select name="month" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <?php for($i=1;$i<=12;$i++): ?>
          <option value="<?php echo $i; ?>" <?php echo $month==$i?'selected':''; ?>>Tháng <?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div style="min-width:120px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Năm</label>
        <select name="year" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <?php for($y=date('Y');$y>=date('Y')-3;$y--): ?>
          <option value="<?php echo $y; ?>" <?php echo $year==$y?'selected':''; ?>><?php echo $y; ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <button type="submit" style="padding:8px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
        <i class="fas fa-chart-bar"></i> Xem thống kê
      </button>
    </form>
  </div>
</div>

<!-- Table -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
    <span style="font-size:13px;font-weight:700;color:#fff;">Top thuốc bán chạy — Tháng <?php echo $month; ?>/<?php echo $year; ?></span>
  </div>
  <div style="overflow-x:auto;">
    <?php if(empty($medicines)): ?>
      <div style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;">
        <i class="fas fa-fire" style="font-size:40px;margin-bottom:12px;display:block;"></i>
        Không có dữ liệu thống kê cho tháng này.
      </div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Hạng</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Mã thuốc</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Tên thuốc</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">ĐVT</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Số lượng bán</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Doanh thu</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($medicines as $i => $m): ?>
        <?php $rowBg = $i%2===0?'#fff':'#f0f7ff'; ?>
        <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:10px 16px;text-align:center;">
            <?php if($i===0): ?>
              <span style="padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#fffbeb;color:#b45309;"><i class="fas fa-trophy"></i> 1</span>
            <?php elseif($i===1): ?>
              <span style="padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#f8fafc;color:#64748b;">2</span>
            <?php elseif($i===2): ?>
              <span style="padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#fef2f2;color:#dc2626;">3</span>
            <?php else: ?>
              <span style="font-size:13px;color:#64748b;"><?php echo $i+1; ?></span>
            <?php endif; ?>
          </td>
          <td style="padding:10px 16px;font-size:13px;color:#64748b;"><?php echo $m['maThuoc']; ?></td>
          <td style="padding:10px 16px;font-size:13px;font-weight:600;color:#374151;"><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($m['donViTinh']); ?></td>
          <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#1d4ed8;text-align:right;"><?php echo number_format($m['soLuongBan']); ?></td>
          <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#15803d;text-align:right;white-space:nowrap;"><?php echo number_format($m['doanhThu'],0,',','.'); ?>đ</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

</div>
