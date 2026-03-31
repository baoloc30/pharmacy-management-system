<?php
require_once 'models/MedicineModel.php';
require_once 'models/CategoryModel.php';

class MedicineController extends Controller {
    
    public function index() {
        $this->checkLogin();
        
        try {
            $medicineModel = $this->model('MedicineModel');
            $categoryModel = $this->model('CategoryModel');
            
            $data['medicines'] = $medicineModel->getAllWithCategory();
            $data['categories'] = $categoryModel->all();
            $this->view('medicine/index', $data);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['medicines'] = [];
            $data['categories'] = [];
            $this->view('medicine/index', $data);
        }
    }

    private function standardizeFilename($string) {
        $accents_regex = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($accents_regex as $nonAccent=>$accent){
            $string = preg_replace("/($accent)/i", $nonAccent, $string);
        }
        
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        $string = trim($string, '-');
        
        return $string;
    }

    public function add() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $categoryModel = $this->model('CategoryModel');
        $data['categories'] = $categoryModel->all();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $medicineData = [
                'maDanhMuc'     => $_POST['maDanhMuc'] ?? '',
                'tenThuoc'      => trim($_POST['tenThuoc'] ?? ''),
                'donViTinh'     => trim($_POST['donViTinh'] ?? ''),
                'donViLe'       => trim($_POST['donViLe'] ?? ''),
                'soLuongQuyDoi' => $_POST['soLuongQuyDoi'] ?? 1,
                'giaBan'        => $_POST['giaBan'] ?? '',
                'giaBanLe'      => $_POST['giaBanLe'] ?? null,
                'giaNhap'       => $_POST['giaNhap'] ?? '',
                'soLuongTon'    => $_POST['soLuongTon'] ?? 0,
                'hanSuDung'     => $_POST['hanSuDung'] ?? '',
                'xuatXu'        => trim($_POST['xuatXu'] ?? ''),
                'thanhPhan'     => trim($_POST['thanhPhan'] ?? ''),
                'congDung'      => trim($_POST['congDung'] ?? ''),
                'cachDung'      => trim($_POST['cachDung'] ?? ''),
                'trangThai'     => 'DangBan'
            ];

            $hinhAnhFileName = null;
            
            if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] == UPLOAD_ERR_OK) {
                
                $uploadDir = 'uploads/medicines/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileInfo = pathinfo($_FILES['hinhAnh']['name']);
                $ext = strtolower($fileInfo['extension']);
                $allowed = ['jpg', 'jpeg', 'png'];

                if (in_array($ext, $allowed)) {
                    if ($_FILES['hinhAnh']['size'] <= 2 * 1024 * 1024) {
                        $standardName = $this->standardizeFilename($medicineData['tenThuoc']);                        
                        if(empty($standardName)) $standardName = "thuoc_" . time();
                        $newFileName = $standardName . '.' . $ext;
                        if (file_exists($uploadDir . $newFileName)) {
                            unlink($uploadDir . $newFileName);
                        }
                        if (move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $uploadDir . $newFileName)) {
                            $hinhAnhFileName = $newFileName;
                        } else {
                            $data['error'] = 'Lỗi không thể lưu file ảnh vào thư mục.';
                        }
                    } else {
                        $data['error'] = 'Kích thước ảnh quá lớn (tối đa 2MB).';
                    }
                } else {
                    $data['error'] = 'Định dạng ảnh không hợp lệ (chỉ chấp nhận JPG, JPEG, PNG).';
                }
            }
            
            $medicineData['hinhAnh'] = $hinhAnhFileName;
            
            if (!isset($data['error'])) {
                try {
                    $medicineModel = $this->model('MedicineModel');
                    if($medicineModel->create($medicineData)) {
                        $_SESSION['success'] = 'Thêm thuốc thành công';
                        redirect('medicine/index');
                        exit;
                    }
                } catch (Exception $e) {
                    if($hinhAnhFileName && file_exists('uploads/medicines/'.$hinhAnhFileName)){
                        unlink('uploads/medicines/'.$hinhAnhFileName);
                    }
                    if ($e->getCode() == 1062) {
                        $data['error'] = 'Tên thuốc này đã tồn tại trong hệ thống. Vui lòng kiểm tra lại!';
                    } else {
                        $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                    }
                }
            }

            $data['medicine'] = $medicineData;
        }
        
        $this->view('medicine/add', $data);
    }

    public function edit($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        try {
            $medicineModel = $this->model('MedicineModel');
            $categoryModel = $this->model('CategoryModel');
            
            $data['medicine'] = $medicineModel->getDetail($id);
            if (!$data['medicine']) {
                redirect('medicine/index');
                exit;
            }
            $data['categories'] = $categoryModel->all();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            redirect('medicine/index');
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $medicineData = [
                'maDanhMuc'     => $_POST['maDanhMuc'] ?? '',
                'tenThuoc'      => trim($_POST['tenThuoc'] ?? ''),
                'donViTinh'     => trim($_POST['donViTinh'] ?? ''),
                'donViLe'       => trim($_POST['donViLe'] ?? ''),
                'soLuongQuyDoi' => $_POST['soLuongQuyDoi'] ?? 1,
                'giaBan'        => $_POST['giaBan'] ?? '',
                'giaBanLe'      => $_POST['giaBanLe'] ?? null,
                'giaNhap'       => $_POST['giaNhap'] ?? '',
                'hanSuDung'     => $_POST['hanSuDung'] ?? '',
                'xuatXu'        => trim($_POST['xuatXu'] ?? ''),
                'thanhPhan'     => trim($_POST['thanhPhan'] ?? ''),
                'congDung'      => trim($_POST['congDung'] ?? ''),
                'cachDung'      => trim($_POST['cachDung'] ?? ''),
                'soLuongTon'    => $data['medicine']['soLuongTon'],
                'trangThai'     => $data['medicine']['trangThai']
            ];

            $hinhAnhFileName = $_POST['hinhAnhCu'] ?? null;
            
            if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/medicines/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileInfo = pathinfo($_FILES['hinhAnh']['name']);
                $ext = strtolower($fileInfo['extension']);
                $allowed = ['jpg', 'jpeg', 'png'];

                if (in_array($ext, $allowed)) {
                    if ($_FILES['hinhAnh']['size'] <= 2 * 1024 * 1024) { 
                        $standardName = $this->standardizeFilename($medicineData['tenThuoc']);
                        if(empty($standardName)) $standardName = "thuoc_" . time();
                        
                        $newFileName = $standardName . '_' . time() . '.' . $ext;

                        if (move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $uploadDir . $newFileName)) {
                            if ($hinhAnhFileName && file_exists($uploadDir . $hinhAnhFileName)) {
                                unlink($uploadDir . $hinhAnhFileName);
                            }
                            $hinhAnhFileName = $newFileName;
                        } else {
                            $data['error'] = 'Lỗi không thể lưu file ảnh mới.';
                        }
                    } else {
                        $data['error'] = 'Kích thước ảnh quá lớn (tối đa 2MB).';
                    }
                } else {
                    $data['error'] = 'Định dạng ảnh không hợp lệ (chỉ chấp nhận JPG, JPEG, PNG).';
                }
            }
            
            $medicineData['hinhAnh'] = $hinhAnhFileName;

            if (!isset($data['error'])) {
                try {
                    if($medicineModel->update($id, $medicineData)) {
                        $_SESSION['success'] = 'Cập nhật thuốc thành công';
                        redirect('medicine/index');
                        exit;
                    }
                } catch (Exception $e) {
                    if ($e->getCode() == 1062) {
                        $data['error'] = 'Tên thuốc này đã tồn tại trong hệ thống. Vui lòng kiểm tra lại!';
                    } else {
                        $data['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
                    }
                }
            }
            
            $data['medicine'] = array_merge($data['medicine'], $medicineData);
        }
        
        $this->view('medicine/edit', $data);
    }

    public function delete($id) {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        try {
            $medicineModel = $this->model('MedicineModel');
            
            if ($medicineModel->hasTransactions($id)) {
                $medicineModel->setStatus($id, 'NgungBan');
                
                $_SESSION['warning'] = 'Thuốc đã phát sinh giao dịch nên không thể xóa hoàn toàn. Hệ thống đã chuyển sang trạng thái ngừng kinh doanh';
            } else {
                $medicineModel->deleteById($id);
                $_SESSION['success'] = 'Xóa thuốc thành công';
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
        }
        
        redirect('medicine/index');
    }

    public function search() {
        $this->checkLogin();
        
        $keyword = trim($_GET['keyword'] ?? '');
        $categoryId = trim($_GET['category_id'] ?? '');
        
        if ($keyword === '' && $categoryId === '') {
            redirect('medicine/index');
            exit;
        }

        try {
            $medicineModel = $this->model('MedicineModel');
            $categoryModel = $this->model('CategoryModel');
            
            $data['medicines'] = $medicineModel->search($keyword, $categoryId);
            $data['categories'] = $categoryModel->all();
            $data['keyword'] = $keyword;
            $data['category_id'] = $categoryId;

            if (empty($data['medicines'])) {
                $_SESSION['warning'] = 'Không tìm thấy thuốc phù hợp';
            }
            
            $this->view('medicine/index', $data);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['medicines'] = [];
            $data['categories'] = [];
            $data['keyword'] = $keyword;
            $data['category_id'] = $categoryId;
            $this->view('medicine/index', $data);
        }
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

    public function detail($id = null) {
        $this->checkLogin();
        
        if (empty($id) || !is_numeric($id)) {
            redirect('medicine/index');
            exit;
        }

        try {
            $medicineModel = $this->model('MedicineModel');
            $data['medicine'] = $medicineModel->getDetail($id);
            
            if (!$data['medicine']) {
                $_SESSION['warning'] = 'Thuốc này không tồn tại hoặc đã bị xóa khỏi hệ thống.';
                redirect('medicine/index');
                exit;
            }
            
            $this->view('medicine/detail', $data);
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            redirect('medicine/index');
            exit;
        }
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