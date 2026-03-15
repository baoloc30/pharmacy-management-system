<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-tag"></i> Cập nhật giá thuốc</h5>
        </div>
        <div class="card-body">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="priceForm">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Mã</th>
                                <th>Tên thuốc</th>
                                <th>Danh mục</th>
                                <th>ĐVT</th>
                                <th>Giá hiện tại</th>
                                <th>Giá mới</th>
                                <th>Tồn kho</th>
                                <th>HSD</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($medicines as $m): ?>
                            <tr>
                                <td><?php echo $m['maThuoc']; ?></td>
                                <td><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
                                <td><?php echo htmlspecialchars($m['tenDanhMuc']); ?></td>
                                <td><?php echo htmlspecialchars($m['donViTinh']); ?></td>
                                <td class="text-end"><?php echo formatCurrency($m['giaBan']); ?></td>
                                <td>
                                    <input type="number" class="form-control form-control-sm price-input"
                                        name="giaMoi[<?php echo $m['maThuoc']; ?>]"
                                        placeholder="Nhập giá mới" min="1" style="width:130px;">
                                </td>
                                <td><?php echo $m['soLuongTon']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($m['hanSuDung'])); ?></td>
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

<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận cập nhật giá</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="confirmBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Từ chối</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('priceForm').submit()">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmUpdate() {
    const inputs = document.querySelectorAll('.price-input');
    let changes = [], hasError = false;
    inputs.forEach(input => {
        if (input.value !== '') {
            const val = parseFloat(input.value);
            if (isNaN(val) || val <= 0) { hasError = true; input.classList.add('is-invalid'); }
            else {
                input.classList.remove('is-invalid');
                const row = input.closest('tr');
                changes.push(`<li>${row.cells[1].textContent.trim()}: ${row.cells[4].textContent.trim()} &rarr; <strong>${new Intl.NumberFormat('vi-VN').format(val)}đ</strong></li>`);
            }
        }
    });
    if (hasError) { alert('Giá không hợp lệ, vui lòng chọn lại!'); return; }
    if (changes.length === 0) { alert('Vui lòng nhập ít nhất một giá mới'); return; }
    document.getElementById('confirmBody').innerHTML = '<p>Các thuốc sẽ thay đổi giá:</p><ul>' + changes.join('') + '</ul>';
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}
</script>
