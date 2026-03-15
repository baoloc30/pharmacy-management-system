<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-history"></i> Lịch sử nhập xuất kho</h5>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-warning"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="GET" action="" class="row g-2 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" name="from_date" value="<?php echo $from_date ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" name="to_date" value="<?php echo $to_date ?? ''; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Loại giao dịch</label>
                    <select class="form-control" name="type">
                        <option value="">-- Tất cả --</option>
                        <option value="Nhap" <?php echo ($type ?? '') == 'Nhap' ? 'selected' : ''; ?>>Nhập kho</option>
                        <option value="Xuat" <?php echo ($type ?? '') == 'Xuat' ? 'selected' : ''; ?>>Xuất kho</option>
                        <option value="DieuChinh" <?php echo ($type ?? '') == 'DieuChinh' ? 'selected' : ''; ?>>Điều chỉnh</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-filter"></i> Lọc</button>
                    <a href="<?php echo BASE_URL; ?>warehouse/history" class="btn btn-secondary">Xóa lọc</a>
                </div>
            </form>

            <?php if (empty($history)): ?>
                <div class="alert alert-info">Không có giao dịch phù hợp với tiêu chí.</div>
            <?php else: ?>
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Ngày</th>
                        <th>Loại GD</th>
                        <th>Tên thuốc</th>
                        <th>Nhân viên</th>
                        <th class="text-end">SL</th>
                        <th class="text-end">Tồn trước</th>
                        <th class="text-end">Tồn sau</th>
                        <th>Loại chứng từ</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $h): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($h['ngayGiaoDich'])); ?></td>
                        <td>
                            <?php if ($h['loaiGiaoDich'] == 'Nhap'): ?>
                                <span class="badge bg-success">Nhập</span>
                            <?php elseif ($h['loaiGiaoDich'] == 'Xuat'): ?>
                                <span class="badge bg-danger">Xuất</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Điều chỉnh</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($h['tenThuoc']); ?></td>
                        <td><?php echo htmlspecialchars($h['tenNhanVien']); ?></td>
                        <td class="text-end"><?php echo $h['soLuong']; ?></td>
                        <td class="text-end"><?php echo $h['tonKhoTruoc']; ?></td>
                        <td class="text-end"><?php echo $h['tonKhoSau']; ?></td>
                        <td><?php echo $h['loaiChungTu']; ?></td>
                        <td><?php echo htmlspecialchars($h['ghiChu'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
