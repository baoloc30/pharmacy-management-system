<div class="container-fluid mt-3">
    <h4><i class="fas fa-tachometer-alt"></i> Dashboard Nhân Viên</h4>
    <hr>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Hóa đơn hôm nay</h6>
                        <h3>--</h3>
                    </div>
                    <i class="fas fa-receipt fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>sale/history" class="text-white">Xem lịch sử &rarr;</a></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Khách hàng</h6>
                        <h3>--</h3>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>customer/index" class="text-white">Quản lý KH &rarr;</a></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Thuốc có sẵn</h6>
                        <h3>--</h3>
                    </div>
                    <i class="fas fa-pills fa-2x opacity-75"></i>
                </div>
                <div class="card-footer"><a href="<?php echo BASE_URL; ?>medicine/index" class="text-white">Tra cứu thuốc &rarr;</a></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h6><i class="fas fa-bolt"></i> Truy cập nhanh</h6></div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo BASE_URL; ?>sale/create" class="btn btn-success btn-lg">
                            <i class="fas fa-cash-register"></i> Bán hàng
                        </a>
                        <a href="<?php echo BASE_URL; ?>customer/add" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus"></i> Thêm khách hàng
                        </a>
                        <a href="<?php echo BASE_URL; ?>medicine/index" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> Tra cứu thuốc
                        </a>
                        <a href="<?php echo BASE_URL; ?>sale/history" class="btn btn-outline-secondary">
                            <i class="fas fa-history"></i> Lịch sử bán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
