<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-warehouse"></i> Phiếu nhập kho</h5>
                </div>
                <div class="card-body">
                    <table class="table" id="import-table">
                        <thead>
                            <tr>
                                <th>Tên thuốc</th>
                                <th>ĐVT</th>
                                <th>SL</th>
                                <th>Đơn giá</th>
                                <th>HSD</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="import-body">
                            <!-- Import items will be added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Tổng tiền:</td>
                                <td class="text-end fw-bold" id="total-amount">0đ</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h6><i class="fas fa-search"></i> Chọn thuốc</h6>
                </div>
                <div class="card-body">
                    <select id="medicine-select" class="form-control mb-2">
                        <option value="">-- Chọn thuốc --</option>
                        <?php foreach($medicines as $medicine): ?>
                        <option value="<?php echo $medicine['maThuoc']; ?>" 
                                data-name="<?php echo $medicine['tenThuoc']; ?>"
                                data-unit="<?php echo $medicine['donViTinh']; ?>">
                            <?php echo $medicine['tenThuoc']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" id="quantity" class="form-control mb-2" placeholder="Số lượng">
                    <input type="number" id="price" class="form-control mb-2" placeholder="Đơn giá">
                    <input type="date" id="expiry" class="form-control mb-2" placeholder="Hạn sử dụng">
                    <button class="btn btn-primary w-100" onclick="addItem()">
                        <i class="fas fa-plus"></i> Thêm vào phiếu
                    </button>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h6><i class="fas fa-truck"></i> Thông tin nhập</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label>Nhà cung cấp:</label>
                        <select id="supplier" class="form-control">
                            <option value="">-- Chọn NCC --</option>
                            <?php foreach($suppliers as $supplier): ?>
                            <option value="<?php echo $supplier['maNhaCC']; ?>">
                                <?php echo $supplier['tenNhaCC']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Ghi chú:</label>
                        <textarea id="note" class="form-control" rows="2"></textarea>
                    </div>
                    <button class="btn btn-success w-100 mt-2" onclick="saveImport()">
                        <i class="fas fa-save"></i> Lưu phiếu nhập
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let importItems = [];

function addItem() {
    let select = $('#medicine-select');
    let medicineId = select.val();
    let medicineName = select.find('option:selected').data('name');
    let unit = select.find('option:selected').data('unit');
    let quantity = $('#quantity').val();
    let price = $('#price').val();
    let expiry = $('#expiry').val();
    
    if(!medicineId || !quantity || !price || !expiry) {
        alert('Vui lòng nhập đầy đủ thông tin');
        return;
    }
    
    importItems.push({
        maThuoc: medicineId,
        tenThuoc: medicineName,
        donViTinh: unit,
        soLuong: quantity,
        donGia: price,
        hanSuDung: expiry,
        thanhTien: quantity * price
    });
    
    updateImportTable();
    clearInputs();
}

function updateImportTable() {
    let html = '';
    let total = 0;
    
    importItems.forEach((item, index) => {
        total += item.thanhTien;
        html += `<tr>
            <td>${item.tenThuoc}</td>
            <td>${item.donViTinh}</td>
            <td>${item.soLuong}</td>
            <td class="text-end">${formatCurrency(item.donGia)}</td>
            <td>${item.hanSuDung}</td>
            <td class="text-end">${formatCurrency(item.thanhTien)}</td>
            <td><button class="btn btn-sm btn-danger" onclick="removeItem(${index})"><i class="fas fa-trash"></i></button></td>
        </tr>`;
    });
    
    $('#import-body').html(html);
    $('#total-amount').text(formatCurrency(total));
}

function removeItem(index) {
    importItems.splice(index, 1);
    updateImportTable();
}

function clearInputs() {
    $('#medicine-select').val('');
    $('#quantity').val('');
    $('#price').val('');
    $('#expiry').val('');
}

function saveImport() {
    if(importItems.length == 0) {
        alert('Vui lòng thêm thuốc vào phiếu nhập');
        return;
    }
    
    let supplierId = $('#supplier').val();
    if(!supplierId) {
        alert('Vui lòng chọn nhà cung cấp');
        return;
    }

    let total = importItems.reduce((sum, item) => sum + parseFloat(item.thanhTien), 0);
    
    $.post('<?php echo BASE_URL; ?>warehouse/import', {
        maNhaCC: supplierId,
        tongTien: total,
        ghiChu: $('#note').val(),
        items: JSON.stringify(importItems)
    }, function(response) {
        if(response.success) {
            alert('Nhập kho thành công');
            location.reload();
        } else {
            alert('Có lỗi xảy ra: ' + (response.message || ''));
        }
    }, 'json');
}

function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}
</script>