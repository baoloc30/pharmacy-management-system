<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-fire" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Thuốc Bán Chạy</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Phân tích các sản phẩm mang lại doanh số cao nhất</div>
    </div>
  </div>
</div>

<?php if(isset($error)): ?>
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:14px;padding:16px 20px;margin-bottom:16px;color:#dc2626;font-size:14px;font-weight:600;display:flex;align-items:center;gap:10px;box-shadow:0 2px 14px rgba(0,0,0,.07);">
  <i class="fas fa-exclamation-triangle" style="font-size:18px;"></i> <?php echo $error; ?>
</div>
<?php endif; ?>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:15px;font-weight:700;color:#fff;">Chọn khoảng thời gian (Ngày / Tuần / Tháng)</span>
  </div>
  <div style="padding:16px 20px;">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:15px;align-items:flex-end;">
        <div style="flex:0 0 160px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Từ ngày</label>
          <input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date ?? ''); ?>" 
                 style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div style="flex:0 0 160px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đến ngày</label>
          <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date ?? ''); ?>" 
                 style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
      <button type="submit" style="padding:9px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;box-shadow:0 4px 10px rgba(37,99,235,.2);">
        <i class="fas fa-chart-bar"></i> Xem thống kê
      </button>
    </form>
  </div>
</div>

<?php if(!empty($medicines)): ?>
<!-- Chart -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
  <div style="padding:14px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
    <span style="font-size:15px;font-weight:700;color:#fff;"><i class="fas fa-chart-pie me-2"></i> Biểu Đồ Top 10 Thuốc Bán Chạy</span>
  </div>
  <div style="padding:20px; min-height: 300px; display:flex; align-items:center;">
    <canvas id="bestSellingChart" height="100"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  <?php
    $labels = [];
    $dataSoLuong = [];
    foreach($medicines as $m) {
        $labels[] = $m['tenThuoc'];
        $dataSoLuong[] = $m['soLuongBan'];
    }
  ?>
  
  const ctx = document.getElementById('bestSellingChart').getContext('2d');
  new Chart(ctx, {
      type: 'bar',
      data: {
          labels: <?php echo json_encode($labels); ?>,
          datasets: [{
              label: 'Số lượng bán',
              data: <?php echo json_encode($dataSoLuong); ?>,
              backgroundColor: ['#fc6e6e', '#fb8d51', '#fac65e', '#faeb60', '#9cfd93', '#7df6d8', '#7bd7fe', '#4a8ef5', '#cc8afb', '#fc9cc4'],
              borderRadius: 6
          }]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
              legend: { display: false },
              tooltip: {
                  backgroundColor: 'rgba(15, 23, 42, 0.9)',
                  padding: 12,
                  callbacks: {
                      title: function(context) { return context[0].label; },
                      label: function(context) { return ' Đã bán: ' + context.raw + ' sản phẩm'; }
                  }
              }
          },
          scales: {
              x: {
                  grid: { display: false },
                  ticks: {
                      font: { size: 11 }, color: '#64748b',
                      callback: function(value) {
                          let label = this.getLabelForValue(value) || '';
                          return label.length > 20 ? label.substring(0, 20) + '...' : label;
                      }
                  }
              },
              y: {
                  beginAtZero: true,
                  grid: { color: '#f1f5f9', drawBorder: false },
                  ticks: { font: { size: 12 }, color: '#64748b' }
              }
          }
      }
  });
</script>
<?php endif; ?>

<!-- Danh sách -->
<div style="background:#fff;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,.08);overflow:hidden;margin-bottom:24px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#172554,#1d4ed8); display:flex; justify-content:space-between; align-items:center;">
    <span style="font-size:15px;font-weight:800;color:#fff;"><i class="fas fa-list me-2"></i> Bảng Danh Sách Xếp Hạng</span>
    <span style="font-size:12px;color:rgba(255,255,255,.8);">Từ <?= date('d/m/Y', strtotime($from_date)) ?> đến <?= date('d/m/Y', strtotime($to_date)) ?></span>
  </div>

  <div style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
    <?php if(empty($medicines)): ?>
      <div style="padding:50px 20px;text-align:center;color:#94a3b8;">
        <i class="fas fa-box-open" style="font-size:48px;margin-bottom:16px;display:block;color:#cbd5e1;"></i>
        <div style="font-size:14px;font-weight:600;"><?php echo $empty_message ?? 'Không có thuốc bán chạy trong khoảng thời gian đã chọn.'; ?></div>
      </div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;min-width:800px;">
      <thead style="position: sticky; top: 0; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;width:80px;">Hạng</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Mã thuốc</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Tên thuốc</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">ĐVT</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Số lượng đã bán</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Doanh thu</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($medicines as $i => $m): ?>
        <?php $rowBg = $i%2===0?'#ffffff':'#f0f7ff'; ?>
        <tr style="background:<?php echo $rowBg; ?>;border-bottom:1px solid #e2e8f0;transition:background 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          
          <td style="padding:14px 20px;text-align:center;">
            <?php if($i===0): ?>
              <span style="display:inline-flex;align-items:center;justify-content:center;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:800;background:#fef08a;color:#a16207;box-shadow:0 2px 6px rgba(253,224,71,.4);">
                <i class="fas fa-trophy" style="margin-right:4px;"></i> 1
              </span>
            <?php elseif($i===1): ?>
              <span style="display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;font-size:12px;font-weight:800;background:#c0f5fb;color:#475569;box-shadow:0 2px 4px rgba(0,0,0,.05);">2</span>
            <?php elseif($i===2): ?>
              <span style="display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;font-size:12px;font-weight:800;background:#fee2e2;color:#dc2626;box-shadow:0 2px 4px rgba(220,38,38,.1);">3</span>
            <?php else: ?>
              <span style="font-size:13px;font-weight:600;color:#94a3b8;"><?php echo $i+1; ?></span>
            <?php endif; ?>
          </td>
          
          <td style="padding:14px 20px;font-size:13px;color:#64748b;"><?php echo htmlspecialchars($m['maThuoc']); ?></td>
          <td style="padding:14px 20px;font-size:13px;font-weight:700;color:#334155;"><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
          <td style="padding:14px 20px;font-size:13px;color:#64748b;"><?php echo htmlspecialchars($m['donViTinh']); ?></td>
          <td style="padding:14px 20px;font-size:14px;font-weight:800;color:#2563eb;text-align:right;"><?php echo number_format($m['soLuongBan']); ?></td>
          <td style="padding:14px 20px;font-size:14px;font-weight:800;color:#16a34a;text-align:right;white-space:nowrap;"><?php echo number_format($m['doanhThu'],0,',','.'); ?>đ</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>
</div>