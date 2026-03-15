<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-fire"></i> Thống kê thuốc bán chạy</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="row g-2 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Tháng <span class="text-danger">*</span></label>
                    <select class="form-control" name="month" required>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $month == $i ? 'selected' : ''; ?>>
                            Tháng <?php echo $i; ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Năm <span class="text-danger">*</span></label>
                    <select class="form-control" name="year" required>
                        <?php for ($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
                        <option value="<?php echo $y; ?>" <?php echo $year == $y ? 'selected' : ''; ?>>
                            <?php echo $y; ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-chart-bar"></i> Xem thống kê</button>
                </div>
            </form>

            <?php if (empty($medicines)): ?>
                <div class="alert alert-info">Không tìm thấy dữ liệu thống kê.</div>
            <?php else: ?>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã thuốc</th>
                        <th>Tên thuốc</th>
                        <th>ĐVT</th>
                        <th class="text-end">Số lượng đã bán</th>
                        <th class="text-end">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicines as $i => $m): ?>
                    <tr>
                        <td>
                            <?php if ($i == 0): ?>
                                <span class="badge bg-warning text-dark"><i class="fas fa-trophy"></i> 1</span>
                            <?php elseif ($i == 1): ?>
                                <span class="badge bg-secondary">2</span>
                            <?php elseif ($i == 2): ?>
                                <span class="badge bg-danger">3</span>
                            <?php else: ?>
                                <?php echo $i + 1; ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $m['maThuoc']; ?></td>
                        <td><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
                        <td><?php echo htmlspecialchars($m['donViTinh']); ?></td>
                        <td class="text-end fw-bold"><?php echo number_format($m['soLuongBan']); ?></td>
                        <td class="text-end text-success"><?php echo formatCurrency($m['doanhThu']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
