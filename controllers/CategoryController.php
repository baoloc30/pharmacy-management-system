<?php
require_once 'models/CategoryModel.php';

class CategoryController extends Controller {

    public function index() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        try {
            $categoryModel = $this->model('CategoryModel');
            $data['categories'] = $categoryModel->all();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể tải danh sách danh mục. Vui lòng kiểm tra kết nối và thử lại sau';
            $data['categories'] = [];
        }
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
                $categoryData = [
                    'tenDanhMuc' => $tenDanhMuc,
                    'moTa'       => $_POST['moTa'] ?? '',
                    'trangThai'  => $_POST['trangThai'] ?? 'SuDung'
                ];
                
                try {
                    $categoryModel = $this->model('CategoryModel');
                    if ($categoryModel->create($categoryData)) {
                        $_SESSION['success'] = 'Thêm danh mục thành công';
                        redirect('category/index');
                        exit;
                    } else {
                        $data['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                    }
                } catch (Exception $e) {
                    if ($e->getCode() == 1062) {
                        $data['error'] = 'Tên danh mục này đã tồn tại. Vui lòng chọn tên khác!';
                    } else {
                        $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                    }                
                }
            }
        }

        $this->view('category/add', $data ?? []);
    }

    public function edit($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        try {
            $categoryModel = $this->model('CategoryModel');
            $data['category'] = $categoryModel->findById($id);

            if (!$data['category']) {
                redirect('category/index');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            redirect('category/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tenDanhMuc = trim($_POST['tenDanhMuc'] ?? '');
            
            if (empty($tenDanhMuc)) {
                $data['error'] = 'Chưa nhập đầy đủ thông tin. Vui lòng nhập lại!';
            } else {
                $updateData = [
                    'tenDanhMuc' => $tenDanhMuc,
                    'moTa'       => $_POST['moTa'] ?? '',
                    'trangThai'  => $_POST['trangThai'] ?? 'SuDung'
                ];
                
                try {
                    if ($categoryModel->update($id, $updateData)) {
                        $_SESSION['success'] = 'Cập nhật danh mục thành công';
                        redirect('category/index');
                        exit;
                    } else {
                        $data['error'] = 'Cập nhật thất bại, vui lòng thử lại';
                    }
                } catch (Exception $e) {
                    if ($e->getCode() == 1062) {
                        $data['error'] = 'Tên danh mục này đã tồn tại. Vui lòng chọn tên khác!';
                    } else {
                        $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                    }
                }
            }
            
            if(isset($data['category'])) {
                $data['category']['tenDanhMuc'] = $tenDanhMuc;
                $data['category']['moTa'] = $_POST['moTa'] ?? '';
                $data['category']['trangThai'] = $_POST['trangThai'] ?? 'SuDung';
            }
        }

        $this->view('category/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        try {
            $categoryModel = $this->model('CategoryModel');
            if ($categoryModel->hasMedicines($id)) {
                $_SESSION['error'] = 'Không thể xóa danh mục này vì đang có thuốc thuộc danh mục. Vui lòng xóa hoặc chuyển các thuốc này sang danh mục khác trước khi xóa.';
            } else {
                if ($categoryModel->deleteById($id)) {
                    $_SESSION['success'] = 'Xóa danh mục thành công';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
        }
        redirect('category/index');
    }
}
