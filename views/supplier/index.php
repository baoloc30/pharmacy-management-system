<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-truck"></i> Danh sách nhà cung cấp</h5>
            <a href="<?php echo BASE_URL; ?>supplier/add" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm NCC
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Tìm theo tên, SĐT, địa chỉ..."
                        value="<?php echo htmlspecialchars($search ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm</button>
                </div>
            </form>

            <?php if (empty($suppliers)): ?>
                <div class="alert alert-info">Không tìm thấy nhà cung cấp phù hợp với tiêu chí trên.</div>
            <?php else: ?>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã NCC</th>
                        <th>Tên nhà cung cấp</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Người liên hệ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $s): ?>
                    <tr>
                        <td><?php echo $s['maNhaCC']; ?></td>
                        <td><?php echo htmlspecialchars($s['tenNhaCC']); ?></td>
                        <td><?php echo htmlspecialchars($s['diaChi'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($s['soDienThoai'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($s['email'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($s['nguoiLienHe'] ?? ''); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>supplier/edit/<?php echo $s['maNhaCC']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
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
