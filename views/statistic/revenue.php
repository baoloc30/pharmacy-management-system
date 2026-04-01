<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-chart-line" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Thống Kê Doanh Thu</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Báo cáo doanh thu theo ngày</div>
    </div>
  </div>
</div>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:15px;font-weight:700;color:#fff;">Chọn khoảng thời gian</span>
  </div>
  <div style="padding:16px 20px;">
    <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
      <div style="flex:1;min-width:160px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Từ ngày <span style="color:#dc2626;">*</span></label>
        <input type="date" name="from_date" value="<?php echo $from_date; ?>" 
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div style="flex:1;min-width:160px;">
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đến ngày <span style="color:#dc2626;">*</span></label>
        <input type="date" name="to_date" value="<?php echo $to_date; ?>" 
          style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <button type="submit" style="padding:8px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
        <i class="fas fa-chart-bar"></i> Xem thống kê
      </button>
    </form>
  </div>
</div>

<?php if(!empty($revenue)): ?>
<?php
  $totalRevenue  = array_sum(array_column($revenue, 'doanhThu'));
  $totalInvoices = array_sum(array_column($revenue, 'soHoaDon'));
  $totalDiscount = array_sum(array_column($revenue, 'tienGiam'));
  $totalActual   = array_sum(array_column($revenue, 'thucThu'));
?>

<!-- Summary cards -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:24px;">
  <div style="background:linear-gradient(135deg,#15803d,#22c55e);border-radius:20px;box-shadow:0 8px 24px rgba(21,128,61,.2);padding:30px 20px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;position:relative;overflow:hidden;transition:transform 0.3s ease;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
    <i class="fas fa-money-bill-wave" style="font-size:90px;color:rgba(255,255,255,.07);position:absolute;right:-15px;bottom:-15px;transform:rotate(-15deg);"></i>
    <div style="width:56px;height:56px;background:rgba(255,255,255,.25);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;backdrop-filter:blur(4px);">
      <i class="fas fa-wallet" style="font-size:26px;color:#fff;"></i>
    </div>
    <div style="font-size:12px;font-weight:800;color:rgba(255,255,255,.9);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;position:relative;z-index:1;">Tổng doanh thu</div>
    <div style="font-size:24px;font-weight:900;color:#fff;position:relative;z-index:1;"><?php echo number_format($totalRevenue,0,',','.'); ?>đ</div>
  </div>
  <div style="background:linear-gradient(135deg,#1e40af,#3b82f6);border-radius:20px;box-shadow:0 8px 24px rgba(30,64,175,.2);padding:30px 20px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;position:relative;overflow:hidden;transition:transform 0.3s ease;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
    <i class="fas fa-file-invoice" style="font-size:90px;color:rgba(255,255,255,.07);position:absolute;right:-15px;bottom:-15px;transform:rotate(-15deg);"></i>
    <div style="width:56px;height:56px;background:rgba(255,255,255,.25);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;backdrop-filter:blur(4px);">
      <i class="fas fa-receipt" style="font-size:26px;color:#fff;"></i>
    </div>
    <div style="font-size:12px;font-weight:800;color:rgba(255,255,255,.9);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;position:relative;z-index:1;">Tổng hóa đơn</div>
    <div style="font-size:24px;font-weight:900;color:#fff;position:relative;z-index:1;"><?php echo $totalInvoices; ?></div>
  </div>
  <div style="background:linear-gradient(135deg,#b45309,#f59e0b);border-radius:20px;box-shadow:0 8px 24px rgba(180,83,9,.2);padding:30px 20px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;position:relative;overflow:hidden;transition:transform 0.3s ease;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
    <i class="fas fa-tags" style="font-size:90px;color:rgba(255,255,255,.07);position:absolute;right:-15px;bottom:-15px;transform:rotate(-15deg);"></i>
    <div style="width:56px;height:56px;background:rgba(255,255,255,.25);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;backdrop-filter:blur(4px);">
      <i class="fas fa-gift" style="font-size:26px;color:#fff;"></i>
    </div>
    <div style="font-size:12px;font-weight:800;color:rgba(255,255,255,.9);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;position:relative;z-index:1;">Tổng giảm giá</div>
    <div style="font-size:24px;font-weight:900;color:#fff;position:relative;z-index:1;"><?php echo number_format($totalDiscount,0,',','.'); ?>đ</div>
  </div>
  <div style="background:linear-gradient(135deg,#0891b2,#06b6d4);border-radius:20px;box-shadow:0 8px 24px rgba(8,145,178,.2);padding:30px 20px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;position:relative;overflow:hidden;transition:transform 0.3s ease;cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
    <i class="fas fa-chart-pie" style="font-size:90px;color:rgba(255,255,255,.07);position:absolute;right:-15px;bottom:-15px;transform:rotate(-15deg);"></i>
    <div style="width:56px;height:56px;background:rgba(255,255,255,.25);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;backdrop-filter:blur(4px);">
      <i class="fas fa-calculator" style="font-size:26px;color:#fff;"></i>
    </div>
    <div style="font-size:12px;font-weight:800;color:rgba(255,255,255,.9);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;position:relative;z-index:1;">TB / Hóa đơn</div>
    <div style="font-size:24px;font-weight:900;color:#fff;position:relative;z-index:1;"><?php echo $totalInvoices>0?number_format($totalRevenue/$totalInvoices,0,',','.').'đ':'0đ'; ?></div>
  </div>
</div>

<!-- Table -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
    <span style="font-size:15px;font-weight:700;color:#fff;">Chi tiết theo ngày</span>
  </div>
  <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ngày</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Số hóa đơn</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Doanh thu</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Tiền giảm</th>
          <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Thực thu</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($revenue as $i => $r): ?>
        <?php $rowBg = $i%2===0?'#fff':'#f0f7ff'; ?>
        <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:10px 16px;font-size:13px;color:#374151;white-space:nowrap;"><?php echo date('d/m/Y', strtotime($r['ngay'])); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;text-align:right;"><?php echo $r['soHoaDon']; ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;text-align:right;white-space:nowrap;"><?php echo number_format($r['doanhThu'],0,',','.'); ?>đ</td>
          <td style="padding:10px 16px;font-size:13px;color:#dc2626;text-align:right;white-space:nowrap;"><?php echo number_format($r['tienGiam'],0,',','.'); ?>đ</td>
          <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#15803d;text-align:right;white-space:nowrap;"><?php echo number_format($r['thucThu'],0,',','.'); ?>đ</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr style="background:#f0f7ff;border-top:2px solid #dbeafe;">
          <td style="padding:11px 16px;font-size:13px;font-weight:700;color:#374151;">Tổng cộng</td>
          <td style="padding:11px 16px;font-size:13px;font-weight:700;color:#374151;text-align:right;"><?php echo $totalInvoices; ?></td>
          <td style="padding:11px 16px;font-size:13px;font-weight:700;color:#374151;text-align:right;white-space:nowrap;"><?php echo number_format($totalRevenue,0,',','.'); ?>đ</td>
          <td style="padding:11px 16px;font-size:13px;font-weight:700;color:#dc2626;text-align:right;white-space:nowrap;"><?php echo number_format($totalDiscount,0,',','.'); ?>đ</td>
          <td style="padding:11px 16px;font-size:14px;font-weight:900;color:#15803d;text-align:right;white-space:nowrap;"><?php echo number_format($totalActual,0,',','.'); ?>đ</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<!-- Chart -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
    <span style="font-size:15px;font-weight:700;color:#fff;">Biểu đồ Thực thu</span>
  </div>
  <div style="padding:20px;">
    <canvas id="revenueChart" height="80"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  <?php
    $labels = [];
    $dataThucThu = [];
    foreach($revenue as $r) {
        $labels[] = date('d/m', strtotime($r['ngay']));
        $dataThucThu[] = $r['thucThu'];
    }
  ?>
  
  const ctx = document.getElementById('revenueChart').getContext('2d');
  new Chart(ctx, {
      type: 'line',
      data: {
          labels: <?php echo json_encode($labels); ?>,
          datasets: [{
              label: 'Thực thu (VNĐ)',
              data: <?php echo json_encode($dataThucThu); ?>,
              borderColor: '#16a34a',
              backgroundColor: 'rgba(22, 163, 74, 0.1)',
              borderWidth: 2,
              pointBackgroundColor: '#15803d',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointRadius: 4,
              fill: true,
              tension: 0.3
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: { display: false },
              tooltip: {
                  callbacks: {
                      label: function(context) {
                          let value = context.raw || 0;
                          return 'Thực thu: ' + value.toLocaleString('vi-VN') + ' đ';
                      }
                  }
              }
          },
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: {
                      callback: function(value) {
                          return value.toLocaleString('vi-VN') + ' đ';
                      }
                  }
              }
          }
      }
  });
</script>

<?php else: ?>
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);padding:40px;text-align:center;color:#94a3b8;">
  <?php if(isset($error)): ?>
    <i class="fas fa-exclamation-triangle" style="font-size:40px;margin-bottom:12px;display:block;color:#ef4444;"></i>
    <div style="font-size:15px;font-weight:700;color:#ef4444;"><?php echo $error; ?></div>
  <?php else: ?>
    <i class="fas fa-chart-line" style="font-size:40px;margin-bottom:12px;display:block;"></i>
    Chọn khoảng thời gian để xem thống kê doanh thu.
  <?php endif; ?>
</div>
<?php endif; ?>

</div>
