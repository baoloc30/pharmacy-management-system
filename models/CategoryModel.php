<?php
require_once 'core/Model.php';

class CategoryModel extends Model {
    protected $table = 'danhmucthuoc';
    protected $primaryKey = 'maDanhMuc';

    public function create($data) {
        $sql = "INSERT INTO danhmucthuoc (tenDanhMuc, moTa, trangThai) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $trangThai = $data['trangThai'] ?? 'SuDung';
        $stmt->bind_param("sss", $data['tenDanhMuc'], $data['moTa'], $trangThai);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE danhmucthuoc SET tenDanhMuc=?, moTa=?, trangThai=? WHERE maDanhMuc=?";
        $stmt = $this->db->prepare($sql);
        $trangThai = $data['trangThai'] ?? 'SuDung';
        $stmt->bind_param("sssi", $data['tenDanhMuc'], $data['moTa'], $trangThai, $id);
        return $stmt->execute();
    }

    public function findById($id) {
        $sql = "SELECT * FROM danhmucthuoc WHERE maDanhMuc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteById($id) {
        $sql = "DELETE FROM danhmucthuoc WHERE maDanhMuc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function hasMedicines($id) {
        $sql = "SELECT COUNT(*) as count FROM thuoc WHERE maDanhMuc = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }
}