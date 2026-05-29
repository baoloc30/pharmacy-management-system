<?php
require_once 'models/StatisticModel.php';

class StatisticController extends Controller {
    
    public function revenue() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $statisticModel = $this->model('StatisticModel');
        $data = [];
        
        $filters = [
            'maNhanVien' => trim($_GET['ma_nhan_vien'] ?? ''),
            'maThuoc'    => trim($_GET['ma_thuoc'] ?? ''),
            'tenThuoc'   => trim($_GET['ten_thuoc'] ?? '')
        ];
        $data['filters'] = $filters;

        $fromDate = $_GET['from_date'] ?? date('Y-m-01');
        $toDate = $_GET['to_date'] ?? date('Y-m-d');
        
        $data['from_date'] = $fromDate;
        $data['to_date'] = $toDate;

        if ($fromDate === '' || $toDate === '') {
            $data['error'] = 'Vui lòng chọn đầy đủ thời gian';
        } else {
            // 1. Lấy dữ liệu Tổng
            $data['summary'] = $statisticModel->getAggregatedRevenue($fromDate, $toDate, $filters);
            
            // 2. Lấy dữ liệu Biểu đồ
            $data['chartData'] = $statisticModel->getDailyRevenue($fromDate, $toDate, $filters);

            // 3. Lấy toàn bộ danh sách chi tiết (Để đẩy vào thanh cuộn)
            $data['revenueDetails'] = $statisticModel->getRevenueDetails($fromDate, $toDate, $filters);

            if (empty($data['revenueDetails'])) {
                $data['error'] = 'Không tìm thấy dữ liệu thống kê phù hợp.';
            }
        }
        
        $this->view('statistic/revenue', $data);
    }

    public function bestSelling() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');
        
        $data['month'] = $month;
        $data['year'] = $year;
        
        $currentYear = (int)date('Y');
        $currentMonth = (int)date('m');
        
        if (!is_numeric($month) || !is_numeric($year) || $month < 1 || $month > 12 || 
            $year > $currentYear || ($year == $currentYear && $month > $currentMonth)) {
            
            $data['error'] = 'Khoảng thời gian không hợp lệ.';
            $data['medicines'] = [];
            
        } else {
            $statisticModel = $this->model('StatisticModel');
            $data['medicines'] = $statisticModel->getBestSelling($month, $year);
            
            if (empty($data['medicines'])) {
                $data['empty_message'] = 'Không có thuốc bán chạy trong khoảng thời gian đã chọn.';
            }
        }
        
        $this->view('statistic/best_selling', $data);
    }
}