<div class="container-fluid mt-3">
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="fas fa-history"></i> Lịch sử mua hàng - <?php echo htmlspecialchars($customer['hoTen']); ?></h5>
            <a href="<?php echo BASE_URL; ?>customer/index" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
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
                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-filter"></i> Lọc</button>
                    <a href="<?php echo BASE_URL; ?>customer/history/<?php echo $customer['maKhachHang']; ?>" class="btn btn-secondary">Xóa lọc</a>
                </div>
            </form>

            <?php if (empty($invoices)): ?>
                <div class="alert alert-info">Khách hàng này chưa có lịch sử mua hàng.</div>
            <?php else: ?>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Ngày mua</th>
                        <th>Nhân viên</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $inv): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($inv['maHoaDonCode']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($inv['ngayLap'])); ?></td>
                        <td><?php echo htmlspecialchars($inv['tenNhanVien']); ?></td>
                        <td class="text-end"><?php echo formatCurrency($inv['tongTien']); ?></td>
                        <td><?php echo $inv['phuongThucThanhToan']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewDetail(<?php echo $inv['maHoaDon']; ?>)">
                                <i class="fas fa-eye"></i> Chi tiết
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

<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết hóa đơn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailBody">Đang tải...</div>
        </div>
    </div>
</div>

<script>
function viewDetail(id) {
    $('#detailBody').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</div>');
    new bootstrap.Modal(document.getElementById('detailModal')).show();
    $.get('<?php echo BASE_URL; ?>sale/detail/' + id, function(data) {
        let html = `<table class="table"><thead><tr><th>Tên thuốc</th><th>ĐVT</th><th>SL</th><th class="text-end">Đơn giá</th><th class="text-end">Thành tiền</th></tr></thead><tbody>`;
        data.items.forEach(item => {
            html += `<tr><td>${item.tenThuoc}</td><td>${item.donViTinh}</td><td>${item.soLuong}</td>
                     <td class="text-end">${fmt(item.donGia)}</td><td class="text-end">${fmt(item.thanhTien)}</td></tr>`;
        });
        html += `</tbody><tfoot><tr><td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                 <td class="text-end fw-bold text-danger">${fmt(data.tongTien)}</td></tr></tfoot></table>`;
        $('#detailBody').html(html);
    }, 'json');
}
function fmt(n) { return new Intl.NumberFormat('vi-VN').format(n) + 'đ'; }
</script>
