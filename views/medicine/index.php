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

                <form method="GET" action="<?php echo BASE_URL; ?>medicine/search" id="searchMedForm" 
                  style="display:flex;align-items:center;background:#fff;border-radius:12px;padding:5px;box-shadow:0 6px 24px rgba(0,0,0,0.18);flex:1;max-width:600px;">
                
                    <div style="position:relative;display:flex;align-items:center;">
                        <i class="fas fa-layer-group" style="position:absolute;left:14px;color:#94a3b8;font-size:13px;pointer-events:none;"></i>
                        <select name="category_id" onchange="this.form.submit()" 
                                style="appearance:none;-webkit-appearance:none;padding:10px 32px 10px 38px;border:none;background:transparent;font-size:13px;font-weight:700;color:#374151;outline:none;cursor:pointer;width:175px;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;">
                            <option value="">Tất cả danh mục</option>
                            <?php if(isset($categories)) foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['maDanhMuc']; ?>" <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat['maDanhMuc']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['tenDanhMuc']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down" style="position:absolute;right:12px;color:#cbd5e1;font-size:11px;pointer-events:none;"></i>
                    </div>

                    <div style="width:1px;height:24px;background:#e2e8f0;margin:0 4px;"></div>

                    <div style="position:relative;flex:1;display:flex;align-items:center;">
                        <input type="text" name="keyword" id="searchKeyword" placeholder="Nhập mã, tên, thành phần..."
                            value="<?php echo htmlspecialchars($keyword ?? $_GET['keyword'] ?? ''); ?>"
                            style="width:100%;padding:10px 36px 10px 14px;border:none;background:transparent;font-size:13px;color:#1e293b;outline:none;">
                        
                        <?php if(!empty($_GET['keyword']) || !empty($_GET['category_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>medicine/index" 
                        style="position:absolute;right:10px;width:24px;height:24px;background:#fef2f2;color:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:12px;transition:all .2s;"
                        onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fef2f2'" title="Xóa bộ lọc">
                            <i class="fas fa-times"></i>
                        </a>
                        <?php endif; ?>
                    </div>

                    <button type="submit"
                            style="padding:10px 20px;border:none;border-radius:9px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;cursor:pointer;font-size:13px;font-weight:700;display:flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(37,99,235,.25);transition:transform .2s;"
                            onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fas fa-search"></i> <span>Tìm</span>
                    </button>
                </form>
            </div>
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
            .glass-toast-med { position: fixed; top: 84px; right: 24px; width: max-content; max-width: 420px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 16px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); padding: 18px 24px; display: flex; align-items: flex-start; gap: 16px; z-index: 9999999; font-family: 'Inter', sans-serif; transform: translateX(120%); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); overflow: hidden; }
            .glass-toast-med.show { transform: translateX(0); }
            .toast-icon-wrapper-med { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, <?php echo $toastColors[0]; ?>, <?php echo $toastColors[1]; ?>); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
            .toast-icon-wrapper-med i { color: #ffffff; font-size: 16px; }
            .toast-text-title-med { font-size: 15px; font-weight: 800; color: #1f2937; }
            .toast-text-msg-med { font-size: 13.5px; color: #4b5563; margin-top: 4px; }
            .toast-progress-med { position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, <?php echo $toastColors[0]; ?>, <?php echo $toastColors[1]; ?>); width: 100%; transform-origin: left; animation: progressShrinkMed 4s linear forwards; }
            @keyframes progressShrinkMed { 0% { transform: scaleX(1); } 100% { transform: scaleX(0); } }
        </style>
        <div id="medToast" class="glass-toast-med">
            <div class="toast-icon-wrapper-med"><i class="fas <?php echo $toastIcon; ?>"></i></div>
            <div>
                <div class="toast-text-title-med">
                    <?php echo $toastType == 'success' ? 'Thành công!' : ($toastType == 'warning' ? 'Lưu ý' : 'Lỗi hệ thống'); ?>
                </div>
                <div class="toast-text-msg-med"><?php echo $toastMsg; ?></div>
            </div>
            <div class="toast-progress-med"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('medToast');
                if (toast) {
                    setTimeout(() => toast.classList.add('show'), 150);
                    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 600); }, 4000);
                }
            });
        </script>
        <?php endif; ?>

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
