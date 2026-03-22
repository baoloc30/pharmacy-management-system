<?php
require_once 'models/MedicineModel.php';
require_once 'models/CategoryModel.php';

class MedicineController extends Controller {
    
    public function index() {
        $this->checkLogin();
        
        $medicineModel = $this->model('MedicineModel');
        $data['medicines'] = $medicineModel->getAllWithCategory();
        $this->view('medicine/index', $data);
    }

    public function add() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $categoryModel = $this->model('CategoryModel');
        $data['categories'] = $categoryModel->all();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $medicineData = [
                'maDanhMuc' => $_POST['maDanhMuc'],
                'tenThuoc' => $_POST['tenThuoc'],
                'donViTinh' => $_POST['donViTinh'],
                'giaBan' => $_POST['giaBan'],
                'giaNhap' => $_POST['giaNhap'],
                'soLuongTon' => $_POST['soLuongTon'],
                'hanSuDung' => $_POST['hanSuDung'],
                'xuatXu' => $_POST['xuatXu'],
                'thanhPhan' => $_POST['thanhPhan'],
                'congDung' => $_POST['congDung'],
                'cachDung' => $_POST['cachDung']
            ];
            
            $medicineModel = $this->model('MedicineModel');
            if($medicineModel->create($medicineData)) {
                redirect('medicine/index');
            }
        }
        
        $this->view('medicine/add', $data);
    }

    public function edit($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $medicineModel = $this->model('MedicineModel');
        $categoryModel = $this->model('CategoryModel');
        
        $data['medicine'] = $medicineModel->find($id);
        $data['categories'] = $categoryModel->all();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($medicineModel->update($id, $_POST)) {
                redirect('medicine/index');
            }
        }
        
        $this->view('medicine/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $medicineModel = $this->model('MedicineModel');
        // Kiểm tra thuốc đã có giao dịch chưa
        if ($medicineModel->hasTransactions($id)) {
            // Chuyển sang trạng thái ngừng bán
            $medicineModel->setStatus($id, 'NgungBan');
            $_SESSION['warning'] = 'Thuốc đã phát sinh giao dịch nên không thể xóa hoàn toàn. Hệ thống đã chuyển sang trạng thái ngừng bán.';
        } else {
            $medicineModel->deleteById($id);
            $_SESSION['success'] = 'Xóa thuốc thành công';
        }
        redirect('medicine/index');
    }

    public function search() {
        $this->checkLogin();
        
        $keyword = $_GET['keyword'] ?? '';
        $medicineModel = $this->model('MedicineModel');
        $data['medicines'] = $medicineModel->search($keyword);
        $this->view('medicine/index', $data);
    }

    public function updatePrice() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        $medicineModel = $this->model('MedicineModel');
        $data['medicines'] = $medicineModel->getAllWithCategory();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prices = $_POST['giaMoi'] ?? [];
            $hasError = false;

            foreach ($prices as $id => $price) {
                if ($price === '' || $price === null) continue;
                if (!is_numeric($price) || $price <= 0) {
                    $hasError = true;
                    break;
                }
            }

            if ($hasError) {
                $data['error'] = 'Giá không hợp lệ, vui lòng chọn lại!';
            } else {
                foreach ($prices as $id => $price) {
                    if ($price === '' || $price === null) continue;
                    $medicineModel->updatePrice((int)$id, (float)$price);
                }
                $data['success'] = 'Cập nhật giá thành công';
                $data['medicines'] = $medicineModel->getAllWithCategory();
            }
        }

        $this->view('medicine/update_price', $data);
    }

    public function detail($id) {
        $this->checkLogin();
        $medicineModel = $this->model('MedicineModel');
        $data['medicine'] = $medicineModel->getDetail($id);
        if (!$data['medicine']) redirect('medicine/index');
        $this->view('medicine/detail', $data);
    }

    public function updateUnit() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        $medicineModel = $this->model('MedicineModel');
        $data['medicines'] = $medicineModel->getAllWithCategoryAndUnit();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $donViLeArr      = $_POST['donViLe']       ?? [];
            $soLuongArr      = $_POST['soLuongQuyDoi'] ?? [];
            $giaBanLeArr     = $_POST['giaBanLe']      ?? [];

            foreach ($donViLeArr as $id => $donViLe) {
                $soLuong  = isset($soLuongArr[$id])  ? (int)$soLuongArr[$id]    : 1;
                $giaBanLe = isset($giaBanLeArr[$id]) ? (float)$giaBanLeArr[$id] : 0;
                if ($soLuong < 1) $soLuong = 1;
                $medicineModel->updateUnit((int)$id, trim($donViLe), $soLuong, $giaBanLe);
            }

            $data['success'] = 'Cập nhật đơn vị lẻ thành công';
            $data['medicines'] = $medicineModel->getAllWithCategoryAndUnit();
        }

        $this->view('medicine/update_unit', $data);
    }
}