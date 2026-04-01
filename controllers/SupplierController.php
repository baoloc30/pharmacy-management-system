<?php
require_once 'models/SupplierModel.php';

class SupplierController extends Controller {

    public function index() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        try {
            $supplierModel = $this->model('SupplierModel');
            $search = $_GET['search'] ?? '';
            $data['suppliers'] = $supplierModel->getAll($search);
            $data['search'] = $search;
            $this->view('supplier/index', $data);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['suppliers'] = [];
            $data['search'] = '';
            $this->view('supplier/index', $data);
        }
    }

    public function add() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $supplierData = [
                'tenNhaCC'    => trim($_POST['tenNhaCC'] ?? ''),
                'soDienThoai' => trim($_POST['soDienThoai'] ?? ''),
                'email'       => trim($_POST['email'] ?? ''),
                'maSoThue'    => trim($_POST['maSoThue'] ?? ''),
                'nguoiLienHe' => trim($_POST['nguoiLienHe'] ?? ''),
                'diaChi'      => trim($_POST['diaChi'] ?? ''),
                'ghiChu'      => trim($_POST['ghiChu'] ?? ''),
                'trangThai'   => $_POST['trangThai'] ?? 'HoatDong'
            ];

            $errors = [];
            
            if (empty($supplierData['tenNhaCC'])) {
                $errors['tenNhaCC'] = 'Vui lòng nhập đầy đủ thông tin';
            }
            
            if (empty($supplierData['soDienThoai'])) {
                $errors['soDienThoai'] = 'Vui lòng nhập đầy đủ thông tin';
            } elseif (!preg_match('/^[0-9]{10}$/', $supplierData['soDienThoai'])) {
                $errors['soDienThoai'] = 'Số điện thoại không hợp lệ (chỉ gồm 10 chữ số)';
            }

            if (!empty($supplierData['email']) && !filter_var($supplierData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ';
            }

            if (empty($errors)) {
                try {
                    $supplierModel = $this->model('SupplierModel');
                    
                    $nameExists = $supplierModel->checkNameExists($supplierData['tenNhaCC']);
                    $phoneExists = $supplierModel->checkPhoneExists($supplierData['soDienThoai']);
                    
                    if ($nameExists) {
                        $errors['tenNhaCC'] = 'Tên nhà cung cấp này đã tồn tại';
                    }
                    if ($phoneExists) {
                        $errors['soDienThoai'] = 'Số điện thoại này đã được sử dụng';
                    }

                    if (!empty($errors)) {
                        $data['field_errors'] = $errors;
                        $data['error'] = 'Vui lòng kiểm tra lại thông tin nhập';
                    } else {
                        if ($supplierModel->create($supplierData)) {
                            $_SESSION['success'] = 'Thêm nhà cung cấp thành công';
                            redirect('supplier/index');
                            exit;
                        } else {
                            $data['error'] = 'Không thể lưu dữ liệu, vui lòng thử lại';
                        }
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            } else {
                $data['field_errors'] = $errors; 
                $data['error'] = $errors['general'] ?? 'Vui lòng kiểm tra lại thông tin nhập';
            }
            $data['supplier'] = $supplierData;
        }

        $this->view('supplier/add', $data ?? []);
    }

    public function edit($id) {
        if (empty($id) || !is_numeric($id)) {
            redirect('supplier/index');
            exit;
        }
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        try {
            $supplierModel = $this->model('SupplierModel');
            $data['supplier'] = $supplierModel->findById($id);

            if (!$data['supplier']) {
                $_SESSION['warning'] = 'Không tìm thấy nhà cung cấp';
                redirect('supplier/index');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            redirect('supplier/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $updateData = [
                'tenNhaCC'    => trim($_POST['tenNhaCC'] ?? ''),
                'soDienThoai' => trim($_POST['soDienThoai'] ?? ''),
                'email'       => trim($_POST['email'] ?? ''),
                'maSoThue'    => trim($_POST['maSoThue'] ?? ''),
                'nguoiLienHe' => trim($_POST['nguoiLienHe'] ?? ''),
                'diaChi'      => trim($_POST['diaChi'] ?? ''),
                'ghiChu'      => trim($_POST['ghiChu'] ?? ''),
                'trangThai'   => $_POST['trangThai'] ?? 'HoatDong'
            ];

            $errors = [];
            
            if (empty($updateData['tenNhaCC'])) {
                $errors['tenNhaCC'] = 'Vui lòng nhập đầy đủ thông tin';
            }
            
            if (empty($updateData['soDienThoai'])) {
                $errors['soDienThoai'] = 'Vui lòng nhập đầy đủ thông tin';
            } elseif (!preg_match('/^[0-9]{10}$/', $updateData['soDienThoai'])) {
                $errors['soDienThoai'] = 'Số điện thoại không hợp lệ (chỉ gồm 10 chữ số)';
            }
            
            if (!empty($updateData['email']) && !filter_var($updateData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ';
            }

            if (empty($errors)) {
                try {
                    $nameExists = $supplierModel->checkNameExists($updateData['tenNhaCC'], $id);
                    $phoneExists = $supplierModel->checkPhoneExists($updateData['soDienThoai'], $id);
                    
                    if ($nameExists) {
                        $errors['tenNhaCC'] = 'Tên nhà cung cấp này đã tồn tại';
                    }
                    if ($phoneExists) {
                        $errors['soDienThoai'] = 'Số điện thoại này đã được sử dụng';
                    }

                    if (!empty($errors)) {
                        $data['field_errors'] = $errors;
                        $data['error'] = 'Vui lòng kiểm tra lại thông tin nhập';
                    } else {
                        if ($supplierModel->update($id, $updateData)) {
                            $_SESSION['success'] = 'Cập nhật nhà cung cấp thành công';
                            redirect('supplier/index');
                            exit;
                        } else {
                            $data['error'] = 'Cập nhật thất bại, vui lòng thử lại';
                        }
                    }
                } catch (Exception $e) {
                    $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                }
            } else {
                $data['field_errors'] = $errors;
                $data['error'] = $errors['general'] ?? 'Vui lòng kiểm tra lại thông tin nhập';
            }
            $data['supplier'] = array_merge($data['supplier'], $updateData);
        }

        $this->view('supplier/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        try {
            $supplierModel = $this->model('SupplierModel');

            if ($supplierModel->hasTransactions($id)) {
                $supplierModel->setStatus($id, 'NgungGiaoDich');
                $_SESSION['warning'] = 'Nhà cung cấp đã phát sinh giao dịch, hệ thống tự động chuyển sang trạng thái Ngừng giao dịch';
            } else {
                $supplierModel->deleteById($id);
                $_SESSION['success'] = 'Đã xóa nhà cung cấp thành công';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
        }
        
        redirect('supplier/index');
    }
}