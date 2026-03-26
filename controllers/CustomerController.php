<?php
require_once 'models/CustomerModel.php';
require_once 'models/InvoiceModel.php';

class CustomerController extends Controller {

    public function index() {
        $this->checkLogin();
        $search = trim($_GET['search'] ?? '');
        
        try {
            $customerModel = $this->model('CustomerModel');
            $data['customers'] = $customerModel->getAllCustomers($search);
            $data['search'] = $search;
            $this->view('customer/index', $data);
            
        } catch (Exception $e) {
            $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['customers'] = [];
            $data['search'] = $search;
            $this->view('customer/index', $data);
        }
    }

    public function add() {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customerModel = $this->model('CustomerModel');
            $hoTen = trim($_POST['hoTen'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $ngaySinh = !empty($_POST['ngaySinh']) ? $_POST['ngaySinh'] : null;

            // Validate
            if (empty($hoTen) || empty($soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đầy đủ họ tên và số điện thoại';
            } elseif (!preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)';
            } elseif ($customerModel->phoneExists($soDienThoai)) {
                $data['error'] = 'Số điện thoại này đã tồn tại trong hệ thống';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                $data['error'] = 'Email không đúng định dạng';
            } elseif ($ngaySinh && strtotime($ngaySinh) > time()) { 
                $data['error'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
            } else {
                $customerData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai,
                    'email'       => $_POST['email'] ?? '',
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => $_POST['ngaySinh'] ?? null,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam',
                    'ghiChu'      => $_POST['ghiChu'] ?? ''
                ];
                
                try {
                    if ($customerModel->createCustomer($customerData)) {
                        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                            $newId = $customerModel->lastId();
                            $customer = $customerModel->getCustomerById($newId);
                            echo json_encode(['success' => true, 'customer' => $customer]);
                            exit;
                        }
                        
                        $_SESSION['success'] = 'Thêm khách hàng thành công';
                        redirect('customer/index');
                        exit;
                    } else {
                        throw new Exception("Lỗi Database");
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                echo json_encode(['success' => false, 'message' => $data['error'] ?? '']);
                exit;
            }
        }

        $this->view('customer/add', $data ?? []);
    }

    public function edit($id) {
        $this->checkLogin();
        
        try {
            $customerModel = $this->model('CustomerModel');
            $data['customer'] = $customerModel->getCustomerById($id);
            
            if (!$data['customer']) {
                redirect('customer/index');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            redirect('customer/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hoTen       = trim($_POST['hoTen'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');
            $email       = trim($_POST['email'] ?? '');
            $ngaySinh    = !empty($_POST['ngaySinh']) ? $_POST['ngaySinh'] : null;

            // Validate
            if (empty($hoTen) || empty($soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đầy đủ họ tên và số điện thoại';
            } elseif (!preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)';
            } elseif ($customerModel->phoneExistsExcept($soDienThoai, $id)) {
                $data['error'] = 'Số điện thoại này đã được sử dụng cho khách hàng khác';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error'] = 'Email không đúng định dạng';
            } elseif ($ngaySinh && strtotime($ngaySinh) > time()) {
                $data['error'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
            } else {
                $updateData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai,
                    'email'       => $email,
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => $ngaySinh,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam',
                    'ghiChu'      => $_POST['ghiChu'] ?? ''
                ];
                
                try {
                    if ($customerModel->updateCustomer($id, $updateData)) {
                        $_SESSION['success'] = 'Cập nhật thành công';
                        redirect('customer/index');
                        exit;
                    } else {
                        throw new Exception("Lỗi Database");
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            }
            
            $data['customer']['hoTen'] = $hoTen;
            $data['customer']['soDienThoai'] = $soDienThoai;
            $data['customer']['email'] = $email;
            $data['customer']['ngaySinh'] = $ngaySinh;
            $data['customer']['diaChi'] = $_POST['diaChi'] ?? '';
            $data['customer']['gioiTinh'] = $_POST['gioiTinh'] ?? 'Nam';
            $data['customer']['ghiChu'] = $_POST['ghiChu'] ?? '';
        }

        $this->view('customer/edit', $data);
    }

    public function history($id) {
        $this->checkLogin();
        
        try {
            $customerModel = $this->model('CustomerModel');
            $invoiceModel  = $this->model('InvoiceModel');

            $data['customer'] = $customerModel->getCustomerById($id);
            if (!$data['customer']) {
                redirect('customer/index');
                exit;
            }

            $fromDate = $_GET['from_date'] ?? '';
            $toDate   = $_GET['to_date'] ?? '';

            $data['invoices']  = $invoiceModel->getByCustomer($id, $fromDate, $toDate);
            $data['from_date'] = $fromDate;
            $data['to_date']   = $toDate;

            $this->view('customer/history', $data);
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            redirect('customer/index');
            exit;
        }
    }

    public function search() {
        $this->checkLogin();
        $phone = $_GET['phone'] ?? '';
        $customerModel = $this->model('CustomerModel');
        $customer = $customerModel->findByPhone($phone);

        header('Content-Type: application/json');
        if ($customer) {
            echo json_encode(['success' => true, 'customer' => $customer]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
}