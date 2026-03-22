<?php
// Clear OPcache nếu có
if (function_exists('opcache_reset')) { opcache_reset(); }
// Tự động detect BASE_URL theo thư mục thực tế
$_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$_host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
$_script   = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$_folder   = trim(dirname($_script), '/');
$_base     = $_folder ? $_protocol . '://' . $_host . '/' . $_folder . '/' : $_protocol . '://' . $_host . '/';

define('BASE_URL', $_base);
define('ROOT_PATH', dirname(__DIR__) . '/');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'quanlynhathuoc');

date_default_timezone_set('Asia/Ho_Chi_Minh');
