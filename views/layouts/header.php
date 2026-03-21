<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Hệ thống quản lý nhà thuốc'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { display: flex; flex-direction: column; min-height: 100vh; background: #f8f9fa; }
        .navbar { position: sticky; top: 0; z-index: 1030; }
        .wrapper { display: flex; flex: 1; }
        .sidebar { width: 250px; min-height: calc(100vh - 56px); background: #2c3e50; color: #fff; flex-shrink: 0; }
        .sidebar-header { padding: 15px 20px; background: #1a252f; font-size: 14px; font-weight: 600; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a { display: block; padding: 12px 20px; color: #bdc3c7; text-decoration: none; font-size: 14px; transition: all 0.2s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: #34495e; color: #fff; }
        .sidebar-menu li a i { width: 20px; margin-right: 8px; }
        .sidebar-menu .submenu > ul { display: none; background: #1a252f; }
        .sidebar-menu .submenu > ul li a { padding-left: 45px; font-size: 13px; }
        .sidebar-menu .submenu.open > ul { display: block; }
        .main-content { flex: 1; padding: 0; overflow-x: auto; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); margin-bottom: 20px; }
        .card-header { background: #fff; border-bottom: 1px solid #e9ecef; font-weight: 600; }
        .page-header { padding: 20px 20px 0; }
        .content-wrapper { padding: 20px; }
        .table th { font-size: 13px; font-weight: 600; }
        .table td { font-size: 13px; vertical-align: middle; }
        .btn-sm { font-size: 12px; }
        .alert { border-radius: 8px; }
        @media (max-width: 768px) { .sidebar { display: none; } }
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ffffff;
            border-left: 5px solid #48bb78;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            padding: 16px 24px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            transform: translateX(150%);
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        .toast-notification.show {
            transform: translateX(0);
        }
        .toast-notification i { color: #48bb78; font-size: 24px; }
        .toast-notification span { color: #2d3748; font-weight: 500; font-size: 15px; }
    </style>
</head>
<?php 
if (Session::get('login_success')): 
    $loginMsg = Session::get('login_success');
    Session::set('login_success', null); 
?>

<div class="toast-notification" id="toastLoginSuccess">
    <i class="fas fa-check-circle"></i>
    <span><?php echo $loginMsg; ?></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toastLoginSuccess = document.getElementById('toastLoginSuccess');
        if (toastLoginSuccess) {
            setTimeout(() => { toastLoginSuccess.classList.add('show'); }, 100);
            
            setTimeout(() => {
                toastLoginSuccess.classList.remove('show');
                setTimeout(() => toastLoginSuccess.remove(), 400);
            }, 3000);
        }
    });
</script>
<?php endif; ?>

<body>
    <?php if(Session::get('logged_in')): ?>
        <?php include __DIR__ . '/navbar.php'; ?>
        <div class="wrapper">
            <?php include __DIR__ . '/sidebar.php'; ?>
            <div class="main-content">
    <?php endif; ?>