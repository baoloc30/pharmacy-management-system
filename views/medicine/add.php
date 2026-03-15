<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-plus"></i> Thêm thuốc mới</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="maDanhMuc" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-control" id="maDanhMuc" name="maDanhMuc" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category['maDanhMuc']; ?>">
                                    <?php echo $category['tenDanhMuc']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="tenThuoc" class="form-label">Tên thuốc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tenThuoc" name="tenThuoc" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="donViTinh" class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="donViTinh" name="donViTinh" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="giaBan" class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="giaBan" name="giaBan" required min="1">
                        <span class="text-danger small" id="giaBanError"></span>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="giaNhap" class="form-label">Giá nhập <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="giaNhap" name="giaNhap" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="soLuongTon" class="form-label">Số lượng tồn</label>
                        <input type="number" class="form-control" id="soLuongTon" name="soLuongTon" value="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="hanSuDung" class="form-label">Hạn sử dụng <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="hanSuDung" name="hanSuDung" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="xuatXu" class="form-label">Xuất xứ</label>
                        <input type="text" class="form-control" id="xuatXu" name="xuatXu">
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="thanhPhan" class="form-label">Thành phần</label>
                        <textarea class="form-control" id="thanhPhan" name="thanhPhan" rows="2"></textarea>
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="congDung" class="form-label">Công dụng</label>
                        <textarea class="form-control" id="congDung" name="congDung" rows="2"></textarea>
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="cachDung" class="form-label">Cách dùng</label>
                        <textarea class="form-control" id="cachDung" name="cachDung" rows="2"></textarea>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="<?php echo BASE_URL; ?>medicine/index" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const giaBan = parseFloat(document.getElementById('giaBan').value);
    const giaBanErr = document.getElementById('giaBanError');
    if (giaBanErr) giaBanErr.textContent = '';
    if (!giaBan || giaBan <= 0) {
        if (giaBanErr) giaBanErr.textContent = 'Giá bán thuốc phải là số dương';
        e.preventDefault();
    }
});
</script>