<?php
require_once 'core/Model.php';

class SupplierModel extends Model {
    protected $table = 'nhacungcap';
    protected $primaryKey = 'maNhaCC';

    public function create($data) {
        $sql = "INSERT INTO nhacungcap (tenNhaCC, diaChi, soDienThoai, email, maSoThue, nguoiLienHe) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssss", 
            $data['tenNhaCC'], $data['diaChi'], $data['soDienThoai'], 
            $data['email'], $data['maSoThue'], $data['nguoiLienHe']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE nhacungcap SET tenNhaCC=?, diaChi=?, soDienThoai=?, 
                email=?, maSoThue=?, nguoiLienHe=? WHERE maNhaCC=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssi", 
            $data['tenNhaCC'], $data['diaChi'], $data['soDienThoai'], 
            $data['email'], $data['maSoThue'], $data['nguoiLienHe'], $id
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
            $sql = "SELECT * FROM nhacungcap WHERE tenNhaCC LIKE ? OR soDienThoai LIKE ? OR diaChi LIKE ? ORDER BY tenNhaCC";
            $s = "%$search%";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $s, $s, $s);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return $this->db->query("SELECT * FROM nhacungcap ORDER BY tenNhaCC")->fetch_all(MYSQLI_ASSOC);
    }
}