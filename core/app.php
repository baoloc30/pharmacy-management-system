<?php
class App {
    protected $controller = 'AuthController';
    protected $method = 'index';
    protected $params = [];

    // Map URL segment -> Controller class name
    private $routes = [
        'auth'      => 'AuthController',
        'home'      => 'HomeController',
        'medicine'  => 'MedicineController',
        'sale'      => 'SaleController',
        'warehouse' => 'WarehouseController',
        'statistic' => 'StatisticController',
        'customer'  => 'CustomerController',
        'category'  => 'CategoryController',
        'employee'  => 'EmployeeController',
        'supplier'  => 'SupplierController',
    ];

    public function __construct() {
        $url = $this->parseUrl();

        $segment = strtolower($url[0]);
        if (isset($this->routes[$segment])) {
            $this->controller = $this->routes[$segment];
            unset($url[0]);
        } elseif (file_exists(__DIR__ . '/../controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['auth', 'login'];
    }
}
