# 💊 Hệ Thống Quản Lý Nhà Thuốc

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

Hệ thống quản lý nhà thuốc toàn diện với tính năng dự báo nhập kho tự động sử dụng thuật toán AI/ROP (Reorder Point).

## 📋 Mục lục

- [Tính năng](#-tính-năng)
- [Công nghệ](#️-công-nghệ)
- [Yêu cầu hệ thống](#-yêu-cầu-hệ-thống)
- [Cài đặt](#-cài-đặt)
- [Cấu trúc thư mục](#-cấu-trúc-thư-mục)
- [Tài khoản mặc định](#-tài-khoản-mặc-định)
- [Screenshots](#-screenshots)
- [Đóng góp](#-đóng-góp)
- [License](#-license)

## ✨ Tính năng

### 🔐 Quản lý người dùng & Phân quyền
- Đăng nhập/Đăng xuất an toàn với session management
- Phân quyền: **Quản lý** và **Nhân viên**
- Quản lý thông tin nhân viên và ca làm việc

### 💊 Quản lý thuốc
- Thêm, sửa, xóa thông tin thuốc
- Upload hình ảnh sản phẩm
- Quản lý danh mục thuốc
- Đơn vị tính đa dạng (hộp, viên, lọ, vỉ...)
- Theo dõi hạn sử dụng
- Quản lý tồn kho theo thời gian thực

### 📦 Quản lý kho
- **Nhập kho** với phiếu nhập chi tiết
- **Xuất kho** tự động qua hóa đơn
- **Lịch sử nhập xuất** đầy đủ
- **Cảnh báo tồn kho thấp** (dưới ngưỡng)
- **Cảnh báo hết hạn** (thuốc sắp/đã hết hạn)
- **Điều chỉnh tồn kho thủ công** (có ghi log)

### 🤖 Dự báo nhập kho (AI)
- **Thuật toán ROP (Reorder Point)** thông minh
- Phân tích dữ liệu bán hàng 30 ngày gần nhất
- Tính toán tự động:
  - Tốc độ tiêu thụ trung bình
  - Điểm đặt hàng lại (ROP)
  - Số lượng đề xuất nhập kho
- **Tạo phiếu đề xuất tự động** với trạng thái "Chờ duyệt"
- Quản lý có thể duyệt/hủy phiếu trước khi nhập kho thực tế

### 🛒 Bán hàng
- Tạo hóa đơn nhanh chóng
- Tìm kiếm thuốc theo mã, tên, danh mục
- Hỗ trợ bán theo đơn vị lẻ/đơn vị lớn
- Tính toán tự động giá tiền
- In hóa đơn (PDF/Xuất file)
- Quản lý khách hàng

### 👥 Quản lý khách hàng
- Lưu thông tin khách hàng
- Lịch sử mua hàng chi tiết
- Tra cứu nhanh theo SĐT

### 🏢 Quản lý nhà cung cấp
- Thêm, sửa, xóa thông tin NCC
- Ghi chú thông tin liên hệ
- Lịch sử giao dịch với NCC

### 📊 Báo cáo & Thống kê
- **Thống kê doanh thu** theo khoảng thời gian
- **Thuốc bán chạy nhất**
- **Biểu đồ trực quan** (Chart.js)
- **Dashboard tổng quan** (doanh thu, đơn hàng, sản phẩm...)
- Xuất báo cáo Excel/PDF

## 🛠️ Công nghệ

### Backend
- **PHP 7.4+** - Ngôn ngữ lập trình server-side
- **MySQL 5.7+** - Cơ sở dữ liệu quan hệ
- **Custom MVC Framework** - Kiến trúc sạch, dễ bảo trì

### Frontend
- **HTML5/CSS3** - Giao diện responsive
- **JavaScript (Vanilla)** - Xử lý tương tác
- **Font Awesome** - Icon library
- **Chart.js** - Biểu đồ thống kê

### Server
- **XAMPP - Môi trường phát triển
- **Apache 2.4+** - Web server
- **MySQLi** - Database connection

## 💻 Yêu cầu hệ thống

- PHP >= 7.4
- MySQL >= 5.7 hoặc MariaDB >= 10.2
- Apache với mod_rewrite enabled
- Extension PHP:
  - `mysqli`
  - `pdo_mysql`
  - `gd` (xử lý ảnh)
  - `mbstring`
  - `json`

## 🚀 Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/baoloc30/pharmacy-management-system.git
cd pharmacy-management-system
```

### 2. Di chuyển vào thư mục web server

#### XAMPP (Windows)
```bash
# Copy project vào
C:\xampp\htdocs\pharmacy-management-system
```
### 3. Tạo cơ sở dữ liệu

1. Mở **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Tạo database mới: `quanlynhathuoc`
3. Import file SQL (nếu có) hoặc tạo bảng theo schema

```sql
CREATE DATABASE quanlynhathuoc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Cấu hình database

Mở file `config/config.php` và điều chỉnh thông tin kết nối:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');           // Tên người dùng MySQL
define('DB_PASS', '');               // Mật khẩu MySQL
define('DB_NAME', 'quanlynhathuoc'); // Tên database
```

### 5. Cấu hình Apache (nếu cần)

Đảm bảo `mod_rewrite` được bật và file `.htaccess` hoạt động:

**.htaccess** (đã có sẵn trong project)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### 6. Khởi động server

#### XAMPP
- Khởi động **Apache** và **MySQL** trong XAMPP Control Panel

### 7. Truy cập hệ thống

Mở trình duyệt và truy cập:
```
http://localhost/pharmacy-management-system
```

## 📁 Cấu trúc thư mục

```
pharmacy-management-system/
│
├── assets/                    # Tài nguyên tĩnh
│   ├── css/                   # File CSS
│   ├── js/                    # File JavaScript
│   └── images/                # Hình ảnh hệ thống
│
├── config/                    # File cấu hình
│   ├── config.php            # Cấu hình chung (BASE_URL, DB)
│   └── database.php          # Class Database connection
│
├── controllers/               # Các Controller (MVC)
│   ├── AuthController.php    # Đăng nhập/Đăng xuất
│   ├── HomeController.php    # Dashboard
│   ├── MedicineController.php # Quản lý thuốc
│   ├── CategoryController.php # Danh mục thuốc
│   ├── WarehouseController.php # Quản lý kho
│   ├── ForecastController.php # Dự báo nhập kho (AI)
│   ├── SaleController.php    # Bán hàng
│   ├── CustomerController.php # Quản lý khách hàng
│   ├── SupplierController.php # Quản lý NCC
│   ├── EmployeeController.php # Quản lý nhân viên
│   └── StatisticController.php # Báo cáo & thống kê
│
├── models/                    # Các Model (Database)
│   ├── MedicineModel.php
│   ├── CategoryModel.php
│   ├── WarehouseModel.php
│   ├── ForecastModel.php     # Model dự báo AI
│   ├── InvoiceModel.php
│   ├── CustomerModel.php
│   ├── SupplierModel.php
│   ├── UserModel.php
│   ├── WorkShiftModel.php
│   └── StatisticModel.php
│
├── views/                     # Giao diện (View)
│   ├── auth/                 # Đăng nhập
│   ├── home/                 # Dashboard
│   ├── medicine/             # Quản lý thuốc
│   ├── category/             # Danh mục
│   ├── warehouse/            # Kho hàng
│   ├── forecast/             # Dự báo (AI)
│   ├── sale/                 # Bán hàng
│   ├── customer/             # Khách hàng
│   ├── supplier/             # Nhà cung cấp
│   ├── employee/             # Nhân viên
│   ├── statistic/            # Báo cáo
│   └── layouts/              # Layout chung (header, sidebar, footer)
│
├── core/                      # Core MVC Framework
│   ├── App.php               # Router & URL handling
│   ├── Controller.php        # Base Controller
│   ├── Model.php             # Base Model
│   └── Session.php           # Session management
│
├── helpers/                   # Helper functions
│   ├── function.php          # Hàm tiện ích
│   └── validation.php        # Validate dữ liệu
│
├── uploads/                   # Thư mục upload file
│   └── medicines/            # Hình ảnh thuốc
│
├── .htaccess                 # Apache rewrite rules
├── index.php                 # Entry point


## 👤 Tài khoản mặc định

Sau khi cài đặt, đăng nhập với tài khoản mặc định:

### Quản lý
```
Username: ngochanh1405
Password: 123456
```

### Nhân viên
```
Username: baoloc3012
Password: 123456
```

## 📸 Screenshots

### Dashboard
![Dashboard](screenshots/dashboard.png)

### Quản lý thuốc
![Medicine Management](screenshots/medicine.png)

### Dự báo nhập kho (AI)
![AI Forecast](screenshots/forecast.png)

### Bán hàng
![Sales](screenshots/sales.png)

### Thống kê doanh thu
![Statistics](screenshots/statistics.png)

> 💡 *Thêm screenshots thực tế vào thư mục `screenshots/` để minh họa*

## 🔧 Tùy chỉnh

### Thay đổi tham số dự báo AI

Mở `controllers/ForecastController.php`:

```php
private function calculateSuggestions($model) {
    $LEAD_TIME = 3;           // Thời gian giao hàng (ngày)
    $SAFETY_STOCK = 20;       // Tồn kho an toàn (đơn vị)
    $DAYS_TO_ANALYZE = 30;    // Số ngày phân tích
    
    // ...
}
```

### Thay đổi múi giờ

Mở `config/config.php`:

```php
date_default_timezone_set('Asia/Ho_Chi_Minh');
```

### Thay đổi ngưỡng cảnh báo tồn kho

Mở `models/MedicineModel.php`:

```php
public function getLowStock($threshold = 10) {
    // Đổi 10 thành giá trị mong muốn
}
```

## 🧪 Testing

### Test cấu hình database

Truy cập:
```
http://localhost/pharmacy-management-system/test_db.php
```


**⭐ Nếu thấy project hữu ích, hãy cho 1 star nhé! ⭐**

Made with ❤️ by [Your Name]

</div>
