<?php
class ForecastModel extends Model
{

    // 1. Lấy dữ liệu dự báo (Thêm cột giaNhap để tính tiền dự kiến)
    public function getInventoryForecastData($daysToAnalyze = 30)
    {
        $sql = "SELECT t.maThuoc, t.tenThuoc, t.soLuongTon, t.giaNhap, 
                       COALESCE(SUM(ct.soLuong), 0) AS tongBan30Ngay
                FROM thuoc t
                LEFT JOIN ct_hoadon ct ON t.maThuoc = ct.maThuoc
                LEFT JOIN hoadon hd ON ct.maHoaDon = hd.maHoaDon 
                      AND hd.ngayLap >= DATE_SUB(NOW(), INTERVAL ? DAY)
                WHERE t.trangThai = 'DangBan'
                GROUP BY t.maThuoc";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $daysToAnalyze);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // 2. Tự động tạo phiếu nhập kho (Trạng thái: ChoDuyet)
    public function createAutoReceipt($maNhanVien, $suggestions)
    {
        if (empty($suggestions)) return false;

        // Lấy đại 1 Nhà cung cấp làm mặc định (Quản lý sẽ đổi lại khi duyệt phiếu thực tế)
        $nhaCCResult = $this->db->query("SELECT maNhaCC FROM nhacungcap LIMIT 1");
        if ($nhaCCResult->num_rows === 0) return "Lỗi: Không tìm thấy Nhà cung cấp nào trong hệ thống.";
        $maNhaCC = $nhaCCResult->fetch_assoc()['maNhaCC'];

        // Khởi tạo thông tin Phiếu nhập
        $maPhieu = 'PN_AI_' . time(); // Mã phiếu sinh tự động
        $ngayLap = date('Y-m-d H:i:s');
        $ghiChu = "Phiếu nhập kho ĐỀ XUẤT tự động sinh bởi hệ thống AI dự báo.";

        // Bắt đầu Transaction để đảm bảo an toàn dữ liệu
        $this->db->begin_transaction();

        try {
            // Insert bảng phieunhapkho (tongTien tạm bằng 0, trangThai mặc định là ChoDuyet)
            $sqlPN = "INSERT INTO phieunhapkho (maPhieu, ngayLap, maNhanVien, maNhaCC, tongTien, trangThai, ghiChu) 
                      VALUES (?, ?, ?, ?, 0, 'ChoDuyet', ?)";
            $stmtPN = $this->db->prepare($sqlPN);
            $stmtPN->bind_param("ssiis", $maPhieu, $ngayLap, $maNhanVien, $maNhaCC, $ghiChu);
            $stmtPN->execute();

            $maPhieuNK = $this->db->insert_id;
            $tongTienPhieu = 0;

            // Insert bảng ct_phieunhapkho
            $sqlCT = "INSERT INTO ct_phieunhapkho (maPhieuNK, maThuoc, soLuong, donGia, thanhTien, hanSuDung) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmtCT = $this->db->prepare($sqlCT);

            // Vì là đề xuất nên Hạn sử dụng mang tính chất giữ chỗ (Quản lý sẽ sửa khi nhập hàng thật)
            $dummyHSD = date('Y-m-d', strtotime('+1 year'));

            foreach ($suggestions as $item) {
                $thanhTien = $item['soLuongDeXuatNhap'] * $item['giaNhap'];
                $tongTienPhieu += $thanhTien;

                $stmtCT->bind_param("iiidds", $maPhieuNK, $item['maThuoc'], $item['soLuongDeXuatNhap'], $item['giaNhap'], $thanhTien, $dummyHSD);
                $stmtCT->execute();
            }

            // Cập nhật lại tổng tiền cho phiếu nhập
            $sqlUpdateTongTien = "UPDATE phieunhapkho SET tongTien = ? WHERE maPhieuNK = ?";
            $stmtUpdate = $this->db->prepare($sqlUpdateTongTien);
            $stmtUpdate->bind_param("di", $tongTienPhieu, $maPhieuNK);
            $stmtUpdate->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return "Lỗi cơ sở dữ liệu: " . $e->getMessage();
        }
    }
}
