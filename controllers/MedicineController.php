<?php
require_once 'models/MedicineModel.php';
require_once 'models/CategoryModel.php';

class MedicineController extends Controller {
    
    public function index() {
        $this->checkLogin();
        
        $medicineModel = $this->model('MedicineModel');
        $categoryModel = $this->model('CategoryModel');

        try {
            $data['categories'] = $categoryModel->all(); 
            $data['medicines'] = $medicineModel->getAllWithCategory();
        } catch (Exception $e) {
            $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['medicines'] = [];
        }
        
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
        
        $keyword = trim($_GET['keyword'] ?? '');
        $categoryId = $_GET['maDanhMuc'] ?? ''; 
        
        $medicineModel = $this->model('MedicineModel');
        $categoryModel = $this->model('CategoryModel');
        
        try {
            $data['categories'] = $categoryModel->all();
            $data['medicines'] = $medicineModel->search($keyword, $categoryId);
        } catch (Exception $e) {
            $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['medicines'] = [];
        }
        
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
        try {
            $medicineModel = $this->model('MedicineModel');
            $data['medicine'] = $medicineModel->getDetail($id);
            
            if (!$data['medicine']) {
                $data['error'] = 'Không tìm thấy thông tin thuốc này trong hệ thống.';
            }
        } catch (Exception $e) {
            $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['medicine'] = null;
        }
        
        $this->view('medicine/detail', $data ?? []);
    }
}
