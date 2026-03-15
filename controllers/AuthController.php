<?php
require_once 'core/Controller.php';
require_once 'models/UserModel.php';

class AuthController extends Controller {

    public function index() {
        $this->login();
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validate empty fields
            if(empty($username)) {
                $data['error'] = 'Vui lòng không để trống tên đăng nhập';
            } elseif(empty($password)) {
                $data['error'] = 'Vui lòng không để trống mật khẩu';
            } else {
                $userModel = $this->model('UserModel');
                $user = $userModel->login($username, $password);
                
                if($user) {
                    // Check account status
                    if($user['trangThai'] !== 'HoatDong') {
                        $data['error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Quản lý';
                    } else {
                        Session::init();
                        Session::set('logged_in', true);
                        Session::set('user_id', $user['idTaiKhoan']);
                        Session::set('username', $user['tenDangNhap']);
                        Session::set('role', $user['vaiTro']);
                        Session::set('nhan_vien_id', $user['maNhanVien']);
                        Session::set('nhan_vien_name', $user['hoTen']);
                        
                        // Redirect based on role from database
                        redirect($user['vaiTro'] == 'QuanLy' ? 'home/admin' : 'home/employee');
                    }
                } else {
                    $data['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
                }
            }
        }
        $this->viewLogin('auth/login', $data ?? []);
    }

    public function logout() {
        Session::init();
        // Xử lý confirm từ POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_logout'])) {
            Session::destroy();
            redirect('auth/login');
        }
        // Hiển thị confirm qua JS (xử lý GET với confirm=1)
        if (isset($_GET['confirm']) && $_GET['confirm'] == '1') {
            Session::destroy();
            redirect('auth/login');
        }
        redirect('auth/login');
    }

    public function changePassword() {
        $this->checkLogin();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oldPass = $_POST['old_password'];
            $newPass = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];
            
            if($newPass != $confirmPass) {
                $data['error'] = 'Mật khẩu mới không khớp';
            } else {
                $userModel = $this->model('UserModel');
                if($userModel->changePassword(Session::get('user_id'), $oldPass, $newPass)) {
                    // Đăng xuất và yêu cầu đăng nhập lại
                    Session::destroy();
                    redirect('auth/login');
                } else {
                    $data['error'] = 'Mật khẩu hiện tại không chính xác';
                }
            }
        }
        $this->view('auth/change_password', $data ?? []);
    }

    public function updateProfile() {
        $this->checkLogin();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            
            $profileData = [
                'hoTen'       => $_POST['hoTen'] ?? '',
                'email'       => $_POST['email'] ?? '',
                'soDienThoai' => $_POST['soDienThoai'] ?? '',
                'diaChi'      => $_POST['diaChi'] ?? '',
                'ngaySinh'    => !empty($_POST['ngaySinh']) ? $_POST['ngaySinh'] : null,
                'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam'
            ];
            
            if(empty($profileData['hoTen'])) {
                $error = 'Vui lòng nhập họ tên';
            } else {
                if($userModel->updateProfile(Session::get('user_id'), $profileData)) {
                    Session::set('nhan_vien_name', $profileData['hoTen']);
                    $success = 'Cập nhật thông tin thành công';
                } else {
                    $error = 'Cập nhật thông tin thất bại';
                }
            }
        }
        
        $userModel = $this->model('UserModel');
        $data['user'] = $userModel->getProfile(Session::get('user_id'));
        if (isset($success)) $data['success'] = $success;
        if (isset($error)) $data['error'] = $error;
        $this->view('auth/profile', $data);
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username    = trim($_POST['username'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');

            $userModel = $this->model('UserModel');
            if ($userModel->resetPassword($username, $soDienThoai)) {
                $data['success'] = 'Đặt lại mật khẩu thành công. Mật khẩu mới của bạn là: <b>123456</b>';
            } else {
                $data['error'] = 'Tên đăng nhập hoặc số điện thoại không đúng';
            }
        }
        $this->viewLogin('auth/forgot_password', $data ?? []);
    }

    public function profile() {
        $this->checkLogin();
        
        $userModel = $this->model('UserModel');
        $data['user'] = $userModel->getProfile(Session::get('user_id'));
        $this->view('auth/profile', $data);
    }
}