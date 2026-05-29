<?php
require_once 'core/Model.php';

class HomeModel extends Model {
    
    // 1. Tổng số lượng thuốc
    public function getTotalMedicine() {
        $sql = "SELECT COUNT(*) as total FROM thuoc";
        $result = $this->db->query($sql);
        return $result ? (int)$result->fetch_assoc()['total'] : 0;
    }

    // 2. Doanh thu hôm nay
    public function getTodayRevenue($idTaiKhoan = null) {
        if ($idTaiKhoan) {
            $sql = "SELECT SUM(h.tongTien) as total 
                    FROM hoadon h
                    JOIN taikhoan t ON h.maNhanVien = t.maNhanVien
                    WHERE h.trangThai = 'DaThanhToan' 
                    AND DATE(h.ngayLap) = CURDATE() 
                    AND t.idTaiKhoan = ?";
            $stmt = $this->db->prepare($sql);
            if (!$stmt) return 0;
            $stmt->bind_param("i", $idTaiKhoan);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            return ($row && $row['total']) ? (float)$row['total'] : 0;
        } else {
            $sql = "SELECT SUM(tongTien) as total 
                    FROM hoadon 
                    WHERE trangThai = 'DaThanhToan' 
                    AND DATE(ngayLap) = CURDATE()";
            $result = $this->db->query($sql);
            $row = $result ? $result->fetch_assoc() : null;
            return ($row && $row['total']) ? (float)$row['total'] : 0;
        }
    }

    // 3. Số hóa đơn bán được hôm nay
    public function getTodayInvoices($idTaiKhoan = null) {
        if ($idTaiKhoan) {
            $sql = "SELECT COUNT(*) as total 
                    FROM hoadon h
                    JOIN taikhoan t ON h.maNhanVien = t.maNhanVien
                    WHERE h.trangThai = 'DaThanhToan' 
                    AND DATE(h.ngayLap) = CURDATE() 
                    AND t.idTaiKhoan = ?";
            $stmt = $this->db->prepare($sql);
            if (!$stmt) return 0;
            $stmt->bind_param("i", $idTaiKhoan);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            return $row ? (int)$row['total'] : 0;
        } else {
            $sql = "SELECT COUNT(*) as total 
                    FROM hoadon 
                    WHERE trangThai = 'DaThanhToan' 
                    AND DATE(ngayLap) = CURDATE()";
            $result = $this->db->query($sql);
            return $result ? (int)$result->fetch_assoc()['total'] : 0;
        }
    }

    // 4. Thuốc sắp hết
    public function getLowStockCount() {
        $sql = "SELECT COUNT(*) as total FROM thuoc WHERE soLuongTon <= 10";
        $result = $this->db->query($sql);
        return $result ? (int)$result->fetch_assoc()['total'] : 0;
    }

    // 5. Thuốc sắp hết hạn
    public function getExpiringSoonCount() {
        $sql = "SELECT COUNT(*) as total FROM thuoc WHERE hanSuDung <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
        $result = $this->db->query($sql);
        return $result ? (int)$result->fetch_assoc()['total'] : 0;
    }
}