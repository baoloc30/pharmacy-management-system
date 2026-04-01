<div class="content-wrapper">

<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-shield-alt" style="color:#fff;font-size:18px;"></i>
      </div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Cấp Quyền Truy Cập</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Tài khoản: <?php echo htmlspecialchars($employee['hoTen']); ?> (<?php echo htmlspecialchars($employee['tenDangNhap']); ?>)</div>
      </div>
    </div>
    <a href="<?php echo BASE_URL; ?>employee/index" style="padding:8px 16px;border-radius:8px;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:6px;transition:0.2s;" onmouseover="this.style.background='rgba(255,255,255,.3)'" onmouseout="this.style.background='rgba(255,255,255,.2)'"><i class="fas fa-arrow-left"></i> Quay lại</a>
  </div>
</div>

<?php if(isset($error)): ?>
<div id="serverErrorBanner" style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#dc2626;font-size:13px;transition:0.5s;display:flex;align-items:center;gap:8px;">
  <i class="fas fa-exclamation-circle" style="font-size:16px;"></i> <b><?php echo $error; ?></b>
</div>
<?php endif; ?>

<style>
.perm-card {
    position: relative;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px 16px;
    background: #fff;
    transition: all 0.25s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-sizing: border-box;
}
.perm-label:hover .perm-card {
    border-color: #bfdbfe;
    box-shadow: 0 10px 20px rgba(59,130,246,0.08);
    transform: translateY(-4px);
}
.perm-checkbox:checked ~ .perm-card {
    border-color: #3b82f6;
    background: #eff6ff;
    box-shadow: 0 8px 16px rgba(59,130,246,0.12);
}
.perm-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    display: flex; justify-content: center; align-items: center;
    font-size: 24px;
    margin-bottom: 16px;
    transition: all 0.25s ease;
}
.perm-checkbox:checked ~ .perm-card .perm-icon {
    background: #2563eb;
    color: #fff;
    box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    transform: scale(1.05);
}
.perm-title {
    font-size: 14px;
    font-weight: 800;
    color: #334155;
    margin-bottom: 8px;
    transition: color 0.2s;
}
.perm-checkbox:checked ~ .perm-card .perm-title {
    color: #1e40af;
}
.perm-desc {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.5;
}
.check-badge {
    position: absolute;
    top: 14px; right: 14px;
    color: #2563eb;
    font-size: 22px;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.perm-checkbox:checked ~ .perm-card .check-badge {
    opacity: 1;
    transform: scale(1);
}
</style>

<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e3a8a,#1e40af);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-check-square" style="color:#60a5fa;"></i>
    <span style="font-size:14px;font-weight:800;color:#fff;text-transform:uppercase;">Danh sách các quyền <span style="color:#93c5fd;font-weight:600;text-transform:none;">(Vui lòng chọn ít nhất một quyền)</span></span>
  </div>
  
  <form method="POST" action="" style="padding:24px;">
    
    <?php
    $iconMap = [
        'BAN_HANG'          => 'fas fa-cash-register',
        'XEM_KHO'           => 'fas fa-box-open',
        'QUAN_LY_THUOC'     => 'fas fa-capsules',
        'QUAN_LY_KHO'       => 'fas fa-warehouse',
        'XEM_THONG_KE'      => 'fas fa-chart-pie',
        'QUAN_LY_NHAN_VIEN' => 'fas fa-user-shield'
    ];

    $nameMap = [
        'BAN_HANG'          => 'BÁN HÀNG',
        'XEM_KHO'           => 'XEM KHO',
        'QUAN_LY_THUOC'     => 'QUẢN LÝ THUỐC',
        'QUAN_LY_KHO'       => 'QUẢN LÝ KHO',
        'XEM_THONG_KE'      => 'XEM THỐNG KÊ',
        'QUAN_LY_NHAN_VIEN' => 'QUẢN LÝ NHÂN VIÊN'
    ];
    ?>

    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
      
      <?php foreach ($all_permissions as $p): ?>
      <?php 
        $isChecked = in_array($p['maQuyen'], $current_permissions); 
        $icon = $iconMap[$p['tenQuyen']] ?? 'fas fa-cogs';
        $displayName = $nameMap[$p['tenQuyen']] ?? $p['tenQuyen'];
      ?>
      
      <label class="perm-label" style="cursor:pointer; display:block; height:100%; margin:0;">
        <input type="checkbox" name="permissions[]" value="<?php echo $p['maQuyen']; ?>" <?php echo $isChecked ? 'checked' : ''; ?> class="perm-checkbox" style="display:none;">
        
        <div class="perm-card">
          <div class="check-badge"><i class="fas fa-check-circle"></i></div>
          <div class="perm-icon"><i class="<?php echo $icon; ?>"></i></div>
          
          <div class="perm-title"><?php echo htmlspecialchars($displayName); ?></div>
          <div class="perm-desc"><?php echo htmlspecialchars($p['moTa']); ?></div>
        </div>
      </label>

      <?php endforeach; ?>

    </div>

    <div style="display:flex;gap:12px;justify-content:flex-end;padding-top:20px;border-top:1px solid #e2e8f0;">
      <a href="<?php echo BASE_URL; ?>employee/index" style="padding:10px 24px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#475569;font-size:13.5px;font-weight:700;text-decoration:none;transition:0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">Hủy</a>
      <button type="submit" style="padding:10px 28px;border-radius:10px;border:none;background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;font-size:13.5px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(37,99,235,.25);display:flex;align-items:center;gap:8px;transition:0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 16px rgba(37,99,235,.35)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 12px rgba(37,99,235,.25)'">
        <i class="fas fa-check-circle"></i> Xác nhận
      </button>
    </div>
  </form>
</div>

</div>

<script>
const errorBanner = document.getElementById('serverErrorBanner');
if(errorBanner) {
    setTimeout(() => { 
        errorBanner.style.opacity = '0'; 
        setTimeout(() => errorBanner.style.display = 'none', 500); 
    }, 3000);
}
</script>