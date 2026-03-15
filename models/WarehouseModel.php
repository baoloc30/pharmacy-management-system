<?php
require_once 'core/Model.php';

class WarehouseModel extends Model {
    protected $table = 'phieunhapkho';
    protected $primaryKey = 'maPhieuNK';

    public function createImport($importData, $items) {
        $this->db->begin_transaction();
        
        try {
            // Tạo mã phiếu nhập
            $importData['maPhieu'] = generateCode('PN');
            
            // Insert phiếu nhập
            $sql = "INSERT INTO phieunhapkho (maPhieu, maNhanVien, maNhaCC, tongTien) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("siid", 
                $importData['maPhieu'],
                $importData['maNhanVien'],
                $importData['maNhaCC'],
                $importData['tongTien']
            );
            $stmt->execute();
            $maPhieuNK = $stmt->insert_id;
            
            // Insert chi tiết và cập nhật tồn kho
            foreach($items as $item) {
                $maThuoc  = (int)$item['maThuoc'];
                $soLuong  = (int)$item['soLuong'];
                $donGia   = (float)$item['donGia'];
                $hanSD    = $item['hanSuDung'];

                // Lấy tồn kho trước khi cộng
                $stmtTon = $this->db->prepare("SELECT soLuongTon FROM thuoc WHERE maThuoc=?");
                $stmtTon->bind_param("i", $maThuoc);
                $stmtTon->execute();
                $tonTruoc = (int)$stmtTon->get_result()->fetch_assoc()['soLuongTon'];
                $tonSau   = $tonTruoc + $soLuong;

                $sql = "INSERT INTO ct_phieunhapkho (maPhieuNK, maThuoc, soLuong, donGia, hanSuDung) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iiids", $maPhieuNK, $maThuoc, $soLuong, $donGia, $hanSD);
                $stmt->execute();
                
                // Cập nhật tồn kho và giá nhập
                $sql = "UPDATE thuoc SET soLuongTon = soLuongTon + ?, giaNhap = ?, hanSuDung = ? WHERE maThuoc = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("idsi", $soLuong, $donGia, $hanSD, $maThuoc);
                $stmt->execute();
                
                // Ghi lịch sử nhập
                $maNV = (int)$importData['maNhanVien'];
                $sql = "INSERT INTO lichsunhap_xuat (maThuoc, loaiGiaoDich, soLuong, tonKhoTruoc, tonKhoSau, maChungTu, loaiChungTu, maNhanVien) 
                        VALUES (?, 'Nhap', ?, ?, ?, ?, 'PhieuNhap', ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iiiiii", $maThuoc, $soLuong, $tonTruoc, $tonSau, $maPhieuNK, $maNV);
                $stmt->execute();
            }
            
            $this->db->commit();
            return true;
            
        } catch(Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getHistory($fromDate = '', $toDate = '', $type = '') {
        $sql = "SELECT l.*, t.tenThuoc, n.hoTen as tenNhanVien 
                FROM lichsunhap_xuat l 
                JOIN thuoc t ON l.maThuoc = t.maThuoc 
                JOIN nhanvien n ON l.maNhanVien = n.maNhanVien 
                WHERE 1=1";
        $params = [];
        $types = "";
        if (!empty($type)) {
            $sql .= " AND l.loaiGiaoDich=?";
            $params[] = $type;
            $types .= "s";
        }
        if (!empty($fromDate)) {
            $sql .= " AND DATE(l.ngayGiaoDich) >= ?";
            $params[] = $fromDate;
            $types .= "s";
        }
        if (!empty($toDate)) {
            $sql .= " AND DATE(l.ngayGiaoDich) <= ?";
            $params[] = $toDate;
            $types .= "s";
        }
        $sql .= " ORDER BY l.ngayGiaoDich DESC LIMIT 200";
        if (empty($params)) {
            return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}