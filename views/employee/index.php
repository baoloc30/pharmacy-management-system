<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-users"></i> Quản lý tài khoản nhân viên</h5>
            <a href="<?php echo BASE_URL; ?>employee/add" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tạo tài khoản mới
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Tên đăng nhập</th>
                        <th>Vai trò</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $emp): ?>
                    <tr>
                        <td><?php echo $emp['maNhanVien']; ?></td>
                        <td><?php echo htmlspecialchars($emp['hoTen']); ?></td>
                        <td><?php echo htmlspecialchars($emp['tenDangNhap']); ?></td>
                        <td>
                            <?php if ($emp['vaiTro'] == 'QuanLy'): ?>
                                <span class="badge bg-primary">Quản lý</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Nhân viên</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($emp['soDienThoai'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($emp['email'] ?? ''); ?></td>
                        <td>
                            <?php if ($emp['trangThai'] == 'HoatDong'): ?>
                                <span class="badge bg-success">Hoạt động</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Bị khóa</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>employee/edit/<?php echo $emp['idTaiKhoan']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($emp['idTaiKhoan'] != Session::get('user_id') && $emp['trangThai'] == 'HoatDong'): ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $emp['idTaiKhoan']; ?>, '<?php echo htmlspecialchars($emp['hoTen']); ?>')">
                                <i class="fas fa-ban"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Xác nhận</h5></div>
            <div class="modal-body" id="deleteBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy thao tác</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Đồng ý</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteBody').textContent = 'Bạn có chắc chắn muốn vô hiệu hóa tài khoản của "' + name + '"?';
    document.getElementById('deleteConfirmBtn').href = '<?php echo BASE_URL; ?>employee/delete/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
