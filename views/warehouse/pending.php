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

    <!-- Header -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
        <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-clipboard-list" style="color:#fff;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Phiếu Đề Xuất Chờ Duyệt</div>
                <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Xét duyệt các phiếu do AI tự động tạo</div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
        <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:13px;font-weight:700;color:#fff;"><?= count($pending_imports ?? []) ?> phiếu chờ duyệt</span>
        </div>
        <div style="overflow-x:auto;">
            <?php if (empty($pending_imports)): ?>
                <div style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;"><i class="fas fa-check-circle" style="font-size:20px;margin-bottom:10px;display:block;color:#15803d;"></i>Không có phiếu đề xuất nào cần xử lý.</div>
            <?php else: ?>
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Mã Phiếu</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ngày lập</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Nhà cung cấp</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Tổng tiền dự kiến</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ghi chú</th>
                            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_imports as $i => $p): ?>
                            <?php $rowBg = $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>
                            <tr style="background:<?= $rowBg ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?= $rowBg ?>'">
                                <td style="padding:12px 16px;text-align:center;">
                                    <span style="background:#1e293b;color:#fff;padding:4px 8px;border-radius:6px;font-size:12px;font-weight:600;"><?= htmlspecialchars($p['maPhieu']) ?></span>
                                </td>
                                <td style="padding:12px 16px;font-size:13px;color:#475569;white-space:nowrap;">
                                    <i class="far fa-clock" style="margin-right:4px;"></i> <?= date('d/m/Y H:i', strtotime($p['ngayLap'])) ?>
                                </td>
                                <td style="padding:12px 16px;">
                                    <select id="ncc_<?= $p['maPhieuNK'] ?>" style="width:100%; max-width:250px; padding:6px 10px; border:1.5px solid #cbd5e1; border-radius:7px; font-size:12.5px; font-weight:600; color:#1e293b; outline:none; cursor:pointer;">
                                        <?php foreach ($suppliers ?? [] as $s): ?>
                                            <option value="<?= $s['maNhaCC'] ?>" <?= $s['maNhaCC'] == $p['maNhaCC'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($s['tenNhaCC']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="padding:12px 16px;font-size:14px;font-weight:700;color:#dc2626;text-align:right;white-space:nowrap;">
                                    <?= number_format($p['tongTien'], 0, ',', '.') ?> đ
                                </td>
                                <td style="padding:12px 16px;font-size:12px;color:#64748b;"><?= htmlspecialchars($p['ghiChu'] ?? '') ?></td>
                                <td style="padding:12px 16px;text-align:center;">
                                    <div style="display:flex;justify-content:center;gap:6px;">
                                        <!-- Nút gọi Popup Duyệt -->
                                        <button onclick="openApproveModal(<?= $p['maPhieuNK'] ?>)"
                                            style="border:none;cursor:pointer;padding:6px 12px;border-radius:7px;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:12px;font-weight:700;box-shadow:0 2px 5px rgba(21,128,61,.3);">
                                            <i class="fas fa-check" style="margin-right:4px;"></i>Duyệt
                                        </button>

                                        <!-- Nút gọi Popup Hủy -->
                                        <button onclick="openCancelModal(<?= $p['maPhieuNK'] ?>)"
                                            style="border:none;cursor:pointer;padding:6px 12px;border-radius:7px;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;font-size:12px;font-weight:700;box-shadow:0 2px 5px rgba(220,38,38,.3);">
                                            <i class="fas fa-times" style="margin-right:4px;"></i>Hủy
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== GIAO DIỆN POPUP XÁC NHẬN DUYỆT ========== -->
    <div id="approveOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;width:100%;max-width:440px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);">
            <div style="padding:14px 20px;background:linear-gradient(135deg,#15803d,#16a34a);display:flex;align-items:center;gap:10px;">
                <i class="fas fa-check-circle" style="color:#fff;font-size:15px;"></i>
                <span style="font-size:14px;font-weight:700;color:#fff;">Xác nhận duyệt phiếu</span>
            </div>
            <div style="padding:18px 22px;font-size:13px;color:#374151;line-height:1.5;">
                Bạn có chắc chắn muốn <b>ĐỒNG Ý</b> duyệt phiếu này và tự động đẩy lượng hàng vào tồn kho chính thức không?
            </div>
            <div style="padding:10px 22px 18px;display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="document.getElementById('approveOverlay').style.display='none'" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Đóng</button>
                <button id="btnConfirmApprove" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;border:none;cursor:pointer;">
                    <i class="fas fa-check"></i> Duyệt Hàng
                </button>
            </div>
        </div>
    </div>

    <!-- ========== GIAO DIỆN POPUP XÁC NHẬN HỦY ========== -->
    <div id="cancelOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:16px;width:100%;max-width:440px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);">
            <div style="padding:14px 20px;background:linear-gradient(135deg,#dc2626,#ef4444);display:flex;align-items:center;gap:10px;">
                <i class="fas fa-exclamation-triangle" style="color:#fff;font-size:15px;"></i>
                <span style="font-size:14px;font-weight:700;color:#fff;">Cảnh báo hủy phiếu</span>
            </div>
            <div style="padding:18px 22px;font-size:13px;color:#374151;line-height:1.5;">
                Bạn có chắc chắn muốn <b>TỪ CHỐI</b> đề xuất này? Phiếu sẽ bị hủy và không thể khôi phục lại.
            </div>
            <div style="padding:10px 22px 18px;display:flex;gap:10px;justify-content:flex-end;">
                <button onclick="document.getElementById('cancelOverlay').style.display='none'" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Đóng</button>
                <button id="btnConfirmCancel" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border:none;cursor:pointer;">
                    <i class="fas fa-times"></i> Xác nhận Hủy
                </button>
            </div>
        </div>
    </div>

    <!-- ========== XỬ LÝ SỰ KIỆN ========== -->
    <script>
        let currentApproveId = null;
        let currentCancelId = null;

        // Xử lý nút Duyệt
        function openApproveModal(maPhieu) {
            currentApproveId = maPhieu;
            document.getElementById('approveOverlay').style.display = 'flex';
        }
        document.getElementById('btnConfirmApprove').addEventListener('click', function() {
            if (currentApproveId) {
                let maNhaCC = document.getElementById('ncc_' + currentApproveId).value;
                window.location.href = '<?= BASE_URL ?>warehouse/approve?id=' + currentApproveId + '&nha_cc=' + maNhaCC;
            }
        });

        // Xử lý nút Hủy
        function openCancelModal(maPhieu) {
            currentCancelId = maPhieu;
            document.getElementById('cancelOverlay').style.display = 'flex';
        }
        document.getElementById('btnConfirmCancel').addEventListener('click', function() {
            if (currentCancelId) {
                window.location.href = '<?= BASE_URL ?>warehouse/cancel?id=' + currentCancelId;
            }
        });

        // Click ra ngoài khoảng tối để đóng Popup (Giống file stock.php)
        document.getElementById('approveOverlay').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
        document.getElementById('cancelOverlay').addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    </script>
</div>