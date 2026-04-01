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
  <?php if(isset($error)): ?>
  <div id="historyErrorBanner" style="margin-bottom:16px;padding:12px 16px;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;color:#b91c1c;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;transition:opacity 0.5s ease;">
      <i class="fas fa-exclamation-triangle" style="font-size:15px;"></i> <?php echo $error; ?>
  </div>
  <script>
      setTimeout(() => {
          let err = document.getElementById('historyErrorBanner');
          if(err) { err.style.opacity = '0'; setTimeout(() => err.style.display = 'none', 500); }
      }, 3000);
  </script>
  <?php endif; ?>
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
      <div style="flex:1;min-width:180px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tên thuốc, nhân viên</label>
        <input type="text" name="search" placeholder="Nhập để tìm..." value="<?php echo htmlspecialchars($search ?? ''); ?>"
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
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Ngày</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Loại GD</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tên thuốc</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Nhân viên</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">SL</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tồn trước</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tồn sau</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Ghi chú</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Chứng từ</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($history as $i => $h): ?>
        <?php $rowBg = $i%2===0?'#fff':'#f0f7ff'; ?>
        <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:9px 14px;font-size:12px;color:#374151;white-space:nowrap;text-align:center;"><?php echo date('d/m/Y H:i', strtotime($h['ngayGiaoDich'])); ?></td>
          <td style="padding:9px 14px;text-align:center;">
            <?php if($h['loaiGiaoDich']==='Nhap'): ?>
              <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#f0fdf4;color:#15803d;">Nhập</span>
            <?php elseif($h['loaiGiaoDich']==='Xuat'): ?>
              <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#fef2f2;color:#dc2626;">Xuất</span>
            <?php else: ?>
              <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#fffbeb;color:#b45309;">Điều chỉnh</span>
            <?php endif; ?>
          </td>
          <td style="padding:9px 14px;font-size:13px;color:#374151;text-align:center;"><?php echo htmlspecialchars($h['tenThuoc']); ?></td>
          <td style="padding:9px 14px;font-size:13px;color:#374151;text-align:center;"><?php echo htmlspecialchars($h['tenNhanVien']); ?></td>
          <td style="padding:9px 14px;font-size:13px;font-weight:700;color:#1d4ed8;text-align:center;"><?php echo $h['soLuong']; ?></td>
          <td style="padding:9px 14px;font-size:13px;color:#374151;text-align:center;"><?php echo $h['tonKhoTruoc']; ?></td>
          <td style="padding:9px 14px;font-size:13px;font-weight:600;color:#15803d;text-align:center;"><?php echo $h['tonKhoSau']; ?></td>
          <td style="padding:9px 14px;font-size:12px;color:#64748b;text-align:center;"><?php echo htmlspecialchars($h['ghiChu'] ?? ''); ?></td>
          <td style="padding:9px 14px;font-size:12px;text-align:center;">
            <?php if(in_array($h['loaiChungTu'], ['PhieuNhap', 'HoaDon']) && !empty($h['maChungTu'])): ?>
               <button onclick="viewDetail(<?php echo $h['maChungTu']; ?>, '<?php echo $h['loaiChungTu']; ?>')" 
                       style="padding:5px 12px; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; transition:0.2s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                   <i class="fas fa-eye"></i> Xem phiếu
               </button>
            <?php else: ?>
               <span style="color:#94a3b8; font-style:italic;">Chỉnh sửa tay</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>
<div id="detailOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;width:100%;max-width:600px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);transform:translateY(-20px);animation:slideDown 0.3s forwards;">
        <div style="padding:16px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
            <div style="color:#fff;font-size:16px;font-weight:800;text-transform:uppercase;" id="detailTitle">Chi tiết chứng từ</div>
            <i class="fas fa-times" onclick="document.getElementById('detailOverlay').style.display='none'" style="color:#fff;font-size:18px;cursor:pointer;"></i>
        </div>
        <div id="detailContent" style="padding:24px; max-height:60vh; overflow-y:auto;">
            </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;text-align:right;">
            <button onclick="document.getElementById('detailOverlay').style.display='none'" style="padding:8px 20px;border-radius:8px;background:#fff;border:1.5px solid #cbd5e1;color:#475569;font-weight:700;cursor:pointer;">Đóng</button>
        </div>
    </div>
</div>

<script>
function viewDetail(id, type) {
    document.getElementById('detailOverlay').style.display = 'flex';
    document.getElementById('detailContent').innerHTML = '<div style="text-align:center; padding:30px; color:#64748b;"><i class="fas fa-spinner fa-spin" style="font-size:24px; margin-bottom:10px;"></i><br>Đang tải dữ liệu...</div>';
    
    fetch('<?php echo BASE_URL; ?>warehouse/ajaxGetDetail?id=' + id + '&type=' + type)
    .then(res => res.json())
    .then(res => {
        if(res.success) {
            let data = res.data;
            let title = type === 'PhieuNhap' ? 'Chi Tiết Phiếu Nhập Kho' : 'Chi Tiết Hóa Đơn Bán Hàng';
            
            let html = `
                <div style="margin-bottom:20px; display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:13.5px; background:#f8fafc; padding:16px; border-radius:10px; border:1px dashed #cbd5e1;">
                    <div><span style="color:#64748b;">Mã chứng từ:</span> <b style="color:#1e293b;">${data.maSo || 'N/A'}</b></div>
                    <div><span style="color:#64748b;">Nhân viên:</span> <b style="color:#1e293b;">${data.tenNhanVien}</b></div>
                    <div><span style="color:#64748b;">NCC / KH:</span> <b style="color:#1e293b;">${data.doiTac || 'Khách hàng lẻ'}</b></div>
                    <div><span style="color:#64748b;">Tổng tiền:</span> <b style="color:#dc2626; font-size:15px;">${new Intl.NumberFormat('vi-VN').format(data.tongTien)} đ</b></div>
                </div>
                <table style="width:100%; border-collapse:collapse; font-size:13px;">
                    <thead>
                        <tr style="background:#f1f5f9; border-bottom:2px solid #cbd5e1;">
                            <th style="padding:10px; text-align:left; color:#334155;">Tên thuốc</th>
                            <th style="padding:10px; text-align:center; color:#334155;">SL</th>
                            <th style="padding:10px; text-align:center; color:#334155;">DVT</th>
                            <th style="padding:10px; text-align:right; color:#334155;">Đơn giá</th>
                            <th style="padding:10px; text-align:right; color:#334155;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            data.chi_tiet.forEach(item => {
                html += `
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:10px; color:#1e293b; font-weight:600;">${item.tenThuoc}</td>
                        <td style="padding:10px; text-align:center; font-weight:700; color:#2563eb;">${item.soLuong}</td>
                        <td style="padding:10px; text-align:center; color:#64748b;">${item.dvt || '---'}</td>
                        <td style="padding:10px; text-align:right; color:#64748b;">${new Intl.NumberFormat('vi-VN').format(item.gia)}</td>
                        <td style="padding:10px; text-align:right; font-weight:700; color:#15803d;">${new Intl.NumberFormat('vi-VN').format(item.thanhTien)} đ</td>
                    </tr>
                `;
            });
            
            html += `</tbody></table>`;
            document.getElementById('detailContent').innerHTML = html;
            document.getElementById('detailTitle').textContent = title;
        } else {
            document.getElementById('detailContent').innerHTML = `<div style="color:#dc2626; text-align:center; padding:20px; font-weight:700;"><i class="fas fa-exclamation-triangle"></i> ${res.message}</div>`;
        }
    });
}
document.getElementById('detailOverlay').addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; });
</script>
</div>
