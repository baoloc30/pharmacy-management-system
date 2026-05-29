<?php
require_once 'core/Model.php';

class WorkShiftModel extends Model {
    protected $table = 'lichlamviec';
    protected $primaryKey = 'maLich';

    // Mapping ca làm → tên hiển thị trong lichLamViec
    private $caLabel = [
        'Sang'   => 'Sáng 7:30-12:00',
        'Chieu'  => 'Chiều 13:00-17:00',
        'TangCa' => 'Tăng ca 18:00-22:00',
    ];

    public function getSchedule($fromDate, $toDate) {
        $sql = "SELECT l.*, n.hoTen 
                FROM lichlamviec l 
                JOIN nhanvien n ON l.maNhanVien = n.maNhanVien 
                WHERE l.ngayLam BETWEEN ? AND ? 
                ORDER BY l.ngayLam, FIELD(l.caLam,'Sang','Chieu','TangCa')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $fromDate, $toDate);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getShiftById($maLich) {
        $sql  = "SELECT * FROM lichlamviec WHERE maLich = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $maLich);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function assignShift($data) {
        try {
            $sql = "INSERT INTO lichlamviec (maNhanVien, ngayLam, caLam, gioBatDau, gioKetThuc, ghiChu) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $ghiChu = $data['ghiChu'] ?? '';
            $stmt->bind_param("isssss", 
                $data['maNhanVien'], $data['ngayLam'], $data['caLam'],
                $data['gioBatDau'], $data['gioKetThuc'], $ghiChu
            );
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteShift($maLich) {
        try {
            $sql  = "DELETE FROM lichlamviec WHERE maLich = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $maLich);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cập nhật cột lichLamViec trong bảng nhanvien
     * dựa trên các ca còn lại trong 14 ngày tới của nhân viên đó.
     */
    public function updateEmployeeLichLamViec($maNhanVien) {
        try {
            $today = date('Y-m-d');
            $next  = date('Y-m-d', strtotime('+14 days'));

            $sql  = "SELECT DISTINCT caLam FROM lichlamviec 
                     WHERE maNhanVien = ? AND ngayLam BETWEEN ? AND ?
                     ORDER BY FIELD(caLam,'Sang','Chieu','TangCa')";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("iss", $maNhanVien, $today, $next);
            $stmt->execute();
            $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $parts = [];
            foreach ($rows as $row) {
                if (isset($this->caLabel[$row['caLam']])) {
                    $parts[] = $this->caLabel[$row['caLam']];
                }
            }
            $lichText = implode(', ', $parts); // rỗng nếu không có ca

            $sql2  = "UPDATE nhanvien SET lichLamViec = ? WHERE maNhanVien = ?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bind_param("si", $lichText, $maNhanVien);
            return $stmt2->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}