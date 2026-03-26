<div class="content-wrapper">

<!-- Header card -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-history" style="color:#fff;font-size:18px;"></i>
      </div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Lịch Sử Mua Hàng</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">
          <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($customer['hoTen']); ?>
          &nbsp;·&nbsp;
          <i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($customer['soDienThoai'] ?? '--'); ?>
        </div>
      </div>
    </div>
    <a href="<?php echo BASE_URL; ?>customer/index"
       style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:9px;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;text-decoration:none;">
      <i class="fas fa-arrow-left"></i> Quay lại
    </a>
  </div>
</div>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">Bộ lọc</span>
  </div>
  <div style="padding:16px 20px;">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
      <div>
        <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Từ ngày</label>
        <input type="date" name="from_date" value="<?php echo $from_date; ?>"
          style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;"
          onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
      </div>
      <div>
        <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Đến ngày</label>
        <input type="date" name="to_date" value="<?php echo $to_date; ?>"
          style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;"
          onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
      </div>
      <div style="display:flex;gap:8px;">
        <button type="submit"
          style="padding:8px 18px;border-radius:8px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
          <i class="fas fa-filter"></i> Lọc
        </button>
        <a href="<?php echo BASE_URL; ?>customer/history/<?php echo $customer['maKhachHang']; ?>"
          style="padding:8px 16px;border-radius:8px;border:1.5px solid #e2e8f0;background:#f1f5f9;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
          <i class="fas fa-times"></i> Xóa lọc
        </a>
      </div>
    </form>
  </div>
</div>

<!-- Table -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-receipt" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách hóa đơn</span>
    </div>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($invoices); ?> hóa đơn</span>
  </div>

  <?php if(empty($invoices)): ?>
  <div style="padding:40px;text-align:center;color:#94a3b8;">
    <i class="fas fa-receipt" style="font-size:40px;margin-bottom:12px;display:block;"></i>
    <div style="font-size:14px;font-weight:600;">Khách hàng này chưa có lịch sử mua hàng</div>
  </div>
  <?php else: ?>
  <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;font-size:13px;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Mã hóa đơn</th>
          <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Ngày mua</th>
          <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Nhân viên</th>
          <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:right;">Tổng tiền</th>
          <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:left;">Thanh toán</th>
          <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;font-size:11px;letter-spacing:.4px;text-align:center;">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($invoices as $i => $inv): ?>
        <tr style="background:<?php echo $i%2===0?'#fff':'#f0f7ff'; ?>;transition:background .15s;"
            onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i%2===0?'#fff':'#f0f7ff'; ?>'">
          <td style="padding:10px 14px;font-weight:700;color:#1d4ed8;"><?php echo htmlspecialchars($inv['maHoaDonCode']); ?></td>
          <td style="padding:10px 14px;color:#475569;"><?php echo date('d/m/Y H:i', strtotime($inv['ngayLap'])); ?></td>
          <td style="padding:10px 14px;color:#374151;"><?php echo htmlspecialchars($inv['tenNhanVien']); ?></td>
          <td style="padding:10px 14px;text-align:right;font-weight:700;color:#15803d;"><?php echo formatCurrency($inv['tongTien']); ?></td>
          <td style="padding:10px 14px;">
            <?php 
              $pt = $inv['phuongThucThanhToan'];
              $ptLabel = $pt === 'TienMat' ? 'Tiền Mặt' : ($pt === 'ChuyenKhoan' ? 'Chuyển Khoản' : ($pt === 'The' ? 'Thẻ' : $pt));
            ?>
            <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">
              <?php echo $ptLabel; ?>
            </span>
          </td>
          <td style="padding:10px 14px;text-align:center;">
            <button onclick="viewDetail(<?php echo $inv['maHoaDon']; ?>)"
              style="padding:6px 14px;border-radius:7px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:700;cursor:pointer;">
              <i class="fas fa-eye"></i> Chi tiết
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

</div>

<!-- Detail overlay -->
<div id="detailOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:14px;box-shadow:0 8px 40px rgba(0,0,0,.25);width:100%;max-width:680px;max-height:85vh;overflow:hidden;display:flex;flex-direction:column;">
    <div style="padding:16px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-receipt" style="color:#fff;"></i>
        <span style="font-size:15px;font-weight:700;color:#fff;" id="detailTitle">Chi tiết hóa đơn</span>
      </div>
      <button onclick="closeDetail()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:7px;cursor:pointer;font-size:16px;">×</button>
    </div>
    <div id="detailBody" style="padding:20px;overflow-y:auto;flex:1;">
      <div style="text-align:center;padding:30px;color:#94a3b8;"><i class="fas fa-spinner fa-spin" style="font-size:24px;"></i></div>
    </div>
  </div>
</div>

<script>
function viewDetail(id) {
  document.getElementById('detailBody').innerHTML = '<div style="text-align:center;padding:30px;color:#94a3b8;"><i class="fas fa-spinner fa-spin" style="font-size:24px;"></i></div>';
  document.getElementById('detailOverlay').style.display = 'flex';
  
  $.get('<?php echo BASE_URL; ?>sale/detail/' + id, function(res) {
    if (!res.success) { 
        document.getElementById('detailBody').innerHTML = '<div style="text-align:center;padding:30px;color:#dc2626;font-size:14px;font-weight:600;"><i class="fas fa-exclamation-triangle" style="font-size:24px;margin-bottom:10px;display:block;"></i>' + res.message + '</div>'; 
        return; 
    }
    
    var data = res.data;
    document.getElementById('detailTitle').textContent = 'Chi tiết hóa đơn';
    var html = '<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;font-size:13px;">';
    html += '<thead><tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">';
    html += '<th style="padding:10px 12px;color:#fff;font-weight:700;text-transform:uppercase;font-size:11px;text-align:left;white-space:nowrap;">Tên thuốc</th>';
    html += '<th style="padding:10px 12px;color:#fff;font-weight:700;text-transform:uppercase;font-size:11px;text-align:left;white-space:nowrap;">ĐVT</th>';
    html += '<th style="padding:10px 12px;color:#fff;font-weight:700;text-transform:uppercase;font-size:11px;text-align:right;white-space:nowrap;">SL</th>';
    html += '<th style="padding:10px 12px;color:#fff;font-weight:700;text-transform:uppercase;font-size:11px;text-align:right;white-space:nowrap;">Đơn giá</th>';
    html += '<th style="padding:10px 12px;color:#fff;font-weight:700;text-transform:uppercase;font-size:11px;text-align:right;white-space:nowrap;">Thành tiền</th>';
    html += '</tr></thead><tbody>';
    
    data.items.forEach(function(item, i) {
      var bg = i % 2 === 0 ? '#fff' : '#f0f7ff';
      html += '<tr style="background:' + bg + ';">';
      html += '<td style="padding:9px 12px;font-weight:600;color:#1e293b;">' + item.tenThuoc + '</td>';
      html += '<td style="padding:9px 12px;color:#475569;">' + item.donViTinh + '</td>';
      html += '<td style="padding:9px 12px;text-align:right;color:#374151;">' + item.soLuong + '</td>';
      html += '<td style="padding:9px 12px;text-align:right;color:#374151;">' + fmt(item.donGia) + '</td>';
      html += '<td style="padding:9px 12px;text-align:right;font-weight:700;color:#15803d;">' + fmt(item.thanhTien) + '</td>';
      html += '</tr>';
    });
    
    html += '</tbody>';
    html += '<tfoot><tr style="background:#f0f7ff;border-top:2px solid #bfdbfe;">';
    html += '<td colspan="4" style="padding:10px 12px;text-align:right;font-weight:700;color:#1e293b;">Tổng tiền:</td>';
    html += '<td style="padding:10px 12px;text-align:right;font-weight:800;color:#dc2626;font-size:15px;">' + fmt(data.tongTien) + '</td>';
    html += '</tr></tfoot></table></div>';
    document.getElementById('detailBody').innerHTML = html;
    
  }, 'json').fail(function() {
    document.getElementById('detailBody').innerHTML = '<div style="text-align:center;padding:30px;color:#dc2626;font-size:14px;font-weight:600;"><i class="fas fa-exclamation-triangle" style="font-size:24px;margin-bottom:10px;display:block;"></i>Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau</div>';
  });
}

function closeDetail() { document.getElementById('detailOverlay').style.display = 'none'; }
document.getElementById('detailOverlay').addEventListener('click', function(e) { if (e.target === this) closeDetail(); });
function fmt(n) { return new Intl.NumberFormat('vi-VN').format(n) + 'đ'; }
</script>
