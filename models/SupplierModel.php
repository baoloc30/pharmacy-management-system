<?php
require_once 'core/Model.php';

class SupplierModel extends Model {
    protected $table = 'nhacungcap';
    protected $primaryKey = 'maNhaCC';

    public function create($data) {
        $sql = "INSERT INTO nhacungcap (tenNhaCC, diaChi, soDienThoai, email, maSoThue, nguoiLienHe, ghiChu, trangThai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssss", 
            $data['tenNhaCC'], $data['diaChi'], $data['soDienThoai'], 
            $data['email'], $data['maSoThue'], $data['nguoiLienHe'],
            $data['ghiChu'], $data['trangThai']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE nhacungcap SET tenNhaCC=?, diaChi=?, soDienThoai=?, 
                email=?, maSoThue=?, nguoiLienHe=?, ghiChu=?, trangThai=? WHERE maNhaCC=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssssi", 
            $data['tenNhaCC'], $data['diaChi'], $data['soDienThoai'], 
            $data['email'], $data['maSoThue'], $data['nguoiLienHe'],
            $data['ghiChu'], $data['trangThai'], $id
        );
        return $stmt->execute();
    }

    public function findById($id) {
        $sql = "SELECT * FROM nhacungcap WHERE maNhaCC=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAll($search = '') {
        if (!empty($search)) {
            $sql = "SELECT * FROM nhacungcap WHERE tenNhaCC LIKE ? OR soDienThoai LIKE ? OR diaChi LIKE ? ORDER BY maNhaCC DESC";
            $s = "%$search%";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $s, $s, $s);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return $this->db->query("SELECT * FROM nhacungcap ORDER BY maNhaCC DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function checkNameExists($tenNhaCC, $excludeId = null) {
        $sql = "SELECT maNhaCC FROM nhacungcap WHERE tenNhaCC = ?";
        if ($excludeId) {
            $sql .= " AND maNhaCC != ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("si", $tenNhaCC, $excludeId);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $tenNhaCC);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function checkPhoneExists($soDienThoai, $excludeId = null) {
        if(empty($soDienThoai)) return false;
        
        $sql = "SELECT maNhaCC FROM nhacungcap WHERE soDienThoai = ?";
        if ($excludeId) {
            $sql .= " AND maNhaCC != ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("si", $soDienThoai, $excludeId);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $soDienThoai);
        }
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function hasTransactions($id) {
        $sql = "SELECT COUNT(*) as total FROM phieunhapkho WHERE maNhaCC=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    public function setStatus($id, $status) {
        $sql = "UPDATE nhacungcap SET trangThai=? WHERE maNhaCC=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function deleteById($id) {
        $sql = "DELETE FROM nhacungcap WHERE maNhaCC=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}