<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-list" style="color:#fff;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Quản lý danh mục thuốc</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Phân loại và quản lý danh mục</div>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>category/add"
           style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 2px 8px rgba(21,128,61,.35);">
            <i class="fas fa-plus"></i> Thêm danh mục
        </a>
    </div>

    <?php
        $toastMsg = ''; $toastType = 'success'; $toastIcon = 'fa-check'; $toastColors = ['#34d399', '#10b981']; 

        if (isset($_SESSION['success'])) {
            $toastMsg = $_SESSION['success']; unset($_SESSION['success']);
        } elseif (isset($_SESSION['warning'])) { 
            $toastMsg = $_SESSION['warning']; $toastType = 'warning'; $toastIcon = 'fa-exclamation-triangle'; $toastColors = ['#fcd34d', '#f59e0b']; unset($_SESSION['warning']);
        } elseif (isset($_SESSION['error'])) { 
            $toastMsg = $_SESSION['error']; $toastType = 'error'; $toastIcon = 'fa-times-circle'; $toastColors = ['#f87171', '#ef4444']; unset($_SESSION['error']);
        }

        if ($toastMsg !== ''):
        ?>
        <style>
            .glass-toast-cat { position: fixed; top: 64px; right: 24px; width: max-content; max-width: 420px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 16px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); padding: 18px 24px; display: flex; align-items: flex-start; gap: 16px; z-index: 9999999; font-family: 'Inter', sans-serif; transform: translateX(120%); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); overflow: hidden; }
            .glass-toast-cat.show { transform: translateX(0); }
            .toast-icon-wrapper-cat { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, <?php echo $toastColors[0]; ?>, <?php echo $toastColors[1]; ?>); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
            .toast-icon-wrapper-cat i { color: #ffffff; font-size: 16px; }
            .toast-text-title-cat { font-size: 15px; font-weight: 800; color: #1f2937; }
            .toast-text-msg-cat { font-size: 13.5px; color: #4b5563; margin-top: 4px; }
            .toast-progress-cat { position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, <?php echo $toastColors[0]; ?>, <?php echo $toastColors[1]; ?>); width: 100%; transform-origin: left; animation: progressShrinkCat 4s linear forwards; }
            @keyframes progressShrinkCat { 0% { transform: scaleX(1); } 100% { transform: scaleX(0); } }
        </style>
        <div id="catToast" class="glass-toast-cat">
            <div class="toast-icon-wrapper-cat"><i class="fas <?php echo $toastIcon; ?>"></i></div>
            <div>
                <div class="toast-text-title-cat">
                    <?php echo $toastType == 'success' ? 'Thành công!' : ($toastType == 'warning' ? 'Lưu ý' : 'Lỗi hệ thống'); ?>
                </div>
                <div class="toast-text-msg-cat"><?php echo $toastMsg; ?></div>
            </div>
            <div class="toast-progress-cat"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('catToast');
                if (toast) {
                    setTimeout(() => toast.classList.add('show'), 150);
                    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 600); }, 4000);
                }
            });
        </script>
    <?php endif; ?>

    <div style="padding:16px 24px 24px;">
        <?php if (empty($categories)): ?>
        <div style="padding:32px;text-align:center;color:#64748b;font-size:14px;">
            <i class="fas fa-list" style="font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block;"></i>
            Không có danh mục nào.
        </div>
        <?php else: ?>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Mã</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Tên danh mục</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Mô tả</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Trạng thái</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Ngày tạo</th>
                        <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:center;font-size:11px;letter-spacing:.4px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $i => $cat): ?>
                    <tr style="background:<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>;transition:background .15s;"
                        onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>'">
                        <td style="padding:10px 14px;color:#64748b;"><?php echo $cat['maDanhMuc']; ?></td>
                        <td style="padding:10px 14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($cat['tenDanhMuc']); ?></td>
                        <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($cat['moTa'] ?? ''); ?></td>
                        <td style="padding:10px 14px;">
                            <?php if ($cat['trangThai'] == 'SuDung'): ?>
                            <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;">
                                <i class="fas fa-circle" style="font-size:7px;"></i> Đang dùng
                            </span>
                            <?php else: ?>
                            <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;">
                                <i class="fas fa-circle" style="font-size:7px;"></i> Ngừng dùng
                            </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding:10px 14px;color:#475569;"><?php echo date('d/m/Y', strtotime($cat['ngayTao'])); ?></td>
                        <td style="padding:10px 14px;text-align:center;white-space:nowrap;">
                            <a href="<?php echo BASE_URL; ?>category/edit/<?php echo $cat['maDanhMuc']; ?>"
                               style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fefce8;color:#ca8a04;border:1px solid #fde68a;text-decoration:none;margin-right:3px;" title="Chỉnh sửa">
                                <i class="fas fa-edit" style="font-size:12px;"></i>
                            </a>
                            <button onclick="confirmDelete(<?php echo $cat['maDanhMuc']; ?>, '<?php echo htmlspecialchars($cat['tenDanhMuc']); ?>')"
                                    style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;cursor:pointer;" title="Xóa">
                                <i class="fas fa-trash" style="font-size:12px;"></i>
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
</div>

<!-- Overlay xác nhận xóa -->
<div id="deleteOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;box-shadow:0 8px 40px rgba(0,0,0,.2);width:100%;max-width:420px;overflow:hidden;">
        <div style="padding:16px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:10px;">
            <i class="fas fa-trash" style="color:#fff;"></i>
            <span style="font-size:15px;font-weight:700;color:#fff;">Xác nhận xóa danh mục</span>
        </div>
        <div style="padding:20px 24px;">
            <p id="deleteMsg" style="color:#374151;font-size:14px;margin:0;"></p>
        </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;">
            <button onclick="document.getElementById('deleteOverlay').style.display='none'"
                    style="padding:9px 20px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;">
                Hủy
            </button>
            <a id="deleteConfirmBtn" href="#"
               style="padding:9px 20px;border-radius:9px;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i class="fas fa-trash"></i> Xác nhận
            </a>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteMsg').textContent = 'Bạn có chắc chắn muốn xóa danh mục "' + name + '" không?';
    document.getElementById('deleteConfirmBtn').href = '<?php echo BASE_URL; ?>category/delete/' + id;
    document.getElementById('deleteOverlay').style.display = 'flex';
}
document.getElementById('deleteOverlay').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
