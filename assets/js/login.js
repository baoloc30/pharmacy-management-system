document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const togglePassword = document.getElementById('togglePassword');
    const loginBtn = document.getElementById('loginBtn');
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');

    // Mock user data for demonstration
    const mockUsers = {
        manager: {
            username: 'admin',
            password: 'admin123'
        },
        employee: {
            username: 'employee',
            password: 'emp123'
        }
    };

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

    // Form submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearError(usernameInput, usernameError);
        clearError(passwordInput, passwordError);
        
        // Get form values
        const role = document.querySelector('input[name="role"]:checked').value;
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();
        
        let hasError = false;
        
        // Validate empty fields
        if (!username) {
            showError(usernameInput, usernameError, 'Vui lòng không để trống tên đăng nhập');
            hasError = true;
        }
        
        if (!password) {
            showError(passwordInput, passwordError, 'Vui lòng không để trống mật khẩu');
            hasError = true;
        }
        
        if (hasError) {
            return;
        }
        
        // Show loading state
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang đăng nhập...';
        
        // Simulate API call
        setTimeout(() => {
            // Validate credentials
            const user = mockUsers[role];
            
            if (!user) {
                showError(usernameInput, usernameError, 'Vai trò không hợp lệ');
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';
                return;
            }
            
            if (username !== user.username || password !== user.password) {
                showError(passwordInput, passwordError, 'Tên đăng nhập hoặc mật khẩu không chính xác');
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';
                return;
            }
            
            // Check if account is locked (mock check)
            if (username === 'locked_user') {
                showError(usernameInput, usernameError, 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Quản lý');
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Đăng nhập';
                return;
            }
            
            // Success - show success modal
            const roleText = role === 'manager' ? 'Quản lý' : 'Nhân viên';
            successMessage.textContent = `Chào mừng ${roleText} ${username}! Đang chuyển hướng đến trang chủ...`;
            successModal.classList.add('show');
            
            // Redirect after delay
            setTimeout(() => {
                // In a real application, redirect to the appropriate dashboard
                if (role === 'manager') {
                    window.location.href = 'manager/dashboard.html';
                } else {
                    window.location.href = 'employee/dashboard.html';
                }
            }, 2000);
            
        }, 1500); // Simulate network delay
    });

    // Helper functions
    function showError(input, errorElement, message) {
        input.classList.add('error');
        errorElement.textContent = message;
    }
    
    function clearError(input, errorElement) {
        input.classList.remove('error');
        errorElement.textContent = '';
    }

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
            loginForm.dispatchEvent(new Event('submit'));
        }
    });

    // Add focus effects
    const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Add role selection animation
    const roleOptions = document.querySelectorAll('input[name="role"]');
    roleOptions.forEach(option => {
        option.addEventListener('change', function() {
            const roleLabel = this.nextElementSibling;
            roleLabel.style.transform = 'scale(0.95)';
            setTimeout(() => {
                roleLabel.style.transform = 'scale(1)';
            }, 100);
        });
    });
});

// Additional utility functions
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    return password.length >= 6;
}

function showMessage(type, message) {
    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    // Show toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    // Hide and remove toast
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
