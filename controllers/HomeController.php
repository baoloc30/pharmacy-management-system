<?php
require_once 'models/HomeModel.php';

class HomeController extends Controller {
    
    public function index() {
        $this->checkLogin();
        // Phân luồng giao diện tùy theo vai trò
        if (Session::get('role') === 'QuanLy') {
            $this->view('home/admin');
        } else {
            $this->view('home/employee');
        }
    }

    // API Trả về số liệu cho Javascript trên Dashboard
    public function stats() {
        $this->checkLogin();
        
        $homeModel = $this->model('HomeModel');
        $role = Session::get('role');
        $userId = Session::get('user_id');

        $data = [];
        if ($role === 'QuanLy') {
            // Thống kê cho Quản lý
            $data = [
                'totalMedicine' => number_format($homeModel->getTotalMedicine(), 0, ',', '.'),
                'todayRevenue'  => $homeModel->getTodayRevenue(), 
                'lowStock'      => number_format($homeModel->getLowStockCount(), 0, ',', '.'),
                'expiringSoon'  => number_format($homeModel->getExpiringSoonCount(), 0, ',', '.')
            ];
        } else {
            // Thống kê cho Nhân viên
            $data = [
                'todayInvoices' => number_format($homeModel->getTodayInvoices($userId), 0, ',', '.'),
                'todayRevenue'  => $homeModel->getTodayRevenue($userId),
                'lowStock'      => number_format($homeModel->getLowStockCount(), 0, ',', '.')
            ];
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);

        exit; 
    }
}