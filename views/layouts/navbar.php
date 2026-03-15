<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-clinic-medical"></i> HỆ THỐNG NHÀ THUỐC PHARMACARE
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> 
                        <?php echo Session::get('nhan_vien_name'); ?>
                        (<?php echo Session::get('role'); ?>)
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/profile"><i class="fas fa-id-card"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>auth/changePassword"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal xác nhận đăng xuất -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Xác nhận đăng xuất</h6></div>
            <div class="modal-body">Bạn có chắc chắn muốn đăng xuất không?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Hủy bỏ</button>
                <a href="<?php echo BASE_URL; ?>auth/logout?confirm=1" class="btn btn-danger btn-sm">Đồng ý</a>
            </div>
        </div>
    </div>
</div>
<script>
function confirmLogout() {
    new bootstrap.Modal(document.getElementById('logoutModal')).show();
}
</script>
