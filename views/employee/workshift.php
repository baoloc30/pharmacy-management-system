<?php
$totalShifts = count($schedule ?? []);
$tangCaCount = count(array_filter($schedule ?? [], fn($s) => $s['caLam'] === 'TangCa'));
$uniqueNV    = count(array_unique(array_column($schedule ?? [], 'maNhanVien')));
?>
<div class="content-wrapper">

<!-- HEADER -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
  <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div style="display:flex;align-items:center;gap:14px;">
      <div style="width:46px;height:46px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-calendar-alt" style="color:#fff;font-size:20px;"></i>
      </div>
      <div>
        <div style="font-size:19px;font-weight:900;color:#fff;letter-spacing:.5px;">Quản Lý Ca Làm Việc</div>
        <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Xem lịch &amp; phân công ca làm việc cho nhân viên</div>
      </div>
    </div>
    <!-- Thống kê nhanh -->
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <div style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);border-radius:10px;padding:8px 18px;text-align:center;">
        <div style="font-size:22px;font-weight:900;color:#fff;"><?php echo $totalShifts; ?></div>
        <div style="font-size:10px;color:rgba(255,255,255,.75);font-weight:600;text-transform:uppercase;">Tổng ca</div>
      </div>
      <div style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);border-radius:10px;padding:8px 18px;text-align:center;">
        <div style="font-size:22px;font-weight:900;color:#fbbf24;"><?php echo $tangCaCount; ?></div>
        <div style="font-size:10px;color:rgba(255,255,255,.75);font-weight:600;text-transform:uppercase;">Tăng ca</div>
      </div>
      <div style="background:rgba(255,255,255,.18);border:1px solid rgba(255,255,255,.3);border-radius:10px;padding:8px 18px;text-align:center;">
        <div style="font-size:22px;font-weight:900;color:#6ee7b7;"><?php echo $uniqueNV; ?></div>
        <div style="font-size:10px;color:rgba(255,255,255,.75);font-weight:600;text-transform:uppercase;">Nhân viên</div>
      </div>
    </div>
  </div>
</div>

<!-- FORM PHÂN CÔNG -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:20px;">
  <div style="padding:14px 20px;background:linear-gradient(135deg,#065f46,#059669);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-plus-circle" style="color:#fff;font-size:15px;"></i>
    <span style="font-size:14px;font-weight:800;color:#fff;">Phân Công Ca Làm Việc</span>
  </div>
  <div style="padding:20px 24px;">
    <form method="POST" action="" id="shiftForm">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(175px,1fr));gap:16px;align-items:end;">

        <!-- Nhân viên -->
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">
            <i class="fas fa-user" style="color:#2563eb;margin-right:4px;"></i>Nhân viên <span style="color:#dc2626;">*</span>
          </label>
          <select name="maNhanVien" id="maNhanVien"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;background:#fff;color:#374151;box-sizing:border-box;">
            <option value="">-- Chọn nhân viên --</option>
            <?php foreach($employees as $emp): ?>
            <?php if(($emp['trangThai'] ?? '') !== 'NgungHoatDong'): ?>
            <option value="<?php echo $emp['maNhanVien']; ?>"
              <?php echo (isset($_POST['maNhanVien']) && $_POST['maNhanVien'] == $emp['maNhanVien']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($emp['hoTen']); ?>
            </option>
            <?php endif; ?>
            <?php endforeach; ?>
          </select>
          <div id="err_maNhanVien" style="color:#dc2626;font-size:11px;margin-top:3px;min-height:14px;font-weight:600;"></div>
        </div>

        <!-- Ngày làm -->
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">
            <i class="fas fa-calendar" style="color:#2563eb;margin-right:4px;"></i>Ngày làm <span style="color:#dc2626;">*</span>
          </label>
          <input type="date" name="ngayLam" id="ngayLam"
            value="<?php echo htmlspecialchars($_POST['ngayLam'] ?? ''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;">
          <div id="err_ngayLam" style="color:#dc2626;font-size:11px;margin-top:3px;min-height:14px;font-weight:600;"></div>
        </div>

        <!-- Loại ca — chỉ 3 ca -->
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">
            <i class="fas fa-clock" style="color:#2563eb;margin-right:4px;"></i>Loại ca <span style="color:#dc2626;">*</span>
          </label>
          <select name="caLam" id="caLam" onchange="autoFillTime(this.value)"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;background:#fff;color:#374151;box-sizing:border-box;">
            <option value="">-- Chọn loại ca --</option>
            <option value="Sang"   <?php echo (isset($_POST['caLam']) && $_POST['caLam']==='Sang')   ? 'selected':''; ?>>☀️ Ca Sáng   (7:30 – 12:00)</option>
            <option value="Chieu"  <?php echo (isset($_POST['caLam']) && $_POST['caLam']==='Chieu')  ? 'selected':''; ?>>🌤️ Ca Chiều  (13:00 – 17:00)</option>
            <option value="TangCa" <?php echo (isset($_POST['caLam']) && $_POST['caLam']==='TangCa') ? 'selected':''; ?>>🌙 Tăng Ca   (18:00 – 22:00)</option>
          </select>
          <div id="err_caLam" style="color:#dc2626;font-size:11px;margin-top:3px;min-height:14px;font-weight:600;"></div>
        </div>

        <!-- Giờ bắt đầu -->
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">
            <i class="fas fa-hourglass-start" style="color:#2563eb;margin-right:4px;"></i>Giờ bắt đầu
          </label>
          <input type="time" name="gioBatDau" id="gioBatDau"
            value="<?php echo htmlspecialchars($_POST['gioBatDau'] ?? ''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>

        <!-- Giờ kết thúc -->
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">
            <i class="fas fa-hourglass-end" style="color:#2563eb;margin-right:4px;"></i>Giờ kết thúc
          </label>
          <input type="time" name="gioKetThuc" id="gioKetThuc"
            value="<?php echo htmlspecialchars($_POST['gioKetThuc'] ?? ''); ?>"
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>

        <!-- Ghi chú -->
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">
            <i class="fas fa-sticky-note" style="color:#2563eb;margin-right:4px;"></i>Ghi chú
          </label>
          <input type="text" name="ghiChu"
            value="<?php echo htmlspecialchars($_POST['ghiChu'] ?? ''); ?>"
            placeholder="Nhập ghi chú..."
            style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;">
        </div>

        <!-- Nút submit -->
        <div style="display:flex;align-items:flex-end;">
          <button type="submit"
            style="width:100%;padding:10px 16px;border-radius:9px;border:none;background:linear-gradient(135deg,#065f46,#059669);color:#fff;font-size:13px;font-weight:800;cursor:pointer;box-shadow:0 4px 12px rgba(5,150,105,.35);display:flex;align-items:center;justify-content:center;gap:7px;">
            <i class="fas fa-check-circle"></i> Xác nhận phân công
          </button>
        </div>

      </div><!-- end grid -->

      <?php if(isset($inline_error)): ?>
      <div style="margin-top:14px;padding:10px 14px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;color:#dc2626;font-size:13px;font-weight:600;">
        <i class="fas fa-exclamation-circle" style="margin-right:6px;"></i><?php echo htmlspecialchars($inline_error); ?>
      </div>
      <?php endif; ?>
    </form>
  </div>
</div>

<!-- BẢNG DANH SÁCH -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:14px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-list-alt" style="color:#fff;font-size:14px;"></i>
      <span style="font-size:14px;font-weight:800;color:#fff;">Danh Sách Ca Làm Việc</span>
    </div>
    <!-- Bộ lọc ngày -->
    <form method="GET" action="" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:6px;">
        <label style="font-size:12px;color:rgba(255,255,255,.85);font-weight:600;white-space:nowrap;">Từ ngày</label>
        <input type="date" name="from_date" value="<?php echo $from_date; ?>"
          style="padding:6px 10px;border:1.5px solid rgba(255,255,255,.35);border-radius:8px;font-size:12px;background:rgba(255,255,255,.15);color:#fff;outline:none;">
      </div>
      <div style="display:flex;align-items:center;gap:6px;">
        <label style="font-size:12px;color:rgba(255,255,255,.85);font-weight:600;white-space:nowrap;">Đến ngày</label>
        <input type="date" name="to_date" value="<?php echo $to_date; ?>"
          style="padding:6px 10px;border:1.5px solid rgba(255,255,255,.35);border-radius:8px;font-size:12px;background:rgba(255,255,255,.15);color:#fff;outline:none;">
      </div>
      <button type="submit"
        style="padding:6px 14px;border-radius:8px;border:none;background:rgba(255,255,255,.25);color:#fff;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:5px;">
        <i class="fas fa-filter"></i> Lọc
      </button>
    </form>
  </div>

  <div style="overflow-x:auto;">
    <?php if(empty($schedule)): ?>
    <div style="padding:50px;text-align:center;">
      <div style="width:64px;height:64px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
        <i class="fas fa-calendar-times" style="font-size:26px;color:#cbd5e1;"></i>
      </div>
      <div style="font-size:14px;font-weight:600;color:#94a3b8;">Không có ca làm việc trong khoảng thời gian này</div>
      <div style="font-size:12px;color:#cbd5e1;margin-top:4px;">Hãy dùng form bên trên để phân công ca mới</div>
    </div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#1e3a8a,#1d4ed8);">
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:left;">#</th>
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:left;">Nhân viên</th>
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:left;">Ngày làm</th>
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:left;">Loại ca</th>
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:left;">Giờ làm</th>
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:left;">Ghi chú</th>
          <th style="padding:11px 14px;font-size:11px;font-weight:700;color:#93c5fd;text-transform:uppercase;text-align:center;">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Badge config — chỉ 3 ca
        $caMap = [
          'Sang'   => ['☀️ Ca sáng',  '#eff6ff','#1d4ed8','#bfdbfe'],
          'Chieu'  => ['🌤️ Ca chiều', '#f0fdf4','#15803d','#bbf7d0'],
          'TangCa' => ['🌙 Tăng ca',  '#fffbeb','#b45309','#fde68a'],
        ];
        $dow = ['CN','T2','T3','T4','T5','T6','T7'];
        foreach($schedule as $i => $s):
          $bg = $i%2===0 ? '#fff' : '#f8faff';
          $ca = $caMap[$s['caLam']] ?? [htmlspecialchars($s['caLam']),'#f1f5f9','#64748b','#e2e8f0'];
          $d  = strtotime($s['ngayLam']);
        ?>
        <tr style="background:<?php echo $bg; ?>;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='<?php echo $bg; ?>'">
          <td style="padding:10px 14px;font-size:12px;color:#94a3b8;font-weight:600;"><?php echo $i+1; ?></td>
          <td style="padding:10px 14px;">
            <div style="display:flex;align-items:center;gap:8px;">
              <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#2563eb,#38bdf8);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#fff;flex-shrink:0;">
                <?php echo mb_strtoupper(mb_substr($s['hoTen'],0,1,'UTF-8'),'UTF-8'); ?>
              </div>
              <span style="font-size:13px;font-weight:700;color:#1e293b;"><?php echo htmlspecialchars($s['hoTen']); ?></span>
            </div>
          </td>
          <td style="padding:10px 14px;">
            <div style="font-size:13px;font-weight:600;color:#374151;"><?php echo date('d/m/Y',$d); ?></div>
            <div style="font-size:11px;color:#94a3b8;"><?php echo $dow[date('w',$d)]; ?></div>
          </td>
          <td style="padding:10px 14px;">
            <span style="padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;background:<?php echo $ca[1]; ?>;color:<?php echo $ca[2]; ?>;border:1px solid <?php echo $ca[3]; ?>;">
              <?php echo $ca[0]; ?>
            </span>
          </td>
          <td style="padding:10px 14px;font-size:13px;font-weight:600;color:#374151;white-space:nowrap;">
            <i class="fas fa-clock" style="color:#94a3b8;font-size:11px;margin-right:4px;"></i>
            <?php echo substr($s['gioBatDau'],0,5); ?> – <?php echo substr($s['gioKetThuc'],0,5); ?>
          </td>
          <td style="padding:10px 14px;font-size:12px;color:#64748b;max-width:160px;">
            <?php echo $s['ghiChu'] ? htmlspecialchars($s['ghiChu']) : '<span style="color:#cbd5e1;">—</span>'; ?>
          </td>
          <td style="padding:10px 14px;text-align:center;">
            <a href="<?php echo BASE_URL; ?>employee/deleteshift/<?php echo $s['maLich']; ?>"
               onclick="return confirm('Bạn có chắc muốn xóa ca làm việc này?')"
               style="display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:7px;background:#fef2f2;color:#dc2626;font-size:12px;font-weight:700;text-decoration:none;border:1px solid #fecaca;"
               onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'">
              <i class="fas fa-trash-alt"></i> Xóa
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div style="padding:10px 16px;border-top:1px solid #f1f5f9;background:#f8faff;font-size:12px;color:#64748b;text-align:right;">
      Hiển thị <strong><?php echo $totalShifts; ?></strong> ca &nbsp;|&nbsp;
      Từ <strong><?php echo date('d/m/Y',strtotime($from_date)); ?></strong>
      đến <strong><?php echo date('d/m/Y',strtotime($to_date)); ?></strong>
    </div>
    <?php endif; ?>
  </div>
</div>

</div><!-- end content-wrapper -->

<!-- Toast container -->
<div id="toastContainer" style="position:fixed;top:70px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;"></div>

<style>
.custom-toast{background:#fff;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.15);display:flex;align-items:center;padding:14px 18px;width:320px;position:relative;overflow:hidden;transform:translateX(120%);animation:slideInToast .4s cubic-bezier(.175,.885,.32,1.275) forwards;}
.toast-icon{width:36px;height:36px;border-radius:50%;color:#fff;display:flex;align-items:center;justify-content:center;margin-right:12px;font-size:16px;flex-shrink:0;}
.toast-success .toast-icon{background:#10b981;} .toast-error .toast-icon{background:#ef4444;}
.toast-content{flex:1;}
.toast-title{font-weight:800;color:#1e293b;font-size:14px;margin-bottom:2px;}
.toast-message{color:#64748b;font-size:12px;}
.toast-progress{position:absolute;bottom:0;left:0;height:3px;width:100%;animation:progressToast 3s linear forwards;}
.toast-success .toast-progress{background:#10b981;} .toast-error .toast-progress{background:#ef4444;}
@keyframes slideInToast{to{transform:translateX(0);}}
@keyframes slideOutToast{to{transform:translateX(120%);}}
@keyframes progressToast{to{width:0;}}
</style>

<script>
function showToast(type, title, message) {
    var c = document.getElementById('toastContainer');
    var t = document.createElement('div');
    t.className = 'custom-toast toast-' + type;
    t.innerHTML = '<div class="toast-icon"><i class="fas fa-'+(type==='success'?'check':'times')+'"></i></div>'
        + '<div class="toast-content"><div class="toast-title">'+title+'</div><div class="toast-message">'+message+'</div></div>'
        + '<div class="toast-progress"></div>';
    c.appendChild(t);
    setTimeout(function(){t.style.animation='slideOutToast .4s forwards';setTimeout(function(){t.remove();},400);},3000);
}

<?php if(isset($_SESSION['toast_success'])): ?>
showToast('success','Thành công!','<?php echo addslashes(htmlspecialchars($_SESSION['toast_success'])); ?>');
<?php unset($_SESSION['toast_success']); endif; ?>
<?php if(isset($toast_error)): ?>
showToast('error','Lỗi!','<?php echo addslashes(htmlspecialchars($toast_error)); ?>');
<?php endif; ?>

// Tự động điền giờ theo loại ca (3 ca cố định)
function autoFillTime(caLam) {
    var map = {
        'Sang':   ['07:30', '12:00'],
        'Chieu':  ['13:00', '17:00'],
        'TangCa': ['18:00', '22:00']
    };
    if (map[caLam]) {
        document.getElementById('gioBatDau').value  = map[caLam][0];
        document.getElementById('gioKetThuc').value = map[caLam][1];
    }
}

// Validate form
document.getElementById('shiftForm').addEventListener('submit', function(e) {
    var ok = true;
    ['maNhanVien','ngayLam','caLam'].forEach(function(f) {
        var el  = document.getElementById(f);
        var err = document.getElementById('err_' + f);
        if (el && !el.value.trim()) {
            if (err) {
                err.textContent = 'Vui lòng chọn đầy đủ thông tin!';
                setTimeout(function(){err.textContent='';},3000);
            }
            ok = false;
        } else {
            if (err) err.textContent = '';
        }
    });
    if (!ok) e.preventDefault();
});
</script>
