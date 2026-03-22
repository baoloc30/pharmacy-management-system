<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ thống Nhà thuốc Pharmare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php 
    $msg = '';
    if (isset($_SESSION['success'])) { $msg = $_SESSION['success']; unset($_SESSION['success']); }
    elseif (isset($data['success'])) { $msg = $data['success']; }
    elseif (isset($success)) { $msg = $success; }

    if ($msg !== ''): 
?>
    <style>
        .glass-toast {
            position: fixed;
            top: 30px;
            right: 30px;
            width: max-content;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12), 0 5px 15px rgba(0, 0, 0, 0.06);
            padding: 18px 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            z-index: 9999999;
            font-family: 'Inter', sans-serif;
            transform: translateX(120%);
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }

        .glass-toast.show {
            transform: translateX(0);
        }

        .toast-icon-wrapper {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #34d399, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .toast-icon-wrapper i {
            color: #ffffff;
            font-size: 18px;
        }

        .toast-text-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: -1px;
        }

        .toast-text-title {
            font-size: 15px;
            font-weight: 800;
            color: #1f2937;
            letter-spacing: 0.2px;
        }

        .toast-text-msg {
            font-size: 13.5px;
            color: #4b5563;
            line-height: 1.5;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #34d399, #10b981);
            width: 100%;
            transform-origin: left;
            animation: progressShrink 4s linear forwards;
        }

        @keyframes progressShrink {
            0% { transform: scaleX(1); }
            100% { transform: scaleX(0); }
        }
    </style>

    <div id="superToast" class="glass-toast">
        <div class="toast-icon-wrapper">
            <i class="fas fa-check"></i>
        </div>
        <div class="toast-text-content">
            <div class="toast-text-title">Thành công!</div>
            <div class="toast-text-msg"><?php echo $msg; ?></div>
        </div>
        <div class="toast-progress"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('superToast');
            if (toast) {
                setTimeout(() => toast.classList.add('show'), 150);
                
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 600);
                }, 4000);
            }
        });
    </script>
<?php endif; ?>
<div class="login-container">
    <div class="login-bg-img" id="loginBgImg"></div>
    <div class="login-box">
        <div class="login-logo">
            <div class="logo">
                <i class="fas fa-clinic-medical"></i>
                <span>PHARMACARE</span>
            </div>
            <div class="logo-tagline">Hệ thống quản lý nhà thuốc</div>
            <div class="logo-divider"></div>
        </div>
        
        <?php if(isset($data['error']) || isset($error)): ?>
            <div class="alert alert-danger server-alert">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo isset($data['error']) ? $data['error'] : $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>auth/login" id="loginForm" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                <span class="error-message" id="usernameError"><?php echo $data['username_error'] ?? ''; ?></span>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" class="form-control" id="password" name="password">
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <span class="error-message" id="passwordError"><?php echo $data['password_error'] ?? ''; ?></span>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 login-btn" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i>
                Đăng nhập
            </button>
            <div style="text-align:center; margin-top:14px;">
                <a href="<?php echo BASE_URL; ?>auth/forgotPassword"
                   style="color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:8px;background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.35);"
                   onmouseover="this.style.background='rgba(255,255,255,.28)'" onmouseout="this.style.background='rgba(255,255,255,.18)'">
                    <i class="fas fa-key"></i> Quên mật khẩu?
                </a>
            </div>
        </form>
        
        <div class="login-info">
            <p><i class="fas fa-info-circle"></i> Vui lòng liên hệ quản lý nếu cần hỗ trợ</p>
        </div>
    </div>
    
    <div class="background-decoration">
        <div class="pill pill-1"></div>
        <div class="pill pill-2"></div>
        <div class="pill pill-3"></div>
        <div class="pill pill-4"></div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
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
        background: linear-gradient(135deg, rgba(5,30,80,.6) 0%, rgba(10,60,120,.45) 60%, rgba(2,20,60,.55) 100%);
        z-index: 1;
    }

    .login-box {
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.2);
        padding: 48px 40px 40px;
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0,0,0,.15);
        width: 100%;
        max-width: 480px;
        position: relative;
        z-index: 10;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        text-decoration: none;
        letter-spacing: 2px;
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

    .form-label {
        font-weight: 600;
        color: rgba(255,255,255,.95);
        font-size: 13px;
        margin-bottom: 7px;
        display: block;
        letter-spacing: .3px;
    }

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 13px 16px 13px 46px;
        border: 1.5px solid rgba(255,255,255,.35);
        border-radius: 11px;
        font-size: 14px;
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


    .login-btn {
        background: linear-gradient(135deg, #0ea5e9, #2563eb);
        color: #fff;
        border: none;
        padding: 14px 24px;
        border-radius: 11px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all .25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin: 22px auto 0;
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

    .login-info {
        text-align: center;
        margin-top: 20px;
    }

    .login-info p {
        color: rgba(255,255,255,.75);
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-bottom: 8px;
    }

    .background-decoration {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        pointer-events: none;
        z-index: 2;
    }


.alert-danger, .server-alert {
    background: rgba(254, 226, 226, 0.85);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(248, 113, 113, 0.3);
    border-left: 4px solid #ef4444;
    color: #991b1b;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    font-weight: 600;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.15);
}

.alert-danger i {
    font-size: 18px;
    color: #ef4444;
}

.error-message {
    color: #fecaca;
    font-size: 12.5px;
    font-weight: 500;
    margin-top: 6px;
    min-height: 18px;
    display: block;
    padding-left: 4px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
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

    @media (max-width:480px) {
        .login-box { padding:30px 20px; }
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var loginBtn = document.getElementById('loginBtn');
        loginBtn.disabled = false;
        loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';

        var bgDiv = document.getElementById('loginBgImg');
        var img = new Image();
        img.onload = function() { bgDiv.style.opacity = '1'; };
        img.src = '<?php echo BASE_URL; ?>assets/images/nhathuoc.jpg';

        const loginForm = document.getElementById('loginForm');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const usernameError = document.getElementById('usernameError');
        const passwordError = document.getElementById('passwordError');
        const togglePassword = document.getElementById('togglePassword');

        const serverAlert = document.querySelector('.server-alert');
        if (serverAlert) {
            setTimeout(function() {
                serverAlert.style.transition = 'opacity 0.5s ease';
                serverAlert.style.opacity = '0';
                setTimeout(() => serverAlert.style.display = 'none', 500);
            }, 3000);
        }

        if (usernameError.textContent.trim() !== '' || passwordError.textContent.trim() !== '') {
            setTimeout(() => {
                clearError(usernameInput, usernameError);
                clearError(passwordInput, passwordError);
            }, 3000);
        }

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        usernameInput.addEventListener('input', function() { clearError(usernameInput, usernameError); });
        passwordInput.addEventListener('input', function() { clearError(passwordInput, passwordError); });

        loginForm.addEventListener('submit', function(e) {
            clearError(usernameInput, usernameError);
            clearError(passwordInput, passwordError);
            
            const username = usernameInput.value.trim();
            const password = passwordInput.value.trim();
            let hasError = false;
            
            if (!username) {
                showError(usernameInput, usernameError, 'Vui lòng không bỏ trống thông tin này');
                hasError = true;
            }
            if (!password) {
                showError(passwordInput, passwordError, 'Vui lòng không bỏ trống thông tin này');
                hasError = true;
            }
            
            if (hasError) {
                e.preventDefault();
                setTimeout(() => {
                    clearError(usernameInput, usernameError);
                    clearError(passwordInput, passwordError);
                }, 3000);
                return false;
            }
            
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng nhập...';
        });

        function showError(input, errorElement, message) {
            input.style.borderColor = '#f56565';
            input.style.background = '#fff5f5';
            errorElement.textContent = message;
        }
        
        function clearError(input, errorElement) {
            input.style.borderColor = '';
            input.style.background = '';
            errorElement.textContent = '';
        }
    });
</script>
</body>
</html>
