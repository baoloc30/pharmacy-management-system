<?php
require_once 'models/UserModel.php';
require_once 'models/WorkShiftModel.php';

class EmployeeController extends Controller {

    public function index() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $userModel = $this->model('UserModel');
        $data['employees'] = $userModel->getAllEmployees();
        $this->view('employee/index', $data);
    }

    public function add() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            $hoTen       = trim($_POST['hoTen'] ?? '');
            $tenDangNhap = trim($_POST['tenDangNhap'] ?? '');
            $matKhau     = $_POST['matKhau'] ?? '';
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $ngaySinh    = $_POST['ngaySinh'] ?? '';

            if (empty($hoTen) || empty($tenDangNhap) || empty($matKhau)) {
                $data['error'] = 'Vui lòng nhập đầy đủ thông tin';
            } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $tenDangNhap)) {
                $data['error'] = 'Tên đăng nhập không được chứa khoảng trắng hoặc ký tự đặc biệt';
            } elseif ($userModel->usernameExists($tenDangNhap)) {
                $data['error'] = 'Tên đăng nhập đã tồn tại';
            } elseif (!empty($soDienThoai) && !preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Số điện thoại không hợp lệ (cần đúng 10 chữ số)';
            } elseif (!empty($soDienThoai) && $userModel->phoneExists($soDienThoai)) {
                $data['error'] = 'Số điện thoại này đã được sử dụng';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Email sai định dạng';
            } elseif (!empty($email) && $userModel->emailExists($email)) {
                $data['error'] = 'Email này đã được sử dụng cho tài khoản khác';
            } elseif (!empty($ngaySinh) && $ngaySinh >= date('Y-m-d')) {
                $data['error'] = 'Ngày sinh phải nhỏ hơn ngày hiện tại';
            } else {
                $employeeData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai !== '' ? $soDienThoai : null,
                    'email'       => $email !== '' ? $email : null,
                    'diaChi'      => (!empty($_POST['diaChi'])) ? trim($_POST['diaChi']) : null,
                    'ngaySinh'    => !empty($ngaySinh) ? $ngaySinh : null,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam'
                ];
                $accountData = [
                    'tenDangNhap' => $tenDangNhap,
                    'matKhau'     => $matKhau,
                    'vaiTro'      => $_POST['vaiTro'] ?? 'NhanVien'
                ];
                
                $createResult = $userModel->createEmployee($employeeData, $accountData);
                
                if ($createResult === true) {
                    $_SESSION['toast_success'] = 'Tạo tài khoản nhân viên thành công';
                    redirect('employee/index');
                    exit;
                } else {
                    $data['error'] = (strpos($createResult, 'Connection') !== false) 
                                     ? 'Mất kết nối CSDL. Vui lòng thử lại sau.' 
                                     : 'Lỗi CSDL: ' . $createResult;
                }
            }
        }

        $this->view('employee/add', $data ?? []);
    }

    public function edit($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $userModel = $this->model('UserModel');
        $data['employee'] = $userModel->getEmployeeById($id);

        if (!$data['employee']) redirect('employee/index');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hoTen       = trim($_POST['hoTen'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $ngaySinh    = $_POST['ngaySinh'] ?? '';

            if (empty($hoTen)) {
                $data['error'] = 'Vui lòng nhập họ tên';
            } elseif (!empty($soDienThoai) && !preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Số điện thoại không hợp lệ';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Email sai định dạng';
            } elseif (!empty($soDienThoai) && $userModel->phoneExistsExclude($soDienThoai, $id)) {
                $data['error'] = 'Số điện thoại này đã được sử dụng';
            } elseif (!empty($email) && $userModel->emailExistsExclude($email, $id)) {
                $data['error'] = 'Email này đã được sử dụng cho tài khoản khác';
            } elseif (!empty($ngaySinh) && $ngaySinh >= date('Y-m-d')) {
                $data['error'] = 'Ngày sinh phải ở quá khứ';
            } else {
                $updateData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai !== '' ? $soDienThoai : null,
                    'email'       => $email !== '' ? $email : null,
                    'diaChi'      => trim($_POST['diaChi'] ?? ''),
                    'ngaySinh'    => !empty($ngaySinh) ? $ngaySinh : null,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam',
                    'vaiTro'      => $_POST['vaiTro'] ?? 'NhanVien'
                ];
                $updateResult = $userModel->updateEmployee($id, $updateData);
                
                if ($updateResult === true) {
                    $_SESSION['toast_success'] = 'Cập nhật tài khoản thành công';
                    redirect('employee/index');
                    exit;
                } else {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            }
        }

        $this->view('employee/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        if ($id == Session::get('user_id')) {
            $_SESSION['error'] = 'Không thể xóa tài khoản đang đăng nhập';
            redirect('employee/index');
            exit;
        }

        $userModel = $this->model('UserModel');
        if ($userModel->deactivate($id)) {
            $_SESSION['toast_success'] = 'Đã xóa tài khoản thành công';
        }
        
        redirect('employee/index');
        exit;
    }

    public function restore($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        $userModel = $this->model('UserModel');
        if ($userModel->activate($id)) {
            $_SESSION['toast_success'] = 'Đã mở khóa tài khoản thành công';
        }
        
        redirect('employee/index');
        exit;
    }

    public function permissions($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $userModel = $this->model('UserModel');
        $data['employee'] = $userModel->getEmployeeById($id);
        
        if (!$data['employee']) redirect('employee/index');
        
        $maNhanVien = $data['employee']['maNhanVien'];
        
        $data['all_permissions'] = $userModel->getAllPermissions();
        $data['current_permissions'] = $userModel->getEmployeePermissions($maNhanVien);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $selectedPermissions = $_POST['permissions'] ?? [];
            
            if (empty($selectedPermissions)) {
                $data['error'] = 'Vui lòng chọn ít nhất một quyền';
            } else {
                if ($userModel->updateEmployeePermissions($maNhanVien, $selectedPermissions)) {
                    $_SESSION['toast_success'] = 'Cấp quyền thành công';
                    redirect('employee/index');
                    exit;
                } else {
                    $data['error'] = 'Lỗi kết nối CSDL, vui lòng thử lại sau';
                }
            }
            
            $data['current_permissions'] = $selectedPermissions; 
        }

        $this->view('employee/permissions', $data);
    }

    public function workshift() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $workShiftModel = $this->model('WorkShiftModel');
        $userModel = $this->model('UserModel');

        $fromDate = $_GET['from_date'] ?? date('Y-m-d');
        $toDate   = $_GET['to_date'] ?? date('Y-m-d', strtotime('+7 days'));

        $data['schedule']  = $workShiftModel->getSchedule($fromDate, $toDate);
        $data['employees'] = $userModel->getAllEmployees();
        $data['from_date'] = $fromDate;
        $data['to_date']   = $toDate;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maNhanVien = $_POST['maNhanVien'] ?? '';
            $ngayLam    = $_POST['ngayLam'] ?? '';
            $gioBatDau  = $_POST['gioBatDau'] ?? '';
            $gioKetThuc = $_POST['gioKetThuc'] ?? '';

            if (empty($maNhanVien) || empty($ngayLam) || empty($gioBatDau) || empty($gioKetThuc)) {
                $data['inline_error'] = 'Vui lòng chọn đầy đủ thông tin!';
            } else {
                $shiftData = [
                    'maNhanVien' => $maNhanVien,
                    'ngayLam'    => $ngayLam,
                    'caLam'      => 'TangCa',
                    'gioBatDau'  => $gioBatDau,
                    'gioKetThuc' => $gioKetThuc,
                    'ghiChu'     => $_POST['ghiChu'] ?? ''
                ];
                if ($workShiftModel->assignShift($shiftData)) {
                    $_SESSION['toast_success'] = 'Phân công tăng ca thành công'; 
                    redirect('employee/workshift?from_date=' . $fromDate . '&to_date=' . $toDate);
                    exit;
                } else {
                    $data['toast_error'] = 'Không thể kết nối CSDL. Vui lòng thử lại sau.';
                }
            }
        }

        $this->view('employee/workshift', $data);
    }
}
