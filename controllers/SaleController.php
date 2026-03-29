<?php
require_once 'models/MedicineModel.php';
require_once 'models/CustomerModel.php';
require_once 'models/InvoiceModel.php';
require_once 'models/CategoryModel.php';

class SaleController extends Controller {
    
    public function create() {
        $this->checkLogin();
        
        $medicineModel = $this->model('MedicineModel');
        $categoryModel = $this->model('CategoryModel');
        $data['medicines'] = $medicineModel->getAvailable();
        $data['categories'] = $categoryModel->all();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $invoiceModel = $this->model('InvoiceModel');
            $invoiceData = [
                'maNhanVien'           => Session::get('nhan_vien_id'),
                'maKhachHang'          => !empty($_POST['maKhachHang']) ? (int)$_POST['maKhachHang'] : null,
                'tongTien'             => (float)$_POST['tongTien'],
                'tienGiam'             => (float)($_POST['tienGiam'] ?? 0),
                'phuongThucThanhToan'  => $_POST['phuongThucThanhToan'] ?? 'TienMat'
            ];
            $cart = json_decode($_POST['cart'], true);

            if (empty($cart)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Giỏ hàng trống']);
                exit;
            }

            $maHoaDon = $invoiceModel->createInvoice($invoiceData, $cart);
            header('Content-Type: application/json');
            if ($maHoaDon) {
                echo json_encode(['success' => true, 'invoice_id' => $maHoaDon]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra']);
            }
            exit;
        }

        $this->view('sale/create', $data);
    }

    public function history() {
        $this->checkLogin();
        try {
            $invoiceModel = $this->model('InvoiceModel');
            $keyword  = $_GET['keyword'] ?? '';
            $fromDate = $_GET['from_date'] ?? '';
            $toDate   = $_GET['to_date'] ?? '';
            
            $data['invoices']  = $invoiceModel->getFiltered($keyword, $fromDate, $toDate);
            $data['keyword']   = $keyword;
            $data['from_date'] = $fromDate;
            $data['to_date']   = $toDate;
            
            $this->view('sale/history', $data);
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau';
            $data['invoices']  = [];
            $data['keyword']   = $_GET['keyword'] ?? '';
            $data['from_date'] = $_GET['from_date'] ?? '';
            $data['to_date']   = $_GET['to_date'] ?? '';
            
            $this->view('sale/history', $data);
        }
    }

    public function detail($id) {
        $this->checkLogin();
        
        try {
            $invoiceModel = $this->model('InvoiceModel');
            $invoice = $invoiceModel->getDetail($id);
            
            header('Content-Type: application/json');
            if (!$invoice) {
                echo json_encode(['success' => false, 'message' => 'Hóa đơn không tồn tại']);
            } else {
                echo json_encode(['success' => true, 'data' => $invoice]);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau']);
        }
        exit;
    }

    public function print($id) {
        $this->checkLogin();
        $invoiceModel = $this->model('InvoiceModel');
        $data['invoice'] = $invoiceModel->getDetail($id);
        // Dùng viewLogin để không wrap header/footer
        $this->viewLogin('sale/print', $data);
    }

    public function searchMedicine() {
        $this->checkLogin();
        $keyword = trim($_GET['keyword'] ?? '');
        $categoryId = trim($_GET['category_id'] ?? '');
        
        try {
            $medicineModel = $this->model('MedicineModel');
            $medicines = $medicineModel->search($keyword, $categoryId);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'medicines' => $medicines]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau']);
        }
        exit;
    }

    private function getPaymentDir() {
        $dir = dirname(__DIR__) . '/uploads/payments/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        return $dir;
    }

    public function checkPayment() {
        $code = trim($_GET['code'] ?? '');
        $dir = $this->getPaymentDir();
        $file = $dir . $code . '.txt';
        
        header('Content-Type: application/json');
        if (file_exists($file)) {
            unlink($file);
            echo json_encode(['paid' => true]);
        } else {
            echo json_encode(['paid' => false]);
        }
        exit;
    }

    public function webhook() {
        $jsonData = file_get_contents('php://input');
        
        $logDir = dirname(__DIR__) . '/uploads/';
        if (!is_dir($logDir)) mkdir($logDir, 0777, true);
        file_put_contents($logDir . 'sepay_log.txt', date('Y-m-d H:i:s') . " - Payload: " . $jsonData . PHP_EOL, FILE_APPEND);
        
        $data = json_decode($jsonData, true);

        $content = '';
        if (isset($data['content'])) $content = $data['content']; 
        elseif (isset($data['transferContent'])) $content = $data['transferContent']; 
        elseif (isset($data['data']['content'])) $content = $data['data']['content']; 

        if (!empty($content)) {
            $content = strtoupper($content); 
            
            preg_match('/DH\d+/', $content, $matches);

            if (!empty($matches[0])) {
                $code = $matches[0];
                $amount = $data['transferAmount'] ?? $data['amount'] ?? $data['data']['amount'] ?? 0; 
                
                $dir = $this->getPaymentDir();
                file_put_contents($dir . $code . '.txt', 'PAID_AMOUNT_' . $amount);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Đã nhận thành công mã ' . $code]);
                exit;
            }
        }
        
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy mã đơn hàng hợp lệ']);
        exit;
    }
}