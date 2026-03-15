<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-users"></i> Quản lý khách hàng</h5>
            <a href="<?php echo BASE_URL; ?>customer/add" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm khách hàng
            </a>
        </div>
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