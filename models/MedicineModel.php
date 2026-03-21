<?php
require_once 'core/Model.php';

class MedicineModel extends Model {
    protected $table = 'thuoc';
    protected $primaryKey = 'maThuoc';

    public function getAllWithCategory() {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                LEFT JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                ORDER BY t.maThuoc DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAvailable() {
        $sql = "SELECT * FROM thuoc 
                WHERE trangThai = 'DangBan' AND soLuongTon > 0 
                AND hanSuDung > CURDATE()";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getLowStock($threshold = 10) {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                WHERE t.soLuongTon <= ? AND t.trangThai = 'DangBan'";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $threshold);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getExpired($days = 30) {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                WHERE t.hanSuDung <= DATE_ADD(CURDATE(), INTERVAL ? DAY) 
                AND t.hanSuDung >= CURDATE()";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $days);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getStock() {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                ORDER BY t.soLuongTon ASC";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO thuoc (maDanhMuc, tenThuoc, donViTinh, giaBan, giaNhap, 
                                   soLuongTon, hanSuDung, xuatXu, thanhPhan, congDung, cachDung) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issddisssss", 
            $data['maDanhMuc'], $data['tenThuoc'], $data['donViTinh'], 
            $data['giaBan'], $data['giaNhap'], $data['soLuongTon'], 
            $data['hanSuDung'], $data['xuatXu'], $data['thanhPhan'], 
            $data['congDung'], $data['cachDung']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE thuoc SET maDanhMuc=?, tenThuoc=?, donViTinh=?, giaBan=?, 
                xuatXu=?, thanhPhan=?, congDung=?, cachDung=? 
                WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("issdssssi", 
            $data['maDanhMuc'], $data['tenThuoc'], $data['donViTinh'], 
            $data['giaBan'], $data['xuatXu'], $data['thanhPhan'], 
            $data['congDung'], $data['cachDung'], $id
        );
        return $stmt->execute();
    }

    public function updateStock($id, $quantity) {
        $sql = "UPDATE thuoc SET soLuongTon = soLuongTon + ? WHERE maThuoc = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        return $stmt->execute();
    }

    public function search($keyword, $categoryId = '') {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                WHERE t.trangThai='DangBan'";

        if ($keyword !== '') {
            $sql .= " AND (
                    CAST(t.maThuoc AS CHAR) LIKE ? OR
                    t.tenThuoc LIKE ? OR 
                    t.thanhPhan LIKE ? OR 
                    t.congDung LIKE ? OR 
                    t.xuatXu LIKE ? OR 
                    d.tenDanhMuc LIKE ?
                  )";
            $kw = "%$keyword%";
        }

        if ($categoryId !== '') {
            $sql .= " AND t.maDanhMuc = ?";
        }

        $sql .= " ORDER BY t.ngayTao DESC";

        $stmt = $this->db->prepare($sql);

        if ($keyword !== '' && $categoryId !== '') {
            $stmt->bind_param("ssssssi", $kw, $kw, $kw, $kw, $kw, $kw, $categoryId);
        } elseif ($keyword !== '') {
            $stmt->bind_param("ssssss", $kw, $kw, $kw, $kw, $kw, $kw);
        } elseif ($categoryId !== '') {
            $stmt->bind_param("i", $categoryId);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getDetail($id) {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                WHERE t.maThuoc = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function hasTransactions($id) {
        $sql = "SELECT (SELECT COUNT(*) FROM ct_hoadon WHERE maThuoc=?) + 
                       (SELECT COUNT(*) FROM ct_phieunhapkho WHERE maThuoc=?) as total";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id, $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    public function setStatus($id, $status) {
        $sql = "UPDATE thuoc SET trangThai=? WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function deleteById($id) {
        $sql = "DELETE FROM thuoc WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updatePrice($id, $newPrice) {
        $sql = "UPDATE thuoc SET giaBan=? WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("di", $newPrice, $id);
        return $stmt->execute();
    }

    public function getAllWithCategoryAndUnit() {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                LEFT JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                ORDER BY t.tenThuoc ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateUnit($id, $donViLe, $soLuongQuyDoi, $giaBanLe) {
        $sql = "UPDATE thuoc SET donViLe=?, soLuongQuyDoi=?, giaBanLe=? WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sidi", $donViLe, $soLuongQuyDoi, $giaBanLe, $id);
        return $stmt->execute();
    }

    public function updateStockDirect($id, $newQty, $maNhanVien) {
        // Lấy tồn kho hiện tại
        $sql = "SELECT soLuongTon FROM thuoc WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $oldQty = $row['soLuongTon'];

        // Cập nhật
        $sql = "UPDATE thuoc SET soLuongTon=? WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $newQty, $id);
        $stmt->execute();

        // Ghi lịch sử
        $diff = $newQty - $oldQty;
        $sql = "INSERT INTO lichsunhap_xuat (maThuoc, loaiGiaoDich, soLuong, tonKhoTruoc, tonKhoSau, loaiChungTu, maNhanVien, ghiChu)
                VALUES (?, 'DieuChinh', ?, ?, ?, 'DieuChinh', ?, 'Cập nhật tồn kho thủ công')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiiii", $id, $diff, $oldQty, $newQty, $maNhanVien);
        return $stmt->execute();
    }
}