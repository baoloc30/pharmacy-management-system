<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn <?php echo $invoice['maHoaDonCode'] ?? ''; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 10px; }
        th { background: #f5f5f5; }
        .total { text-align: right; font-weight: bold; font-size: 15px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
<div class="header">
    <h2>HỆ THỐNG NHÀ THUỐC PHARMACARE</h2>
    <h3>HÓA ĐƠN BÁN THUỐC</h3>
    <p>Mã HD: <strong><?php echo $invoice['maHoaDonCode'] ?? ''; ?></strong> |
       Ngày: <strong><?php echo date('d/m/Y H:i', strtotime($invoice['ngayLap'])); ?></strong></p>
    <p>Nhân viên: <strong><?php echo htmlspecialchars($invoice['tenNhanVien'] ?? ''); ?></strong> |
       Khách hàng: <strong><?php echo htmlspecialchars($invoice['hoTen'] ?? 'Khách lẻ'); ?></strong></p>
</div>

<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên thuốc</th>
            <th>ĐVT</th>
            <th>SL</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoice['items'] as $i => $item): ?>
        <tr>
            <td><?php echo $i + 1; ?></td>
            <td><?php echo htmlspecialchars($item['tenThuoc']); ?></td>
            <td><?php echo htmlspecialchars($item['donViTinh']); ?></td>
            <td><?php echo $item['soLuong']; ?></td>
            <td><?php echo number_format($item['donGia'], 0, ',', '.'); ?>đ</td>
            <td><?php echo number_format($item['thanhTien'], 0, ',', '.'); ?>đ</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="total">Tổng tiền:</td>
            <td class="total"><?php echo number_format($invoice['tongTien'], 0, ',', '.'); ?>đ</td>
        </tr>
        <?php if ($invoice['tienGiam'] > 0): ?>
        <tr>
            <td colspan="5" class="total">Giảm giá:</td>
            <td class="total">-<?php echo number_format($invoice['tienGiam'], 0, ',', '.'); ?>đ</td>
        </tr>
        <tr>
            <td colspan="5" class="total">Thanh toán:</td>
            <td class="total"><?php echo number_format($invoice['tongTien'] - $invoice['tienGiam'], 0, ',', '.'); ?>đ</td>
        </tr>
        <?php endif; ?>
    </tfoot>
</table>

<p style="margin-top:20px; text-align:center;">Cảm ơn quý khách! Hẹn gặp lại.</p>

<div class="no-print" style="text-align:center; margin-top:20px;">
    <button onclick="window.print()" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
        In hóa đơn
    </button>
    <button onclick="window.close()" style="padding:10px 20px; background:#6c757d; color:white; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">
        Đóng
    </button>
</div>
</body>
</html>
