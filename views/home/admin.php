<div class="container-fluid mt-3">
    <h4><i class="fas fa-tachometer-alt"></i> Dashboard Quản Lý</h4>
    <hr>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Tổng thuốc</h6>
                        <h3 id="totalMedicine">--</h3>
                    </div>
                    <i class="fas fa-pills fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>medicine/index" class="text-white">Xem chi tiết &rarr;</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Doanh thu hôm nay</h6>
                        <h3 id="todayRevenue">--</h3>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>statistic/revenue" class="text-white">Xem thống kê &rarr;</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Thuốc sắp hết</h6>
                        <h3 id="lowStock">--</h3>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>warehouse/alert" class="text-white">Xem cảnh báo &rarr;</a></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Thuốc sắp hết hạn</h6>
                        <h3 id="expiringSoon">--</h3>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>warehouse/alert" class="text-white">Xem cảnh báo &rarr;</a></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h6><i class="fas fa-bolt"></i> Truy cập nhanh</h6></div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo BASE_URL; ?>medicine/add" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Thêm thuốc</a>
                        <a href="<?php echo BASE_URL; ?>warehouse/import" class="btn btn-outline-success"><i class="fas fa-warehouse"></i> Nhập kho</a>
                        <a href="<?php echo BASE_URL; ?>medicine/updatePrice" class="btn btn-outline-warning"><i class="fas fa-tag"></i> Cập nhật giá</a>
                        <a href="<?php echo BASE_URL; ?>employee/index" class="btn btn-outline-info"><i class="fas fa-users"></i> Nhân viên</a>
                        <a href="<?php echo BASE_URL; ?>statistic/revenue" class="btn btn-outline-dark"><i class="fas fa-chart-bar"></i> Thống kê</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h6><i class="fas fa-info-circle"></i> Thông tin hệ thống</h6></div>
                <div class="card-body">
                    <p><i class="fas fa-user"></i> Đăng nhập: <strong><?php echo Session::get('nhan_vien_name'); ?></strong></p>
                    <p><i class="fas fa-calendar"></i> Ngày: <strong><?php echo date('d/m/Y H:i'); ?></strong></p>
                    <p><i class="fas fa-shield-alt"></i> Vai trò: <strong>Quản lý</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
