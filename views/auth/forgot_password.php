<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quên mật khẩu - PHARMACARE</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Inter',Arial,sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f4c75 0%,#0ea5e9 100%);}
.box{background:#fff;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,.18);width:100%;max-width:420px;overflow:hidden;}
.box-header{padding:28px 30px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);text-align:center;}
.box-header .logo{display:inline-flex;align-items:center;gap:10px;margin-bottom:10px;}
.box-header .logo i{font-size:28px;color:#fff;}
.box-header .logo span{font-size:22px;font-weight:800;color:#fff;letter-spacing:1px;}
.box-header p{font-size:13px;color:rgba(255,255,255,.8);margin:0;}
.box-body{padding:24px 30px 28px;}
.alert{padding:11px 16px;border-radius:9px;font-size:13px;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.alert-error{background:#fef2f2;border:1.5px solid #fecaca;color:#dc2626;}
.alert-success{background:#f0fdf4;border:1.5px solid #bbf7d0;color:#15803d;}
.field{margin-bottom:16px;}
.field label{font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;}
.input-wrap{position:relative;}
.input-wrap i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;}
.input-wrap input{width:100%;padding:10px 14px 10px 38px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;font-family:inherit;outline:none;transition:all .2s;}
.input-wrap input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.btn-submit{width:100%;padding:12px;border:none;border-radius:10px;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:4px;transition:opacity .2s;}
.btn-submit:hover{opacity:.9;}
.back-link{text-align:center;margin-top:18px;}
.back-link a{font-size:13px;color:#2563eb;text-decoration:none;font-weight:600;}
.back-link a:hover{text-decoration:underline;}
.hint{background:#eff6ff;border:1px solid #bfdbfe;border-radius:9px;padding:10px 14px;font-size:12px;color:#1d4ed8;margin-bottom:16px;display:flex;align-items:flex-start;gap:8px;}
</style>
</head>
<body>
<div class="box">
  <div class="box-header">
    <div class="logo">
      <i class="fas fa-clinic-medical"></i>
      <span>PHARMACARE</span>
    </div>
    <p>Đặt lại mật khẩu tài khoản của bạn</p>
  </div>
  <div class="box-body">
    <?php if(isset($error)): ?>
    <div class="alert alert-error"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
    <?php endif; ?>
    <?php if(isset($success)): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
    <?php endif; ?>

    <div class="hint">
      <i class="fas fa-info-circle" style="margin-top:1px;flex-shrink:0;"></i>
      <span>Nhập tên đăng nhập và số điện thoại đã đăng ký. Mật khẩu sẽ được đặt lại về <strong>123456</strong>.</span>
    </div>

    <form method="POST" action="<?php echo BASE_URL; ?>auth/forgotPassword">
      <div class="field">
        <label>Tên đăng nhập</label>
        <div class="input-wrap">
          <i class="fas fa-user"></i>
          <input type="text" name="username" required placeholder="Nhập tên đăng nhập">
        </div>
      </div>
      <div class="field">
        <label>Số điện thoại</label>
        <div class="input-wrap">
          <i class="fas fa-phone"></i>
          <input type="text" name="soDienThoai" required placeholder="Số điện thoại đã đăng ký">
        </div>
      </div>
      <button type="submit" class="btn-submit">
        <i class="fas fa-redo"></i> Đặt lại mật khẩu
      </button>
    </form>

    <div class="back-link">
      <a href="<?php echo BASE_URL; ?>auth/login"><i class="fas fa-arrow-left"></i> Quay lại đăng nhập</a>
    </div>
  </div>
</div>
</body>
</html>
