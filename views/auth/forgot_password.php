<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - PHARMACARE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            height: 100vh;
            background: linear-gradient(135deg, #0f4c75 0%, #1b6ca8 50%, #0ea5e9 100%);
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        .login-bg-img {
            position: absolute;
            inset: 0;
            background-image: url('<?php echo BASE_URL; ?>assets/images/nhathuoc.jpg');
            background-size: cover;
            background-position: center;
            z-index: 0;
            opacity: 0;
            transition: opacity .5s;
        }

        .login-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 50% 45%, rgba(14, 116, 144, .12) 0%, transparent 55%),
                linear-gradient(135deg, rgba(4, 20, 54, .76) 0%, rgba(8, 45, 91, .62) 48%, rgba(3, 19, 48, .78) 100%);
            z-index: 1;
        }

        .login-box {
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.2);
            padding: 28px 28px 24px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,.15);
            width: 100%;
            max-width: 380px;
            position: relative;
            z-index: 10;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 16px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 12px rgba(0,0,0,.3);
        }

        .logo i {
            font-size: 34px;
            margin-right: 12px;
            color: #7dd3fc;
            filter: drop-shadow(0 2px 8px rgba(125,211,252,.5));
        }

        .logo-tagline {
            font-size: 12px;
            color: rgba(255,255,255,.75);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 4px;
            font-weight: 500;
        }

        .logo-divider {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #38bdf8, #7dd3fc);
            border-radius: 2px;
            margin: 14px auto 0;
        }

        .hint {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: rgba(255,255,255,.9);
            font-size: 12.5px;
            line-height: 1.5;
        }

        .hint i {
            color: #7dd3fc;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .mb-3 {
            margin-bottom: 12px;
        }

        .form-label {
            font-weight: 600;
            color: rgba(255,255,255,.95);
            font-size: 13px;
            margin-bottom: 8px;
            padding-top: 4px;
            display: block;
            letter-spacing: .3px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px 11px 42px;
            border: 1.5px solid rgba(255,255,255,.35);
            border-radius: 10px;
            font-size: 13px;
            transition: all .25s ease;
            background: rgba(255,255,255,.85);
            color: #1e293b;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #38bdf8;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(56,189,248,.2);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            z-index: 5;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 15px;
            transition: color .2s;
            z-index: 5;
        }

        .toggle-password:hover { color: #38bdf8; }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0,0,0,.08);
        }

        .alert-error {
            background: rgba(254, 226, 226, 0.9);
            border: 1px solid rgba(248, 113, 113, 0.28);
            color: #991b1b;
        }

        .alert-success {
            background: rgba(220, 252, 231, 0.9);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #166534;
        }

        .login-btn {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 16px auto 0;
            width: 100%;
            letter-spacing: .4px;
            box-shadow: 0 6px 20px rgba(14,165,233,.4);
            font-family: 'Inter', sans-serif;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(14,165,233,.5);
            background: linear-gradient(135deg, #38bdf8, #3b82f6);
        }

        .login-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(14,165,233,.3);
        }

        .back-link {
            text-align: center;
            margin-top: 16px;
        }

        .back-link a {
            color: #fff;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            transition: all .2s ease;
        }

        .back-link a:hover {
            background: rgba(255,255,255,.18);
            text-decoration: none;
        }

        .background-decoration {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .pill {
            position: absolute;
            border-radius: 50%;
            background: rgba(14,165,233,.15);
            backdrop-filter: blur(5px);
        }

        .pill-1 { width:80px;height:80px;top:10%;left:10%;animation:float 6s ease-in-out infinite; }
        .pill-2 { width:60px;height:60px;top:20%;right:15%;animation:float 8s ease-in-out infinite reverse; }
        .pill-3 { width:100px;height:100px;bottom:20%;left:5%;animation:float 7s ease-in-out infinite; }
        .pill-4 { width:70px;height:70px;bottom:10%;right:10%;animation:float 9s ease-in-out infinite reverse; }

        @keyframes float {
            0%,100% { transform:translateY(0) rotate(0deg); }
            50% { transform:translateY(-20px) rotate(180deg); }
        }

        @media (max-width: 480px) {
            .login-box { padding: 30px 20px; }
            .logo { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-bg-img" id="loginBgImg"></div>
        <div class="background-decoration">
            <div class="pill pill-1"></div>
            <div class="pill pill-2"></div>
            <div class="pill pill-3"></div>
            <div class="pill pill-4"></div>
        </div>

        <div class="login-box">
            <div class="login-logo">
                <div class="logo">
                    <i class="fas fa-clinic-medical"></i>
                    <span>PHARMACARE</span>
                </div>
                <div class="logo-tagline">HỆ THỐNG QUẢN LÝ NHÀ THUỐC</div>
                <div class="logo-divider"></div>
            </div>

            <?php if(isset($error)): ?>
                <div class="alert alert-error"><i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?></div>
            <?php endif; ?>
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
            <?php endif; ?>

            <div class="hint">
                <i class="fas fa-info-circle"></i>
                <span>Nhập tên đăng nhập, số điện thoại đã đăng ký và chọn mật khẩu mới cho tài khoản của bạn.</span>
            </div>

            <form method="POST" action="<?php echo BASE_URL; ?>auth/forgotPassword" id="forgotPasswordForm">
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

                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <div class="input-wrapper">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" class="form-control" name="new_password" id="new_password" required minlength="6" placeholder="Nhập mật khẩu mới">
                        <i class="fas fa-eye toggle-password" data-target="new_password"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nhập lại mật khẩu mới</label>
                    <div class="input-wrapper">
                        <i class="fas fa-check input-icon"></i>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required minlength="6" placeholder="Nhập lại mật khẩu mới">
                        <i class="fas fa-eye toggle-password" data-target="confirm_password"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <i class="fas fa-redo"></i>
                    Đặt lại mật khẩu
                </button>
            </form>

            <div class="back-link">
                <a href="<?php echo BASE_URL; ?>auth/login"><i class="fas fa-arrow-left"></i> Quay lại đăng nhập</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var bgDiv = document.getElementById('loginBgImg');
            var img = new Image();
            img.onload = function() { bgDiv.style.opacity = '1'; };
            img.src = '<?php echo BASE_URL; ?>assets/images/nhathuoc.jpg';

            document.querySelectorAll('.toggle-password').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    var input = document.getElementById(this.dataset.target);
                    if (!input) return;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        input.type = 'password';
                        this.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });
        });
    </script>
</body>
</html>
