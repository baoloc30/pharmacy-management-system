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

            $hasError = false;
            $ngaySinh = !empty($_POST['ngaySinh']) ? $_POST['ngaySinh'] : null;

            // Validate
            if ($ngaySinh && strtotime($ngaySinh) > time()) {
                $data['ngaySinh_error'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
                $hasError = true;
            }
            if (empty($hoTen)) {
                $data['hoTen_error'] = 'Vui lòng không bỏ trống thông tin này';
                $hasError = true;
            }
            if (empty($soDienThoai)) {
                $data['sdt_error'] = 'Vui lòng không bỏ trống thông tin này';
                $hasError = true;
            } elseif (!preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['sdt_error'] = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)';
                $hasError = true;
            } else {
                try {
                    if ($customerModel->phoneExists($soDienThoai)) {
                        $data['error'] = 'Số điện thoại này đã tồn tại trong hệ thống';
                        $hasError = true;
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                    $hasError = true;
                }
            }
            if (!$hasError) {
                $customerData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai,
                    'email'       => $_POST['email'] ?? '',
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => !empty($_POST['ngaySinh']) ? $_POST['ngaySinh'] : null,
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
                        
                        Session::set('success', 'Thêm khách hàng thành công');
                        redirect('customer/index');
                        exit;
                    } else {
                        $data['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $hasError) {
                echo json_encode(['success' => false, 'message' => $data['error'] ?? $data['sdt_error'] ?? 'Lỗi dữ liệu']);
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
            }
        } catch (Exception $e) {
            $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $this->view('customer/edit', $data ?? []);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hoTen       = trim($_POST['hoTen'] ?? '');
            $soDienThoai = trim($_POST['soDienThoai'] ?? '');
            $ngaySinh    = !empty($_POST['ngaySinh']) ? $_POST['ngaySinh'] : null;

            $hasError = false;

            if ($ngaySinh && strtotime($ngaySinh) > time()) {
                $data['ngaySinh_error'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
                $hasError = true;
            }
            if (empty($hoTen)) {
                $data['hoTen_error'] = 'Vui lòng không bỏ trống thông tin này';
                $hasError = true;
            }
            if (empty($soDienThoai)) {
                $data['sdt_error'] = 'Vui lòng không bỏ trống thông tin này';
                $hasError = true;
            } elseif (!preg_match('/^[0-9]{10}$/', $soDienThoai)) {
                $data['sdt_error'] = 'Vui lòng nhập đúng định dạng số điện thoại (10 chữ số)';
                $hasError = true;
            } else {
                try {
                    if ($customerModel->phoneExistsExcept($soDienThoai, $id)) {
                        $data['error'] = 'Số điện thoại này đã được sử dụng cho khách hàng khác';
                        $hasError = true;
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                    $hasError = true;
                }
            }

            if (!$hasError) {
                $updateData = [
                    'hoTen'       => $hoTen,
                    'soDienThoai' => $soDienThoai,
                    'email'       => $_POST['email'] ?? '',
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'ngaySinh'    => $ngaySinh,
                    'gioiTinh'    => $_POST['gioiTinh'] ?? 'Nam',
                    'ghiChu'      => $_POST['ghiChu'] ?? ''
                ];
                try {
                    if ($customerModel->updateCustomer($id, $updateData)) {
                        Session::set('success', 'Cập nhật thông tin khách hàng thành công');
                        redirect('customer/index');
                        exit;
                    } else {
                        $data['error'] = 'Cập nhật thất bại';
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            }

            // Giữ lại thông tin vừa nhập nếu có lỗi
            if ($hasError || isset($data['error'])) {
                $data['customer']['hoTen'] = $hoTen;
                $data['customer']['soDienThoai'] = $soDienThoai;
                $data['customer']['email'] = $_POST['email'] ?? '';
                $data['customer']['diaChi'] = $_POST['diaChi'] ?? '';
                $data['customer']['ngaySinh'] = $ngaySinh;
                $data['customer']['gioiTinh'] = $_POST['gioiTinh'] ?? 'Nam';
                $data['customer']['ghiChu'] = $_POST['ghiChu'] ?? '';
            }
        }

        $this->view('customer/edit', $data ?? []);
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
