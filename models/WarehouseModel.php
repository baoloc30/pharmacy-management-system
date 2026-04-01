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

    public function getHistory($fromDate = '', $toDate = '', $type = '', $search = '') {
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
        if (!empty($search)) {
            $sql .= " AND (t.tenThuoc LIKE ? OR n.hoTen LIKE ? OR l.maChungTu LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "sss";
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

    public function getTransactionDetail($maChungTu, $loaiChungTu) {
        if ($loaiChungTu === 'PhieuNhap') {
            $sqlMaster = "SELECT p.maPhieu as maSo, p.tongTien, n.hoTen as tenNhanVien, nc.tenNhaCC as doiTac
                          FROM phieunhapkho p
                          JOIN nhanvien n ON p.maNhanVien = n.maNhanVien
                          LEFT JOIN nhacungcap nc ON p.maNhaCC = nc.maNhaCC
                          WHERE p.maPhieuNK = ?";
            $sqlDetail = "SELECT t.tenThuoc, c.soLuong, t.donViTinh as dvt, c.donGia as gia, (c.soLuong * c.donGia) as thanhTien
                          FROM ct_phieunhapkho c
                          JOIN thuoc t ON c.maThuoc = t.maThuoc
                          WHERE c.maPhieuNK = ?";
        } elseif ($loaiChungTu === 'HoaDon') {
            $sqlMaster = "SELECT h.maHoaDon as maSo, h.tongTien, n.hoTen as tenNhanVien, COALESCE(k.hoTen, 'Khách lẻ') as doiTac
                          FROM hoadon h
                          JOIN nhanvien n ON h.maNhanVien = n.maNhanVien
                          LEFT JOIN khachhang k ON h.maKhachHang = k.maKhachHang
                          WHERE h.maHoaDon = ?";
            $sqlDetail = "SELECT t.tenThuoc, c.soLuong, c.donGia as gia, c.thanhTien as thanhTien, 
                        IF(c.donViBan IS NULL OR c.donViBan = '', t.donViTinh, c.donViBan) as dvt
                        FROM ct_hoadon c
                        JOIN thuoc t ON c.maThuoc = t.maThuoc
                        WHERE c.maHoaDon = ?";
        } else {
            return null; 
        }

        try {
            $stmt1 = $this->db->prepare($sqlMaster);
            $stmt1->bind_param("i", $maChungTu);
            $stmt1->execute();
            $master = $stmt1->get_result()->fetch_assoc();

            $stmt2 = $this->db->prepare($sqlDetail);
            $stmt2->bind_param("i", $maChungTu);
            $stmt2->execute();
            $details = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

            if($master) {
                $master['chi_tiet'] = $details;
                return $master;
            }
        } catch (Exception $e) { return null; }
        return null;
    }
}