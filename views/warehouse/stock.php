<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-boxes"></i> Cập nhật tồn kho</h5>
        </div>
        <div class="card-body">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="stockForm">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Mã</th>
                                <th>Tên thuốc</th>
                                <th>ĐVT</th>
                                <th>HSD</th>
                                <th>Tồn kho hiện tại</th>
                                <th>Số lượng mới</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($medicines as $m): ?>
                            <tr>
                                <td><?php echo $m['maThuoc']; ?></td>
                                <td><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
                                <td><?php echo htmlspecialchars($m['donViTinh']); ?></td>
                                <td class="<?php echo strtotime($m['hanSuDung']) < time() ? 'text-danger' : ''; ?>">
                                    <?php echo date('d/m/Y', strtotime($m['hanSuDung'])); ?>
                                </td>
                                <td class="<?php echo $m['soLuongTon'] <= 10 ? 'text-danger fw-bold' : ''; ?>">
                                    <?php echo $m['soLuongTon']; ?>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm qty-input"
                                        name="soLuong[<?php echo $m['maThuoc']; ?>]"
                                        placeholder="Nhập SL mới" min="0" style="width:120px;">
                                </td>
                                <td>
                                    <?php if ($m['trangThai'] == 'DangBan'): ?>
                                        <span class="badge bg-success">Đang bán</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ngừng KD</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex gap-2 justify-content-end mt-3">
                    <button type="button" class="btn btn-primary" onclick="confirmUpdate()">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal xác nhận -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Xác nhận cập nhật tồn kho</h5></div>
            <div class="modal-body" id="confirmBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('stockForm').submit()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmUpdate() {
    const inputs = document.querySelectorAll('.qty-input');
    let changes = [];
    let hasError = false;

    inputs.forEach(input => {
        if (input.value !== '') {
            const val = parseInt(input.value);
            if (isNaN(val) || val < 0 || !Number.isInteger(val)) {
                hasError = true;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
                const row = input.closest('tr');
                const name = row.cells[1].textContent.trim();
                const old = row.cells[4].textContent.trim();
                changes.push(`<li>${name}: ${old} &rarr; <strong>${val}</strong></li>`);
            }
        }
    });

    if (hasError) {
        alert('Số lượng không hợp lệ, vui lòng chọn lại');
        return;
    }
    if (changes.length === 0) {
        alert('Vui lòng nhập ít nhất một số lượng mới');
        return;
    }

    document.getElementById('confirmBody').innerHTML = '<p>Các thuốc sẽ thay đổi số lượng tồn kho:</p><ul>' + changes.join('') + '</ul>';
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}
</script>
