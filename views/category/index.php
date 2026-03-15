<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-list"></i> Quản lý danh mục thuốc</h5>
            <a href="<?php echo BASE_URL; ?>category/add" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm danh mục
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (empty($categories)): ?>
                <p class="text-center text-muted">Không có danh mục nào.</p>
            <?php else: ?>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?php echo $cat['maDanhMuc']; ?></td>
                        <td><?php echo htmlspecialchars($cat['tenDanhMuc']); ?></td>
                        <td><?php echo htmlspecialchars($cat['moTa'] ?? ''); ?></td>
                        <td>
                            <?php if ($cat['trangThai'] == 'SuDung'): ?>
                                <span class="badge bg-success">Đang dùng</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Ngừng dùng</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($cat['ngayTao'])); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>category/edit/<?php echo $cat['maDanhMuc']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $cat['maDanhMuc']; ?>, '<?php echo htmlspecialchars($cat['tenDanhMuc']); ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục "' + name + '" không?')) {
        window.location.href = '<?php echo BASE_URL; ?>category/delete/' + id;
    }
}
</script>
