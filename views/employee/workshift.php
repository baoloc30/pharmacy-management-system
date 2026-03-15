<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt"></i> Lịch làm việc nhân viên</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="" class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" name="from_date" value="<?php echo $from_date; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" name="to_date" value="<?php echo $to_date; ?>">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                        </div>
                    </form>

                    <?php if (empty($schedule)): ?>
                        <div class="alert alert-info">Không có lịch làm việc trong khoảng thời gian này.</div>
                    <?php else: ?>
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Nhân viên</th>
                                <th>Ngày làm</th>
                                <th>Ca làm</th>
                                <th>Giờ bắt đầu</th>
                                <th>Giờ kết thúc</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($schedule as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['hoTen']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($s['ngayLam'])); ?></td>
                                <td>
                                    <?php if ($s['caLam'] == 'TangCa'): ?>
                                        <span class="badge bg-warning text-dark">Tăng ca</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Sáng chiều</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $s['gioBatDau']; ?></td>
                                <td><?php echo $s['gioKetThuc']; ?></td>
                                <td><?php echo htmlspecialchars($s['ghiChu'] ?? ''); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning">
                    <h6><i class="fas fa-plus"></i> Phân công tăng ca (18h - 22h)</h6>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="" id="shiftForm">
                        <div class="mb-3">
                            <label class="form-label">Nhân viên <span class="text-danger">*</span></label>
                            <select class="form-control" name="maNhanVien" id="maNhanVien" required>
                                <option value="">-- Chọn nhân viên --</option>
                                <?php foreach ($employees as $emp): ?>
                                <option value="<?php echo $emp['maNhanVien']; ?>">
                                    <?php echo htmlspecialchars($emp['hoTen']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày tăng ca <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="ngayLam" id="ngayLam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ bắt đầu <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="gioBatDau" id="gioBatDau" value="18:00" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giờ kết thúc <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="gioKetThuc" id="gioKetThuc" value="22:00" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú</label>
                            <input type="text" class="form-control" name="ghiChu">
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-save"></i> Xác nhận phân công
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('shiftForm').addEventListener('submit', function(e) {
    const nv = document.getElementById('maNhanVien').value;
    const ngay = document.getElementById('ngayLam').value;
    const gio1 = document.getElementById('gioBatDau').value;
    const gio2 = document.getElementById('gioKetThuc').value;
    if (!nv || !ngay || !gio1 || !gio2) {
        alert('Vui lòng chọn đầy đủ thông tin!');
        e.preventDefault();
    }
});
</script>
