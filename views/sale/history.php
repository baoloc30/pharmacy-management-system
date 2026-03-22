<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-receipt" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Danh Sách Hóa Đơn</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Quản lý lịch sử bán hàng</div>
    </div>
  </div>
</div>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">Bộ lọc tìm kiếm</span>
  </div>
  <div style="padding:16px 20px;">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
      <div style="flex:2;min-width:200px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Mã HD / Tên khách hàng</label>
        <input type="text" name="keyword" value="<?php echo htmlspecialchars($keyword ?? ''); ?>"
          placeholder="Nhập mã hóa đơn hoặc tên khách..."
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div style="flex:1;min-width:150px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Từ ngày</label>
        <input type="date" name="from_date" value="<?php echo $from_date ?? ''; ?>"
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div style="flex:1;min-width:150px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đến ngày</label>
        <input type="date" name="to_date" value="<?php echo $to_date ?? ''; ?>"
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div>
        <button type="submit" style="padding:8px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
          <i class="fas fa-search"></i> Tìm kiếm
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Table -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-list" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách hóa đơn</span>
    </div>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($invoices ?? []); ?> hóa đơn</span>
  </div>
  <div style="overflow-x:auto;">
    <?php if (empty($invoices)): ?>
      <div style="padding:40px;text-align:center;color:#94a3b8;">
        <i class="fas fa-receipt" style="font-size:40px;margin-bottom:12px;display:block;"></i>
        Không tìm thấy hóa đơn nào.
      </div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Mã HD</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Thời gian lập</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Nhân viên</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Khách hàng</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Tổng tiền</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Thanh toán</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($invoices as $i => $inv): ?>
        <?php
          $pt = $inv['phuongThucThanhToan'];
          $ptLabel = $pt=='TienMat'?'Tiền mặt':($pt=='ChuyenKhoan'?'Chuyển khoản':'Thẻ');
          $ptColor = $pt=='TienMat'?'#15803d':($pt=='ChuyenKhoan'?'#1d4ed8':'#b45309');
          $ptBg = $pt=='TienMat'?'#f0fdf4':($pt=='ChuyenKhoan'?'#eff6ff':'#fffbeb');
          $rowBg = $i%2==0?'#fff':'#f0f7ff';
        ?>
        <tr style="background:<?php echo $rowBg; ?>;transition:background .15s;"
          onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#1d4ed8;"><?php echo htmlspecialchars($inv['maHoaDonCode']); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;white-space:nowrap;"><?php echo date('d/m/Y H:i', strtotime($inv['ngayLap'])); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($inv['tenNhanVien']); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($inv['tenKhachHang'] ?? 'Khách lẻ'); ?></td>
          <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#15803d;text-align:right;white-space:nowrap;"><?php echo number_format($inv['tongTien'],0,',','.'); ?>đ</td>
          <td style="padding:10px 16px;">
            <span style="padding:3px 10px;border-radius:20px;font-weight:700;font-size:11px;background:<?php echo $ptBg; ?>;color:<?php echo $ptColor; ?>;"><?php echo $ptLabel; ?></span>
          </td>
          <td style="padding:10px 16px;text-align:center;white-space:nowrap;">
            <button onclick="viewDetail(<?php echo $inv['maHoaDon']; ?>)"
              style="padding:5px 12px;border-radius:7px;border:none;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:700;cursor:pointer;margin-right:4px;">
              <i class="fas fa-eye"></i> Xem
            </button>
            <a href="<?php echo BASE_URL; ?>sale/print/<?php echo $inv['maHoaDon']; ?>" target="_blank"
              style="padding:5px 10px;border-radius:7px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#374151;font-size:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
              <i class="fas fa-print"></i>
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

<!-- Overlay chi tiết -->
<div id="detailOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:20px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:680px;max-height:90vh;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);display:flex;flex-direction:column;">
    <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-receipt" style="color:#fff;font-size:15px;"></i>
        <span style="font-size:14px;font-weight:700;color:#fff;">Chi tiết hóa đơn</span>
      </div>
      <button onclick="closeDetail()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;font-size:14px;">✕</button>
    </div>
    <div id="detailBody" style="padding:20px;overflow-y:auto;flex:1;"></div>
    <div style="padding:12px 20px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;flex-shrink:0;">
      <button onclick="closeDetail()" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Đóng</button>
    </div>
  </div>
</div>

<script>
function viewDetail(id) {
    document.getElementById('detailBody').innerHTML = '<div style="text-align:center;padding:30px;color:#94a3b8;"><i class="fas fa-spinner fa-spin" style="font-size:24px;"></i></div>';
    document.getElementById('detailOverlay').style.display = 'flex';
    $.get('<?php echo BASE_URL; ?>sale/detail/' + id, function(data) {
        let ptLabel = data.phuongThucThanhToan=='TienMat'?'Tiền mặt':(data.phuongThucThanhToan=='ChuyenKhoan'?'Chuyển khoản':'Thẻ');
        let html = `<div style="display:flex;gap:20px;flex-wrap:wrap;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid #e2e8f0;">
            <div><div style="font-size:11px;color:#64748b;margin-bottom:2px;">Mã hóa đơn</div><div style="font-size:15px;font-weight:700;color:#1d4ed8;">${data.maHoaDonCode}</div></div>
            <div><div style="font-size:11px;color:#64748b;margin-bottom:2px;">Ngày lập</div><div style="font-size:13px;font-weight:600;color:#374151;">${data.ngayLap}</div></div>
            <div><div style="font-size:11px;color:#64748b;margin-bottom:2px;">Khách hàng</div><div style="font-size:13px;font-weight:600;color:#374151;">${data.tenKhachHang||'Khách lẻ'}</div></div>
            <div><div style="font-size:11px;color:#64748b;margin-bottom:2px;">Thanh toán</div><div style="font-size:13px;font-weight:600;color:#374151;">${ptLabel}</div></div>
        </div>`;
        html += `<table style="width:100%;border-collapse:collapse;">
            <thead><tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                <th style="padding:9px 12px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;text-align:left;">Tên thuốc</th>
                <th style="padding:9px 12px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;">ĐVT</th>
                <th style="padding:9px 12px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;text-align:center;">SL</th>
                <th style="padding:9px 12px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;text-align:right;">Đơn giá</th>
                <th style="padding:9px 12px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;text-align:right;">Thành tiền</th>
            </tr></thead><tbody>`;
        data.items.forEach((item, i) => {
            html += `<tr style="background:${i%2==0?'#fff':'#f0f7ff'};">
                <td style="padding:9px 12px;font-size:13px;color:#374151;">${item.tenThuoc}</td>
                <td style="padding:9px 12px;font-size:13px;color:#374151;">${item.donViTinh}</td>
                <td style="padding:9px 12px;font-size:13px;color:#374151;text-align:center;">${item.soLuong}</td>
                <td style="padding:9px 12px;font-size:13px;color:#374151;text-align:right;">${fmt(item.donGia)}</td>
                <td style="padding:9px 12px;font-size:13px;font-weight:600;color:#374151;text-align:right;">${fmt(item.thanhTien)}</td>
            </tr>`;
        });
        html += `</tbody><tfoot><tr style="background:#f0f7ff;border-top:2px solid #dbeafe;">
            <td colspan="4" style="padding:10px 12px;font-size:13px;font-weight:700;color:#374151;text-align:right;">Tổng tiền:</td>
            <td style="padding:10px 12px;font-size:14px;font-weight:900;color:#15803d;text-align:right;">${fmt(data.tongTien)}</td>
        </tr></tfoot></table>`;
        document.getElementById('detailBody').innerHTML = html;
    }, 'json');
}
function closeDetail() { document.getElementById('detailOverlay').style.display = 'none'; }
function fmt(n) { return new Intl.NumberFormat('vi-VN').format(n) + 'đ'; }
document.getElementById('detailOverlay').addEventListener('click', function(e){ if(e.target===this) closeDetail(); });
</script>
