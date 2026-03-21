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

<?php if(isset($data['success'])): ?>
    <div class="toast-notification" id="toastSuccess">
        <i class="fas fa-check-circle"></i>
        <span><?php echo $data['success']; ?></span>
    </div>
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
        
        <form method="POST" action="<?php echo BASE_URL; ?>auth/login" id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                <span class="error-message" id="usernameError"><?php echo $username_error ?? ''; ?></span>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" class="form-control" id="password" name="password">
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <span class="error-message" id="passwordError"><?php echo $password_error ?? ''; ?></span>
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

    .alert-danger {
        background: rgba(255,245,245,.9);
        border: 1px solid #fed7d7;
        color: #c53030;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
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

    .error-message {
        color: #fca5a5;
        font-size: 12px;
        font-weight: 500;
        margin-top: 4px;
        min-height: 16px;
        display: block;
    }

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
    // Reset button state on page load (handles back navigation / server error)
    var loginBtn = document.getElementById('loginBtn');
    loginBtn.disabled = false;
    loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';

    // Fade in background image khi load xong
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
    const loginBtn = document.getElementById('loginBtn');
    const toastSuccess = document.getElementById('toastSuccess');

    if (toastSuccess) {
        setTimeout(() => {
            toastSuccess.classList.add('show');
        }, 100);

        setTimeout(() => {
            toastSuccess.classList.remove('show');
            setTimeout(() => {
                toastSuccess.remove();
            }, 400);
        }, 3000);
    }

    const serverAlert = document.querySelector('.server-alert');
    if (serverAlert) {
        setTimeout(function() {
            serverAlert.style.transition = 'opacity 0.5s ease';
            serverAlert.style.opacity = '0';
            setTimeout(function() {
                serverAlert.style.display = 'none';
            }, 500);
        }, 1000);
    }

    if (usernameError.textContent.trim() !== '' || passwordError.textContent.trim() !== '') {
        setTimeout(() => {
            userErrText.textContent = '';
            passErrText.textContent = '';
        }, 3000);
    }

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    // Clear error messages on input
    usernameInput.addEventListener('input', function() {
        clearError(usernameInput, usernameError);
    });

    passwordInput.addEventListener('input', function() {
        clearError(passwordInput, passwordError);
    });

    // Form validation before submit
    loginForm.addEventListener('submit', function(e) {
        // Clear previous errors
        clearError(usernameInput, usernameError);
        clearError(passwordInput, passwordError);
        
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();
        
        let hasError = false;
        
        // Validate empty fields
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
                usernameError.textContent = '';
                passwordError.textContent = '';
                usernameInput.style.borderColor = '';
                passwordInput.style.borderColor = '';
            }, 1000);
            return false;
        }
        
        // Show loading state
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng nhập...';
        
        // Re-enable after 5s in case of server error
        setTimeout(function() {
            loginBtn.disabled = false;
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';
        }, 5000);
    });

    // Helper functions
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
