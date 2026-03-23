<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-users" style="color:#fff;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Quản lý khách hàng</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Danh sách và thông tin khách hàng</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <form method="GET" action="" style="display:flex;gap:0;">
                <input type="text" name="search" placeholder="Tìm theo tên hoặc SĐT..."
                       value="<?php echo htmlspecialchars($search ?? ''); ?>"
                       style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-right:none;border-radius:9px 0 0 9px;font-size:13px;background:rgba(255,255,255,.9);color:#1e293b;outline:none;width:220px;">
                <button type="submit"
                        style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-left:none;border-radius:0 9px 9px 0;background:rgba(255,255,255,.2);color:#fff;cursor:pointer;font-size:13px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a href="<?php echo BASE_URL; ?>customer/add"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 2px 8px rgba(21,128,61,.35);">
                <i class="fas fa-plus"></i> Thêm khách hàng
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
    <style>
        .glass-toast-cust { position: fixed; top: 64px; right: 24px; width: max-content; max-width: 420px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 16px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); padding: 18px 24px; display: flex; align-items: flex-start; gap: 16px; z-index: 9999999; font-family: 'Inter', sans-serif; transform: translateX(120%); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); overflow: hidden; }
        .glass-toast-cust.show { transform: translateX(0); }
        .toast-icon-wrapper-cust { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #34d399, #10b981); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35); }
        .toast-icon-wrapper-cust i { color: #ffffff; font-size: 18px; }
        .toast-text-title-cust { font-size: 15px; font-weight: 800; color: #1f2937; }
        .toast-text-msg-cust { font-size: 13.5px; color: #4b5563; margin-top: 4px; }
        .toast-progress-cust { position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, #34d399, #10b981); width: 100%; transform-origin: left; animation: progressShrinkCust 4s linear forwards; }
        @keyframes progressShrinkCust { 0% { transform: scaleX(1); } 100% { transform: scaleX(0); } }
    </style>
    <div id="custToast" class="glass-toast-cust">
        <div class="toast-icon-wrapper-cust"><i class="fas fa-check"></i></div>
        <div>
            <div class="toast-text-title-cust">Thành công!</div>
            <div class="toast-text-msg-cust"><?php echo $_SESSION['success']; ?></div>
        </div>
        <div class="toast-progress-cust"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('custToast');
            if (toast) {
                setTimeout(() => toast.classList.add('show'), 150);
                setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 600); }, 4000);
            }
        });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

    <div style="padding:16px 24px 24px;overflow-x:auto;">
        <?php if (empty($customers)): ?>
        <div style="padding:32px;text-align:center;color:#64748b;font-size:14px;">
            <i class="fas fa-users" style="font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block;"></i>
            Không tìm thấy khách hàng nào.
        </div>
        <?php else: ?>
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
            <thead>
                <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">STT</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Họ tên</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Số điện thoại</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Email</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Địa chỉ</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:right;font-size:11px;letter-spacing:.4px;">Tổng chi tiêu</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:center;font-size:11px;letter-spacing:.4px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($customers as $key => $customer): ?>
                <tr style="background:<?php echo $key % 2 === 0 ? '#fff' : '#f0f7ff'; ?>;transition:background .15s;"
                    onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $key % 2 === 0 ? '#fff' : '#f0f7ff'; ?>'">
                    <td style="padding:10px 14px;color:#64748b;"><?php echo $key + 1; ?></td>
                    <td style="padding:10px 14px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0;">
                                <?php echo mb_strtoupper(mb_substr($customer['hoTen'], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                            </div>
                            <span style="font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($customer['hoTen']); ?></span>
                        </div>
                    </td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($customer['soDienThoai']); ?></td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($customer['email'] ?? ''); ?></td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($customer['diaChi'] ?? ''); ?></td>
                    <td style="padding:10px 14px;text-align:right;font-weight:700;color:#1d4ed8;"><?php echo formatCurrency($customer['tongChiTieu']); ?></td>
                    <td style="padding:10px 14px;text-align:center;white-space:nowrap;">
                        <a href="<?php echo BASE_URL; ?>customer/history/<?php echo $customer['maKhachHang']; ?>"
                           style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;text-decoration:none;margin-right:3px;" title="Lịch sử mua hàng">
                            <i class="fas fa-history" style="font-size:12px;"></i>
                        </a>
                        <a href="<?php echo BASE_URL; ?>customer/edit/<?php echo $customer['maKhachHang']; ?>"
                           style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fefce8;color:#ca8a04;border:1px solid #fde68a;text-decoration:none;" title="Chỉnh sửa">
                            <i class="fas fa-edit" style="font-size:12px;"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</div>