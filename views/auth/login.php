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
    <div class="login-box">
        <div class="login-logo">
            <div class="logo">
                <i class="fas fa-clinic-medical"></i>
                <span>PHARMACARE</span>
            </div>
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
            <div style="text-align:center; margin-top:12px;">
                <a href="<?php echo BASE_URL; ?>auth/forgotPassword" style="color:#0d6efd; font-size:13px;">
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
        background: linear-gradient(135deg, #7dd3fc 0%, #38bdf8 50%, #0ea5e9 100%);
        position: relative;
        overflow: hidden;
        padding: 20px;
    }

    .login-box {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 100%;
        max-width: 450px;
        position: relative;
        z-index: 10;
    }

    .login-logo {
        text-align: center;
        margin-bottom: 35px;
    }

    .logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 32px;
        font-weight: 700;
        color: #0d6efd;
        text-decoration: none;
    }

    .logo i {
        font-size: 36px;
        margin-right: 10px;
        color: #0d6efd;
    }

    .login-logo h2 {
        font-size: 24px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .subtitle {
        color: #718096;
        font-size: 14px;
        font-weight: 400;
    }

    .alert-danger {
        background: #fff5f5;
        border: 1px solid #fed7d7;
        color: #c53030;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label {
        font-weight: 500;
        color: #4a5568;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .input-wrapper {
        position: relative;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px 14px 45px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f7fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 16px;
        transition: color 0.3s ease;
        z-index: 5;
    }

    .form-control:focus + .input-icon {
        color: #667eea;
    }

    .toggle-password {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        cursor: pointer;
        font-size: 16px;
        transition: color 0.3s ease;
        z-index: 5;
    }

    .toggle-password:hover {
        color: #667eea;
    }

    .error-message {
        color: #f56565;
        font-size: 12px;
        font-weight: 500;
        margin-top: 4px;
        min-height: 16px;
        display: block;
    }

    .login-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 16px 24px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin: 20px auto 0;
        width: auto;
        min-width: 200px;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .login-info {
        text-align: center;
        margin-top: 20px;
    }

    .login-info p {
        color: #718096;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-bottom: 8px;
    }

    .login-info i {
        color: #667eea;
    }

    .demo-accounts {
        margin-top: 12px;
        padding: 12px;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 8px;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    .demo-accounts p {
        margin: 4px 0;
        font-size: 12px;
        color: #4a5568;
    }

    .demo-accounts strong {
        color: #667eea;
    }

    .background-decoration {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .pill {
        position: absolute;
        border-radius: 50%;
        background: rgba(14, 165, 233, 0.15);
        backdrop-filter: blur(5px);
    }

    .pill-1 {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation: float 6s ease-in-out infinite;
    }

    .pill-2 {
        width: 60px;
        height: 60px;
        top: 20%;
        right: 15%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .pill-3 {
        width: 100px;
        height: 100px;
        bottom: 20%;
        left: 5%;
        animation: float 7s ease-in-out infinite;
    }

    .pill-4 {
        width: 70px;
        height: 70px;
        bottom: 10%;
        right: 10%;
        animation: float 9s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }

    @media (max-width: 480px) {
        .login-box {
            padding: 30px 20px;
            margin: 20px;
        }
        
        .login-logo h2 {
            font-size: 20px;
        }
    }

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

<script>
document.addEventListener('DOMContentLoaded', function() {
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
