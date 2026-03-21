<div class="content-wrapper">



<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
    <!-- Header -->
        <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-pills" style="color:#fff;font-size:18px;"></i>
                </div>
                <div>
                    <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Danh sách thuốc</div>
                    <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Quản lý toàn bộ danh mục thuốc</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <?php if(isAdmin()): ?>
                <a href="<?php echo BASE_URL; ?>medicine/add"
                   style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 2px 8px rgba(21,128,61,.35);">
                    <i class="fas fa-plus"></i> Thêm thuốc
                </a>
                <?php endif; ?>
                <form method="GET" action="<?php echo BASE_URL; ?>medicine/search" style="display:flex;gap:0;">
                    <input type="text" name="keyword" placeholder="Tìm kiếm thuốc..."
                           value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>"
                           style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-right:none;border-radius:9px 0 0 9px;font-size:13px;background:rgba(255,255,255,.9);color:#1e293b;outline:none;width:220px;">
                    <button type="submit"
                            style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-left:none;border-radius:0 9px 9px 0;background:rgba(255,255,255,.2);color:#fff;cursor:pointer;font-size:13px;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Alerts -->
        <div style="padding:0 24px;">
            <?php if (isset($_SESSION['success'])): ?>
            <div style="margin-top:14px;padding:11px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;color:#15803d;font-size:13px;font-weight:600;">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['warning'])): ?>
            <div style="margin-top:14px;padding:11px 16px;background:#fefce8;border:1.5px solid #fde68a;border-radius:9px;color:#ca8a04;font-size:13px;font-weight:600;">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $_SESSION['warning']; unset($_SESSION['warning']); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Table -->
        <div style="padding:16px 24px 24px;overflow-x:auto;">
            <?php if (empty($medicines)): ?>
            <div style="padding:32px;text-align:center;color:#64748b;font-size:14px;">
                <i class="fas fa-search" style="font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block;"></i>
                Không tìm thấy thuốc phù hợp.
            </div>
            <?php else: ?>
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">STT</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Tên thuốc</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Danh mục</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">ĐVT</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:right;font-size:11px;letter-spacing:.4px;">Giá bán</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:right;font-size:11px;letter-spacing:.4px;">Tồn kho</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">HSD</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:center;font-size:11px;letter-spacing:.4px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($medicines as $i => $medicine): ?>
                    <tr style="background:<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>;transition:background .15s;"
                        onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>'">
                        <td style="padding:10px 14px;color:#64748b;"><?php echo $i + 1; ?></td>
                        <td style="padding:10px 14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($medicine['tenThuoc']); ?></td>
                        <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($medicine['tenDanhMuc']); ?></td>
                        <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($medicine['donViTinh']); ?></td>
                        <td style="padding:10px 14px;text-align:right;font-weight:600;color:#1e293b;"><?php echo formatCurrency($medicine['giaBan']); ?></td>
                        <td style="padding:10px 14px;text-align:right;font-weight:700;color:<?php echo $medicine['soLuongTon'] <= 10 ? '#dc2626' : '#1e293b'; ?>;">
                            <?php echo $medicine['soLuongTon']; ?>
                        </td>
                        <td style="padding:10px 14px;color:<?php echo strtotime($medicine['hanSuDung']) < time() ? '#dc2626' : '#475569'; ?>;font-weight:<?php echo strtotime($medicine['hanSuDung']) < time() ? '700' : '400'; ?>;">
                            <?php echo date('d/m/Y', strtotime($medicine['hanSuDung'])); ?>
                        </td>
                        <td style="padding:10px 14px;text-align:center;white-space:nowrap;">
                            <a href="<?php echo BASE_URL; ?>medicine/detail/<?php echo $medicine['maThuoc']; ?>"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;text-decoration:none;margin-right:3px;" title="Xem chi tiết">
                                <i class="fas fa-eye" style="font-size:12px;"></i>
                            </a>
                            <?php if(isAdmin()): ?>
                            <a href="<?php echo BASE_URL; ?>medicine/edit/<?php echo $medicine['maThuoc']; ?>"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fefce8;color:#ca8a04;border:1px solid #fde68a;text-decoration:none;margin-right:3px;" title="Chỉnh sửa">
                                <i class="fas fa-edit" style="font-size:12px;"></i>
                            </a>
                            <button onclick="confirmDelete(<?php echo $medicine['maThuoc']; ?>, '<?php echo htmlspecialchars($medicine['tenThuoc']); ?>')"
                                    style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;cursor:pointer;" title="Xóa">
                                <i class="fas fa-trash" style="font-size:12px;"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Overlay xác nhận xóa -->
<div id="deleteOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;box-shadow:0 8px 40px rgba(0,0,0,.2);width:100%;max-width:420px;overflow:hidden;">
        <div style="padding:16px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:10px;">
            <i class="fas fa-trash" style="color:#fff;"></i>
            <span style="font-size:15px;font-weight:700;color:#fff;">Xác nhận xóa thuốc</span>
        </div>
        <div style="padding:20px 24px;">
            <p id="deleteMsg" style="color:#374151;font-size:14px;margin:0;"></p>
        </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;">
            <button onclick="document.getElementById('deleteOverlay').style.display='none'"
                    style="padding:9px 20px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;">
                Hủy bỏ
            </button>
            <a id="deleteConfirmBtn" href="#"
               style="padding:9px 20px;border-radius:9px;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i class="fas fa-trash"></i> Đồng ý xóa
            </a>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteMsg').textContent = 'Bạn có chắc chắn muốn xóa thuốc "' + name + '" không?';
    document.getElementById('deleteConfirmBtn').href = '<?php echo BASE_URL; ?>medicine/delete/' + id;
    document.getElementById('deleteOverlay').style.display = 'flex';
}
document.getElementById('deleteOverlay').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
