<?php
require_once 'models/MedicineModel.php';
require_once 'models/SupplierModel.php';
require_once 'models/WarehouseModel.php';

class WarehouseController extends Controller {
    
    public function import() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $medicineModel = $this->model('MedicineModel');
        $supplierModel = $this->model('SupplierModel');
        
        $data['medicines'] = $medicineModel->all();
        $data['suppliers'] = $supplierModel->all();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $warehouseModel = $this->model('WarehouseModel');
            $importData = [
                'maNhanVien' => Session::get('nhan_vien_id'),
                'maNhaCC'    => $_POST['maNhaCC'] ?? '',
                'tongTien'   => (float)($_POST['tongTien'] ?? 0)
            ];
            $items = json_decode($_POST['items'] ?? '[]', true);

            header('Content-Type: application/json');
            if (empty($items)) {
                echo json_encode(['success' => false, 'message' => 'Danh sách thuốc trống']);
                exit;
            }
            if (empty($importData['maNhaCC'])) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn nhà cung cấp']);
                exit;
            }
            if ($warehouseModel->createImport($importData, $items)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi lưu phiếu nhập']);
            }
            exit;
        }
        
        $this->view('warehouse/import', $data);
    }

    public function stock() {
        $this->checkLogin();
        
        $medicineModel  = $this->model('MedicineModel');
        $supplierModel  = $this->model('SupplierModel');
        $data['medicines'] = $medicineModel->getStock();
        $data['suppliers'] = $supplierModel->all();
        $this->view('warehouse/stock', $data);
    }

    public function alert() {
        $this->checkLogin();
        $this->checkRole('QuanLy');
        
        $data = [];
        try {
            $medicineModel = $this->model('MedicineModel');
            
            $data['low_stock'] = $medicineModel->getLowStock(10);
            $data['expired'] = $medicineModel->getExpired(30);
        } catch (Exception $e) {
            $data['error'] = 'Không thể truy xuất dữ liệu';
            $data['low_stock'] = [];
            $data['expired'] = [];
        }
        
        $this->view('warehouse/alert', $data);
    }

    public function updateStock() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        $medicineModel  = $this->model('MedicineModel');
        $supplierModel  = $this->model('SupplierModel');
        $data['medicines'] = $medicineModel->getStock();
        $data['suppliers'] = $supplierModel->all();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $updates = $_POST['soLuong'] ?? [];
            $maNhanVien = Session::get('nhan_vien_id');
            $hasError = false;

            foreach ($updates as $maThuoc => $soLuong) {
                if ($soLuong === '' || $soLuong === null) continue;
                if (!is_numeric($soLuong) || $soLuong < 0) {
                    $hasError = true;
                    break;
                }
            }

            if ($hasError) {
                $data['error'] = 'Số lượng không hợp lệ, vui lòng chọn lại';
            } else {
                try {
                    foreach ($updates as $maThuoc => $soLuong) {
                        if ($soLuong === '' || $soLuong === null) continue;
                        $medicineModel->updateStockDirect((int)$maThuoc, (float)$soLuong, $maNhanVien);
                    }
                    $_SESSION['success'] = 'Cập nhật tồn kho thành công';
                    redirect('warehouse/stock');
                    exit;
                } catch (Exception $e) {
                    $data['error'] = 'Lỗi kết nối cơ sở dữ liệu khi cập nhật tồn kho';
                }
                $data['medicines'] = $medicineModel->getStock();
            }
        }

        $this->view('warehouse/stock', $data);
    }

    public function history() {
        $this->checkLogin();
        $this->checkRole('QuanLy');

        $warehouseModel = $this->model('WarehouseModel');
        $fromDate = $_GET['from_date'] ?? '';
        $toDate   = $_GET['to_date'] ?? '';
        $type     = $_GET['type'] ?? '';
        $search   = trim($_GET['search'] ?? '');

        $currentDate = date('Y-m-d');
        if (($fromDate && $fromDate > $currentDate) || ($toDate && $toDate > $currentDate)) {
            $data['error'] = 'Khoảng thời gian không hợp lệ, vui lòng chọn lại!';
        } elseif ($fromDate && $toDate && $fromDate > $toDate) {
            $data['error'] = 'Ngày bắt đầu không thể lớn hơn ngày kết thúc!';
        }

        if (!isset($data['error'])) {
            $data['history'] = $warehouseModel->getHistory($fromDate, $toDate, $type, $search);
        } else {
            $data['history'] = []; 
        }

        $data['from_date'] = $fromDate;
        $data['to_date']   = $toDate;
        $data['type']      = $type;
        $data['search']    = $search;
        
        $this->view('warehouse/history', $data);
    }

    public function ajaxGetDetail() {
        $this->checkLogin();
        header('Content-Type: application/json');
        
        $id = $_GET['id'] ?? 0;
        $type = $_GET['type'] ?? '';
        
        if (!$id || !$type) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
            exit;
        }
        
        $warehouseModel = $this->model('WarehouseModel');
        $data = $warehouseModel->getTransactionDetail($id, $type);
        
        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy chi tiết chứng từ']);
        }
        exit;
    }
}
