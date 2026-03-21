<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-bell" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Cảnh Báo Kho Thuốc</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Theo dõi tồn kho và hạn sử dụng</div>
    </div>
  </div>
</div>

<!-- Sắp hết hàng -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#92400e,#b45309);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-exclamation-triangle" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Thuốc sắp hết hàng (tồn kho ≤ 10)</span>
    </div>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($low_stock ?? []); ?> mặt hàng</span>
  </div>
  <div style="overflow-x:auto;">
    <?php if(empty($low_stock)): ?>
      <div style="padding:30px;text-align:center;color:#15803d;font-size:13px;"><i class="fas fa-check-circle" style="margin-right:6px;"></i>Không có thuốc nào sắp hết hàng</div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#92400e,#b45309);">
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Mã</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Tên thuốc</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Danh mục</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">ĐVT</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tồn kho</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">HSD</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($low_stock as $i => $item): ?>
        <?php $rowBg = $i%2===0?'#fff':'#fffbeb'; ?>
        <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:9px 16px;font-size:13px;color:#64748b;"><?php echo $item['maThuoc']; ?></td>
          <td style="padding:9px 16px;font-size:13px;font-weight:600;color:#374151;"><?php echo htmlspecialchars($item['tenThuoc']); ?></td>
          <td style="padding:9px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($item['tenDanhMuc']); ?></td>
          <td style="padding:9px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($item['donViTinh']); ?></td>
          <td style="padding:9px 16px;text-align:center;">
            <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#fef2f2;color:#dc2626;"><?php echo $item['soLuongTon']; ?></span>
          </td>
          <td style="padding:9px 16px;font-size:13px;color:#374151;"><?php echo date('d/m/Y', strtotime($item['hanSuDung'])); ?></td>
          <td style="padding:9px 16px;text-align:center;">
            <a href="<?php echo BASE_URL; ?>medicine/detail/<?php echo $item['maThuoc']; ?>"
              style="padding:5px 12px;border-radius:7px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:700;text-decoration:none;">
              <i class="fas fa-eye"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

<!-- Sắp hết hạn -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#991b1b,#dc2626);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-clock" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Thuốc sắp hết hạn (30 ngày tới)</span>
    </div>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($expired ?? []); ?> mặt hàng</span>
  </div>
  <div style="overflow-x:auto;">
    <?php if(empty($expired)): ?>
      <div style="padding:30px;text-align:center;color:#15803d;font-size:13px;"><i class="fas fa-check-circle" style="margin-right:6px;"></i>Không có thuốc nào sắp hết hạn</div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#991b1b,#dc2626);">
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Mã</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Tên thuốc</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Danh mục</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">ĐVT</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tồn kho</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">HSD</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($expired as $i => $item): ?>
        <?php $rowBg = $i%2===0?'#fff':'#fef2f2'; ?>
        <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:9px 16px;font-size:13px;color:#64748b;"><?php echo $item['maThuoc']; ?></td>
          <td style="padding:9px 16px;font-size:13px;font-weight:600;color:#374151;"><?php echo htmlspecialchars($item['tenThuoc']); ?></td>
          <td style="padding:9px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($item['tenDanhMuc']); ?></td>
          <td style="padding:9px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($item['donViTinh']); ?></td>
          <td style="padding:9px 16px;font-size:13px;color:#374151;text-align:center;"><?php echo $item['soLuongTon']; ?></td>
          <td style="padding:9px 16px;">
            <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:#fef2f2;color:#dc2626;"><?php echo date('d/m/Y', strtotime($item['hanSuDung'])); ?></span>
          </td>
          <td style="padding:9px 16px;text-align:center;">
            <a href="<?php echo BASE_URL; ?>medicine/detail/<?php echo $item['maThuoc']; ?>"
              style="padding:5px 12px;border-radius:7px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:700;text-decoration:none;">
              <i class="fas fa-eye"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

</div>
