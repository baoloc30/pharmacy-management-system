<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-users" style="color:#fff;font-size:18px;"></i>
      </div>
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

<?php if (isset($_SESSION['error'])): ?>
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#dc2626;font-size:13px;">
  <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
</div>
<?php endif; ?>

<!-- Table -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-list" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách nhân viên</span>
    </div>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($employees); ?> nhân viên</span>
  </div>
  <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Mã NV</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Họ tên</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Tên đăng nhập</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Vai trò</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">SĐT</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Email</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Trạng thái</th>
          <th style="padding:11px 16px;font-size:12px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $i => $emp): ?>
        <?php $rowBg = $i%2===0?'#fff':'#f0f7ff'; ?>
        <tr style="background:<?php echo $rowBg; ?>;transition:background .15s;"
          onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
          <td style="padding:10px 16px;font-size:13px;color:#64748b;"><?php echo $emp['maNhanVien']; ?></td>
          <td style="padding:10px 16px;font-size:13px;font-weight:600;color:#1e40af;"><?php echo htmlspecialchars($emp['hoTen']); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($emp['tenDangNhap']); ?></td>
          <td style="padding:10px 16px;">
            <?php if ($emp['vaiTro']=='QuanLy'): ?>
              <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#eff6ff;color:#1d4ed8;">Quản lý</span>
            <?php else: ?>
              <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f8fafc;color:#64748b;">Dược sĩ</span>
            <?php endif; ?>
          </td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($emp['soDienThoai'] ?? ''); ?></td>
          <td style="padding:10px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($emp['email'] ?? ''); ?></td>
          <td style="padding:10px 16px;">
            <?php if ($emp['trangThai']=='HoatDong'): ?>
              <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f0fdf4;color:#15803d;">Hoạt động</span>
            <?php else: ?>
              <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fef2f2;color:#dc2626;">Bị khóa</span>
            <?php endif; ?>
          </td>
          <td style="padding:10px 16px;text-align:center;white-space:nowrap;">
            <a href="<?php echo BASE_URL; ?>employee/edit/<?php echo $emp['idTaiKhoan']; ?>"
              style="padding:5px 12px;border-radius:7px;border:1.5px solid #fde68a;background:#fffbeb;color:#b45309;font-size:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-right:4px;">
              <i class="fas fa-edit"></i> Sửa
            </a>
            <?php if ($emp['idTaiKhoan'] != Session::get('user_id') && $emp['trangThai']=='HoatDong'): ?>
            <button onclick="confirmDelete(<?php echo $emp['idTaiKhoan']; ?>,'<?php echo htmlspecialchars($emp['hoTen']); ?>')"
              style="padding:5px 12px;border-radius:7px;border:none;background:#fef2f2;color:#dc2626;font-size:12px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
              <i class="fas fa-ban"></i> Khóa
            </button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</div>

<!-- Overlay xác nhận khóa -->
<div id="deleteOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:360px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);">
    <div style="padding:14px 20px;background:linear-gradient(135deg,#dc2626,#ef4444);display:flex;align-items:center;gap:10px;">
      <i class="fas fa-ban" style="color:#fff;font-size:15px;"></i>
      <span style="font-size:14px;font-weight:700;color:#fff;">Xác nhận vô hiệu hóa</span>
    </div>
    <div style="padding:20px 22px;font-size:14px;color:#374151;" id="deleteMsg"></div>
    <div style="padding:10px 22px 18px;display:flex;gap:10px;justify-content:flex-end;">
      <button onclick="document.getElementById('deleteOverlay').style.display='none'" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Hủy</button>
      <a href="#" id="deleteConfirmBtn" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
        <i class="fas fa-ban"></i> Vô hiệu hóa
      </a>
    </div>
  </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteMsg').textContent = 'Bạn có chắc chắn muốn vô hiệu hóa tài khoản của "' + name + '"?';
    document.getElementById('deleteConfirmBtn').href = '<?php echo BASE_URL; ?>employee/delete/' + id;
    document.getElementById('deleteOverlay').style.display = 'flex';
}
document.getElementById('deleteOverlay').addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; });
</script>

<!-- MODAL TẠO TÀI KHOẢN -->
<div id="addEmpModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:600px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 24px 64px rgba(0,0,0,.3);">
    <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-user-plus" style="color:#fff;font-size:15px;"></i>
        <span style="font-size:15px;font-weight:800;color:#fff;">Tạo tài khoản nhân viên</span>
      </div>
      <button onclick="closeAddEmpModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>
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
</script>
