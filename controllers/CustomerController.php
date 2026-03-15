<?php
require_once 'models/CustomerModel.php';
require_once 'models/InvoiceModel.php';

class CustomerController extends Controller {

    public function index() {
        $this->checkLogin();
        $search = $_GET['search'] ?? '';
        $customerModel = $this->model('CustomerModel');
        $data['customers'] = $customerModel->getAllCustomers($search);
        $data['search'] = $search;
        $this->view('customer/index', $data);
    }

    public function add() {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customerModel = $this->model('CustomerModel');
            $hoTen = trim($_POST['hoTen'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');

            // Validate
            if (empty($hoTen) || empty($soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đầy đủ họ tên và số điện thoại';
            } elseif (!preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)';
            } elseif ($customerModel->phoneExists($soDienThoai)) {
                $data['error'] = 'Số điện thoại này đã tồn tại trong hệ thống';
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
                if ($customerModel->createCustomer($customerData)) {
                    // AJAX request
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                        $newId = $customerModel->lastId();
                        $customer = $customerModel->getCustomerById($newId);
                        echo json_encode(['success' => true, 'customer' => $customer]);
                        exit;
                    }
                    redirect('customer/index');
                } else {
                    $data['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
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
        $customerModel = $this->model('CustomerModel');
        $data['customer'] = $customerModel->getCustomerById($id);

        if (!$data['customer']) {
            redirect('customer/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hoTen       = trim($_POST['hoTen'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');

            if (empty($hoTen) || empty($soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đầy đủ họ tên và số điện thoại';
            } elseif (!preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['error'] = 'Vui lòng nhập đúng định dạng số điện thoại';
            } elseif ($customerModel->phoneExistsExcept($soDienThoai, $id)) {
                $data['error'] = 'Số điện thoại này đã được sử dụng cho khách hàng khác';
            } else {
                $updateData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai,
                    'email'       => $_POST['email'] ?? '',
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => $_POST['ngaySinh'] ?? null,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam',
                    'ghiChu'      => $_POST['ghiChu'] ?? ''
                ];
                if ($customerModel->updateCustomer($id, $updateData)) {
                    $data['success'] = 'Cập nhật thành công';
                    $data['customer'] = $customerModel->getCustomerById($id);
                } else {
                    $data['error'] = 'Cập nhật thất bại';
                }
            }
        }

        $this->view('customer/edit', $data);
    }

    public function history($id) {
        $this->checkLogin();
        $customerModel = $this->model('CustomerModel');
        $invoiceModel  = $this->model('InvoiceModel');

        $data['customer'] = $customerModel->getCustomerById($id);
        if (!$data['customer']) redirect('customer/index');

        $fromDate = $_GET['from_date'] ?? '';
        $toDate   = $_GET['to_date'] ?? '';

        $data['invoices']  = $invoiceModel->getByCustomer($id, $fromDate, $toDate);
        $data['from_date'] = $fromDate;
        $data['to_date']   = $toDate;

        $this->view('customer/history', $data);
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
