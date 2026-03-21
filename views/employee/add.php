<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-users" style="color:#fff;font-size:18px;"></i></div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Quản Lý Nhân Viên</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Quản lý tài khoản và phân quyền</div>
      </div>
    </div>
    <button onclick="document.getElementById('addEmpModal').style.display='flex'"
      style="padding:9px 18px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 10px rgba(21,128,61,.3);">
      <i class="fas fa-plus"></i> Tạo tài khoản mới
    </button>
  </div>
</div>

<?php if(isset($success)): ?>
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#15803d;font-size:13px;"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
<?php endif; ?>
<?php if(isset($error)): ?>
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#dc2626;font-size:13px;"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
<?php endif; ?>

<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);padding:32px;text-align:center;">
  <div style="width:64px;height:64px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
    <i class="fas fa-users" style="font-size:28px;color:#2563eb;"></i>
  </div>
  <div style="font-size:16px;font-weight:700;color:#1e40af;margin-bottom:6px;">Quản lý tài khoản nhân viên</div>
  <div style="font-size:13px;color:#64748b;margin-bottom:18px;">Nhấn nút bên trên để tạo tài khoản mới</div>
</div>
</div>

<!-- MODAL TẠO TÀI KHOẢN -->
<div id="addEmpModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:600px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 24px 64px rgba(0,0,0,.3);">

    <!-- Header -->
    <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-user-plus" style="color:#fff;font-size:15px;"></i>
        <span style="font-size:15px;font-weight:800;color:#fff;">Tạo tài khoản nhân viên</span>
      </div>
      <button onclick="closeAddEmpModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>

    <!-- Body -->
    <div style="overflow-y:auto;flex:1;padding:22px;">
      <form method="POST" action="<?php echo BASE_URL; ?>employee/add" id="addEmpForm">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Họ tên <span style="color:#dc2626;">*</span></label>
            <input type="text" name="hoTen" id="hoTen" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
            <span style="font-size:11px;color:#dc2626;" id="hoTenErr"></span>
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Tên đăng nhập <span style="color:#dc2626;">*</span></label>
            <input type="text" name="tenDangNhap" id="tenDangNhap" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
            <span style="font-size:11px;color:#dc2626;" id="userErr"></span>
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Mật khẩu <span style="color:#dc2626;">*</span></label>
            <input type="password" name="matKhau" id="matKhau" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
            <span style="font-size:11px;color:#dc2626;" id="passErr"></span>
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Vai trò</label>
            <select name="vaiTro" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
              <option value="NhanVien">Dược sĩ</option>
              <option value="QuanLy">Quản lý</option>
            </select>
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Số điện thoại</label>
            <input type="text" name="soDienThoai" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Email</label>
            <input type="email" name="email" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Ngày sinh</label>
            <input type="date" name="ngaySinh" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
          </div>
          <div>
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Giới tính</label>
            <select name="gioiTinh" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
              <option value="Nam">Nam</option><option value="Nu">Nữ</option><option value="Khac">Khác</option>
            </select>
          </div>
          <div style="grid-column:1/-1;">
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Địa chỉ</label>
            <input type="text" name="diaChi" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;">
          </div>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div style="padding:14px 22px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;background:#fff;">
      <button onclick="closeAddEmpModal()" style="padding:9px 20px;border-radius:9px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Hủy</button>
      <button onclick="submitAddEmp()" style="padding:9px 24px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 10px rgba(21,128,61,.3);">
        <i class="fas fa-save"></i> Tạo tài khoản
      </button>
    </div>
  </div>
</div>

<script>
function closeAddEmpModal(){ document.getElementById('addEmpModal').style.display='none'; }
document.getElementById('addEmpModal').addEventListener('click',function(e){ if(e.target===this) closeAddEmpModal(); });

function submitAddEmp(){
    var ok=true;
    ['hoTenErr','userErr','passErr'].forEach(function(id){ document.getElementById(id).textContent=''; });
    if(!document.getElementById('hoTen').value.trim()){ document.getElementById('hoTenErr').textContent='Vui lòng nhập họ tên'; ok=false; }
    if(!document.getElementById('tenDangNhap').value.trim()){ document.getElementById('userErr').textContent='Vui lòng nhập tên đăng nhập'; ok=false; }
    if(!document.getElementById('matKhau').value){ document.getElementById('passErr').textContent='Vui lòng nhập mật khẩu'; ok=false; }
    if(ok) document.getElementById('addEmpForm').submit();
}

// Tự mở modal nếu có lỗi từ server
<?php if(isset($error)): ?>
document.getElementById('addEmpModal').style.display='flex';
<?php endif; ?>
</script>
