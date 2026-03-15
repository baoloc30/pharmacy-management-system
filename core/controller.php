<?php
class Controller {
    protected function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }

    protected function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    protected function viewLogin($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    protected function checkLogin() {
        Session::init();
        if (!Session::get('logged_in')) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }
    }

    protected function checkRole($role) {
        if (Session::get('role') != $role) {
            $home = Session::get('role') == 'QuanLy' ? 'home/admin' : 'home/employee';
            header('Location: ' . BASE_URL . $home);
            exit();
        }
    }
}
