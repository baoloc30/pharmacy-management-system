<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quên mật khẩu - PHARMACARE</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="login-container">
    <div class="login-box">
        <div class="login-logo">
            <div class="logo">
                <i class="fas fa-clinic-medical"></i>
                <span>PHARMACARE</span>
            </div>
        </div>

        <h5 style="text-align:center; margin-bottom:6px; color:#2d3748;">Quên mật khẩu</h5>
        <p style="text-align:center; color:#718096; font-size:13px; margin-bottom:20px;">
            Nhập tên đăng nhập và số điện thoại để đặt lại mật khẩu về <b>123456</b>
        </p>

        <?php if(isset($error)): ?>
            <div class="alert-danger"><i class="fas fa-exclamation-triangle"></i> <?= $error ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class="alert-success"><i class="fas fa-check-circle"></i> <?= $success ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>auth/forgotPassword">
            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" name="username" required placeholder="Nhập tên đăng nhập">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" class="form-control" name="soDienThoai" required placeholder="Số điện thoại đã đăng ký">
                </div>
            </div>
            <button type="submit" class="btn-primary-full">
                <i class="fas fa-redo"></i> Đặt lại mật khẩu
            </button>
        </form>

        <div style="text-align:center; margin-top:16px;">
            <a href="<?= BASE_URL ?>auth/login" style="color:#0d6efd; font-size:13px;">
                <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
            </a>
        </div>
    </div>
</div>

<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Inter', Arial, sans-serif; }
.login-container {
    display:flex; justify-content:center; align-items:center;
    min-height:100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.login-box {
    background:#fff; padding:40px 30px; border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1); width:100%; max-width:420px;
}
.login-logo { text-align:center; margin-bottom:20px; }
.logo { display:inline-flex; align-items:center; font-size:28px; font-weight:700; color:#0d6efd; }
.logo i { font-size:32px; margin-right:8px; }
.form-label { font-weight:500; color:#4a5568; font-size:14px; display:block; margin-bottom:6px; }
.input-wrapper { position:relative; }
.form-control {
    width:100%; padding:12px 16px 12px 42px;
    border:2px solid #e2e8f0; border-radius:10px; font-size:14px;
    background:#f7fafc; transition:border-color .3s;
}
.form-control:focus { outline:none; border-color:#0d6efd; background:#fff; }
.input-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#a0aec0; }
.mb-3 { margin-bottom:16px; }
.btn-primary-full {
    width:100%; padding:14px; background:#0d6efd; color:#fff;
    border:none; border-radius:10px; font-size:15px; font-weight:600;
    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;
    margin-top:8px; transition:background .3s;
}
.btn-primary-full:hover { background:#0b5ed7; }
.alert-danger {
    background:#fff5f5; border:1px solid #fed7d7; color:#c53030;
    padding:10px 14px; border-radius:8px; margin-bottom:16px; font-size:13px;
    display:flex; align-items:center; gap:8px;
}
.alert-success {
    background:#f0fff4; border:1px solid #9ae6b4; color:#276749;
    padding:10px 14px; border-radius:8px; margin-bottom:16px; font-size:13px;
    display:flex; align-items:center; gap:8px;
}
</style>
</body>
</html>
