<?php
require_once 'models/SupplierModel.php';

class SupplierController extends Controller {

    public function index() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $supplierModel = $this->model('SupplierModel');
        $search = $_GET['search'] ?? '';
        $data['suppliers'] = $supplierModel->getAll($search);
        $data['search'] = $search;
        $this->view('supplier/index', $data);
    }

    public function add() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenNhaCC = trim($_POST['tenNhaCC'] ?? '');
            if (empty($tenNhaCC)) {
                $data['error'] = 'Vui lòng nhập tên nhà cung cấp';
            } else {
                $supplierModel = $this->model('SupplierModel');
                $supplierData = [
                    'tenNhaCC'    => $tenNhaCC,
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'soDienThoai' => $_POST['soDienThoai'] ?? '',
                    'email'       => $_POST['email'] ?? '',
                    'maSoThue'    => $_POST['maSoThue'] ?? '',
                    'nguoiLienHe' => $_POST['nguoiLienHe'] ?? ''
                ];
                if ($supplierModel->create($supplierData)) {
                    redirect('supplier/index');
                } else {
                    $data['error'] = 'Có lỗi xảy ra';
                }
            }
        }

        $this->view('supplier/add', $data ?? []);
    }

    public function edit($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $supplierModel = $this->model('SupplierModel');
        $data['supplier'] = $supplierModel->findById($id);

        if (!$data['supplier']) redirect('supplier/index');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenNhaCC = trim($_POST['tenNhaCC'] ?? '');
            if (empty($tenNhaCC)) {
                $data['error'] = 'Vui lòng nhập tên nhà cung cấp';
            } else {
                $updateData = [
                    'tenNhaCC'    => $tenNhaCC,
                    'diaChi'      => $_POST['diaChi'] ?? '',
                    'soDienThoai' => $_POST['soDienThoai'] ?? '',
                    'email'       => $_POST['email'] ?? '',
                    'maSoThue'    => $_POST['maSoThue'] ?? '',
                    'nguoiLienHe' => $_POST['nguoiLienHe'] ?? ''
                ];
                if ($supplierModel->update($id, $updateData)) {
                    $data['success'] = 'Cập nhật thành công';
                    $data['supplier'] = $supplierModel->findById($id);
                } else {
                    $data['error'] = 'Cập nhật thất bại';
                }
            }
        }

        $this->view('supplier/edit', $data);
    }
}
