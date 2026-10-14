<?php
require_once 'models/StatisticModel.php';

class StatisticController extends Controller {
    
    public function revenue() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $defaultFromDate = (new DateTimeImmutable('today'))->modify('-10 months')->format('Y-m-d');
        $fromDate = $_GET['from_date'] ?? $defaultFromDate;
        $toDate = $_GET['to_date'] ?? date('Y-m-d');
        
        $statisticModel = $this->model('StatisticModel');
        $data['from_date'] = $fromDate;
        $data['to_date'] = $toDate;

        if ($fromDate > $toDate) {
            $data['error'] = 'Khoảng thời gian không hợp lệ. Ngày bắt đầu phải trước ngày kết thúc.';
            $data['revenue'] = [];
        } else {
            try {
                $data['revenue'] = $statisticModel->getRevenue($fromDate, $toDate);
            } catch (Exception $e) {
                $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                $data['revenue'] = [];
            }
        }
        
        $this->view('statistic/revenue', $data);
    }

    public function bestSelling() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $defaultFromDate = (new DateTimeImmutable('today'))->modify('-10 months')->format('Y-m-d');
        $fromDate = $_GET['from_date'] ?? $defaultFromDate;
        $toDate   = $_GET['to_date'] ?? date('Y-m-d');
        
        $statisticModel = $this->model('StatisticModel');
        $data['from_date'] = $fromDate;
        $data['to_date'] = $toDate;

        if ($fromDate > $toDate) {
            $data['error'] = 'Khoảng thời gian không hợp lệ. Ngày bắt đầu phải trước ngày kết thúc.';
            $data['medicines'] = [];
        } else {
            try {
                $data['medicines'] = $statisticModel->getBestSelling($fromDate, $toDate);
                if (empty($data['medicines'])) {
                    $data['empty_message'] = 'Không có thuốc bán chạy trong khoảng thời gian đã chọn.';
                }
            } catch (Exception $e) {
                $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                $data['medicines'] = [];
            }
        }
        
        $this->view('statistic/best_selling', $data);
    }
}