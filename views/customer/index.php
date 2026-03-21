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
        <?php if (isset($_SESSION['success'])): ?>
            <div class="toast-notification" id="toastSuccess">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
            
            <style>
                .toast-notification {
                    position: fixed; top: 20px; right: 20px; background: #ffffff;
                    border-left: 5px solid #48bb78; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                    padding: 16px 24px; border-radius: 8px; display: flex; align-items: center; gap: 12px;
                    z-index: 9999; transform: translateX(150%); transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                }
                .toast-notification.show { transform: translateX(0); }
                .toast-notification i { color: #48bb78; font-size: 24px; }
                .toast-notification span { color: #2d3748; font-weight: 500; font-size: 15px; }
            </style>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const toast = document.getElementById('toastSuccess');
                    if (toast) {
                        setTimeout(() => toast.classList.add('show'), 100);
                        setTimeout(() => {
                            toast.classList.remove('show');
                            setTimeout(() => toast.remove(), 400);
                        }, 3000);
                    }
                });
            </script>
        <?php endif; ?>
        <div class="card-body">
            <form method="GET" action="" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Tìm theo tên hoặc SĐT..."
                        value="<?php echo htmlspecialchars($search ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm</button>
                </div>
            </form>

            <?php if (empty($customers)): ?>
                <div class="alert alert-info">Không tìm thấy khách hàng nào.</div>
            <?php else: ?>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th class="text-end">Tổng chi tiêu</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($customers as $key => $customer): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo htmlspecialchars($customer['hoTen']); ?></td>
                        <td><?php echo htmlspecialchars($customer['soDienThoai']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['diaChi'] ?? ''); ?></td>
                        <td class="text-end"><?php echo formatCurrency($customer['tongChiTieu']); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>customer/edit/<?php echo $customer['maKhachHang']; ?>" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>customer/history/<?php echo $customer['maKhachHang']; ?>" class="btn btn-sm btn-info" title="Lịch sử mua hàng">
                                <i class="fas fa-history"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

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
