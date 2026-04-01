<?php
require_once 'models/StatisticModel.php';

class StatisticController extends Controller {
    
    public function revenue() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $statisticModel = $this->model('StatisticModel');
        $data = [];
        
        if (isset($_GET['from_date']) || isset($_GET['to_date'])) {
            $fromDate = trim($_GET['from_date'] ?? '');
            $toDate = trim($_GET['to_date'] ?? '');
            
            $data['from_date'] = $fromDate;
            $data['to_date'] = $toDate;
            
            if ($fromDate === '' || $toDate === '') {
                $data['error'] = 'Vui lòng chọn đầy đủ thông tin thống kê';
                $data['revenue'] = [];
            } else {
                $data['revenue'] = $statisticModel->getRevenue($fromDate, $toDate);
                
                if (empty($data['revenue'])) {
                    $data['error'] = 'Không tìm thấy dữ liệu thống kê';
                }
            }
        } else {
            $data['from_date'] = date('Y-m-01');
            $data['to_date'] = date('Y-m-d');
            $data['revenue'] = $statisticModel->getRevenue($data['from_date'], $data['to_date']);
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