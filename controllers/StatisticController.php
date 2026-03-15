<?php
require_once 'models/StatisticModel.php';

class StatisticController extends Controller {
    
    public function revenue() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $fromDate = $_GET['from_date'] ?? date('Y-m-01');
        $toDate = $_GET['to_date'] ?? date('Y-m-d');
        
        $statisticModel = $this->model('StatisticModel');
        $data['revenue'] = $statisticModel->getRevenue($fromDate, $toDate);
        $data['from_date'] = $fromDate;
        $data['to_date'] = $toDate;
        
        $this->view('statistic/revenue', $data);
    }

    public function bestSelling() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');
        
        $statisticModel = $this->model('StatisticModel');
        $data['medicines'] = $statisticModel->getBestSelling($month, $year);
        $data['month'] = $month;
        $data['year'] = $year;
        
        $this->view('statistic/best_selling', $data);
    }
}