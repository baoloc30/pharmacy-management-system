<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-history" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Lịch Sử Nhập Xuất Kho</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Theo dõi giao dịch kho hàng</div>
    </div>
  </div>
</div>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">Bộ lọc</span>
  </div>
  <div style="padding:16px 20px;">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
      <div style="flex:1;min-width:140px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Từ ngày</label>
        <input type="date" name="from_date" value="<?php echo $from_date ?? ''; ?>"
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div style="flex:1;min-width:140px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đến ngày</label>
        <input type="date" name="to_date" value="<?php echo $to_date ?? ''; ?>"
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div style="flex:1;min-width:160px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Loại giao dịch</label>
        <select name="type" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <option value="">-- Tất cả --</option>
          <option value="Nhap" <?php echo ($type??'')==='Nhap'?'selected':''; ?>>Nhập kho</option>
          <option value="Xuat" <?php echo ($type??'')==='Xuat'?'selected':''; ?>>Xuất kho</option>
          <option value="DieuChinh" <?php echo ($type??'')==='DieuChinh'?'selected':''; ?>>Điều chỉnh</option>
        </select>
      </div>
      <div style="display:flex;gap:8px;">
        <button type="submit" style="padding:8px 18px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
          <i class="fas fa-filter"></i> Lọc
        </button>
        <a href="<?php echo BASE_URL; ?>warehouse/history" style="padding:8px 14px;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">Xóa lọc</a>
      </div>
    </form>
  </div>
</div>

<!-- Table -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
    <span style="font-size:13px;font-weight:700;color:#fff;"><?php echo count($history ?? []); ?> giao dịch</span>
  </div>
  <div style="overflow-x:auto;">
    <?php if(empty($history)): ?>
      <div style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;">Không có giao dịch phù hợp</div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ngày</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Loại GD</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Tên thuốc</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Nhân viên</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">SL</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Tồn trước</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Tồn sau</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Chứng từ</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ghi chú</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($history as $i => $h): ?>
        <?php $rowBg = $i%2===0?'#fff':'#f0f7ff'; ?>
        <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:9px 14px;font-size:12px;color:#374151;white-space:nowrap;"><?php echo date('d/m/Y H:i', strtotime($h['ngayGiaoDich'])); ?></td>
          <td style="padding:9px 14px;">
            <?php if($h['loaiGiaoDich']==='Nhap'): ?>
              <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#f0fdf4;color:#15803d;">Nhập</span>
            <?php elseif($h['loaiGiaoDich']==='Xuat'): ?>
              <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#fef2f2;color:#dc2626;">Xuất</span>
            <?php else: ?>
              <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#fffbeb;color:#b45309;">Điều chỉnh</span>
            <?php endif; ?>
          </td>
          <td style="padding:9px 14px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($h['tenThuoc']); ?></td>
          <td style="padding:9px 14px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($h['tenNhanVien']); ?></td>
          <td style="padding:9px 14px;font-size:13px;font-weight:700;color:#1d4ed8;text-align:right;"><?php echo $h['soLuong']; ?></td>
          <td style="padding:9px 14px;font-size:13px;color:#374151;text-align:right;"><?php echo $h['tonKhoTruoc']; ?></td>
          <td style="padding:9px 14px;font-size:13px;font-weight:600;color:#15803d;text-align:right;"><?php echo $h['tonKhoSau']; ?></td>
          <td style="padding:9px 14px;font-size:12px;color:#64748b;"><?php echo htmlspecialchars($h['loaiChungTu']); ?></td>
          <td style="padding:9px 14px;font-size:12px;color:#64748b;"><?php echo htmlspecialchars($h['ghiChu'] ?? ''); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

</div>
