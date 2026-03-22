<?php
$avatarLetter = mb_strtoupper(mb_substr($user['hoTen'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$roleLabel = ($user['vaiTro'] ?? '') === 'QuanLy' ? 'Quản lý' : 'Dược sĩ';
$homeUrl = BASE_URL . 'home/' . (Session::get('role') === 'QuanLy' ? 'admin' : 'employee');
?>
<div class="content-wrapper">

<?php if(isset($data['success'])): ?>
        <style>
            .glass-toast-profile { position: fixed; top: 84px; right: 24px; width: max-content; max-width: 420px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 16px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12), 0 5px 15px rgba(0, 0, 0, 0.06); padding: 18px 24px; display: flex; align-items: flex-start; gap: 16px; z-index: 9999999; font-family: 'Inter', sans-serif; transform: translateX(120%); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); overflow: hidden; }
            .glass-toast-profile.show { transform: translateX(0); }
            .toast-icon-wrapper-profile { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #34d399, #10b981); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35); }
            .toast-icon-wrapper-profile i { color: #ffffff; font-size: 18px; }
            .toast-text-title-profile { font-size: 15px; font-weight: 800; color: #1f2937; }
            .toast-text-msg-profile { font-size: 13.5px; color: #4b5563; margin-top: 4px; }
            .toast-progress-profile { position: absolute; bottom: 0; left: 0; height: 4px; background: linear-gradient(90deg, #34d399, #10b981); width: 100%; transform-origin: left; animation: progressShrinkProfile 4s linear forwards; }
            @keyframes progressShrinkProfile { 0% { transform: scaleX(1); } 100% { transform: scaleX(0); } }
        </style>
        <div id="profileToast" class="glass-toast-profile">
            <div class="toast-icon-wrapper-profile"><i class="fas fa-check"></i></div>
            <div>
                <div class="toast-text-title-profile">Thành công!</div>
                <div class="toast-text-msg-profile"><?php echo $data['success']; ?></div>
            </div>
            <div class="toast-progress-profile"></div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('profileToast');
                if (toast) {
                    setTimeout(() => toast.classList.add('show'), 150);
                    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 600); }, 4000);
                }
            });
        </script>
    <?php endif; ?>

    <?php if(isset($data['error'])): ?>
        <div class="server-alert" style="max-width:800px; margin:0 auto 16px; padding:14px 18px; background:rgba(254,226,226,0.85); backdrop-filter:blur(8px); border-left:4px solid #ef4444; border-radius:12px; color:#991b1b; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px; box-shadow:0 8px 20px rgba(239,68,68,0.15);">
            <i class="fas fa-exclamation-triangle" style="color:#ef4444; font-size:18px;"></i>
            <?php echo $data['error']; ?>
        </div>
    <?php endif; ?>
<div style="max-width:800px;margin:0 auto;">

  <!-- Profile hero card -->
  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
    <div style="height:90px;background:linear-gradient(135deg,#1e40af,#2563eb,#0ea5e9);position:relative;overflow:hidden;">
      <div style="position:absolute;inset:0;background-image:radial-gradient(circle at 10% 20%, rgba(255,255,255,0.1) 2px, transparent 2px), radial-gradient(circle at 30% 70%, rgba(255,255,255,0.08) 3px, transparent 3px), radial-gradient(circle at 80% 40%, rgba(255,255,255,0.06) 4px, transparent 4px);background-size:40px 40px, 60px 60px, 80px 80px;background-repeat:repeat;"></div>
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

    <style>
        .editable-input { width: 100%; padding: 9px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 13px; outline: none; transition: all .2s; }
        .editable-input[readonly], .editable-input[disabled] { background-color: #f8fafc; color: #64748b; cursor: default; pointer-events: none; }
        .editable-input:not([readonly]):not([disabled]) { background-color: #ffffff; color: #1e293b; }
        .editable-input:not([readonly]):not([disabled]):focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
    </style>

    <form method="POST" action="<?php echo BASE_URL; ?>auth/profile" id="profileForm" style="padding:20px 22px;" novalidate>
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

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Họ tên <span style="color:#dc2626;">*</span></label>
          <input type="text" name="hoTen" id="hoTen" class="editable-input" value="<?php echo htmlspecialchars($user['hoTen']??''); ?>" readonly>
          <span style="font-size:11px;color:#dc2626;display:block;margin-top:4px;" id="hoTenError"><?php echo $data['hoTen_error'] ?? ''; ?></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Số điện thoại</label>
          <input type="text" name="soDienThoai" id="soDienThoai" class="editable-input" value="<?php echo htmlspecialchars($user['soDienThoai']??''); ?>" readonly>
          <span style="font-size:11px;color:#dc2626;display:block;margin-top:4px;" id="sdtError"><?php echo $data['sdt_error'] ?? ''; ?></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Email</label>
          <input type="email" name="email" id="email" class="editable-input" value="<?php echo htmlspecialchars($user['email']??''); ?>" readonly>
          <span style="font-size:11px;color:#dc2626;display:block;margin-top:4px;" id="emailError"><?php echo $data['email_error'] ?? ''; ?></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Ngày sinh</label>
          <input type="date" name="ngaySinh" id="ngaySinh" class="editable-input" value="<?php echo $user['ngaySinh']??''; ?>" readonly>
          <span style="font-size:11px;color:#dc2626;display:block;margin-top:4px;" id="ngaySinhError"><?php echo $data['ngaySinh_error'] ?? ''; ?></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Giới tính</label>
          <select name="gioiTinh" class="editable-input" disabled>
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
          <input type="text" name="diaChi" class="editable-input" value="<?php echo htmlspecialchars($user['diaChi']??''); ?>" readonly>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
        <button type="button" id="editProfileBtn"
           style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(30,64,175,.3);">
          <i class="fas fa-edit"></i> Chỉnh sửa
        </button>
        
        <a href="<?php echo BASE_URL; ?>auth/profile" id="cancelEditBtn"
           style="display:none; padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;align-items:center;gap:7px;">
          <i class="fas fa-times"></i> Hủy
        </a>
        
        <button type="submit" id="saveProfileBtn"
           style="display:none; padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:13px;font-weight:700;cursor:pointer;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(16,185,129,.3);">
          <i class="fas fa-save"></i> Cập nhật
        </button>
      </div>
    </form>
  </div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editProfileBtn');
    const saveBtn = document.getElementById('saveProfileBtn');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const editableInputs = document.querySelectorAll('.editable-input');

    function enableEditMode() {
        editableInputs.forEach(el => {
            el.removeAttribute('readonly');
            el.removeAttribute('disabled');
        });
        editBtn.style.display = 'none';
        cancelBtn.style.display = 'inline-flex';
        saveBtn.style.display = 'inline-flex';
        document.getElementById('hoTen').focus();
    }

    editBtn.addEventListener('click', enableEditMode);

    <?php if(isset($data['error']) || isset($data['hoTen_error']) || isset($data['sdt_error']) || isset($data['email_error']) || isset($data['ngaySinh_error'])): ?>
        enableEditMode();
    <?php endif; ?>

    const serverAlert = document.querySelector('.server-alert');
    if (serverAlert) {
        setTimeout(() => {
            serverAlert.style.transition = 'opacity 0.5s ease';
            serverAlert.style.opacity = '0';
            setTimeout(() => serverAlert.style.display = 'none', 500);
        }, 3000);
    }

    ['hoTenError', 'sdtError', 'emailError', 'ngaySinhError'].forEach(id => {
        const el = document.getElementById(id);
        if (el && el.textContent.trim() !== '') {
            setTimeout(() => el.textContent = '', 3000);
        }
    });

    document.getElementById('profileForm').addEventListener('submit', function(e) {
        let valid = true;
        const hoTen = document.getElementById('hoTen').value.trim();
        const sdt = document.getElementById('soDienThoai').value.trim();
        const email = document.getElementById('email').value.trim();
        const ngaySinh = document.getElementById('ngaySinh').value;

        ['hoTenError','sdtError','emailError','ngaySinhError'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = ''; 
        });

        if (!hoTen) {
            document.getElementById('hoTenError').textContent = 'Vui lòng không bỏ trống thông tin này';
            valid = false;
        }
        
        if (sdt && !/^[0-9]{10}$/.test(sdt)) {
            document.getElementById('sdtError').textContent = 'Số điện thoại không hợp lệ (10 chữ số)';
            valid = false;
        }
        
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById('emailError').textContent = 'Email không đúng định dạng';
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
                ['hoTenError','sdtError','emailError','ngaySinhError'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = ''; 
                });
            }, 3000);
            return;
        }
        
        if(saveBtn) {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
        }
    });
});
</script>