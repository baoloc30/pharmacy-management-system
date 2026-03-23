<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hóa đơn <?php echo htmlspecialchars($invoice['maHoaDonCode'] ?? ''); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Inter',Arial,sans-serif;background:#f1f5f9;display:flex;flex-direction:column;align-items:center;padding:24px 16px;min-height:100vh;}
.invoice{background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.1);width:100%;max-width:680px;overflow:hidden;}
.inv-header{background:linear-gradient(135deg,#1e40af,#2563eb);padding:24px 28px;text-align:center;}
.inv-header .brand{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:8px;}
.inv-header .brand i{font-size:26px;color:#fff;}
.inv-header .brand span{font-size:22px;font-weight:800;color:#fff;letter-spacing:1px;}
.inv-header .subtitle{font-size:13px;color:rgba(255,255,255,.8);font-weight:500;}
.inv-meta{padding:16px 28px;background:#f0f7ff;border-bottom:1px solid #dbeafe;display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;}
.inv-meta .meta-item{min-width:0; overflow:hidden;}
.inv-meta .meta-label{font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px;}
.inv-meta .meta-value{font-size:13px;font-weight:600;color:#1e293b;}
.inv-body{padding:20px 28px;}
table{width:100%;border-collapse:collapse;font-size:13px;}
thead tr{background:linear-gradient(135deg,#172554,#1d4ed8);}
thead th{padding:10px 12px;color:#fff;font-weight:700;text-transform:uppercase;font-size:11px;letter-spacing:.4px;white-space:nowrap;}
tbody tr:nth-child(even){background:#f0f7ff;}
tbody tr:nth-child(odd){background:#fff;}
tbody td{padding:9px 12px;color:#374151;border-bottom:1px solid #e2e8f0;}
tfoot tr{background:#f0f7ff;}
tfoot td{padding:10px 12px;font-weight:700;border-top:2px solid #bfdbfe;}
.text-right{text-align:right;}
.text-center{text-align:center;}
.inv-footer{padding:16px 28px;text-align:center;border-top:1px solid #e2e8f0;color:#64748b;font-size:13px;}
.inv-footer strong{color:#1d4ed8;}
.actions{display:flex;gap:10px;justify-content:center;margin-top:20px;}
.btn-print{padding:11px 28px;border:none;border-radius:10px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:14px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px;}
.btn-close{padding:11px 24px;border:1.5px solid #e2e8f0;border-radius:10px;background:#f1f5f9;color:#64748b;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px;}
@media print{
  body{background:#fff;padding:0;}
  .invoice{box-shadow:none;border-radius:0;max-width:100%;}
  .actions{display:none;}
  .inv-header{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  thead tr{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="invoice">
  <div class="inv-header">
    <div class="brand">
      <i class="fas fa-clinic-medical"></i>
      <span>PHARMACARE</span>
    </div>
    <div style="font-size:16px;font-weight:700;color:#fff;margin-bottom:4px;">HÓA ĐƠN BÁN THUỐC</div>
    <div class="subtitle">Cảm ơn quý khách đã tin tưởng sử dụng dịch vụ của chúng tôi</div>
  </div>

  <div class="inv-meta">
    <div class="meta-item">
      <div class="meta-label">Mã hóa đơn</div>
      <div class="meta-value" style="color:#1d4ed8;font-weight:800;"><?php echo htmlspecialchars($invoice['maHoaDonCode'] ?? ''); ?></div>
    </div>
    <div class="meta-item">
      <div class="meta-label">Ngày lập</div>
      <div class="meta-value"><?php echo date('d/m/Y H:i', strtotime($invoice['ngayLap'])); ?></div>
    </div>
    <div class="meta-item">
      <div class="meta-label">Nhân viên</div>
      <div class="meta-value"><?php echo htmlspecialchars($invoice['tenNhanVien'] ?? ''); ?></div>
    </div>
    <div class="meta-item" style="grid-column: span 2;">
      <div class="meta-label">Khách hàng</div>
      <div class="meta-value">
        <?php 
          if (!empty($invoice['hoTen'])) {
              echo htmlspecialchars($invoice['hoTen']);
              if (!empty($invoice['soDienThoai'])) {
                  echo ' - ' . htmlspecialchars($invoice['soDienThoai']);
              }
          } else {
              echo 'Khách lẻ';
          }
        ?>
      </div>
    </div>
    <?php 
    if(!empty($invoice['phuongThucThanhToan'])): 
        $pt = $invoice['phuongThucThanhToan'];
        $ptLabel = $pt === 'TienMat' ? 'Tiền mặt' : ($pt === 'ChuyenKhoan' ? 'Chuyển khoản' : ($pt === 'The' ? 'Thẻ' : $pt));
    ?>
    <div class="meta-item">
      <div class="meta-label">Thanh toán</div>
      <div class="meta-value"><?php echo $ptLabel; ?></div>
    </div>
    <?php endif; ?>
  </div>

  <div class="inv-body">
    <table>
      <thead>
        <tr>
          <th class="text-center" style="width:40px;">STT</th>
          <th>Tên thuốc</th>
          <th>ĐVT</th>
          <th class="text-right">SL</th>
          <th class="text-right">Đơn giá</th>
          <th class="text-right">Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($invoice['items'] as $i => $item): ?>
        <tr>
          <td class="text-center" style="color:#94a3b8;"><?php echo $i+1; ?></td>
          <td style="font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($item['tenThuoc']); ?></td>
          <td><?php echo htmlspecialchars($item['donViTinh']); ?></td>
          <td class="text-right"><?php echo $item['soLuong']; ?></td>
          <td class="text-right"><?php echo number_format($item['donGia'],0,',','.'); ?>đ</td>
          <td class="text-right" style="font-weight:600;"><?php echo number_format($item['thanhTien'],0,',','.'); ?>đ</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-right" style="color:#1e293b;">Tổng tiền:</td>
          <td class="text-right" style="color:#15803d;font-size:15px;"><?php echo number_format($invoice['tongTien'],0,',','.'); ?>đ</td>
        </tr>
        <?php if(!empty($invoice['tienGiam']) && $invoice['tienGiam'] > 0): ?>
        <tr>
          <td colspan="5" class="text-right" style="color:#1e293b;">Giảm giá:</td>
          <td class="text-right" style="color:#dc2626;">-<?php echo number_format($invoice['tienGiam'],0,',','.'); ?>đ</td>
        </tr>
        <tr style="background:#eff6ff;">
          <td colspan="5" class="text-right" style="color:#1e293b;font-size:14px;">Thanh toán:</td>
          <td class="text-right" style="color:#1d4ed8;font-size:16px;font-weight:800;"><?php echo number_format($invoice['tongTien']-$invoice['tienGiam'],0,',','.'); ?>đ</td>
        </tr>
        <?php endif; ?>
      </tfoot>
    </table>
  </div>

  <div class="inv-footer">
    <i class="fas fa-heart" style="color:#dc2626;"></i>
    Cảm ơn quý khách! Hẹn gặp lại
    <br><strong>PHARMACARE</strong>
  </div>
</div>

<div class="actions">
  <button class="btn-print" onclick="window.print()">
    <i class="fas fa-print"></i> In hóa đơn
  </button>
  <button class="btn-close" onclick="window.close()">
    <i class="fas fa-times"></i> Đóng
  </button>
</div>

</body>
</html>
