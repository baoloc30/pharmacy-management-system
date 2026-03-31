<style>
.med-label{font-size:12px;font-weight:700;color:#475569;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px;}
.med-input{width:100%;padding:10px 13px;border:1.5px solid #cbd5e1;border-radius:9px;font-size:13px;color:#1e293b;background:#fff;outline:none;box-sizing:border-box;font-family:inherit;transition:all .2s;}
.med-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.med-input.error{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);}
.field-err{font-size:11px;color:#ef4444;font-weight:600;margin-top:4px;display:block;min-height:16px;}
</style>

<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:860px;margin:0 auto;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-plus" style="color:#fff;font-size:17px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Thêm thuốc mới</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Điền đầy đủ thông tin bên dưới</div>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>medicine/index"
           style="width:32px;height:32px;background:rgba(255,255,255,.2);border-radius:9px;color:#fff;font-size:15px;display:flex;align-items:center;justify-content:center;text-decoration:none;" title="Quay lại">
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

    <form method="POST" action="" id="addMedForm" enctype="multipart/form-data" style="padding:22px 24px;">
        <div style="margin-bottom:14px; display:flex; gap:20px; align-items:flex-start; background:#fff; padding:18px; border:1px solid #e2e8f0; border-radius:12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            
            <div style="position:relative; width:160px; height:160px; border:2px dashed #CBD5E1; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#94A3B8; overflow:hidden; background:#f8fafc; cursor:pointer; transition:all .2s ease;"
                 id="imageUploadWrapper"
                 onclick="document.getElementById('hinhAnhInput').click()"
                 onmouseover="this.style.borderColor='#2563eb'; this.style.background='#eff6ff'; document.getElementById('hoverOverlay').style.opacity='1'; document.getElementById('defaultIcon').style.scale='1.1';"
                 onmouseout="this.style.borderColor='#CBD5E1'; this.style.background='#f8fafc'; document.getElementById('hoverOverlay').style.opacity='0'; document.getElementById('defaultIcon').style.scale='1';">
                
                <div id="imagePreview" style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                    <i class="fas fa-image" style="font-size:36px; transition: scale .2s;" id="defaultIcon"></i>
                </div>

                <div id="hoverOverlay" style="position:absolute; inset:0; background:rgba(37,99,235, 0.85); color:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; opacity:0; transition:opacity .2s; font-size:12px; font-weight:700;">
                    <i class="fas fa-cloud-upload-alt" style="font-size:24px; margin-bottom:8px;"></i>
                    <span id="overlayText">Chọn ảnh</span>
                </div>
            </div>

            <div style="flex:1; padding-top:10px;">
                <label class="med-label" style="display:block; margin-bottom:10px; font-size:14px; font-weight:700;">Hình ảnh thuốc</label>
                
                <input type="file" name="hinhAnh" id="hinhAnhInput" accept="image/jpeg, image/png" onchange="previewImage(this)" style="display:none;">
                
                <div style="font-size:11px; color:#64748B; line-height:1.5;">
                    • Định dạng: .jpg, .png, .jpeg.<br>
                    • Kích thước: Tối đa 2MB.
                </div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="med-label">Danh mục <span style="color:#ef4444;">*</span></label>
                <select name="maDanhMuc" id="maDanhMuc" class="med-input">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach($categories as $category): ?>
                    <option value="<?php echo $category['maDanhMuc']; ?>" <?php echo (isset($medicine['maDanhMuc']) && $medicine['maDanhMuc'] == $category['maDanhMuc']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['tenDanhMuc']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <span class="field-err" id="maDanhMucError"></span>
            </div>
            <div>
                <label class="med-label">Tên thuốc <span style="color:#ef4444;">*</span></label>
                <input type="text" name="tenThuoc" id="tenThuoc" class="med-input" placeholder="Nhập tên thuốc" value="<?php echo htmlspecialchars($medicine['tenThuoc'] ?? ''); ?>">
                <span class="field-err" id="tenThuocError"></span>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="med-label">Đơn vị tính <span style="color:#ef4444;">*</span></label>
                <input type="text" name="donViTinh" id="donViTinh" class="med-input" placeholder="VD: Hộp, Vỉ, Viên" value="<?php echo htmlspecialchars($medicine['donViTinh'] ?? ''); ?>">
                <span class="field-err" id="donViTinhError"></span>
            </div>
            <div>
                <label class="med-label">Giá nhập <span style="color:#ef4444;">*</span></label>
                <input type="number" name="giaNhap" id="giaNhap" class="med-input" placeholder="Giá nhập (VNĐ)" value="<?php echo htmlspecialchars($medicine['giaNhap'] ?? ''); ?>">
                <span class="field-err" id="giaNhapError"></span>
            </div>
            <div>
                <label class="med-label">Giá bán <span style="color:#ef4444;">*</span></label>
                <input type="number" name="giaBan" id="giaBan" class="med-input" placeholder="Giá bán (VNĐ)" value="<?php echo htmlspecialchars($medicine['giaBan'] ?? ''); ?>">
                <span class="field-err" id="giaBanError"></span>
            </div>
        </div>
            
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;margin-bottom:24px;">
            <div>
                <label class="med-label">Đơn vị lẻ</label>
                <input type="text" name="donViLe" class="med-input" 
                        placeholder="VD: Viên, Gói (Để trống nếu ko có)" 
                        value="<?php echo htmlspecialchars($medicine['donViLe'] ?? ''); ?>">
            </div>
            <div>
                <label class="med-label">Quy đổi (1 Chẵn = ? Lẻ)</label>
                <input type="number" name="soLuongQuyDoi" class="med-input" 
                        placeholder="VD: 10" min="1" 
                        value="<?php echo htmlspecialchars($medicine['soLuongQuyDoi'] ?? '1'); ?>">
                <span style="font-size:11.5px; color:#64748b; font-weight:500; margin-top:5px; display:block;">Mặc định là 1 nếu không bán lẻ</span>
            </div>
            <div>
                <label class="med-label">Giá bán lẻ</label>
                <input type="number" name="giaBanLe" class="med-input" 
                        placeholder="VD: 1500" min="0" 
                        value="<?php echo htmlspecialchars($medicine['giaBanLe'] ?? ''); ?>">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:14px;">
            <div>
                <label class="med-label">Số lượng tồn</label>
                <input type="number" name="soLuongTon" class="med-input" value="<?php echo htmlspecialchars($medicine['soLuongTon'] ?? '0'); ?>" min="0">
            </div>
            <div>
                <label class="med-label">Hạn sử dụng <span style="color:#ef4444;">*</span></label>
                <input type="date" name="hanSuDung" id="hanSuDung" class="med-input" value="<?php echo htmlspecialchars($medicine['hanSuDung'] ?? ''); ?>">
                <span class="field-err" id="hanSuDungError"></span>
            </div>
            <div>
                <label class="med-label">Xuất xứ</label>
                <input type="text" name="xuatXu" class="med-input" placeholder="VD: Việt Nam, Hàn Quốc" value="<?php echo htmlspecialchars($medicine['xuatXu'] ?? ''); ?>">
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label class="med-label">Thành phần</label>
            <textarea name="thanhPhan" class="med-input" rows="2" placeholder="Liệt kê thành phần hoạt chất..." style="resize:vertical;"><?php echo htmlspecialchars($medicine['thanhPhan'] ?? ''); ?></textarea>
        </div>
        <div style="margin-bottom:14px;">
            <label class="med-label">Công dụng</label>
            <textarea name="congDung" class="med-input" rows="2" placeholder="Mô tả công dụng của thuốc..." style="resize:vertical;"><?php echo htmlspecialchars($medicine['congDung'] ?? ''); ?></textarea>
        </div>
        <div style="margin-bottom:20px;">
            <label class="med-label">Cách dùng</label>
            <textarea name="cachDung" class="med-input" rows="2" placeholder="Hướng dẫn cách dùng..." style="resize:vertical;"><?php echo htmlspecialchars($medicine['cachDung'] ?? ''); ?></textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid #e2e8f0;">
            <a href="<?php echo BASE_URL; ?>medicine/index"
               style="padding:10px 22px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#64748b;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
                <i class="fas fa-times"></i> Hủy bỏ
            </a>
            <button type="submit" id="saveBtn"
               style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(21,128,61,.3);">
                <i class="fas fa-save"></i> Lưu
            </button>
        </div>
    </form>
</div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const overlayText = document.getElementById('overlayText');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            overlayText.textContent = "Đổi ảnh";
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '<i class="fas fa-image" style="font-size:36px;" id="defaultIcon"></i>';
        overlayText.textContent = "Chọn ảnh";
    }
}

document.getElementById('addMedForm').addEventListener('submit', function(e) {
    let valid = true;
    
    document.querySelectorAll('.field-err').forEach(el => el.textContent = '');
    document.querySelectorAll('.med-input').forEach(el => el.classList.remove('error'));

    const reqFields = [
        {id: 'maDanhMuc', err: 'maDanhMucError'},
        {id: 'tenThuoc', err: 'tenThuocError'},
        {id: 'donViTinh', err: 'donViTinhError'},
        {id: 'giaNhap', err: 'giaNhapError'},
        {id: 'giaBan', err: 'giaBanError'},
        {id: 'hanSuDung', err: 'hanSuDungError'}
    ];

    reqFields.forEach(field => {
        const el = document.getElementById(field.id);
        if (!el.value.trim()) {
            document.getElementById(field.err).textContent = 'Vui lòng nhập đầy đủ thông tin';
            el.classList.add('error');
            valid = false;
        }
    });

    const giaBanEl = document.getElementById('giaBan');
    if (giaBanEl.value.trim() && parseFloat(giaBanEl.value) <= 0) {
        document.getElementById('giaBanError').textContent = 'Giá bán thuốc phải là số dương';
        giaBanEl.classList.add('error');
        valid = false;
    }

    const giaNhapEl = document.getElementById('giaNhap');
    if (giaNhapEl.value.trim() && parseFloat(giaNhapEl.value) <= 0) {
        document.getElementById('giaNhapError').textContent = 'Giá nhập thuốc phải là số dương';
        giaNhapEl.classList.add('error');
        valid = false;
    }

    const hanSuDungEl = document.getElementById('hanSuDung');
    if (hanSuDungEl.value.trim()) {
        const hsd = new Date(hanSuDungEl.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (hsd <= today) {
            document.getElementById('hanSuDungError').textContent = 'Hạn sử dụng phải lớn hơn ngày hiện tại';
            hanSuDungEl.classList.add('error');
            valid = false;
        }
    }

    if (!valid) {
        e.preventDefault();
    } else {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
    }
});
</script>
