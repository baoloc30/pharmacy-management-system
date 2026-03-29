<?php
require_once 'core/Model.php';

class InvoiceModel extends Model {
    protected $table = 'hoadon';
    protected $primaryKey = 'maHoaDon';

    public function createInvoice($invoiceData, $items) {
        $this->db->begin_transaction();
        
        try {
            // Tạo mã hóa đơn
            $invoiceData['maHoaDonCode'] = generateCode('HD');
            
            // Insert hóa đơn
            $sql = "INSERT INTO hoadon (maHoaDonCode, maNhanVien, maKhachHang, 
                                        tongTien, tienGiam, phuongThucThanhToan) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("siidds", 
                $invoiceData['maHoaDonCode'],
                $invoiceData['maNhanVien'],
                $invoiceData['maKhachHang'],
                $invoiceData['tongTien'],
                $invoiceData['tienGiam'],
                $invoiceData['phuongThucThanhToan']
            );
            $stmt->execute();
            $maHoaDon = $stmt->insert_id;
            
            // Insert chi tiết hóa đơn và cập nhật tồn kho
            foreach($items as $item) {
                $maThuoc = (int)$item['maThuoc'];
                $soLuong = (int)$item['soLuong'];
                $donGia  = (float)$item['donGia'];
                
                // --- XỬ LÝ LOGIC ĐƠN VỊ LẺ ---
                $isRetail = isset($item['isRetail']) ? $item['isRetail'] : false;
                $soLuongQuyDoi = (isset($item['soLuongQuyDoi']) && (int)$item['soLuongQuyDoi'] > 0) ? (int)$item['soLuongQuyDoi'] : 1;
                
                // Tính toán số lượng thực tế cần trừ trong kho (tính theo đơn vị chẵn)
                if ($isRetail) {
                    $soLuongTruKho = (float)($soLuong / $soLuongQuyDoi);
                } else {
                    $soLuongTruKho = (float)$soLuong; 
                }

                // Lấy tồn kho hiện tại trước khi trừ
                $stmtTon = $this->db->prepare("SELECT soLuongTon FROM thuoc WHERE maThuoc=?");
                $stmtTon->bind_param("i", $maThuoc);
                $stmtTon->execute();
                $tonTruoc = (float)$stmtTon->get_result()->fetch_assoc()['soLuongTon'];
                $tonSau   = $tonTruoc - $soLuongTruKho;

                // Insert chi tiết hóa đơn (thanhTien là GENERATED COLUMN)
                $donViBan = isset($item['donViTinh']) ? $item['donViTinh'] : '';
                
                $sql = "INSERT INTO ct_hoadon (maHoaDon, maThuoc, donViBan, soLuong, donGia) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iisid", $maHoaDon, $maThuoc, $donViBan, $soLuong, $donGia);
                $stmt->execute();
                
                // Cập nhật tồn kho
                $sql = "UPDATE thuoc SET soLuongTon = soLuongTon - ? WHERE maThuoc = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("di", $soLuongTruKho, $maThuoc); 
                $stmt->execute();
                
                // Ghi lịch sử xuất
                $maNV = (int)$invoiceData['maNhanVien'];
                $sql = "INSERT INTO lichsunhap_xuat (maThuoc, loaiGiaoDich, soLuong, tonKhoTruoc, tonKhoSau, maChungTu, loaiChungTu, maNhanVien) 
                        VALUES (?, 'Xuat', ?, ?, ?, ?, 'HoaDon', ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iidddi", $maThuoc, $soLuongTruKho, $tonTruoc, $tonSau, $maHoaDon, $maNV);
                $stmt->execute();
            }
            
            // Cập nhật tổng chi tiêu khách hàng
            if($invoiceData['maKhachHang']) {
                $sql = "UPDATE khachhang SET tongChiTieu = tongChiTieu + ? 
                        WHERE maKhachHang = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("di", $invoiceData['tongTien'], $invoiceData['maKhachHang']);
                $stmt->execute();
            }
            
            $this->db->commit();
            return $maHoaDon;
            
        } catch(Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT h.*, n.hoTen as tenNhanVien, kh.hoTen as tenKhachHang 
                FROM hoadon h 
                JOIN nhanvien n ON h.maNhanVien = n.maNhanVien 
                LEFT JOIN khachhang kh ON h.maKhachHang = kh.maKhachHang 
                ORDER BY h.ngayLap DESC";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getDetail($id) {
        $sql = "SELECT h.*, n.hoTen as tenNhanVien, kh.* 
                FROM hoadon h 
                JOIN nhanvien n ON h.maNhanVien = n.maNhanVien 
                LEFT JOIN khachhang kh ON h.maKhachHang = kh.maKhachHang 
                WHERE h.maHoaDon = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $invoice = $stmt->get_result()->fetch_assoc();
        
        $sql = "SELECT c.*, t.tenThuoc, t.donViTinh 
                FROM ct_hoadon c 
                JOIN thuoc t ON c.maThuoc = t.maThuoc 
                WHERE c.maHoaDon = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $invoice['items'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        return $invoice;
    }

    public function getByCustomer($customerId, $fromDate = '', $toDate = '') {
        $sql = "SELECT h.*, n.hoTen as tenNhanVien 
                FROM hoadon h 
                JOIN nhanvien n ON h.maNhanVien = n.maNhanVien 
                WHERE h.maKhachHang = ?";
        $params = [$customerId];
        $types = "i";
        if (!empty($fromDate)) {
            $sql .= " AND DATE(h.ngayLap) >= ?";
            $params[] = $fromDate;
            $types .= "s";
        }
        if (!empty($toDate)) {
            $sql .= " AND DATE(h.ngayLap) <= ?";
            $params[] = $toDate;
            $types .= "s";
        }
        $sql .= " ORDER BY h.ngayLap DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getFiltered($keyword = '', $fromDate = '', $toDate = '') {
        $sql = "SELECT h.*, n.hoTen as tenNhanVien, kh.hoTen as tenKhachHang 
                FROM hoadon h 
                JOIN nhanvien n ON h.maNhanVien = n.maNhanVien 
                LEFT JOIN khachhang kh ON h.maKhachHang = kh.maKhachHang 
                WHERE 1=1";
        $params = [];
        $types = "";
        if (!empty($keyword)) {
            $sql .= " AND (h.maHoaDonCode LIKE ? OR kh.hoTen LIKE ?)";
            $k = "%$keyword%";
            $params[] = $k;
            $params[] = $k;
            $types .= "ss";
        }
        if (!empty($fromDate)) {
            $sql .= " AND DATE(h.ngayLap) >= ?";
            $params[] = $fromDate;
            $types .= "s";
        }
        if (!empty($toDate)) {
            $sql .= " AND DATE(h.ngayLap) <= ?";
            $params[] = $toDate;
            $types .= "s";
        }
        $sql .= " ORDER BY h.ngayLap DESC";
        if (empty($params)) {
            return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}