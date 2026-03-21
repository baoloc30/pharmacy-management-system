<?php
$avatarLetter = mb_strtoupper(mb_substr($user['hoTen'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$roleLabel = ($user['vaiTro'] ?? '') === 'QuanLy' ? 'Quản lý' : 'Dược sĩ';
$homeUrl = BASE_URL . 'home/' . (Session::get('role') === 'QuanLy' ? 'admin' : 'employee');
?>
<div class="content-wrapper">
<div style="max-width:800px;margin:0 auto;">

  <!-- Profile hero card -->
  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
    <div style="height:90px;background:linear-gradient(135deg,#1e40af,#2563eb,#0ea5e9);position:relative;">
      <div style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 20\"><circle cx=\"10\" cy=\"10\" r=\"8\" fill=\"rgba(255,255,255,.06)\"/><circle cx=\"50\" cy=\"5\" r=\"12\" fill=\"rgba(255,255,255,.04)\"/><circle cx=\"85\" cy=\"15\" r=\"6\" fill=\"rgba(255,255,255,.07)\"/></svg>');background-size:cover;"></div>
    </div>
    <div style="padding:0 24px 20px;position:relative;">
      <!-- Avatar -->
      <div style="width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,#38bdf8,#2563eb);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:900;color:#fff;border:4px solid #fff;box-shadow:0 4px 16px rgba(37,99,235,.3);margin-top:-36px;margin-bottom:10px;">
        <?php echo $avatarLetter; ?>
      </div>
      <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div>
          <div style="font-size:20px;font-weight:900;color:#1e293b;"><?php echo htmlspecialchars($user['hoTen'] ?? ''); ?></div>
          <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
            <span style="font-size:12px;color:#64748b;">@<?php echo htmlspecialchars($user['tenDangNhap'] ?? ''); ?></span>
            <span style="padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;background:<?php echo $roleLabel==='Quản lý'?'#eff6ff':'#f0fdf4'; ?>;color:<?php echo $roleLabel==='Quản lý'?'#1d4ed8':'#15803d'; ?>;">
              <?php echo $roleLabel; ?>
            </span>
          </div>
        </div>
        <a href="<?php echo BASE_URL; ?>auth/changePassword"
           style="padding:8px 16px;border-radius:9px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
          <i class="fas fa-key"></i> Đổi mật khẩu
        </a>
      </div>
    </div>
  </div>

  <!-- Form card -->
  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
    <div style="padding:14px 22px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
      <i class="fas fa-edit" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Cập nhật thông tin</span>
    </div>

    <?php if(isset($success)): ?>
    <div style="margin:14px 22px 0;padding:11px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;color:#15803d;font-size:13px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-check-circle"></i> <?php echo $success; ?>
    </div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
    <div style="margin:14px 22px 0;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>auth/updateProfile" id="profileForm" style="padding:20px 22px;">
      <!-- Readonly info -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
        <div>
          <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Mã nhân viên</div>
          <div style="font-size:14px;font-weight:700;color:#374151;"><?php echo $user['maNhanVien'] ?? '—'; ?></div>
        </div>
        <div>
          <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">Tên đăng nhập</div>
          <div style="font-size:14px;font-weight:700;color:#374151;"><?php echo htmlspecialchars($user['tenDangNhap'] ?? ''); ?></div>
        </div>
      </div>

      <!-- Editable fields -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Họ tên <span style="color:#dc2626;">*</span></label>
          <input type="text" name="hoTen" id="hoTen" value="<?php echo htmlspecialchars($user['hoTen']??''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;transition:border .2s;"
            onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
          <span style="font-size:11px;color:#dc2626;" id="hoTenError"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Số điện thoại</label>
          <input type="text" name="soDienThoai" id="soDienThoai" value="<?php echo htmlspecialchars($user['soDienThoai']??''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;transition:border .2s;"
            onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
          <span style="font-size:11px;color:#dc2626;" id="sdtError"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Email</label>
          <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']??''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;transition:border .2s;"
            onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
          <span style="font-size:11px;color:#dc2626;" id="emailError"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Ngày sinh</label>
          <input type="date" name="ngaySinh" value="<?php echo $user['ngaySinh']??''; ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;transition:border .2s;"
            onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Giới tính</label>
          <select name="gioiTinh" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;cursor:pointer;">
            <option value="Nam" <?php echo ($user['gioiTinh']??'')==='Nam'?'selected':''; ?>>Nam</option>
            <option value="Nu"  <?php echo ($user['gioiTinh']??'')==='Nu'?'selected':''; ?>>Nữ</option>
            <option value="Khac" <?php echo ($user['gioiTinh']??'')==='Khac'?'selected':''; ?>>Khác</option>
          </select>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Vai trò</label>
          <div style="padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;background:#f8fafc;color:#94a3b8;"><?php echo $roleLabel; ?></div>
        </div>
        <div style="grid-column:1/-1;">
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Địa chỉ</label>
          <input type="text" name="diaChi" value="<?php echo htmlspecialchars($user['diaChi']??''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;transition:border .2s;"
            onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
        <a href="<?php echo $homeUrl; ?>"
           style="padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
          <i class="fas fa-times"></i> Hủy
        </a>
        <button type="submit" id="saveProfileBtn"
           style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(30,64,175,.3);">
          <i class="fas fa-save"></i> Lưu thay đổi
        </button>
      </div>
    </form>
  </div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editBtn').addEventListener('click', function() {
        document.querySelectorAll('.editable-input').forEach(el => {
            el.removeAttribute('readonly');
            el.removeAttribute('disabled');
        });
        
        this.classList.add('d-none');
        document.getElementById('saveBtn').classList.remove('d-none');
        document.getElementById('hoTen').focus();
    });

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });

    const toastSuccess = document.getElementById('toastSuccess');
    if (toastSuccess) {
        setTimeout(() => {
            toastSuccess.classList.add('show');
        }, 100);

        setTimeout(() => {
            toastSuccess.classList.remove('show');
            setTimeout(() => toastSuccess.remove(), 400); 
        }, 3000);
    }

    document.getElementById('profileForm').addEventListener('submit', function(e) {
        let valid = true;
        const hoTen = document.getElementById('hoTen').value.trim();
        const sdt = document.getElementById('soDienThoai').value.trim();
        const email = document.getElementById('email').value.trim();
        const ngaySinh = document.getElementById('ngaySinh').value;

        ['hoTenError', 'sdtError', 'emailError', 'ngaySinhError'].forEach(id => document.getElementById(id).textContent = '');

        if (!hoTen) {
            document.getElementById('hoTenError').textContent = 'Vui lòng nhập họ tên';
            valid = false;
        }
        if (sdt && !/^[0-9]{10}$/.test(sdt)) {
            document.getElementById('sdtError').textContent = 'Số điện thoại không được chứa chữ cái hoặc không đủ 10 số';
            valid = false;
        }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').textContent = 'Email sai định dạng';
            valid = false;
        }

        if (ngaySinh) {
            const selectedDate = new Date(ngaySinh);
            const today = new Date();
            today.setHours(0, 0, 0, 0); 
            
            if (selectedDate > today) {
                document.getElementById('ngaySinhError').textContent = 'Ngày sinh không được lớn hơn ngày hiện tại';
                valid = false;
            }
        }
        
        if (!valid) {
            e.preventDefault();
            setTimeout(() => {
                ['hoTenError', 'sdtError', 'emailError', 'ngaySinhError'].forEach(id => document.getElementById(id).textContent = '');
            }, 3000);
            return false;
        }
        
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    });
});
</script>

<style>
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

    .toast-notification i {
        color: #48bb78;
        font-size: 24px;
    }

    .toast-notification span {
        color: #2d3748;
        font-weight: 500;
        font-size: 15px;
    }
</style>