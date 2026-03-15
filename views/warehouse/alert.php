<div class="container-fluid mt-3">
    <!-- Cảnh báo tồn kho thấp -->
    <div class="card mb-3">
        <div class="card-header bg-warning">
            <h5><i class="fas fa-exclamation-triangle"></i> Thuốc sắp hết hàng (tồn kho ≤ 10)</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Tên thuốc</th>
                        <th>Danh mục</th>
                        <th>ĐVT</th>
                        <th>Tồn kho</th>
                        <th>HSD</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($low_stock)): ?>
                        <tr><td colspan="7" class="text-center text-success">Không có thuốc nào sắp hết hàng</td></tr>
                    <?php else: ?>
                        <?php foreach($low_stock as $item): ?>
                        <tr class="table-warning">
                            <td><?php echo $item['maThuoc']; ?></td>
                            <td><?php echo $item['tenThuoc']; ?></td>
                            <td><?php echo $item['tenDanhMuc']; ?></td>
                            <td><?php echo $item['donViTinh']; ?></td>
                            <td class="fw-bold text-danger"><?php echo $item['soLuongTon']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($item['hanSuDung'])); ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>medicine/detail/<?php echo $item['maThuoc']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Cảnh báo thuốc sắp hết hạn -->
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h5><i class="fas fa-clock"></i> Thuốc sắp hết hạn (30 ngày tới)</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Tên thuốc</th>
                        <th>Danh mục</th>
                        <th>ĐVT</th>
                        <th>Tồn kho</th>
                        <th>HSD</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($expired)): ?>
                        <tr><td colspan="7" class="text-center text-success">Không có thuốc nào sắp hết hạn</td></tr>
                    <?php else: ?>
                        <?php foreach($expired as $item): ?>
                        <tr class="table-danger">
                            <td><?php echo $item['maThuoc']; ?></td>
                            <td><?php echo $item['tenThuoc']; ?></td>
                            <td><?php echo $item['tenDanhMuc']; ?></td>
                            <td><?php echo $item['donViTinh']; ?></td>
                            <td><?php echo $item['soLuongTon']; ?></td>
                            <td class="fw-bold"><?php echo date('d/m/Y', strtotime($item['hanSuDung'])); ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>medicine/detail/<?php echo $item['maThuoc']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>