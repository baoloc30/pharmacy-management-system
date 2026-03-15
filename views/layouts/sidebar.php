<div class="sidebar">
    <div class="sidebar-header">
        <h5>Menu chức năng</h5>
    </div>
    <ul class="sidebar-menu">
        <?php if(Session::get('role') == 'QuanLy'): ?>
            <li><a href="<?php echo BASE_URL; ?>home/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="submenu">
                <a href="#"><i class="fas fa-pills"></i> Quản lý thuốc <i class="fas fa-chevron-down float-end"></i></a>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>medicine/index">Danh sách thuốc</a></li>
                    <li><a href="<?php echo BASE_URL; ?>medicine/add">Thêm thuốc mới</a></li>
                    <li><a href="<?php echo BASE_URL; ?>medicine/updatePrice">Cập nhật giá</a></li>
                    <li><a href="<?php echo BASE_URL; ?>category/index">Danh mục thuốc</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-warehouse"></i> Quản lý kho <i class="fas fa-chevron-down float-end"></i></a>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>warehouse/import">Tạo phiếu nhập kho</a></li>
                    <li><a href="<?php echo BASE_URL; ?>warehouse/updateStock">Cập nhật tồn kho</a></li>
                    <li><a href="<?php echo BASE_URL; ?>warehouse/history">Lịch sử nhập xuất</a></li>
                    <li><a href="<?php echo BASE_URL; ?>warehouse/alert">Cảnh báo thuốc</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-truck"></i> Nhà cung cấp <i class="fas fa-chevron-down float-end"></i></a>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>supplier/index">Danh sách NCC</a></li>
                    <li><a href="<?php echo BASE_URL; ?>supplier/add">Thêm NCC mới</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-chart-bar"></i> Thống kê <i class="fas fa-chevron-down float-end"></i></a>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>statistic/revenue">Doanh thu</a></li>
                    <li><a href="<?php echo BASE_URL; ?>statistic/bestSelling">Thuốc bán chạy</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-users"></i> Nhân viên <i class="fas fa-chevron-down float-end"></i></a>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>employee/index">Quản lý tài khoản</a></li>
                    <li><a href="<?php echo BASE_URL; ?>employee/workshift">Lịch làm việc</a></li>
                </ul>
            </li>
        <?php else: ?>
            <li><a href="<?php echo BASE_URL; ?>home/employee"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>sale/create"><i class="fas fa-cash-register"></i> Bán hàng</a></li>
            <li><a href="<?php echo BASE_URL; ?>sale/history"><i class="fas fa-receipt"></i> Danh sách hóa đơn</a></li>
            <li><a href="<?php echo BASE_URL; ?>medicine/index"><i class="fas fa-pills"></i> Tra cứu thuốc</a></li>
            <li class="submenu">
                <a href="#"><i class="fas fa-user-friends"></i> Khách hàng <i class="fas fa-chevron-down float-end"></i></a>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>customer/index">Danh sách KH</a></li>
                    <li><a href="<?php echo BASE_URL; ?>customer/add">Thêm KH mới</a></li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</div>