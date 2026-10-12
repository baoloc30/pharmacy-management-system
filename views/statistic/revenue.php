<div class="content-wrapper">

  <!-- Header -->
  <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
    <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-chart-line" style="color:#fff;font-size:18px;"></i>
      </div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Thống Kê Doanh Thu</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Báo cáo doanh thu theo ngày và phân tích trực quan</div>
      </div>
    </div>
  </div>

  <!-- Filter -->
  <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
    <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
      <i class="fas fa-filter" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:15px;font-weight:700;color:#fff;">Tiêu chí lọc</span>
    </div>
    <div style="padding:16px 20px;">
      <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:15px;align-items:flex-end;">

        <div style="flex:0 0 135px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Từ ngày <span style="color:#dc2626;">*</span></label>
          <input type="date" name="from_date" value="<?php echo $from_date ?? ''; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div style="flex:0 0 135px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đến ngày <span style="color:#dc2626;">*</span></label>
          <input type="date" name="to_date" value="<?php echo $to_date ?? ''; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>

        <div style="flex:0 0 110px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Mã nhân viên</label>
          <input type="text" name="ma_nhan_vien" value="<?php echo htmlspecialchars($filters['maNhanVien'] ?? ''); ?>" placeholder="VD: NV001" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>

        <div style="flex:0 0 110px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Mã thuốc</label>
          <input type="text" name="ma_thuoc" value="<?php echo htmlspecialchars($filters['maThuoc'] ?? ''); ?>" placeholder="VD: TH001" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>

        <div style="flex:0 0 180px;">
          <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Tên thuốc</label>
          <input type="text" name="ten_thuoc" value="<?php echo htmlspecialchars($filters['tenThuoc'] ?? ''); ?>" placeholder="VD: Paracetamol" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
        <div style="flex:0 0 auto;">
          <button type="submit" style="padding:9px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;white-space:nowrap;box-shadow:0 4px 10px rgba(37,99,235,.2);">
            <i class="fas fa-search"></i> Lọc dữ liệu
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php if (isset($revenueDetails) && !empty($revenueDetails)): ?>

    <?php
    $soHoaDon = 0;
    $dsHoaDon = [];
    $doanhThuTheoThuoc = [];
    $doanhThuTheoNhanVien = [];

    foreach ($revenueDetails as $r) {
      $dsHoaDon[$r['maHoaDon']] = true;
      $tenThuoc = $r['tenThuoc'];
      if (!isset($doanhThuTheoThuoc[$tenThuoc])) $doanhThuTheoThuoc[$tenThuoc] = 0;
      $doanhThuTheoThuoc[$tenThuoc] += $r['doanhThu'];

      $tenNV = $r['tenNhanVien'];
      if (!isset($doanhThuTheoNhanVien[$tenNV])) $doanhThuTheoNhanVien[$tenNV] = 0;
      $doanhThuTheoNhanVien[$tenNV] += $r['doanhThu'];
    }

    $soHoaDon = count($dsHoaDon);
    $giaTriTrungBinh = $soHoaDon > 0 ? (($summary['totalRevenue'] ?? 0) / $soHoaDon) : 0;

    arsort($doanhThuTheoThuoc);
    $topThuocLabels = array_slice(array_keys($doanhThuTheoThuoc), 0, 5);
    $topThuocData = array_slice(array_values($doanhThuTheoThuoc), 0, 5);

    arsort($doanhThuTheoNhanVien);
    
    $top5NV = array_slice($doanhThuTheoNhanVien, 0, 5);
    $otherNVRevenue = array_sum(array_slice($doanhThuTheoNhanVien, 5));
    if ($otherNVRevenue > 0) {
        $top5NV['Nhân viên khác'] = $otherNVRevenue;
    }
    
    $nvLabels = array_keys($top5NV);
    $nvData = array_values($top5NV);
    
    // Insight 1: Ngày đạt đỉnh doanh thu
    $maxDay = '';
    $maxDayRevenue = 0;
    if (!empty($chartData)) {
        foreach ($chartData as $d) {
            if ($d['doanhThu'] > $maxDayRevenue) {
                $maxDayRevenue = $d['doanhThu'];
                $maxDay = date('d/m/Y', strtotime($d['ngay']));
            }
        }
    }

    // Insight 2: Sản phẩm chủ lực & Tỷ trọng
    $bestProduct = '';
    $bestProductRevenue = 0;
    if (!empty($doanhThuTheoThuoc)) {
        reset($doanhThuTheoThuoc);
        $bestProduct = key($doanhThuTheoThuoc);
        $bestProductRevenue = current($doanhThuTheoThuoc);
    }
    $bestProductPercent = ($summary['totalRevenue'] ?? 0) > 0 ? round(($bestProductRevenue / $summary['totalRevenue']) * 100, 1) : 0;

    // Insight 3: Nhân viên xuất sắc & Tỷ trọng
    $bestEmp = '';
    $bestEmpRevenue = 0;
    if (!empty($doanhThuTheoNhanVien)) {
        reset($doanhThuTheoNhanVien);
        $bestEmp = key($doanhThuTheoNhanVien);
        $bestEmpRevenue = current($doanhThuTheoNhanVien);
    }
    $bestEmpPercent = ($summary['totalRevenue'] ?? 0) > 0 ? round(($bestEmpRevenue / $summary['totalRevenue']) * 100, 1) : 0;
    ?>

    <!-- --- KHỐI THẺ KPI CHỈ SỐ TỔNG QUAN --- -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:20px;">
      <!-- Thẻ 1 -->
      <div style="background:linear-gradient(135deg,#1e40af,#3b82f6); border-radius:18px; box-shadow:0 8px 24px rgba(37,99,235,.25); padding:24px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden; transition:transform 0.3s ease; cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
        <i class="fas fa-wallet" style="font-size:90px; color:rgba(255,255,255,.08); position:absolute; right:-15px; bottom:-15px; transform:rotate(-15deg);"></i>
        <div style="font-size:12px; font-weight:800; color:rgba(255,255,255,.9); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; position:relative; z-index:1;">Tổng doanh thu</div>
        <div style="font-size:26px; font-weight:900; color:#fff; position:relative; z-index:1;">
          <?= number_format($summary['totalRevenue'] ?? 0, 0, ',', '.') ?> <span style="font-size:16px;">đ</span>
        </div>
      </div>
      <!-- Thẻ 2 -->
      <div style="background:linear-gradient(135deg,#15803d,#22c55e); border-radius:18px; box-shadow:0 8px 24px rgba(21,128,61,.25); padding:24px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden; transition:transform 0.3s ease; cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
        <i class="fas fa-box-open" style="font-size:90px; color:rgba(255,255,255,.08); position:absolute; right:-15px; bottom:-15px; transform:rotate(-15deg);"></i>
        <div style="font-size:12px; font-weight:800; color:rgba(255,255,255,.9); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; position:relative; z-index:1;">Số lượng đã bán</div>
        <div style="font-size:26px; font-weight:900; color:#fff; position:relative; z-index:1;">
          <?= number_format($summary['totalQuantity'] ?? 0, 0, ',', '.') ?> <span style="font-size:16px;">sp</span>
        </div>
      </div>
      <!-- Thẻ 3 -->
      <div style="background:linear-gradient(135deg,#b45309,#f59e0b); border-radius:18px; box-shadow:0 8px 24px rgba(180,83,9,.25); padding:24px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden; transition:transform 0.3s ease; cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
        <i class="fas fa-file-invoice-dollar" style="font-size:90px; color:rgba(255,255,255,.08); position:absolute; right:-15px; bottom:-15px; transform:rotate(-15deg);"></i>
        <div style="font-size:12px; font-weight:800; color:rgba(255,255,255,.9); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; position:relative; z-index:1;">Tổng hóa đơn</div>
        <div style="font-size:26px; font-weight:900; color:#fff; position:relative; z-index:1;">
          <?= number_format($soHoaDon, 0, ',', '.') ?> <span style="font-size:16px;">phiếu</span>
        </div>
      </div>
      <!-- Thẻ 4 -->
      <div style="background:linear-gradient(135deg,#6d28d9,#8b5cf6); border-radius:18px; box-shadow:0 8px 24px rgba(109,40,217,.25); padding:24px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden; transition:transform 0.3s ease; cursor:pointer;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='translateY(0)'">
        <i class="fas fa-users" style="font-size:90px; color:rgba(255,255,255,.08); position:absolute; right:-15px; bottom:-15px; transform:rotate(-15deg);"></i>
        <div style="font-size:12px; font-weight:800; color:rgba(255,255,255,.9); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; position:relative; z-index:1;">Trung bình / Khách</div>
        <div style="font-size:26px; font-weight:900; color:#fff; position:relative; z-index:1;">
          <?= number_format($giaTriTrungBinh, 0, ',', '.') ?> <span style="font-size:16px;">đ</span>
        </div>
      </div>
    </div>

    <!-- KHỐI SMART INSIGHTS - NHẬN XÉT THÔNG MINH TỪ HỆ THỐNG                  -->
    <div style="background:#c1f7f9;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
      <div style="padding:14px 20px;background:linear-gradient(135deg,#0dba04,#06e8ef);display:flex;align-items:center;gap:8px;">
        <i class="fas fa-lightbulb" style="color:#fde047;font-size:15px;animation: flash 2s infinite;"></i>
        <span style="font-size:15px;font-weight:700;color:#fff;">Phân Tích & Nhận Xét Từ Dữ Liệu</span>
      </div>
      <div style="padding:20px;display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:24px;">
        
        <!-- Insight 1 -->
        <div style="display:flex;gap:12px;align-items:flex-start;">
            <div style="width:42px;height:42px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;box-shadow:0 2px 6px rgba(37,99,235,.15);">
                <i class="fas fa-arrow-trend-up"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:800;color:#1e293b;margin-bottom:6px;text-transform:uppercase;">Đỉnh điểm doanh thu</div>
                <div style="font-size:13px;color:#475569;line-height:1.6; font-weight:600;">
                    Ghi nhận vào ngày <strong style="color:#2563eb;"><?= $maxDay ?></strong> đạt mức cao nhất <strong style="color:#15803d;"><?= number_format($maxDayRevenue, 0, ',', '.') ?>đ</strong>. Khuyến nghị chuẩn bị nhân sự và lượng hàng tồn kho tốt nhất vào các chu kỳ tương tự.
                </div>
            </div>
        </div>

        <!-- Insight 2 -->
        <div style="display:flex;gap:12px;align-items:flex-start;">
            <div style="width:42px;height:42px;border-radius:10px;background:#f0fdf4;color:#15803d;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;box-shadow:0 2px 6px rgba(21,128,61,.15);">
                <i class="fas fa-star"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:800;color:#1e293b;margin-bottom:6px;text-transform:uppercase;">Sản phẩm chủ lực</div>
                <div style="font-size:13px;color:#475569;line-height:1.6; font-weight:600;">
                    Thuốc <strong style="color:#2563eb;"><?= htmlspecialchars($bestProduct) ?></strong> mang lại <strong style="color:#15803d;"><?= number_format($bestProductRevenue, 0, ',', '.') ?>đ</strong>, chiếm <strong style="color:#ea580c;"><?= $bestProductPercent ?>%</strong> tổng tỷ trọng. Nên ưu tiên thiết lập AI Dự báo (ROP) cảnh báo sớm cho mặt hàng này.
                </div>
            </div>
        </div>

        <!-- Insight 3 -->
        <div style="display:flex;gap:12px;align-items:flex-start;">
            <div style="width:42px;height:42px;border-radius:10px;background:#fffbeb;color:#b45309;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;box-shadow:0 2px 6px rgba(180,83,9,.15);">
                <i class="fas fa-medal"></i>
            </div>
            <div>
                <div style="font-size:13px;font-weight:800;color:#1e293b;margin-bottom:6px;text-transform:uppercase;">Hiệu suất nhân viên</div>
                <div style="font-size:13px;color:#475569;line-height:1.6; font-weight:600;">
                    Nhân viên <strong style="color:#2563eb;"><?= htmlspecialchars($bestEmp) ?></strong> xuất sắc dẫn đầu với mức đóng góp <strong style="color:#ea580c;"><?= $bestEmpPercent ?>%</strong> doanh số. Cân nhắc khen thưởng và phân tích kỹ năng bán chéo (Cross-selling).
                </div>
            </div>
        </div>

      </div>
    </div>
    <style>@keyframes flash { 0%,100%{opacity:1;} 50%{opacity:0.4;} }</style>
    <!-- ========================================================================= -->

    <!-- --- KHỐI BIỂU ĐỒ --- -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
      <div style="padding:14px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
        <span style="font-size:15px;font-weight:700;color:#fff;"><i class="fas fa-chart-area me-2"></i> Xu Hướng Doanh Thu Theo Thời Gian</span>
      </div>
      <div style="padding:20px;">
        <canvas id="revenueChart" height="70"></canvas>
      </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
      
      <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
        <div style="padding:14px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
          <span style="font-size:15px;font-weight:700;color:#fff;"><i class="fas fa-trophy me-2"></i> Top 5 Sản Phẩm Bán Chạy</span>
        </div>
        <div style="padding:20px; min-height: 280px; display:flex; align-items:center;">
          <canvas id="topProductChart" height="250"></canvas>
        </div>
      </div>

      <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
        <div style="padding:14px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
          <span style="font-size:15px;font-weight:700;color:#fff;"><i class="fas fa-id-badge me-2"></i> Tỷ Trọng Theo Nhân Viên</span>
        </div>
        <div style="padding:20px; display:flex; justify-content:center; align-items:center; min-height: 280px;">
          <canvas id="employeeChart" height="250"></canvas>
        </div>
      </div>
    </div>
    </div>

    <!-- --- BẢNG DỮ LIỆU CHI TIẾT --- -->
    <div style="padding:20px;">
      <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
        <div style="padding:14px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
          <span style="font-size:15px;font-weight:700;color:#fff;"><i class="fas fa-list me-2"></i> Bảng Chi Tiết Giao Dịch Bán Hàng</span>
        </div>

        <div style="max-height:400px; overflow-y:auto; overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;">
            <thead style="position: sticky; top: 0; z-index: 10;">
              <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                <th style="padding:11px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Mã HĐ</th>
                <th style="padding:11px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Ngày</th>
                <th style="padding:11px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Nhân viên</th>
                <th style="padding:11px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Tên thuốc</th>
                <th style="padding:11px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Số lượng</th>
                <th style="padding:11px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Doanh thu</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($revenueDetails as $i => $r): ?>
                <?php $rowBg = $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>
                <tr style="background:<?php echo $rowBg; ?>; transition:background .15s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
                  <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#1e40af;white-space:nowrap;">#<?= htmlspecialchars($r['maHoaDon']) ?></td>
                  <td style="padding:10px 16px;font-size:13px;color:#374151;white-space:nowrap;"><?= date('d/m/Y', strtotime($r['ngayLap'])) ?></td>
                  <td style="padding:10px 16px;font-size:13px;color:#374151;white-space:nowrap;">
                    <div style="font-weight:600;"><?= htmlspecialchars($r['tenNhanVien']) ?></div>
                    <div style="font-size:11px;color:#6b7280;">NV: <?= htmlspecialchars($r['maNhanVien']) ?></div>
                  </td>
                  <td style="padding:10px 16px;font-size:13px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($r['tenThuoc']) ?></td>
                  <td style="padding:10px 16px;font-size:13px;color:#1e293b;text-align:right;font-weight:700;"><?= number_format($r['soLuong'], 0, ',', '.') ?></td>
                  <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#15803d;text-align:right;white-space:nowrap;"><?= number_format($r['doanhThu'], 0, ',', '.') ?> đ</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- --- JAVASCRIPT VẼ BIỂU ĐỒ --- -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const currencyFormatter = function(value) {
        if (value >= 1000000) return (value / 1000000).toLocaleString('vi-VN') + ' Tr';
        return value.toLocaleString('vi-VN');
      };
      const tooltipFormatter = function(context) {
        return ' Doanh thu: ' + (context.raw || 0).toLocaleString('vi-VN') + ' VNĐ';
      };

      // 1. Biểu đồ đường
      <?php
      $rawLabels = array_column($chartData ?? [], 'ngay');
      
      // Từ ngày và Đến ngày có nằm trong cùng 1 năm không?
      $startYear = !empty($from_date) ? date('Y', strtotime($from_date)) : date('Y');
      $endYear = !empty($to_date) ? date('Y', strtotime($to_date)) : date('Y');
      $isSameYear = ($startYear === $endYear);
      
      // Nếu cùng năm chỉ in "Ngày/Tháng" (d/m), nếu vắt qua năm khác in đủ "Ngày/Tháng/Năm"
      $lineLabels = array_map(function($date) use ($isSameYear) {
          return $isSameYear ? date('d/m', strtotime($date)) : date('d/m/Y', strtotime($date)); 
      }, $rawLabels);
      
      $lineData = array_column($chartData ?? [], 'doanhThu');
      ?>
      new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'line',
        data: {
          labels: <?= json_encode($lineLabels) ?>,
          datasets: [{
            label: 'Doanh thu',
            data: <?= json_encode($lineData) ?>,
            borderColor: '#03db4b',
            backgroundColor: 'rgba(46, 233, 90, 0.1)',
            borderWidth: 3,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#61f593',
            pointBorderWidth: 2,
            pointRadius: 5,
            fill: true,
            tension: 0.3
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: 'rgba(15, 23, 42, 0.9)',
              padding: 10,
              callbacks: { label: tooltipFormatter }
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                maxTicksLimit: 12,
                maxRotation: 0,
                minRotation: 0,
                font: { size: 11 },
                color: '#64748b'
              }
            },
            y: {
              beginAtZero: true,
              grid: {
                color: '#f1f5f9',
                drawBorder: false
              },
              ticks: {
                font: { size: 12 },
                color: '#64748b',
                callback: currencyFormatter
              }
            }
          }
        }
      });

      // 2. Biểu đồ cột
      new Chart(document.getElementById('topProductChart').getContext('2d'), {
        type: 'bar',
        data: {
          labels: <?= json_encode($topThuocLabels) ?>,
          datasets: [{
            label: 'Doanh thu',
            data: <?= json_encode($topThuocData) ?>,
            backgroundColor: ['#00c2e9', '#25d8f4', '#49e0f1', '#7ae0ef', '#b2edf4'],
            borderRadius: 6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          indexAxis: 'y',
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              backgroundColor: 'rgba(15, 23, 42, 0.9)',
              padding: 10,
              callbacks: {
                title: function(context) {
                    return context[0].label;
                },
                label: function(context) {
                    return ' Doanh thu: ' + (context.raw || 0).toLocaleString('vi-VN') + ' VNĐ';
                }
            }
          },
          scales: {
            x: {
              beginAtZero: true,
              grid: {
                color: '#f1f5f9',
                drawBorder: false
              },
              ticks: {
                font: {
                  size: 11
                },
                color: '#64748b',
                callback: function(value) {
                  if (value >= 1000000) return (value / 1000000).toLocaleString('vi-VN') + ' Tr';
                  if (value >= 1000) return (value / 1000).toLocaleString('vi-VN') + ' K';
                  return value;
                }
              }
            },
            y: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  size: 12,
                  weight: '600'
                },
                color: '#334155',
                callback: function(value) {
                  let label = this.getLabelForValue(value) || '';
                  if (label.length > 25) {
                    return label.substring(0, 25) + '...';
                  }
                  return label;
                }
              }
            }
          }
        }
      }});

      // 3. Biểu đồ tròn
      new Chart(document.getElementById('employeeChart').getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: <?= json_encode($nvLabels) ?>,
          datasets: [{
            data: <?= json_encode($nvData) ?>,
            backgroundColor: ['#08a4f2', '#14e088', '#edb34f', '#d478f8', '#f56666', '#64eedc'],
            borderWidth: 3,
            borderColor: '#ffffff',
            hoverOffset: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '65%',
          plugins: {
            legend: {
              position: 'right',
              labels: {
                boxWidth: 12,
                padding: 15,
                font: { size: 11 }
              }
            },
            tooltip: {
              backgroundColor: 'rgba(15, 23, 42, 0.9)',
              padding: 10,
              callbacks: {
                label: tooltipFormatter
              }
            }
          }
        }
      });
    </script>

  <?php else: ?>
    <!-- Trạng thái khi không có dữ liệu -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);padding:60px 20px;text-align:center;color:#94a3b8;">
      <?php if (isset($error)): ?>
        <i class="fas fa-exclamation-triangle" style="font-size:48px;margin-bottom:16px;display:block;color:#ef4444;"></i>
        <div style="font-size:16px;font-weight:700;color:#ef4444;"><?php echo $error; ?></div>
      <?php else: ?>
        <i class="fas fa-chart-line" style="font-size:48px;margin-bottom:16px;display:block;color:#cbd5e1;"></i>
        <div style="font-size:16px;font-weight:700;color:#64748b;">Chưa có dữ liệu giao dịch</div>
        <div style="font-size:13px;margin-top:6px;">Vui lòng chọn khoảng thời gian khác ở bộ lọc phía trên.</div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

</div>