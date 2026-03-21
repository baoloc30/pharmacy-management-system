<div class="container mt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-eye"></i> Chi tiết thuốc</h5>
            <a href="<?php echo BASE_URL; ?>medicine/index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            
            <?php if (isset($data['error']) || isset($error)): ?>
                <div class="alert alert-danger" id="serverAlert">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <?php echo isset($data['error']) ? $data['error'] : $error; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($medicine)): ?>
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <?php if (!empty($medicine['hinhAnh'])): ?>
                        <img src="<?php echo BASE_URL . 'uploads/medicines/' . $medicine['hinhAnh']; ?>"
                             class="img-fluid rounded" style="max-height:200px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" alt="Hình thuốc">
                    <?php else: ?>
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:200px; border: 2px dashed #dee2e6;">
                            <i class="fas fa-image fa-4x text-muted mb-2"></i>
                            <span class="d-block text-muted small mt-2">Chưa có hình ảnh</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr><th width="40%">Mã thuốc</th><td><?php echo $medicine['maThuoc']; ?></td></tr>
                        <tr><th>Tên thuốc</th><td><strong><?php echo htmlspecialchars($medicine['tenThuoc']); ?></strong></td></tr>
                        <tr><th>Danh mục</th><td><?php echo htmlspecialchars($medicine['tenDanhMuc']); ?></td></tr>
                        <tr><th>Đơn vị tính</th><td><?php echo htmlspecialchars($medicine['donViTinh']); ?></td></tr>
                        <tr><th>Giá bán</th><td class="text-primary fw-bold"><?php echo formatCurrency($medicine['giaBan']); ?></td></tr>
                        <tr><th>Số lượng tồn</th>
                            <td class="<?php echo $medicine['soLuongTon'] <= 10 ? 'text-danger fw-bold' : 'text-success fw-bold'; ?>">
                                <?php echo $medicine['soLuongTon']; ?>
                            </td>
                        </tr>
                        <tr><th>Hạn sử dụng</th>
                            <td class="<?php echo strtotime($medicine['hanSuDung']) < time() ? 'text-danger fw-bold' : ''; ?>">
                                <?php echo date('d/m/Y', strtotime($medicine['hanSuDung'])); ?>
                            </td>
                        </tr>
                        <tr><th>Xuất xứ</th><td><?php echo htmlspecialchars($medicine['xuatXu'] ?? '--'); ?></td></tr>
                        <tr><th>Trạng thái</th>
                            <td>
                                <?php if ($medicine['trangThai'] == 'DangBan'): ?>
                                    <span class="badge bg-success">Đang bán</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Ngừng bán</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <?php if (!empty($medicine['thanhPhan'])): ?>
                <div class="col-12 mt-2">
                    <h6 class="fw-bold"><i class="fas fa-flask text-info"></i> Thành phần:</h6>
                    <p class="text-muted bg-light p-2 rounded"><?php echo nl2br(htmlspecialchars($medicine['thanhPhan'])); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($medicine['congDung'])): ?>
                <div class="col-12 mt-2">
                    <h6 class="fw-bold"><i class="fas fa-heartbeat text-danger"></i> Công dụng:</h6>
                    <p class="text-muted bg-light p-2 rounded"><?php echo nl2br(htmlspecialchars($medicine['congDung'])); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($medicine['cachDung'])): ?>
                <div class="col-12 mt-2">
                    <h6 class="fw-bold"><i class="fas fa-clipboard-list text-warning"></i> Cách dùng:</h6>
                    <p class="text-muted bg-light p-2 rounded"><?php echo nl2br(htmlspecialchars($medicine['cachDung'])); ?></p>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if (Session::get('role') == 'QuanLy'): ?>
            <div class="d-flex gap-2 mt-4 border-top pt-3">
                <a href="<?php echo BASE_URL; ?>medicine/edit/<?php echo $medicine['maThuoc']; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                </a>
            </div>
            <?php endif; ?>
            
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serverAlert = document.getElementById('serverAlert');
    if (serverAlert) {
        setTimeout(function() {
            serverAlert.style.transition = 'opacity 0.5s ease';
            serverAlert.style.opacity = '0';
            setTimeout(function() {
                serverAlert.style.display = 'none';
            }, 500);
        }, 3000);
    }
});
</script>