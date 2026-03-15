<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-chart-line"></i> Thống kê doanh thu</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="row g-2 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Từ ngày <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="from_date"
                        value="<?php echo $from_date; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Đến ngày <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="to_date"
                        value="<?php echo $to_date; ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-chart-bar"></i> Xem thống kê</button>
                </div>
            </form>

            <?php if (empty($revenue)): ?>
                <div class="alert alert-info">Không tìm thấy dữ liệu thống kê.</div>
            <?php else: ?>
            <?php
                $totalRevenue  = array_sum(array_column($revenue, 'doanhThu'));
                $totalInvoices = array_sum(array_column($revenue, 'soHoaDon'));
            ?>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h6>Tổng doanh thu</h6>
                            <h4><?php echo formatCurrency($totalRevenue); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h6>Tổng hóa đơn</h6>
                            <h4><?php echo $totalInvoices; ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h6>TB/hóa đơn</h6>
                            <h4><?php echo $totalInvoices > 0 ? formatCurrency($totalRevenue / $totalInvoices) : '0đ'; ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Ngày</th>
                        <th class="text-end">Số hóa đơn</th>
                        <th class="text-end">Doanh thu</th>
                        <th class="text-end">Tiền giảm</th>
                        <th class="text-end">Thực thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($revenue as $r): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($r['ngay'])); ?></td>
                        <td class="text-end"><?php echo $r['soHoaDon']; ?></td>
                        <td class="text-end"><?php echo formatCurrency($r['doanhThu']); ?></td>
                        <td class="text-end text-danger"><?php echo formatCurrency($r['tienGiam']); ?></td>
                        <td class="text-end fw-bold text-success"><?php echo formatCurrency($r['thucThu']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
