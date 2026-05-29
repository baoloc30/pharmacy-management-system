<?php
class LandingController extends Controller {
    public function index() {
        // Nếu đã đăng nhập thì chuyển thẳng vào hệ thống
        if (Session::get('logged_in')) {
            redirect(Session::get('role') == 'QuanLy' ? 'home/admin' : 'home/employee');
            exit;
        }
        $this->viewLanding('landing/index', []);
    }

    // Render trang landing không dùng header/footer chung
    protected function viewLanding($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
