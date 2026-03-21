<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-users"></i> Quản lý khách hàng</h5>
            <a href="<?php echo BASE_URL; ?>customer/add" class="btn btn-primary btn-sm">
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
</div>