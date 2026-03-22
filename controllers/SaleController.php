<?php
require_once 'models/MedicineModel.php';
require_once 'models/CustomerModel.php';
require_once 'models/InvoiceModel.php';

class SaleController extends Controller {
    
    public function create() {
        $this->checkLogin();
        
        $medicineModel = $this->model('MedicineModel');
        $data['medicines'] = $medicineModel->getAvailable();

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
        $invoiceModel = $this->model('InvoiceModel');
        $keyword  = $_GET['keyword'] ?? '';
        $fromDate = $_GET['from_date'] ?? '';
        $toDate   = $_GET['to_date'] ?? '';
        $data['invoices']  = $invoiceModel->getFiltered($keyword, $fromDate, $toDate);
        $data['keyword']   = $keyword;
        $data['from_date'] = $fromDate;
        $data['to_date']   = $toDate;
        $this->view('sale/history', $data);
    }

    public function detail($id) {
        $this->checkLogin();
        $invoiceModel = $this->model('InvoiceModel');
        $data['invoice'] = $invoiceModel->getDetail($id);
        if (!$data['invoice']) redirect('sale/history');
        header('Content-Type: application/json');
        echo json_encode($data['invoice']);
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
        $keyword = $_GET['keyword'] ?? '';
        $medicineModel = $this->model('MedicineModel');
        $medicines = $medicineModel->search($keyword);
        header('Content-Type: application/json');
        echo json_encode(['medicines' => $medicines]);
        exit;
    }
}