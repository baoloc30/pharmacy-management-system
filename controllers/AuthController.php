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
            $target = Session::get('role') === 'QuanLy' ? 'home/admin' : 'home/employee';
            redirect($target);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if(empty($username)) {
                $data['username_error'] = 'Vui lòng không bỏ trống thông tin này';
            }
            if(empty($password)) {
                $data['password_error'] = 'Vui lòng không bỏ trống thông tin này';
            }

            if (empty($data['username_error']) && empty($data['password_error'])) {
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
            $oldPass = $_POST['old_password'] ?? '';
            $newPass = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';
            
            if($newPass != $confirmPass) {
                $data['error'] = 'Mật khẩu mới không khớp';
            } else {
                try {
                    $userModel = $this->model('UserModel');
                    if($userModel->changePassword(Session::get('user_id'), $oldPass, $newPass)) {
                        Session::destroy();
                        Session::set('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại bằng mật khẩu mới.');
                        redirect('auth/login');
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
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            if (empty($username)) {
                $data['error'] = 'Vui lòng nhập tên đăng nhập';
            } elseif (empty($soDienThoai)) {
                $data['error'] = 'Vui lòng nhập số điện thoại';
            } elseif (empty($newPassword)) {
                $data['error'] = 'Vui lòng nhập mật khẩu mới';
            } elseif (strlen($newPassword) < 6) {
                $data['error'] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
            } elseif ($newPassword !== $confirmPassword) {
                $data['error'] = 'Mật khẩu xác nhận không trùng khớp';
            } else {
                try {
                    $userModel = $this->model('UserModel');
                    if ($userModel->resetPassword($username, $soDienThoai, $newPassword)) {
                        $data['success'] = 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập bằng mật khẩu mới.';
                    } else {
                        $data['error'] = 'Tên đăng nhập hoặc số điện thoại không đúng';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
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