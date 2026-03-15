<?php
require_once 'models/CategoryModel.php';

class CategoryController extends Controller {

    public function index() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $categoryModel = $this->model('CategoryModel');
        $data['categories'] = $categoryModel->all();
        $this->view('category/index', $data);
    }

    public function add() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenDanhMuc = trim($_POST['tenDanhMuc'] ?? '');
            if (empty($tenDanhMuc)) {
                $data['error'] = 'Vui lòng nhập tên danh mục';
            } else {
                $categoryModel = $this->model('CategoryModel');
                $categoryData = [
                    'tenDanhMuc' => $tenDanhMuc,
                    'moTa'       => $_POST['moTa'] ?? '',
                    'trangThai'  => $_POST['trangThai'] ?? 'SuDung'
                ];
                if ($categoryModel->create($categoryData)) {
                    redirect('category/index');
                } else {
                    $data['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        }

        $this->view('category/add', $data ?? []);
    }

    public function edit($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $categoryModel = $this->model('CategoryModel');
        $data['category'] = $categoryModel->findById($id);

        if (!$data['category']) redirect('category/index');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenDanhMuc = trim($_POST['tenDanhMuc'] ?? '');
            if (empty($tenDanhMuc)) {
                $data['error'] = 'Vui lòng nhập tên danh mục';
            } else {
                $updateData = [
                    'tenDanhMuc' => $tenDanhMuc,
                    'moTa'       => $_POST['moTa'] ?? '',
                    'trangThai'  => $_POST['trangThai'] ?? 'SuDung'
                ];
                if ($categoryModel->update($id, $updateData)) {
                    $data['success'] = 'Cập nhật thành công';
                    $data['category'] = $categoryModel->findById($id);
                } else {
                    $data['error'] = 'Cập nhật thất bại';
                }
            }
        }

        $this->view('category/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        $categoryModel = $this->model('CategoryModel');

        if ($categoryModel->hasMedicines($id)) {
            $_SESSION['error'] = 'Không thể xóa danh mục đang có thuốc';
        } else {
            $categoryModel->deleteById($id);
        }
        redirect('category/index');
    }
}
