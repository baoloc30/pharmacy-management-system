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
        $sql = "INSERT INTO thuoc (maDanhMuc, hinhAnh,tenThuoc, donViTinh, giaBan, giaNhap, 
                                   soLuongTon, hanSuDung, xuatXu, thanhPhan, congDung, cachDung) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isssddisssss", 
            $data['maDanhMuc'], $data['hinhAnh'], $data['tenThuoc'], $data['donViTinh'], 
            $data['giaBan'], $data['giaNhap'], $data['soLuongTon'], 
            $data['hanSuDung'], $data['xuatXu'], $data['thanhPhan'], 
            $data['congDung'], $data['cachDung']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE thuoc SET maDanhMuc=?, hinhAnh=?, tenThuoc=?, donViTinh=?, giaBan=?, 
                giaNhap=?, hanSuDung=?, xuatXu=?, thanhPhan=?, congDung=?, cachDung=? 
                WHERE maThuoc=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isssddsssssi", 
            $data['maDanhMuc'], $data['hinhAnh'], $data['tenThuoc'], $data['donViTinh'], 
            $data['giaBan'], $data['giaNhap'], $data['hanSuDung'], $data['xuatXu'], $data['thanhPhan'], 
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

    public function search($keyword, $categoryId = null) {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                LEFT JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                WHERE 1=1";
        
        $params = [];
        $types = "";

        // Lọc theo danh mục
        if (!empty($categoryId)) {
            $sql .= " AND t.maDanhMuc = ?";
            $types .= "i";
            $params[] = $categoryId;
        }

        if ($keyword !== '') {
            $sql .= " AND (t.maThuoc LIKE ? OR t.tenThuoc LIKE ? OR t.congDung LIKE ? OR t.thanhPhan LIKE ? OR d.tenDanhMuc LIKE ?)";
            $kw = "%$keyword%";
            $types .= "sssss";
            array_push($params, $kw, $kw, $kw, $kw, $kw);
        }

        $sql .= " ORDER BY t.maThuoc DESC";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) throw new Exception("Lỗi prepare database");

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) throw new Exception("Lỗi execute database");

        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getDetail($id) {
        $sql = "SELECT t.*, d.tenDanhMuc 
                FROM thuoc t 
                LEFT JOIN danhmucthuoc d ON t.maDanhMuc = d.maDanhMuc 
                WHERE t.maThuoc = ?";
                
        $stmt = $this->db->prepare($sql);
        if (!$stmt) throw new Exception("Lỗi prepare database");
        
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) throw new Exception("Lỗi execute database");
        
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