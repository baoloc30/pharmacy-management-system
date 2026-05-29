<?php
require_once 'core/Model.php';

class StatisticModel extends Model {

    // 1. Lấy tổng số lượng và doanh thu (CHỈ tính các thuốc thỏa mãn bộ lọc)
    public function getAggregatedRevenue($fromDate, $toDate, $filters = []) {
        $sql = "SELECT SUM(c.soLuong) as totalQuantity, SUM(c.thanhTien) as totalRevenue
                FROM ct_hoadon c
                JOIN hoadon h ON c.maHoaDon = h.maHoaDon
                JOIN thuoc t ON c.maThuoc = t.maThuoc
                WHERE h.trangThai = 'DaThanhToan' AND h.ngayLap BETWEEN ? AND ?";
        
        $toDateEnd = $toDate . ' 23:59:59';
        $params = [$fromDate, $toDateEnd];
        $types = "ss";

        if (!empty($filters['maNhanVien'])) { $sql .= " AND h.maNhanVien = ?"; $params[] = $filters['maNhanVien']; $types .= "s"; }
        if (!empty($filters['maThuoc'])) { $sql .= " AND c.maThuoc = ?"; $params[] = $filters['maThuoc']; $types .= "s"; }
        if (!empty($filters['tenThuoc'])) { $sql .= " AND t.tenThuoc LIKE ?"; $params[] = "%" . $filters['tenThuoc'] . "%"; $types .= "s"; }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return [
            'totalQuantity' => (int)$row['totalQuantity'],
            'totalRevenue'  => (float)$row['totalRevenue']
        ];
    }

    // 2. Lấy doanh thu theo ngày để vẽ biểu đồ
    public function getDailyRevenue($fromDate, $toDate, $filters = []) {
        $sql = "SELECT DATE(h.ngayLap) as ngay, SUM(c.thanhTien) as doanhThu
                FROM ct_hoadon c
                JOIN hoadon h ON c.maHoaDon = h.maHoaDon
                JOIN thuoc t ON c.maThuoc = t.maThuoc
                WHERE h.trangThai = 'DaThanhToan' AND h.ngayLap BETWEEN ? AND ?";
        
        $toDateEnd = $toDate . ' 23:59:59';
        $params = [$fromDate, $toDateEnd];
        $types = "ss";

        if (!empty($filters['maNhanVien'])) { $sql .= " AND h.maNhanVien = ?"; $params[] = $filters['maNhanVien']; $types .= "s"; }
        if (!empty($filters['maThuoc'])) { $sql .= " AND c.maThuoc = ?"; $params[] = $filters['maThuoc']; $types .= "s"; }
        if (!empty($filters['tenThuoc'])) { $sql .= " AND t.tenThuoc LIKE ?"; $params[] = "%" . $filters['tenThuoc'] . "%"; $types .= "s"; }

        $sql .= " GROUP BY DATE(h.ngayLap) ORDER BY DATE(h.ngayLap) ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 3. Lấy danh sách chi tiết bán hàng
    public function getRevenueDetails($fromDate, $toDate, $filters = []) {
        $select = "h.maHoaDon, h.ngayLap, h.maNhanVien, nv.hoTen as tenNhanVien, c.maThuoc, t.tenThuoc, c.soLuong, c.thanhTien as doanhThu";
        $data = $this->buildRevenueQuery($select, $fromDate, $toDate, $filters);
        
        $data['sql'] .= " ORDER BY h.ngayLap DESC, h.maHoaDon DESC";

        $stmt = $this->db->prepare($data['sql']);
        if($data['types']) $stmt->bind_param($data['types'], ...$data['params']);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Hàm phụ trợ: Xây dựng câu Query tìm chi tiết
    private function buildRevenueQuery($select, $fromDate, $toDate, $filters) {
        $sql = "SELECT $select 
                FROM ct_hoadon c 
                JOIN hoadon h ON c.maHoaDon = h.maHoaDon 
                JOIN thuoc t ON c.maThuoc = t.maThuoc 
                JOIN nhanvien nv ON h.maNhanVien = nv.maNhanVien
                WHERE h.trangThai = 'DaThanhToan' AND h.ngayLap BETWEEN ? AND ?";
        
        $params = [$fromDate, $toDate . ' 23:59:59'];
        $types = "ss";

        if (!empty($filters['maNhanVien'])) { $sql .= " AND h.maNhanVien = ?"; $params[] = $filters['maNhanVien']; $types .= "s"; }
        if (!empty($filters['maThuoc'])) { $sql .= " AND c.maThuoc = ?"; $params[] = $filters['maThuoc']; $types .= "s"; }
        if (!empty($filters['tenThuoc'])) { $sql .= " AND t.tenThuoc LIKE ?"; $params[] = "%" . $filters['tenThuoc'] . "%"; $types .= "s"; }
        
        return ['sql' => $sql, 'params' => $params, 'types' => $types];
    }

    public function getBestSelling($month, $year) {
        $sql = "SELECT t.maThuoc, t.tenThuoc, t.donViTinh, SUM(c.soLuong) as soLuongBan, SUM(c.thanhTien) as doanhThu
                FROM ct_hoadon c JOIN hoadon h ON c.maHoaDon = h.maHoaDon JOIN thuoc t ON c.maThuoc = t.maThuoc
                WHERE MONTH(h.ngayLap) = ? AND YEAR(h.ngayLap) = ? AND h.trangThai = 'DaThanhToan'
                GROUP BY t.maThuoc ORDER BY soLuongBan DESC LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}