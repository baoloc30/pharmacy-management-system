<?php
class HomeController extends Controller {
    
    public function admin() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $data['title'] = 'Dashboard Quản Lý';
        $this->view('home/admin', $data);
    }

    public function employee() {
        $this->checkLogin();
        $this->checkRole('NhanVien');
        
        $data['title'] = 'Dashboard Nhân Viên';
        $this->view('home/employee', $data);
    }
}