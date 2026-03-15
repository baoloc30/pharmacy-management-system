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

            if (empty($hoTen) || empty($tenDangNhap) || empty($matKhau)) {
                $data['error'] = 'Vui lòng nhập đầy đủ thông tin';
            } elseif ($userModel->usernameExists($tenDangNhap)) {
                $data['error'] = 'Tên đăng nhập đã tồn tại';
            } else {
                $employeeData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $_POST['soDienThoai'] ?? '',
                    'email'       => $_POST['email'] ?? '',
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => $_POST['ngaySinh'] ?? null,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam'
                ];
                $accountData = [
                    'tenDangNhap' => $tenDangNhap,
                    'matKhau'     => $matKhau,
                    'vaiTro'      => $_POST['vaiTro'] ?? 'NhanVien'
                ];
                if ($userModel->createEmployee($employeeData, $accountData)) {
                    $data['success'] = 'Tạo tài khoản thành công';
                } else {
                    $data['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
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

            if (empty($hoTen)) {
                $data['error'] = 'Vui lòng nhập họ tên';
            } elseif (!empty($soDienThoai) && !preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Số điện thoại không hợp lệ';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Email sai định dạng';
            } else {
                $updateData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai,
                    'email'       => $email,
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => $_POST['ngaySinh'] ?? null,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam',
                    'vaiTro'      => $_POST['vaiTro'] ?? 'NhanVien'
                ];
                if ($userModel->updateEmployee($id, $updateData)) {
                    $data['success'] = 'Cập nhật thành công';
                    $data['employee'] = $userModel->getEmployeeById($id);
                } else {
                    $data['error'] = 'Cập nhật thất bại';
                }
            }
        }

        $this->view('employee/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        // Không cho xóa chính mình
        if ($id == Session::get('user_id')) {
            $_SESSION['error'] = 'Không thể xóa tài khoản đang đăng nhập';
            redirect('employee/index');
        }

        $userModel = $this->model('UserModel');
        $userModel->deactivate($id);
        redirect('employee/index');
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
                $data['error'] = 'Vui lòng chọn đầy đủ thông tin!';
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
                    $data['success'] = 'Phân công tăng ca thành công';
                    $data['schedule'] = $workShiftModel->getSchedule($fromDate, $toDate);
                } else {
                    $data['error'] = 'Không thể kết nối CSDL. Vui lòng thử lại sau.';
                }
            }
        }

        $this->view('employee/workshift', $data);
    }
}
