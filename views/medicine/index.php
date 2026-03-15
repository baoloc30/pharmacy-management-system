<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-pills"></i> Danh sách thuốc</h5>
            <div class="d-flex gap-2">
                <?php if(isAdmin()): ?>
                    <a href="<?php echo BASE_URL; ?>medicine/add" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm thuốc
                    </a>
                <?php endif; ?>
                <form class="d-inline-flex" method="GET" action="<?php echo BASE_URL; ?>medicine/search">
                    <div class="input-group input-group-sm">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm thuốc..." value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['warning'])): ?>
                <div class="alert alert-warning"><?php echo $_SESSION['warning']; unset($_SESSION['warning']); ?></div>
            <?php endif; ?>

            <?php if (empty($medicines)): ?>
                <div class="alert alert-info">Không tìm thấy thuốc phù hợp.</div>
            <?php else: ?>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã</th>
                        <th>Tên thuốc</th>
                        <th>Danh mục</th>
                        <th>ĐVT</th>
                        <th class="text-end">Giá bán</th>
                        <th class="text-end">Tồn kho</th>
                        <th>HSD</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($medicines as $medicine): ?>
                    <tr>
                        <td><?php echo $medicine['maThuoc']; ?></td>
                        <td><?php echo htmlspecialchars($medicine['tenThuoc']); ?></td>
                        <td><?php echo htmlspecialchars($medicine['tenDanhMuc']); ?></td>
                        <td><?php echo htmlspecialchars($medicine['donViTinh']); ?></td>
                        <td class="text-end"><?php echo formatCurrency($medicine['giaBan']); ?></td>
                        <td class="text-end <?php echo $medicine['soLuongTon'] <= 10 ? 'text-danger fw-bold' : ''; ?>">
                            <?php echo $medicine['soLuongTon']; ?>
                        </td>
                        <td class="<?php echo strtotime($medicine['hanSuDung']) < time() ? 'text-danger fw-bold' : ''; ?>">
                            <?php echo date('d/m/Y', strtotime($medicine['hanSuDung'])); ?>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>medicine/detail/<?php echo $medicine['maThuoc']; ?>" class="btn btn-sm btn-info" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if(isAdmin()): ?>
                                <a href="<?php echo BASE_URL; ?>medicine/edit/<?php echo $medicine['maThuoc']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $medicine['maThuoc']; ?>, '<?php echo htmlspecialchars($medicine['tenThuoc']); ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Xác nhận xóa thuốc</h5></div>
            <div class="modal-body" id="deleteBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-danger">Đồng ý</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteBody').textContent = 'Bạn có chắc chắn muốn xóa thuốc "' + name + '" không?';
    document.getElementById('deleteConfirmBtn').href = '<?php echo BASE_URL; ?>medicine/delete/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>