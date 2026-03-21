<?php $homeUrl = BASE_URL . 'home/' . (Session::get('role') === 'QuanLy' ? 'admin' : 'employee'); ?>
<div class="content-wrapper">
<div style="max-width:520px;margin:0 auto;">
<div style="background:#fff;border-radius:16px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

                    <form method="POST" action="<?php echo BASE_URL; ?>auth/changePassword" class="change-password-form">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                            <span class="text-danger small" id="oldPasswordError"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            <span class="text-danger small d-block" id="newPasswordError"></span>
                            <small class="text-muted d-block">Ít nhất 6 ký tự</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            <span class="text-danger small" id="confirmPasswordError"></span>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?php echo BASE_URL; ?>home/<?php echo Session::get('role') == 'QuanLy' ? 'admin' : 'employee'; ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
      <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Đổi Mật Khẩu</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Cập nhật mật khẩu đăng nhập của bạn</div>
    </div>
  </div>

  <?php if(isset($error)): ?>
  <div style="margin:14px 22px 0;padding:12px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:10px;color:#dc2626;font-size:13px;display:flex;align-items:center;gap:8px;">
    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
  </div>
  <?php endif; ?>
  <?php if(isset($success)): ?>
  <div style="margin:14px 22px 0;padding:12px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;color:#15803d;font-size:13px;display:flex;align-items:center;gap:8px;">
    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
  </div>
  <?php endif; ?>

  <div style="margin:14px 22px 0;padding:12px 14px;background:#eff6ff;border-radius:10px;border-left:3px solid #2563eb;">
    <div style="font-size:12px;font-weight:700;color:#1d4ed8;margin-bottom:3px;"><i class="fas fa-lightbulb"></i> Lưu ý bảo mật</div>
    <div style="font-size:12px;color:#3b82f6;">Mật khẩu nên có ít nhất 6 ký tự, kết hợp chữ và số.</div>
  </div>

  <form method="POST" action="<?php echo BASE_URL; ?>auth/changePassword" id="changePwForm" style="padding:20px 22px;">

    <div style="margin-bottom:16px;">
      <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">Mật khẩu hiện tại <span style="color:#dc2626;">*</span></label>
      <div style="position:relative;">
        <i class="fas fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none;"></i>
        <input type="password" name="old_password" id="old_password" placeholder="Nhập mật khẩu hiện tại"
          style="width:100%;padding:10px 40px 10px 36px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;"
          onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
          onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
        <i class="fas fa-eye toggle-pw" data-target="old_password" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;cursor:pointer;font-size:13px;"></i>
      </div>
      <span style="font-size:11px;color:#dc2626;display:block;min-height:16px;margin-top:3px;" id="oldPwErr"></span>
    </div>

    <div style="height:1px;background:#f1f5f9;margin-bottom:16px;"></div>

    <div style="margin-bottom:16px;">
      <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">Mật khẩu mới <span style="color:#dc2626;">*</span></label>
      <div style="position:relative;">
        <i class="fas fa-key" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none;"></i>
        <input type="password" name="new_password" id="new_password" placeholder="Tối thiểu 6 ký tự"
          style="width:100%;padding:10px 40px 10px 36px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;"
          onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
          onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
          oninput="checkStrength(this.value)">
        <i class="fas fa-eye toggle-pw" data-target="new_password" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;cursor:pointer;font-size:13px;"></i>
      </div>
      <div style="display:flex;gap:4px;margin-top:6px;">
        <div style="flex:1;height:3px;border-radius:2px;background:#e2e8f0;transition:background .3s;" id="bar1"></div>
        <div style="flex:1;height:3px;border-radius:2px;background:#e2e8f0;transition:background .3s;" id="bar2"></div>
        <div style="flex:1;height:3px;border-radius:2px;background:#e2e8f0;transition:background .3s;" id="bar3"></div>
        <div style="flex:1;height:3px;border-radius:2px;background:#e2e8f0;transition:background .3s;" id="bar4"></div>
      </div>
      <span style="font-size:11px;color:#dc2626;display:block;min-height:16px;margin-top:3px;" id="newPwErr"></span>
    </div>

    <div style="margin-bottom:20px;">
      <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;">Nhập lại mật khẩu mới <span style="color:#dc2626;">*</span></label>
      <div style="position:relative;">
        <i class="fas fa-check-double" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none;"></i>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Nhập lại mật khẩu mới"
          style="width:100%;padding:10px 40px 10px 36px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;outline:none;box-sizing:border-box;"
          onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
          onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
        <i class="fas fa-eye toggle-pw" data-target="confirm_password" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;cursor:pointer;font-size:13px;"></i>
      </div>
      <span style="font-size:11px;color:#dc2626;display:block;min-height:16px;margin-top:3px;" id="cfPwErr"></span>
    </div>

    <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
      <a href="<?php echo $homeUrl; ?>"
         style="padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
        <i class="fas fa-times"></i> Hủy
      </a>
      <button type="submit" id="submitBtn"
         style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(30,64,175,.3);">
        <i class="fas fa-shield-alt"></i> Cập nhật mật khẩu
      </button>
    </div>
  </form>
</div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serverAlert = document.querySelector('.alert-danger');
        if (serverAlert) {
            setTimeout(function() {
                serverAlert.style.transition = 'opacity 0.5s ease';
                serverAlert.style.opacity = '0'; 
                setTimeout(function() {
                    serverAlert.style.display = 'none'; 
                }, 500);
            }, 2000);
        }

    document.querySelector('.change-password-form').addEventListener('submit', function(e) {
        ['oldPasswordError','newPasswordError','confirmPasswordError'].forEach(id => document.getElementById(id).textContent = '');
        const old = document.getElementById('old_password').value.trim();
        const nw = document.getElementById('new_password').value.trim();
        const cf = document.getElementById('confirm_password').value.trim();
        let hasError = false;

        if (!old) { document.getElementById('oldPasswordError').textContent = 'Vui lòng nhập mật khẩu hiện tại'; hasError = true; }
        if (!nw) { document.getElementById('newPasswordError').textContent = 'Vui lòng nhập mật khẩu mới'; hasError = true; }
        else if (nw.length < 6) { document.getElementById('newPasswordError').textContent = 'Mật khẩu mới phải có ít nhất 6 ký tự'; hasError = true; }
        if (!cf) { document.getElementById('confirmPasswordError').textContent = 'Vui lòng nhập lại mật khẩu mới'; hasError = true; }
        else if (nw !== cf) { document.getElementById('confirmPasswordError').textContent = 'Mật khẩu xác nhận không trùng khớp'; hasError = true; }

        if (hasError) { 
            e.preventDefault(); 
            setTimeout(() => {
                ['oldPasswordError','newPasswordError','confirmPasswordError'].forEach(id => {
                    document.getElementById(id).textContent = '';
                });
            }, 2000);
            return; 
        }
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    });
});
</script>
