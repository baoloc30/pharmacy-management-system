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

<?php if(isset($error)): ?>
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:16px;color:#dc2626;font-size:13px;display:flex;align-items:center;gap:8px;">
  <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
</div>
<?php endif; ?>

<!-- Filter -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:15px;font-weight:700;color:#fff;">Chọn tháng / năm</span>
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

<!-- Chart -->
<?php if(!empty($medicines)): ?>
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
  <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#3b82f6);">
    <span style="font-size:15px;font-weight:700;color:#fff;">Biểu Đồ Top Thuốc Bán Chạy (Số Lượng)</span>
  </div>
  <div style="padding:20px;">
    <canvas id="bestSellingChart" height="80"></canvas>
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
              backgroundColor: 'rgb(122, 217, 248)',
              borderColor: '#0e5cee',
              borderWidth: 1,
              borderRadius: 6
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: { display: false },
              tooltip: {
                  callbacks: {
                      label: function(context) {
                          return 'Đã bán: ' + context.raw;
                      }
                  }
              }
          },
          scales: {
              y: { beginAtZero: true }
          }
      }
  });
</script>
<?php endif; ?>

<div style="background:#fff;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,.08);overflow:hidden;margin-bottom:24px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e3a8a,#2563eb);">
    <span style="font-size:15px;font-weight:800;color:#fff;">Top thuốc bán chạy — Tháng <?php echo $month; ?>/<?php echo $year; ?></span>
  </div>
  <div style="overflow-x:auto;">
    <?php if(empty($medicines)): ?>
      <div style="padding:50px 20px;text-align:center;color:#94a3b8;">
        <i class="fas fa-box-open" style="font-size:48px;margin-bottom:16px;display:block;color:#cbd5e1;"></i>
        <div style="font-size:14px;font-weight:600;"><?php echo $empty_message ?? 'Không có thuốc bán chạy trong khoảng thời gian đã chọn.'; ?></div>
      </div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;min-width:800px;">
      <thead>
        <tr style="background:#1e3a8a;">
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;width:80px;">Hạng</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Mã thuốc</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Tên thuốc</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">ĐVT</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Số lượng bán</th>
          <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Doanh thu</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($medicines as $i => $m): ?>
        <?php $rowBg = $i%2===0?'#ffffff':'#dfedfb'; ?>
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
          
          <td style="padding:14px 20px;font-size:13px;color:#64748b;"><?php echo $m['maThuoc']; ?></td>
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
