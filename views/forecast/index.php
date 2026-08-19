<div class="content-wrapper">

    <!-- Thông báo -->
    <?php if (!empty($success)): ?>
        <div id="sysSuccessBanner" style="margin-bottom:16px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;color:#15803d;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;transition:opacity 0.5s ease;box-shadow:0 2px 8px rgba(0,0,0,.04);">
            <i class="fas fa-check-circle" style="font-size:15px;"></i> <?= htmlspecialchars($success) ?>
        </div>
        <script>
            setTimeout(() => {
                let msg = document.getElementById('sysSuccessBanner');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.style.display = 'none', 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div id="sysErrorBanner" style="margin-bottom:16px;padding:12px 16px;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;color:#b91c1c;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;transition:opacity 0.5s ease;box-shadow:0 2px 8px rgba(0,0,0,.04);">
            <i class="fas fa-exclamation-triangle" style="font-size:15px;"></i> <?= htmlspecialchars($error) ?>
        </div>
        <script>
            setTimeout(() => {
                let err = document.getElementById('sysErrorBanner');
                if (err) {
                    err.style.opacity = '0';
                    setTimeout(() => err.style.display = 'none', 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <!-- Header với nút bấm bên phải -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
        <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-magic" style="color:#fff;font-size:18px;"></i>
                </div>
                <div>
                    <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Dự Báo Nhập Kho (AI)</div>
                    <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Tự động phân tích tốc độ tiêu thụ 30 ngày (Thuật toán ROP)</div>
                </div>
            </div>

            <!-- Nút Tạo Phiếu Nổi Bật Dành Riêng Cho Quản Lý -->
            <?php if (!empty($suggestions)): ?>
                <a href="<?= BASE_URL ?>forecast/autoCreate"
                    style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:9px;border:none;background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(217,119,6,.4);text-decoration:none;">
                    <i class="fas fa-robot"></i> Tạo Phiếu Đề Xuất Tự Động
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
        <div style="padding:12px 20px;background:linear-gradient(135deg,#991b1b,#dc2626);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách hàng hóa cần nhập gấp</span>
            <span style="font-size:12px;color:rgba(255,255,255,.8);"><?= count($suggestions ?? []) ?> mặt hàng</span>
        </div>
        <div style="overflow-x:auto;">
            <?php if (empty($suggestions)): ?>
                <div style="padding:40px;text-align:center;color:#15803d;font-size:14px;font-weight:600;"><i class="fas fa-shield-alt" style="font-size:24px;margin-bottom:10px;display:block;"></i>Kho hàng đang ở trạng thái an toàn.</div>
            <?php else: ?>
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:linear-gradient(135deg,#991b1b,#dc2626);">
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Mã</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Tên thuốc</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tốc độ bán</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tồn hiện tại</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Mức báo động (ROP)</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">AI Đề xuất nhập (+14 ngày)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($suggestions as $i => $item): ?>
                            <?php $rowBg = $i % 2 === 0 ? '#fff' : '#fef2f2'; ?>
                            <tr style="background:<?= $rowBg ?>;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='<?= $rowBg ?>'">
                                <td style="padding:12px 16px;font-size:13px;color:#64748b;text-align:center;"><?= htmlspecialchars($item['maThuoc']) ?></td>
                                <td style="padding:12px 16px;font-size:13px;font-weight:700;color:#1e293b;"><?= htmlspecialchars($item['tenThuoc']) ?></td>
                                <td style="padding:12px 16px;font-size:13px;color:#374151;text-align:center;"><?= htmlspecialchars($item['tocDoBan']) ?> sp/ngày</td>
                                <td style="padding:12px 16px;text-align:center;">
                                    <span style="background:#fef2f2;color:#dc2626;padding:4px 10px;border-radius:20px;font-size:13px;font-weight:700;border:1px solid #fecaca;"><?= htmlspecialchars($item['tonKhoHienTai']) ?></span>
                                </td>
                                <td style="padding:12px 16px;text-align:center;">
                                    <span style="background:#fffbeb;color:#b45309;padding:4px 10px;border-radius:20px;font-size:13px;font-weight:700;border:1px solid #fde68a;"><?= htmlspecialchars($item['diemROP']) ?></span>
                                </td>
                                <td style="padding:12px 16px;text-align:center;font-size:16px;font-weight:800;color:#15803d;">
                                    +<?= htmlspecialchars($item['soLuongDeXuatNhap']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>