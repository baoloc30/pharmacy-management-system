<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-truck" style="color:#fff;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Danh sách nhà cung cấp</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Quản lý thông tin nhà cung cấp</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <form method="GET" action="" style="display:flex;gap:0;">
                <input type="text" name="search" placeholder="Tìm theo tên, SĐT, địa chỉ..."
                       value="<?php echo htmlspecialchars($search ?? ''); ?>"
                       style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-right:none;border-radius:9px 0 0 9px;font-size:13px;background:rgba(255,255,255,.9);color:#1e293b;outline:none;width:220px;">
                <button type="submit"
                        style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-left:none;border-radius:0 9px 9px 0;background:rgba(255,255,255,.2);color:#fff;cursor:pointer;font-size:13px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a href="<?php echo BASE_URL; ?>supplier/add"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 2px 8px rgba(21,128,61,.35);">
                <i class="fas fa-plus"></i> Thêm NCC
            </a>
        </div>
    </div>

    <div style="padding:16px 24px 24px;overflow-x:auto;">
        <?php if (empty($suppliers)): ?>
        <div style="padding:32px;text-align:center;color:#64748b;font-size:14px;">
            <i class="fas fa-truck" style="font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block;"></i>
            Không tìm thấy nhà cung cấp phù hợp.
        </div>
        <?php else: ?>
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
            <thead>
                <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;">Mã NCC</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;">Tên nhà cung cấp</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;">SĐT / Email</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;">Người liên hệ</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:center;font-size:11px;">Trạng thái</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:center;font-size:11px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $i => $s): ?>
                <tr style="background:<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>;transition:background .15s;"
                    onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>'">
                    <td style="padding:10px 14px;color:#64748b;font-weight:600;"><?php echo $s['maNhaCC']; ?></td>
                    <td style="padding:10px 14px;">
                        <div style="font-weight:700;color:#1e293b;"><?php echo htmlspecialchars($s['tenNhaCC']); ?></div>
                        <div style="font-size:11px;color:#64748b;margin-top:3px;"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($s['diaChi'] ?? '--'); ?></div>
                    </td>
                    <td style="padding:10px 14px;">
                        <div style="color:#1d4ed8;font-weight:600;"><i class="fas fa-phone-alt" style="font-size:10px;margin-right:4px;"></i><?php echo htmlspecialchars($s['soDienThoai']); ?></div>
                        <?php if(!empty($s['email'])): ?>
                        <div style="font-size:11px;color:#475569;margin-top:3px;"><i class="fas fa-envelope" style="font-size:10px;margin-right:4px;"></i><?php echo htmlspecialchars($s['email']); ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px 14px;color:#475569;font-weight:600;"><?php echo htmlspecialchars($s['nguoiLienHe'] ?? '--'); ?></td>
                    <td style="padding:10px 14px;text-align:center;">
                        <?php if($s['trangThai'] === 'HoatDong'): ?>
                            <span style="padding:4px 10px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;border-radius:20px;font-size:11px;font-weight:700;">Hoạt động</span>
                        <?php else: ?>
                            <span style="padding:4px 10px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:20px;font-size:11px;font-weight:700;">Ngừng GD</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px 14px;text-align:center;white-space:nowrap;">
                        <a href="<?php echo BASE_URL; ?>supplier/edit/<?php echo $s['maNhaCC']; ?>"
                           style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fefce8;color:#ca8a04;border:1px solid #fde68a;text-decoration:none;margin-right:5px;" title="Chỉnh sửa">
                            <i class="fas fa-edit" style="font-size:12px;"></i>
                        </a>
                        <button onclick="confirmDelete(<?php echo $s['maNhaCC']; ?>, '<?php echo htmlspecialchars(addslashes($s['tenNhaCC'])); ?>')"
                           style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;cursor:pointer;" title="Xóa">
                            <i class="fas fa-trash" style="font-size:12px;"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</div>

<div id="deleteOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;width:100%;max-width:400px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);transform:translateY(-20px);animation:slideDown 0.3s forwards;">
        <div style="padding:16px 24px;background:#fef2f2;border-bottom:1px solid #fee2e2;display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:32px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#dc2626;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <span style="font-size:15px;font-weight:800;color:#991b1b;">Xác nhận xóa</span>
        </div>
        <div style="padding:24px;">
            <p style="color:#374151;font-size:14px;margin:0;line-height:1.5;">Bạn có chắc chắn muốn xóa nhà cung cấp <strong id="deleteName" style="color:#111827;"></strong> không?</p>
            <p style="color:#64748b;font-size:12px;margin-top:8px;margin-bottom:0;"><i class="fas fa-info-circle"></i> Nếu NCC đã có giao dịch, hệ thống sẽ tự động chuyển sang trạng thái "Ngừng giao dịch" để bảo toàn dữ liệu.</p>
        </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;">
            <button onclick="document.getElementById('deleteOverlay').style.display='none'"
                    style="padding:8px 18px;border-radius:8px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;">Hủy bỏ</button>
            <a id="deleteConfirmBtn" href="#"
               style="padding:8px 18px;border-radius:8px;background:linear-gradient(135deg,#dc2626,#991b1b);color:#fff;border:none;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i class="fas fa-trash"></i> Đồng ý xóa
            </a>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteConfirmBtn').href = '<?php echo BASE_URL; ?>supplier/delete/' + id;
    document.getElementById('deleteOverlay').style.display = 'flex';
}
document.getElementById('deleteOverlay').addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; });

function showToast(message, type = 'success') {
    let container = document.getElementById('toast-container-sys');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container-sys';
        container.style.cssText = 'position:fixed; top:64px; right:24px; z-index:9999999; display:flex; flex-direction:column; gap:12px;';
        document.body.appendChild(container);
    }

    if (!document.getElementById('toast-styles-sys')) {
        const style = document.createElement('style');
        style.id = 'toast-styles-sys';
        style.innerHTML = `
            .glass-toast-sys { width: max-content; max-width: 420px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 16px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); padding: 18px 24px; display: flex; align-items: flex-start; gap: 16px; font-family: sans-serif; transform: translateX(120%); transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); overflow: hidden; position: relative; }
            .glass-toast-sys.show { transform: translateX(0); }
            .toast-icon-wrapper-sys { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
            .toast-icon-wrapper-sys i { color: #ffffff; font-size: 16px; }
            .toast-text-title-sys { font-size: 15px; font-weight: 800; color: #1f2937; }
            .toast-text-msg-sys { font-size: 13.5px; color: #4b5563; margin-top: 4px; }
            .toast-progress-sys { position: absolute; bottom: 0; left: 0; height: 4px; width: 100%; transform-origin: left; animation: progressShrinkSys 4s linear forwards; }
            @keyframes progressShrinkSys { 0% { transform: scaleX(1); } 100% { transform: scaleX(0); } }
        `;
        document.head.appendChild(style);
    }

    const toast = document.createElement('div');
    toast.className = 'glass-toast-sys';
    
    let title = type === 'success' ? 'Thành công!' : (type === 'warning' ? 'Lưu ý!' : 'Có lỗi xảy ra!');
    let icon = type === 'success' ? 'fa-check' : (type === 'warning' ? 'fa-exclamation-circle' : 'fa-exclamation-triangle');
    let colors = type === 'success' ? ['#34d399', '#10b981'] : (type === 'warning' ? ['#fbbf24', '#d97706'] : ['#f87171', '#ef4444']);
    
    toast.innerHTML = `
        <div class="toast-icon-wrapper-sys" style="background: linear-gradient(135deg, ${colors[0]}, ${colors[1]});">
            <i class="fas ${icon}"></i>
        </div>
        <div>
            <div class="toast-text-title-sys">${title}</div>
            <div class="toast-text-msg-sys">${message}</div>
        </div>
        <div class="toast-progress-sys" style="background: linear-gradient(90deg, ${colors[0]}, ${colors[1]});"></div>
    `;
    
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 50);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 600);
    }, 4000);
}
</script>

<?php 
if (isset($_SESSION['success'])) {
    echo "<script>document.addEventListener('DOMContentLoaded', () => showToast('{$_SESSION['success']}', 'success'));</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>document.addEventListener('DOMContentLoaded', () => showToast('{$_SESSION['error']}', 'error'));</script>";
    unset($_SESSION['error']);
}
if (isset($_SESSION['warning'])) {
    echo "<script>document.addEventListener('DOMContentLoaded', () => showToast('{$_SESSION['warning']}', 'warning'));</script>";
    unset($_SESSION['warning']);
}
?>