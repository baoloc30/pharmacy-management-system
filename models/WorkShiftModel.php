<?php
require_once 'core/Model.php';

class WorkShiftModel extends Model {
    protected $table = 'lichlamviec';
    protected $primaryKey = 'maLich';

    public function getSchedule($fromDate, $toDate) {
        $sql = "SELECT l.*, n.hoTen 
                FROM lichlamviec l 
                JOIN nhanvien n ON l.maNhanVien = n.maNhanVien 
                WHERE l.ngayLam BETWEEN ? AND ? 
                ORDER BY l.ngayLam, l.caLam";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $fromDate, $toDate);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
}