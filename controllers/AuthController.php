<?php
require_once 'core/Controller.php';
require_once 'models/UserModel.php';

class AuthController extends Controller {

    public function index() {
        $this->login();
    }

    public function login() {
        Session::init();
        
        if (Session::get('logged_in')) {
            redirect(Session::get('role') == 'QuanLy' ? 'home/admin' : 'home/employee');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            $hasError = false;
            
            if(empty($username)) {
                $data['username_error'] = 'Vui lòng không bỏ trống thông tin này';
                $hasError = true;
            } 
            if(empty($password)) {
                $data['password_error'] = 'Vui lòng không bỏ trống thông tin này';
                $hasError = true;
            } 
            
            if(!$hasError) {
                try {
                    $userModel = $this->model('UserModel');
                    $user = $userModel->login($username, $password);
                    
                    if($user) {
                        if($user['trangThai'] !== 'HoatDong') {
                            $data['error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Quản lý';
                        } else {
                            Session::set('logged_in', true);
                            Session::set('user_id', $user['idTaiKhoan']);
                            Session::set('username', $user['tenDangNhap']);
                            Session::set('role', $user['vaiTro']);
                            Session::set('nhan_vien_id', $user['maNhanVien']);
                            Session::set('nhan_vien_name', $user['hoTen']);
                            
                            Session::set('login_success', 'Đăng nhập thành công');
                            $target = $user['vaiTro'] == 'QuanLy' ? 'home/admin' : 'home/employee';
                            redirect($target);
                            exit();
                        }
                    } else {
                        $data['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            }
        }
        $this->viewLogin('auth/login', $data ?? []);
    }

    public function logout() {
        Session::destroy();
        redirect('auth/login');
    }

    public function changePassword() {
        $this->checkLogin();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oldPass = $_POST['old_password'];
            $newPass = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];
            
            if($newPass != $confirmPass) {
                $data['error'] = 'Mật khẩu xác nhận không trùng khớp';
            } else {
                try {
                    $userModel = $this->model('UserModel');
                    if($userModel->changePassword(Session::get('user_id'), $oldPass, $newPass)) {
                        Session::set('logged_in', false);
                        Session::set('user_id', null);
                        Session::set('role', null);
                        Session::set('username', null);
                        $_SESSION['success'] = 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại bằng mật khẩu mới.';
                        redirect('auth/login');
                        exit;
                    } else {
                        $data['error'] = 'Mật khẩu hiện tại không chính xác';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
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