<?php
require_once 'core/Model.php';

class StatisticModel extends Model {

    public function getRevenue($fromDate, $toDate) {
        $sql = "SELECT DATE(ngayLap) as ngay, COUNT(*) as soHoaDon, 
                       SUM(tongTien) as doanhThu, SUM(tienGiam) as tienGiam,
                       SUM(tongTien - tienGiam) as thucThu
                FROM hoadon 
                WHERE ngayLap BETWEEN ? AND ? 
                AND trangThai = 'DaThanhToan'
                GROUP BY DATE(ngayLap)
                ORDER BY ngayLap";
        $toDateEnd = $toDate . ' 23:59:59';
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $fromDate, $toDateEnd);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBestSelling($month, $year) {
        $sql = "SELECT t.maThuoc, t.tenThuoc, t.donViTinh, 
                       SUM(c.soLuong) as soLuongBan, 
                       SUM(c.thanhTien) as doanhThu
                FROM ct_hoadon c
                JOIN hoadon h ON c.maHoaDon = h.maHoaDon
                JOIN thuoc t ON c.maThuoc = t.maThuoc
                WHERE MONTH(h.ngayLap) = ? AND YEAR(h.ngayLap) = ?
                AND h.trangThai = 'DaThanhToan'
                GROUP BY t.maThuoc
                ORDER BY soLuongBan DESC
                LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}