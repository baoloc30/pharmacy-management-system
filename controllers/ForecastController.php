<?php
class ForecastController extends Controller
{

    public function __construct()
    {
        $this->checkLogin();
    }

    // Hàm xử lý thuật toán (Dùng chung)
    private function calculateSuggestions($model)
    {
        $LEAD_TIME = 3;
        $SAFETY_STOCK = 20;
        $DAYS_TO_ANALYZE = 30;

        $rawData = $model->getInventoryForecastData($DAYS_TO_ANALYZE);
        $suggestions = [];

        foreach ($rawData as $item) {
            if ($item['tongBan30Ngay'] == 0) continue;

            $averageDailySales = $item['tongBan30Ngay'] / $DAYS_TO_ANALYZE;
            $ROP = ceil(($averageDailySales * $LEAD_TIME) + $SAFETY_STOCK);

            if ($item['soLuongTon'] <= $ROP) {
                $soLuongCanNhap = ceil(($averageDailySales * 14) + $SAFETY_STOCK - $item['soLuongTon']);
                if ($soLuongCanNhap <= 0) $soLuongCanNhap = $SAFETY_STOCK;

                $suggestions[] = [
                    'maThuoc' => $item['maThuoc'],
                    'tenThuoc' => $item['tenThuoc'],
                    'tonKhoHienTai' => $item['soLuongTon'],
                    'tocDoBan' => round($averageDailySales, 2),
                    'diemROP' => $ROP,
                    'soLuongDeXuatNhap' => $soLuongCanNhap,
                    'giaNhap' => $item['giaNhap'] // Truyền thêm giá nhập để lưu CSDL
                ];
            }
        }
        return $suggestions;
    }

    // Hiển thị giao diện
    public function index()
    {
        $model = $this->model('ForecastModel');
        $suggestions = $this->calculateSuggestions($model);

        // Nhận thông báo lỗi nếu có từ hàm autoCreate
        $error = isset($_GET['err']) ? $_GET['err'] : null;
        $success = isset($_GET['msg']) ? $_GET['msg'] : null;

        $this->view('forecast/index', [
            'suggestions' => $suggestions,
            'error' => $error,
            'success' => $success
        ]);
    }

    // Nút bấm "Tạo phiếu tự động" sẽ gọi vào hàm này
    public function autoCreate()
    {
        $model = $this->model('ForecastModel');
        $suggestions = $this->calculateSuggestions($model);

        if (empty($suggestions)) {
            header("Location: " . BASE_URL . "forecast/index?err=Không có dữ liệu đề xuất để tạo phiếu.");
            exit;
        }

        // Lấy ID nhân viên đang đăng nhập, mặc định là 1 nếu không thấy
        $maNhanVien = Session::get('nhan_vien_id') ?? 1;

        $result = $model->createAutoReceipt($maNhanVien, $suggestions);

        if ($result === true) {
            // Đã tạo thành công -> Chuyển hướng thẳng sang trang chờ duyệt
            header("Location: " . BASE_URL . "warehouse/pending?msg=Đã tạo phiếu đề xuất thành công!");
            exit;
        } else {
            // Báo lỗi
            header("Location: " . BASE_URL . "forecast/index?err=" . urlencode($result));
            exit;
        }
    }
}
