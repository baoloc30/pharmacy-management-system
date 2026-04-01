<div class="content-wrapper">
<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-calendar-alt" style="color:#fff;font-size:18px;"></i></div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Lịch Làm Việc</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Phân công ca làm việc nhân viên</div>
    </div>
  </div>
</div>

<div style="display:flex;gap:16px;flex-wrap:wrap;">

  <!-- Bảng lịch -->
  <div style="flex:1.4;min-width:300px;">
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
      <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);">
        <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách ca làm việc</span>
      </div>
      <div style="padding:14px 16px;border-bottom:1px solid #e2e8f0;">
        <form method="GET" action="" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;">
          <div style="flex:1;min-width:140px;">
            <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Từ ngày</label>
            <input type="date" name="from_date" value="<?php echo $from_date; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          </div>
          <div style="flex:1;min-width:140px;">
            <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đến ngày</label>
            <input type="date" name="to_date" value="<?php echo $to_date; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          </div>
          <button type="submit" style="padding:8px 16px;border-radius:8px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;"><i class="fas fa-filter"></i> Lọc</button>
        </form>
      </div>
      <div style="overflow-x:auto;">
        <?php if(empty($schedule)): ?>
          <div style="padding:30px;text-align:center;color:#94a3b8;font-size:13px;">Không có lịch làm việc trong khoảng thời gian này</div>
        <?php else: ?>
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
              <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Nhân viên</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ngày làm</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ca làm</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Giờ bắt đầu</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Giờ kết thúc</th>
              <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Ghi chú</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($schedule as $i => $s): ?>
            <?php $rowBg = $i%2===0?'#fff':'#f0f7ff'; ?>
            <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
              <td style="padding:9px 14px;font-size:13px;font-weight:600;color:#374151;"><?php echo htmlspecialchars($s['hoTen']); ?></td>
              <td style="padding:9px 14px;font-size:13px;color:#374151;white-space:nowrap;"><?php echo date('d/m/Y', strtotime($s['ngayLam'])); ?></td>
              <td style="padding:9px 14px;">
                <?php if($s['caLam']==='TangCa'): ?>
                  <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#fffbeb;color:#b45309;">Tăng ca</span>
                <?php else: ?>
                  <span style="padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;background:#eff6ff;color:#1d4ed8;">Sáng chiều</span>
                <?php endif; ?>
              </td>
              <td style="padding:9px 14px;font-size:13px;color:#374151;"><?php echo $s['gioBatDau']; ?></td>
              <td style="padding:9px 14px;font-size:13px;color:#374151;"><?php echo $s['gioKetThuc']; ?></td>
              <td style="padding:9px 14px;font-size:12px;color:#64748b;"><?php echo htmlspecialchars($s['ghiChu']??''); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Form phân công -->
  <div style="flex:1;min-width:260px;">
    <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
      <div style="padding:12px 16px;background:linear-gradient(135deg,#15803d,#16a34a);display:flex;align-items:center;gap:8px;">
        <i class="fas fa-plus" style="color:#fff;font-size:13px;"></i>
        <span style="font-size:13px;font-weight:700;color:#fff;">Phân công tăng ca (18h - 22h)</span>
      </div>
      <div style="padding:18px;">
        <form method="POST" action="" id="shiftForm">
          <div style="margin-bottom:12px;">
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Nhân viên <span style="color:#dc2626;">*</span></label>
            <select name="maNhanVien" id="maNhanVien" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
              <option value="">-- Chọn nhân viên --</option>
              <?php foreach($employees as $emp): ?>
              <option value="<?php echo $emp['maNhanVien']; ?>" <?php echo (isset($_POST['maNhanVien']) && $_POST['maNhanVien'] == $emp['maNhanVien']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($emp['hoTen']); ?></option>
              <?php endforeach; ?>
            </select>
            <div id="err_maNhanVien" style="color:#dc2626; font-size:11px; margin-top:4px; height:13px; font-weight:600; transition: 0.3s;"><?php echo (isset($inline_error) && empty($_POST['maNhanVien'])) ? $inline_error : ''; ?></div>
          </div>
          <div style="margin-bottom:12px;">
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Ngày tăng ca <span style="color:#dc2626;">*</span></label>
            <input type="date" name="ngayLam" id="ngayLam" value="<?php echo $_POST['ngayLam'] ?? ''; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
            <div id="err_ngayLam" style="color:#dc2626; font-size:11px; margin-top:4px; height:13px; font-weight:600; transition: 0.3s;"><?php echo (isset($inline_error) && empty($_POST['ngayLam'])) ? $inline_error : ''; ?></div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;">
            <div>
              <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Giờ bắt đầu</label>
              <input type="time" name="gioBatDau" id="gioBatDau" value="<?php echo $_POST['gioBatDau'] ?? '18:00'; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
              <div id="err_gioBatDau" style="color:#dc2626; font-size:11px; margin-top:4px; height:13px; font-weight:600; transition: 0.3s;"><?php echo (isset($inline_error) && empty($_POST['gioBatDau'])) ? $inline_error : ''; ?></div>
            </div>
            <div>
              <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Giờ kết thúc</label>
              <input type="time" name="gioKetThuc" id="gioKetThuc" value="<?php echo $_POST['gioKetThuc'] ?? '22:00'; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
              <div id="err_gioKetThuc" style="color:#dc2626; font-size:11px; margin-top:4px; height:13px; font-weight:600; transition: 0.3s;"><?php echo (isset($inline_error) && empty($_POST['gioKetThuc'])) ? $inline_error : ''; ?></div>
            </div>
          </div>
          <div style="margin-bottom:14px;">
            <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Ghi chú</label>
            <input type="text" name="ghiChu" value="<?php echo $_POST['ghiChu'] ?? ''; ?>" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
          </div>
          <button type="submit" style="width:100%;padding:10px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 10px rgba(21,128,61,.3);">
            <i class="fas fa-save"></i> Xác nhận phân công
          </button>
        </form>
      </div>
    </div>
  </div>

</div>
</div>

<div id="toastContainer" style="position:fixed; top:64px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px;"></div>

<style>
.custom-toast {
    background: #fff; border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    display: flex; align-items: center; padding: 16px 20px; width: 330px;
    position: relative; overflow: hidden; transform: translateX(120%);
    animation: slideInToast 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}
.custom-toast .toast-icon {
    width: 38px; height: 38px; border-radius: 50%; color: #fff;
    display: flex; align-items: center; justify-content: center; margin-right: 14px; font-size: 18px; flex-shrink: 0;
}
.toast-success .toast-icon { background: #10b981; }
.toast-error .toast-icon { background: #ef4444; }
.toast-content { flex: 1; }
.toast-title { font-weight: 800; color: #1e293b; font-size: 16px; margin-bottom: 2px; }
.toast-message { color: #64748b; font-size: 13.5px; line-height: 1.4; }
.toast-progress {
    position: absolute; bottom: 0; left: 0; height: 4px; width: 100%;
    animation: progressToast 3s linear forwards;
}
.toast-success .toast-progress { background: #10b981; }
.toast-error .toast-progress { background: #ef4444; }

@keyframes slideInToast { to { transform: translateX(0); } }
@keyframes slideOutToast { to { transform: translateX(120%); } }
@keyframes progressToast { to { width: 0; } }
</style>

<script>
function showToast(type, title, message) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `custom-toast toast-${type}`;
    const iconClass = type === 'success' ? 'fa-check' : 'fa-times';

    toast.innerHTML = `
        <div class="toast-icon"><i class="fas ${iconClass}"></i></div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <div class="toast-progress"></div>
    `;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOutToast 0.5s forwards';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

<?php if(isset($_SESSION['toast_success'])): ?>
    showToast('success', 'Thành công!', '<?php echo htmlspecialchars($_SESSION['toast_success']); ?>');
    <?php unset($_SESSION['toast_success']); ?>
<?php endif; ?>

<?php if(isset($toast_error)): ?>
    showToast('error', 'Lỗi!', '<?php echo htmlspecialchars($toast_error); ?>');
<?php endif; ?>

document.getElementById('shiftForm').addEventListener('submit', function(e) {
    let isValid = true;
    let fields = ['maNhanVien', 'ngayLam', 'gioBatDau', 'gioKetThuc'];

    fields.forEach(function(field) {
        let input = document.getElementById(field);
        let errDiv = document.getElementById('err_' + field);
        
        if (!input.value.trim()) {
            errDiv.textContent = 'Vui lòng chọn đầy đủ thông tin!';
            isValid = false;
            
            setTimeout(() => { errDiv.textContent = ''; }, 3000);
        } else {
            errDiv.textContent = '';
        }
    });

    if (!isValid) {
        e.preventDefault();
    }
});

setTimeout(() => {
    document.querySelectorAll('[id^="err_"]').forEach(el => el.textContent = '');
}, 3000);
</script>
