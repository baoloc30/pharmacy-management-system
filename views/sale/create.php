<div class="container-fluid mt-3">
    <div class="row">
        <!-- Giỏ hàng -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-shopping-cart"></i> Giỏ hàng</h5>
                </div>
                <div class="card-body">
                    <table class="table" id="cart-table">
                        <thead>
                            <tr>
                                <th>Tên thuốc</th>
                                <th>ĐVT</th>
                                <th>SL</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-body">
                            <!-- Cart items will be added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                                <td class="text-end fw-bold" id="total-amount">0đ</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Tìm kiếm và thanh toán -->
        <div class="col-md-4">
            <!-- Tìm kiếm thuốc -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6><i class="fas fa-search"></i> Tìm thuốc</h6>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <select id="search-category" class="form-select" style="max-width: 130px;">
                            <option value="">Tất cả</option>
                            <?php if(!empty($categories)): foreach($categories as $cat): ?>
                                <option value="<?php echo $cat['maDanhMuc']; ?>"><?php echo htmlspecialchars($cat['tenDanhMuc']); ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                        <input type="text" id="search-medicine" class="form-control" placeholder="Nhập tên, mã, thành phần, công dụng...">
                        <button class="btn btn-primary" type="button" onclick="searchMedicine()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="search-result" class="mt-2" style="max-height: 200px; overflow-y: auto;">
                        <!-- Search results will be displayed here -->
                    </div>
                </div>
            </div>
            
            <!-- Thông tin khách hàng -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6><i class="fas fa-user"></i> Khách hàng</h6>
                </div>
                <div class="card-body">
                    <div class="input-group mb-2">
                        <input type="text" id="customer-phone" class="form-control" placeholder="Nhập SĐT khách hàng">
                        <button class="btn btn-outline-secondary" type="button" onclick="findCustomer()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="customer-info"></div>
                    <button type="button" class="btn btn-success btn-sm w-100 mt-2" onclick="showAddCustomer()">
                        <i class="fas fa-user-plus"></i> Thêm khách hàng mới
                    </button>
                </div>
            </div>
            
            <!-- Thanh toán -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h6><i class="fas fa-credit-card"></i> Thanh toán</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label>Tổng tiền:</label>
                        <input type="text" id="total" class="form-control" readonly>
                    </div>
                    <div class="mb-2">
                        <label>Giảm giá:</label>
                        <input type="number" id="discount" class="form-control" value="0" onchange="updateFinalTotal()">
                    </div>
                    <div class="mb-2">
                        <label>Thanh toán:</label>
                        <input type="text" id="final-total" class="form-control" readonly>
                    </div>
                    <div class="mb-2">
                        <label>Phương thức:</label>
                        <select id="payment-method" class="form-control">
                            <option value="TienMat">Tiền mặt</option>
                            <option value="ChuyenKhoan">Chuyển khoản</option>
                            <option value="The">Thẻ</option>
                        </select>
                    </div>
                    <button class="btn btn-success w-100 mt-2" onclick="checkout()">
                        <i class="fas fa-check"></i> Thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm khách hàng -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm khách hàng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCustomerForm">
                    <div class="mb-3">
                        <label for="hoTen" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="hoTen" name="hoTen" required>
                    </div>
                    <div class="mb-3">
                        <label for="soDienThoai" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="soDienThoai" name="soDienThoai" required>
                    </div>
                    <div class="mb-3">
                        <label for="diaChi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="diaChi" name="diaChi">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="saveCustomer()">Lưu</button>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];
let selectedCustomer = null;

function searchMedicine() {
    let keyword = $('#search-medicine').val().trim();
    let categoryId = $('#search-category').val();
    
    if(keyword.length === 0 && categoryId === '') {
        $('#search-result').html('');
        return;
    }
    
    let url = '<?php echo BASE_URL; ?>sale/searchMedicine?keyword=' + encodeURIComponent(keyword) + '&maDanhMuc=' + encodeURIComponent(categoryId);
    
    $('#search-result').html('<div class="text-center p-3 text-muted"><i class="fas fa-spinner fa-spin"></i> Đang tìm kiếm...</div>');
    
    $.get(url, function(data) {
        if (data.success === false) {
            $('#search-result').html('<div class="alert alert-danger p-2 m-1"><i class="fas fa-exclamation-triangle"></i> ' + data.message + '</div>');
            return;
        }

        if (!data.medicines || data.medicines.length === 0) {
            $('#search-result').html('<div class="text-muted p-2 alert alert-warning m-1">Không tìm thấy thuốc phù hợp</div>');
            return;
        }
        
        let html = '';
        data.medicines.forEach(item => {
            let isOutOfStock = item.soLuongTon <= 0;
            let style = isOutOfStock ? 'opacity: 0.5; cursor: not-allowed;' : 'cursor:pointer;';
            let clickAction = isOutOfStock ? '' : `onclick="addToCart(${item.maThuoc}, '${item.tenThuoc.replace(/'/g,"\\'")}', '${item.donViTinh}', ${item.giaBan}, ${item.soLuongTon})"`;
            let stockColor = isOutOfStock ? 'text-danger fw-bold' : 'text-success';

            html += `<div class="search-item p-2 border-bottom" style="${style}" ${clickAction}>
                <strong>${item.tenThuoc}</strong> - <span class="text-primary">${formatCurrency(item.giaBan)}</span><br>
                <small class="text-muted">
                    <span class="${stockColor}">Tồn kho: ${item.soLuongTon}</span> | HSD: ${item.hanSuDung}
                </small>
            </div>`;
        });
        $('#search-result').html(html);
        
    }, 'json').fail(function() {
        $('#search-result').html('<div class="alert alert-danger p-2 m-1"><i class="fas fa-wifi"></i> Không thể kết nối với máy chủ</div>');
    });
}

document.getElementById('search-medicine').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchMedicine();
    }
});

document.getElementById('search-category').addEventListener('change', function() {
    searchMedicine();
});

function addToCart(id, name, unit, price, stock) {
    let existing = cart.find(item => item.maThuoc == id);
    if(existing) {
        if (existing.soLuong >= stock) {
            alert('Số lượng tồn kho không đủ. Vui lòng nhập lại');
            return;
        }
        existing.soLuong++;
        existing.stock = stock;
    } else {
        cart.push({
            maThuoc: id,
            tenThuoc: name,
            donViTinh: unit,
            donGia: price,
            soLuong: 1,
            stock: stock
        });
    }
    updateCart();
    $('#search-result').html('');
    $('#search-medicine').val('');
}

function updateCart() {
    let html = '';
    let total = 0;
    
    cart.forEach((item, index) => {
        let thanhTien = item.soLuong * item.donGia;
        total += thanhTien;
        html += `<tr>
            <td>${item.tenThuoc}</td>
            <td>${item.donViTinh}</td>
            <td><input type="number" value="${item.soLuong}" min="1" max="${item.stock || 9999}" style="width:65px" class="form-control form-control-sm d-inline-block"
                onchange="updateQuantity(${index}, this.value, ${item.stock || 9999})"></td>
            <td class="text-end">${formatCurrency(item.donGia)}</td>
            <td class="text-end">${formatCurrency(thanhTien)}</td>
            <td><button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})"><i class="fas fa-trash"></i></button></td>
        </tr>`;
    });
    
    $('#cart-body').html(html);
    let totalVal = total;
    $('#total').val(totalVal);
    $('#total-amount').text(formatCurrency(total));
    updateFinalTotal();
}

function updateQuantity(index, quantity, stock) {
    const qty = parseInt(quantity);
    if (qty > stock) {
        alert('Số lượng tồn kho không đủ. Vui lòng nhập lại');
        cart[index].soLuong = stock;
    } else {
        cart[index].soLuong = qty;
    }
    updateCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

function updateFinalTotal() {
    let total = parseFloat($('#total').val()) || 0;
    let discount = parseFloat($('#discount').val()) || 0;
    let finalTotal = total - discount;
    $('#final-total').val(formatCurrency(finalTotal));
}

function findCustomer() {
    let phone = $('#customer-phone').val();
    if(!phone) return;
    
    $.get('<?php echo BASE_URL; ?>customer/search?phone=' + phone, function(data) {
        if(data.success) {
            selectedCustomer = data.customer;
            $('#customer-info').html(`
                <div class="alert alert-success">
                    <strong>${data.customer.hoTen}</strong><br>
                    ĐT: ${data.customer.soDienThoai}
                </div>
            `);
        } else {
            $('#customer-info').html('<div class="alert alert-warning">Không tìm thấy khách hàng</div>');
            selectedCustomer = null;
        }
    }, 'json');
}

function showAddCustomer() {
    $('#addCustomerModal').modal('show');
}

function saveCustomer() {
    let formData = $('#addCustomerForm').serialize();
    
    $.ajax({
        url: '<?php echo BASE_URL; ?>customer/add',
        type: 'POST',
        data: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        dataType: 'json',
        success: function(data) {
            if(data.success) {
                $('#addCustomerModal').modal('hide');
                selectedCustomer = data.customer;
                $('#customer-phone').val(data.customer.soDienThoai);
                $('#customer-info').html(`
                    <div class="alert alert-success">
                        <strong>${data.customer.hoTen}</strong><br>
                        ĐT: ${data.customer.soDienThoai}
                    </div>
                `);
                alert('Thêm khách hàng thành công');
            } else {
                alert('Lỗi: ' + (data.message || 'Có lỗi xảy ra'));
            }
        }
    });
}

function checkout() {
    if(cart.length == 0) {
        alert('Vui lòng chọn thuốc');
        return;
    }
    
    let total = parseFloat($('#total').val()) || 0;
    let discount = parseFloat($('#discount').val()) || 0;

    let postData = {
        maKhachHang: selectedCustomer ? selectedCustomer.maKhachHang : '',
        tongTien: total,
        tienGiam: discount,
        phuongThucThanhToan: $('#payment-method').val(),
        cart: JSON.stringify(cart)
    };
    
    $.post('<?php echo BASE_URL; ?>sale/create', postData, function(response) {
        if(response.success) {
            alert('Thanh toán thành công');
            window.open('<?php echo BASE_URL; ?>sale/print/' + response.invoice_id, '_blank');
            cart = [];
            selectedCustomer = null;
            updateCart();
            $('#customer-info').html('');
            $('#customer-phone').val('');
            $('#discount').val(0);
        } else {
            alert('Có lỗi xảy ra: ' + (response.message || ''));
        }
    }, 'json');
}

function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
}
</script>