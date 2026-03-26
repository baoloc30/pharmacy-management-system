<style>
.cat-label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;}
.cat-input{width:100%;padding:10px 13px;border:1.5px solid #cbd5e1;border-radius:9px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box;font-family:inherit;transition:all .2s;}
.cat-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.field-err{font-size:11px;color:#ef4444;font-weight:600;margin-top:4px;display:block;min-height:16px;}
</style>

<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:600px;margin:0 auto;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-plus" style="color:#fff;font-size:17px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Thêm danh mục thuốc</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Điền thông tin danh mục mới</div>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>category/index"
           style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:9px;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;text-decoration:none;">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <?php if (isset($error)): ?>
    <div id="serverErrorMsg" style="margin:14px 24px 0;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;font-weight:600; transition: opacity 0.5s ease;">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
    </div>
    <script>
        setTimeout(function() {
            const errMsg = document.getElementById('serverErrorMsg');
            if (errMsg) {
                errMsg.style.opacity = '0';
                setTimeout(() => errMsg.style.display = 'none', 500);
            }
        }, 3000);
    </script>
    <?php endif; ?>

    <form method="POST" action="" id="addCategoryForm" style="padding:22px 24px;">
        <div style="margin-bottom:14px;">
            <label class="cat-label">Tên danh mục <span style="color:#ef4444;">*</span></label>
            <input type="text" name="tenDanhMuc" id="tenDanhMuc" class="cat-input"
                placeholder="Nhập tên danh mục"
                value="<?php echo htmlspecialchars($_POST['tenDanhMuc'] ?? ''); ?>" required>
            <span class="field-err" id="tenError"></span>
        </div>
        <div style="margin-bottom:14px;">
            <label class="cat-label">Mô tả</label>
            <textarea name="moTa" class="cat-input" rows="3" placeholder="Mô tả ngắn về danh mục..." style="resize:vertical;"><?php echo htmlspecialchars($_POST['moTa'] ?? ''); ?></textarea>
        </div>
        <div style="margin-bottom:20px;">
            <label class="cat-label">Trạng thái</label>
            <select name="trangThai" class="cat-input" style="cursor:pointer;">
                <option value="SuDung">Đang dùng</option>
                <option value="NgungSuDung">Ngừng dùng</option>
            </select>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
            <a href="<?php echo BASE_URL; ?>category/index"
               style="padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
                <i class="fas fa-times"></i> Hủy bỏ
            </a>
            <button type="button" onclick="confirmAdd()"
               style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(21,128,61,.3);">
                <i class="fas fa-save"></i> Lưu
            </button>
        </div>
    </form>
</div>
</div>

<!-- Overlay xác nhận -->
<div id="confirmOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;box-shadow:0 8px 40px rgba(0,0,0,.2);width:100%;max-width:400px;overflow:hidden;">
        <div style="padding:16px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:10px;">
            <i class="fas fa-question-circle" style="color:#fff;"></i>
            <span style="font-size:15px;font-weight:700;color:#fff;">Xác nhận</span>
        </div>
        <div style="padding:20px 24px;">
            <p style="color:#374151;font-size:14px;margin:0;">Bạn có chắc chắn muốn thêm danh mục này không?</p>
        </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;">
            <a href="<?php echo BASE_URL; ?>category/index"
               style="padding:9px 20px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;">
                Từ chối
            </a>
            <button onclick="document.getElementById('addCategoryForm').submit()"
                    style="padding:9px 20px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                Đồng ý
            </button>
        </div>
    </div>
</div>

<script>
function confirmAdd() {
    const tenInput = document.getElementById('tenDanhMuc');
    const tenError = document.getElementById('tenError');
    const ten = tenInput.value.trim();
    
    tenError.style.transition = 'none';
    tenError.style.opacity = '1';
    tenError.textContent = '';

    if (!ten) {
        tenError.textContent = 'Vui lòng nhập tên danh mục'; 
        tenInput.style.borderColor = '#ef4444';
        
        tenError.style.transition = 'opacity 0.5s ease';
        setTimeout(function() {
            tenError.style.opacity = '0';
            tenInput.style.borderColor = '#cbd5e1';
            
            setTimeout(() => {
                tenError.textContent = '';
                tenError.style.opacity = '1';
            }, 500);
        }, 3000);
        
        return;
    }
    document.getElementById('confirmOverlay').style.display = 'flex';
}

document.getElementById('confirmOverlay').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
