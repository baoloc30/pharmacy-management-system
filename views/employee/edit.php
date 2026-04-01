<div class="content-wrapper">
<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user-edit" style="color:#fff;font-size:18px;"></i></div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Chỉnh Sửa Nhân Viên</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;"><?php echo htmlspecialchars($employee['hoTen']); ?></div>
      </div>
    </div>
    <a href="<?php echo BASE_URL; ?>employee/index" style="padding:8px 16px;border-radius:8px;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:6px;"><i class="fas fa-arrow-left"></i> Quay lại</a>
  </div>
</div>

<?php if(isset($error)): ?>
<div id="serverErrorBanner" style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#dc2626;font-size:13px;transition:0.5s;">
  <i class="fas fa-exclamation-circle"></i> <span id="serverErrorMsg"><?php echo $error; ?></span>
</div>
<?php endif; ?>

<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);"><span style="font-size:13px;font-weight:700;color:#fff;">Thông tin tài khoản</span></div>
  <div style="padding:22px;">
    <form method="POST" action="" id="editEmpForm" novalidate>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Họ tên <span style="color:#dc2626;">*</span></label>
          <input type="text" name="hoTen" id="hoTen" value="<?php echo htmlspecialchars($_POST['hoTen'] ?? $employee['hoTen']); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <span style="font-size:11px;color:#dc2626;font-weight:600;" id="hoTenErr"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Tên đăng nhập</label>
          <input type="text" value="<?php echo htmlspecialchars($employee['tenDangNhap']); ?>" readonly style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;background:#f8fafc;color:#94a3b8;">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Vai trò</label>
          <select name="vaiTro" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
            <option value="NhanVien" <?php echo (($employee['vaiTro']??'')==='NhanVien')?'selected':''; ?>>Dược sĩ</option>
            <option value="QuanLy" <?php echo (($employee['vaiTro']??'')==='QuanLy')?'selected':''; ?>>Quản lý</option>
          </select>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Số điện thoại</label>
          <input type="text" name="soDienThoai" id="soDienThoai" value="<?php echo htmlspecialchars($_POST['soDienThoai'] ?? $employee['soDienThoai'] ?? ''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <span style="font-size:11px;color:#dc2626;font-weight:600;" id="sdtErr"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Email</label>
          <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $employee['email'] ?? ''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <span style="font-size:11px;color:#dc2626;font-weight:600;" id="emailErr"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Ngày sinh</label>
          <input type="date" name="ngaySinh" id="ngaySinh" value="<?php echo htmlspecialchars($_POST['ngaySinh'] ?? $employee['ngaySinh'] ?? ''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          <span style="font-size:11px;color:#dc2626;font-weight:600;" id="nsErr"></span>
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Giới tính</label>
          <select name="gioiTinh" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
            <option value="Nam" <?php echo (($employee['gioiTinh']??'')==='Nam')?'selected':''; ?>>Nam</option>
            <option value="Nu" <?php echo (($employee['gioiTinh']??'')==='Nu')?'selected':''; ?>>Nữ</option>
            <option value="Khac" <?php echo (($employee['gioiTinh']??'')==='Khac')?'selected':''; ?>>Khác</option>
          </select>
        </div>
        <div style="grid-column:1/-1;">
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Địa chỉ</label>
          <input type="text" name="diaChi" value="<?php echo htmlspecialchars($_POST['diaChi'] ?? $employee['diaChi'] ?? ''); ?>" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        </div>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid #e2e8f0;">
        <a href="<?php echo BASE_URL; ?>employee/index" style="padding:9px 20px;border-radius:8px;border:1.5px solid #e2e8f0;background:#f1f5f9;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;">Hủy</a>
        <button type="submit" style="padding:9px 24px;border-radius:8px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;"><i class="fas fa-save"></i> Lưu thay đổi</button>
      </div>
    </form>
  </div>
</div>
</div>

<script>
document.getElementById('editEmpForm').addEventListener('submit', function(e) {
    let ok = true;
    let errorIds = ['hoTenErr', 'sdtErr', 'emailErr', 'nsErr'];
    errorIds.forEach(function(id){ document.getElementById(id).textContent=''; });
    
    if(!document.getElementById('hoTen').value.trim()) { 
        document.getElementById('hoTenErr').textContent='Vui lòng nhập họ tên'; ok=false; 
    }
    
    const sdt = document.getElementById('soDienThoai').value.trim();
    if(sdt && !/^[0-9]{10}$/.test(sdt)){ 
        document.getElementById('sdtErr').textContent='Số điện thoại không hợp lệ'; ok=false; 
    }
    
    const email = document.getElementById('email').value.trim();
    if(email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ 
        document.getElementById('emailErr').textContent='Email sai định dạng'; ok=false; 
    }
    
    const ns = document.getElementById('ngaySinh').value;
    if(ns && ns >= new Date().toISOString().split('T')[0]) { 
        document.getElementById('nsErr').textContent='Ngày sinh phải ở quá khứ'; ok=false; 
    }
    
    if(!ok) {
        e.preventDefault();
        setTimeout(() => { errorIds.forEach(function(id){ document.getElementById(id).textContent=''; }); }, 3000);
    }
});

const errorBanner = document.getElementById('serverErrorBanner');
if(errorBanner) {
    let srvErr = "<?php echo $error ?? ''; ?>";
    let handledInline = false;
    
    if(srvErr.includes('họ tên')) {
        document.getElementById('hoTenErr').textContent = srvErr; handledInline = true;
    } else if(srvErr.includes('Số điện thoại này đã được sử dụng') || srvErr.includes('Số điện thoại không hợp lệ')) {
        document.getElementById('sdtErr').textContent = srvErr; handledInline = true;
    } else if(srvErr.includes('Email này đã được sử dụng') || srvErr.includes('Email sai định dạng')) {
        document.getElementById('emailErr').textContent = srvErr; handledInline = true;
    } else if(srvErr.includes('Ngày sinh')) {
        document.getElementById('nsErr').textContent = srvErr; handledInline = true;
    }

    if(handledInline) {
        errorBanner.style.display = 'none';
        setTimeout(() => { document.querySelectorAll('[id$="Err"]').forEach(function(el){ el.textContent=''; }); }, 3000);
    } else {
        setTimeout(() => { errorBanner.style.opacity = '0'; setTimeout(() => errorBanner.style.display = 'none', 500); }, 3000);
    }
}
</script>
