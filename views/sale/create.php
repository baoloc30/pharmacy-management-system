<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-cash-register" style="color:#fff;font-size:18px;"></i>
      </div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Tạo Hóa Đơn Bán Hàng</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;"><?php echo date('d/m/Y H:i'); ?> &nbsp;·&nbsp; <?php echo htmlspecialchars(Session::get('nhan_vien_name')); ?></div>
      </div>
    </div>
    <button onclick="openSaleModal()" style="padding:10px 22px;border-radius:10px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(21,128,61,.35);">
      <i class="fas fa-plus"></i> Tạo hóa đơn mới
    </button>
  </div>
</div>
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);padding:32px;text-align:center;">
  <div style="width:64px;height:64px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
    <i class="fas fa-cash-register" style="font-size:28px;color:#2563eb;"></i>
  </div>
  <div style="font-size:16px;font-weight:700;color:#1e40af;margin-bottom:6px;">Sẵn sàng bán hàng</div>
  <div style="font-size:13px;color:#64748b;margin-bottom:18px;">Nhấn nút bên trên để bắt đầu tạo hóa đơn</div>
</div>
</div>

<!-- ===== MODAL 1: CHỌN THUỐC + GIỎ HÀNG ===== -->
<div id="saleModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(4px);z-index:9999;align-items:flex-start;justify-content:center;padding:70px 20px 20px;overflow-y:auto;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:560px;margin:auto;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.3);">
    <!-- Header -->
    <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-shopping-cart" style="color:#fff;font-size:15px;"></i>
        <span style="font-size:15px;font-weight:700;color:#fff;">Chọn thuốc</span>
      </div>
      <button onclick="closeSaleModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:15px;">✕</button>
    </div>
    <!-- Tìm thuốc -->
    <div style="padding:14px 16px;background:linear-gradient(135deg,#0891b2,#06b6d4);">
      <div style="display:flex;gap:8px;">
        <input type="text" id="searchInput" placeholder="Nhập tên thuốc..."
          style="flex:1;padding:9px 13px;border:none;border-radius:8px;font-size:13px;outline:none;"
          oninput="searchMedicine()" onkeydown="if(event.key==='Enter'){event.preventDefault();searchMedicine();}">
        <button onclick="searchMedicine()" style="padding:9px 16px;border-radius:8px;border:none;background:rgba(255,255,255,.25);color:#fff;font-size:13px;cursor:pointer;font-weight:700;"><i class="fas fa-search"></i></button>
      </div>
    </div>
    <div id="searchResults" style="max-height:200px;overflow-y:auto;border-bottom:2px solid #e2e8f0;">
      <div style="padding:18px;text-align:center;color:#94a3b8;font-size:13px;">Nhập tên thuốc để tìm kiếm</div>
    </div>
    <!-- Giỏ hàng -->
    <div style="padding:10px 16px;background:linear-gradient(135deg,#059669,#10b981);display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:8px;">
        <i class="fas fa-shopping-cart" style="color:#fff;font-size:13px;"></i>
        <span style="font-size:13px;font-weight:700;color:#fff;">Giỏ hàng</span>
      </div>
      <span id="cartCount" style="background:rgba(255,255,255,.25);color:#fff;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;">0 sản phẩm</span>
    </div>
    <div style="overflow-x:auto;">
      <table style="width:100%;border-collapse:collapse;font-size:13px;">
        <thead>
          <tr style="background:linear-gradient(135deg,#064e3b,#065f46);">
            <th style="padding:8px 12px;color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;text-align:left;white-space:nowrap;">Tên thuốc</th>
            <th style="padding:8px 12px;color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;white-space:nowrap;">ĐVT</th>
            <th style="padding:8px 12px;color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;text-align:center;white-space:nowrap;">SL</th>
            <th style="padding:8px 12px;color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;text-align:right;white-space:nowrap;">Đơn giá</th>
            <th style="padding:8px 12px;color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;text-align:right;white-space:nowrap;">Thành tiền</th>
            <th style="padding:8px 6px;"></th>
          </tr>
        </thead>
        <tbody id="cartBody">
          <tr><td colspan="6" style="padding:20px;text-align:center;color:#94a3b8;font-size:13px;">Chưa có sản phẩm</td></tr>
        </tbody>
      </table>
    </div>
    <div style="padding:10px 16px;background:#f0fdf4;border-top:1px solid #d1fae5;display:flex;justify-content:space-between;align-items:center;">
      <span style="font-size:13px;font-weight:600;color:#374151;">Tổng tiền:</span>
      <span id="cartTotal" style="font-size:20px;font-weight:900;color:#15803d;">0đ</span>
    </div>
    <!-- Footer -->
    <div style="padding:14px 16px;border-top:1px solid #e2e8f0;background:#f8fafc;">
      <button onclick="openPayModal()" id="goPayBtn"
        style="width:100%;padding:13px;border-radius:10px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:15px;font-weight:800;cursor:pointer;box-shadow:0 4px 14px rgba(30,64,175,.35);display:flex;align-items:center;justify-content:center;gap:8px;opacity:.5;"
        disabled>
        <i class="fas fa-arrow-right"></i> Tiếp tục thanh toán
      </button>
    </div>
  </div>
</div>

<!-- ===== MODAL 2: THANH TOÁN ===== -->
<div id="payModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(4px);z-index:9999;align-items:flex-start;justify-content:center;padding:70px 20px 20px;overflow-y:auto;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:480px;margin:auto;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.3);">
    <!-- Header -->
    <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-credit-card" style="color:#fff;font-size:15px;"></i>
        <span style="font-size:15px;font-weight:700;color:#fff;">Thanh toán</span>
      </div>
      <div style="display:flex;gap:8px;">
        <button onclick="backToCart()" style="background:rgba(255,255,255,.2);border:none;color:#fff;padding:6px 12px;border-radius:8px;cursor:pointer;font-size:12px;font-weight:700;display:flex;align-items:center;gap:5px;"><i class="fas fa-arrow-left"></i> Quay lại</button>
        <button onclick="closePayModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:15px;">✕</button>
      </div>
    </div>
    <!-- Tóm tắt giỏ hàng -->
    <div style="padding:12px 16px;background:#f0f7ff;border-bottom:1px solid #dbeafe;display:flex;justify-content:space-between;align-items:center;">
      <span style="font-size:13px;color:#374151;"><i class="fas fa-shopping-cart" style="color:#2563eb;margin-right:6px;"></i><span id="payCartSummary">0 sản phẩm</span></span>
      <span style="font-size:15px;font-weight:800;color:#15803d;" id="payCartTotal">0đ</span>
    </div>
    <div style="padding:18px 18px 6px;">
      <!-- Khách hàng -->
      <div style="margin-bottom:14px;">
        <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;"><i class="fas fa-user" style="color:#2563eb;margin-right:4px;"></i>Khách hàng (tùy chọn)</label>
        <div style="display:flex;gap:8px;">
          <input type="text" id="customerPhone" placeholder="Nhập số điện thoại..."
            style="flex:1;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;"
            onkeydown="if(event.key==='Enter') findCustomer()"
            onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
          <button onclick="findCustomer()" style="padding:8px 14px;border-radius:8px;border:none;background:#eff6ff;color:#1d4ed8;font-size:13px;font-weight:700;cursor:pointer;">Tìm</button>
          <button onclick="openAddCustomerModal()" style="padding:8px 12px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;">+ Thêm KH</button>
        </div>
        <div id="customerInfo" style="margin-top:6px;"></div>
      </div>
      <!-- Giảm giá + phương thức -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;"><i class="fas fa-tag" style="color:#ca8a04;margin-right:4px;"></i>Giảm giá (đ)</label>
          <input type="number" id="discountInput" value="0" min="0"
            style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;"
            oninput="updatePayCalc()" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
        </div>
        <div>
          <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;"><i class="fas fa-wallet" style="color:#0e7490;margin-right:4px;"></i>Phương thức</label>
          <select id="paymentMethod" onchange="updatePayCalc()"
            style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;cursor:pointer;box-sizing:border-box;">
            <option value="TienMat">💵 Tiền mặt</option>
            <option value="ChuyenKhoan">🏦 Chuyển khoản</option>
            <option value="The">💳 Thẻ</option>
          </select>
        </div>
      </div>
      <!-- Tổng thanh toán -->
      <div style="background:#eff6ff;border-radius:10px;padding:12px 14px;margin-bottom:14px;border:1.5px solid #bfdbfe;">
        <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
          <span style="font-size:13px;color:#374151;">Tổng tiền hàng:</span>
          <span id="payTotal" style="font-size:13px;font-weight:600;color:#374151;">0đ</span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
          <span style="font-size:13px;color:#374151;">Giảm giá:</span>
          <span id="payDiscount" style="font-size:13px;font-weight:600;color:#ca8a04;">-0đ</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding-top:8px;border-top:1.5px solid #bfdbfe;align-items:center;">
          <span style="font-size:14px;font-weight:800;color:#1e40af;">Cần thanh toán:</span>
          <span id="payFinal" style="font-size:22px;font-weight:900;color:#1d4ed8;">0đ</span>
        </div>
      </div>
      <!-- Tiền mặt -->
      <div id="cashSection">
        <label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:6px;"><i class="fas fa-money-bill-wave" style="color:#15803d;margin-right:4px;"></i>Tiền khách đưa</label>
        <input type="number" id="cashGiven" placeholder="Nhập số tiền khách đưa..."
          style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-weight:600;outline:none;box-sizing:border-box;"
          oninput="calcChange()" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
        <div id="quickCash" style="display:flex;gap:6px;flex-wrap:wrap;margin-top:8px;"></div>
        <div id="changeRow" style="display:none;margin-top:10px;padding:12px 14px;border-radius:9px;align-items:center;justify-content:space-between;">
          <span style="font-size:14px;font-weight:700;color:#374151;">Tiền thối lại:</span>
          <span id="changeAmount" style="font-size:22px;font-weight:900;">0đ</span>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <div style="padding:14px 18px;border-top:1px solid #e2e8f0;background:#f8fafc;">
      <button onclick="doCheckout()" id="confirmPayBtn"
        style="width:100%;padding:13px;border-radius:10px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:15px;font-weight:800;cursor:pointer;box-shadow:0 4px 14px rgba(21,128,61,.35);display:flex;align-items:center;justify-content:center;gap:8px;">
        <i class="fas fa-check-circle"></i> Xác nhận thanh toán
      </button>
    </div>
  </div>
</div>

<!-- MODAL CHỌN ĐƠN VỊ -->
<div id="unitModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.7);z-index:10100;align-items:center;justify-content:center;padding:20px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:360px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.3);">
    <div style="padding:14px 20px;background:linear-gradient(135deg,#0891b2,#06b6d4);display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:8px;"><i class="fas fa-capsules" style="color:#fff;font-size:14px;"></i><span style="font-size:14px;font-weight:700;color:#fff;">Chọn đơn vị bán</span></div>
      <button onclick="closeUnitModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;">✕</button>
    </div>
    <div style="padding:18px 20px;">
      <div id="unitMedicineName" style="font-size:14px;font-weight:700;color:#0e7490;margin-bottom:14px;"></div>
      <div id="unitOptions" style="display:flex;flex-direction:column;gap:10px;"></div>
    </div>
  </div>
</div>

<!-- MODAL THÊM KHÁCH HÀNG -->
<div id="addCustomerModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.75);z-index:10200;align-items:center;justify-content:center;padding:20px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:400px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.3);">
    <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#3b82f6);display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:8px;"><i class="fas fa-user-plus" style="color:#fff;font-size:14px;"></i><span style="font-size:14px;font-weight:700;color:#fff;">Thêm khách hàng mới</span></div>
      <button onclick="closeAddCustomerModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;">✕</button>
    </div>
    <div style="padding:18px 20px;">
      <div style="margin-bottom:11px;"><label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Họ tên <span style="color:#dc2626;">*</span></label><input type="text" id="newHoTen" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;"></div>
      <div style="margin-bottom:11px;"><label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Số điện thoại <span style="color:#dc2626;">*</span></label><input type="text" id="newSoDienThoai" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;"></div>
      <div style="margin-bottom:11px;"><label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Địa chỉ</label><input type="text" id="newDiaChi" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;"></div>
      <div style="margin-bottom:16px;"><label style="font-size:12px;font-weight:700;color:#374151;display:block;margin-bottom:5px;">Email</label><input type="email" id="newEmail" style="width:100%;padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;box-sizing:border-box;"></div>
      <div style="display:flex;gap:8px;">
        <button onclick="closeAddCustomerModal()" style="flex:1;padding:9px;border-radius:8px;border:1.5px solid #e2e8f0;background:#f1f5f9;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;">Hủy</button>
        <button onclick="saveNewCustomer()" style="flex:2;padding:9px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;"><i class="fas fa-save"></i> Lưu khách hàng</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL THÀNH CÔNG -->
<div id="successModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.7);z-index:10300;align-items:center;justify-content:center;padding:20px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:360px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.3);text-align:center;">
    <div style="padding:14px 20px;background:linear-gradient(135deg,#15803d,#16a34a);"><span style="font-size:14px;font-weight:700;color:#fff;">Thanh toán thành công</span></div>
    <div style="padding:28px 24px;">
      <div style="width:64px;height:64px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;"><i class="fas fa-check-circle" style="font-size:32px;color:#16a34a;"></i></div>
      <div id="successMsg" style="font-size:14px;color:#374151;margin-bottom:4px;"></div>
      <div id="successChange" style="font-size:13px;margin-bottom:20px;"></div>
      <div style="display:flex;gap:8px;justify-content:center;">
        <button onclick="printInvoice()" style="padding:9px 18px;border-radius:8px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:13px;font-weight:700;cursor:pointer;"><i class="fas fa-print"></i> In hóa đơn</button>
        <button onclick="resetSale()" style="padding:9px 18px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;"><i class="fas fa-plus"></i> Hóa đơn mới</button>
      </div>
    </div>
  </div>
</div>

<script>
var cart = [];
var selectedCustomer = null;
var lastInvoiceId = null;

/* ---- MODAL 1 ---- */
function openSaleModal(){
    document.getElementById('saleModal').style.display='flex';
    setTimeout(function(){ document.getElementById('searchInput').focus(); },100);
}
function closeSaleModal(){ document.getElementById('saleModal').style.display='none'; }
document.getElementById('saleModal').addEventListener('click',function(e){ if(e.target===this) closeSaleModal(); });

/* ---- MODAL 2 ---- */
function openPayModal(){
    if(cart.length===0) return;
    closeSaleModal();
    var total = cart.reduce(function(s,i){ return s+i.thanhTien; },0);
    document.getElementById('payCartSummary').textContent = cart.length+' sản phẩm';
    document.getElementById('payCartTotal').textContent = fmt(total);
    document.getElementById('discountInput').value='0';
    document.getElementById('cashGiven').value='';
    document.getElementById('customerInfo').innerHTML='';
    updatePayCalc();
    document.getElementById('payModal').style.display='flex';
}
function closePayModal(){ document.getElementById('payModal').style.display='none'; }
function backToCart(){ closePayModal(); openSaleModal(); }
document.getElementById('payModal').addEventListener('click',function(e){ if(e.target===this) closePayModal(); });

/* ---- TÌM THUỐC ---- */
var searchTimer;
function searchMedicine(){
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function(){
        var kw = document.getElementById('searchInput').value.trim();
        if(kw.length<1){ document.getElementById('searchResults').innerHTML='<div style="padding:18px;text-align:center;color:#94a3b8;font-size:13px;">Nhập tên thuốc để tìm kiếm</div>'; return; }
        document.getElementById('searchResults').innerHTML='<div style="padding:16px;text-align:center;color:#94a3b8;font-size:13px;"><i class="fas fa-spinner fa-spin"></i> Đang tìm...</div>';
        $.get('<?php echo BASE_URL; ?>sale/searchMedicine',{keyword:kw},function(res){
            if(!res.medicines||res.medicines.length===0){ document.getElementById('searchResults').innerHTML='<div style="padding:18px;text-align:center;color:#94a3b8;font-size:13px;">Không tìm thấy thuốc</div>'; return; }
            var html='';
            res.medicines.forEach(function(m){
                var low=parseInt(m.soLuongTon)<=0;
                html+='<div onclick="'+(low?'':'selectMedicine('+JSON.stringify(m).replace(/"/g,'&quot;')+')')+'" style="padding:10px 14px;border-bottom:1px solid #f1f5f9;cursor:'+(low?'not-allowed':'pointer')+';display:flex;justify-content:space-between;align-items:center;'+(low?'opacity:.5;':'')+'" '+(low?'':'onmouseover="this.style.background=\'#f0f7ff\'" onmouseout="this.style.background=\'\'"')+'>';
                html+='<div><div style="font-size:13px;font-weight:600;color:#1e293b;">'+m.tenThuoc+'</div><div style="font-size:11px;color:#64748b;margin-top:2px;">'+m.donViTinh+' &nbsp;·&nbsp; Tồn: <b style="color:'+(low?'#dc2626':'#15803d')+';">'+m.soLuongTon+'</b></div></div>';
                html+='<div style="text-align:right;"><div style="font-size:13px;font-weight:700;color:#1d4ed8;white-space:nowrap;">'+fmt(m.giaBan)+'</div>'+(low?'<div style="font-size:10px;color:#dc2626;font-weight:700;">Hết hàng</div>':'')+'</div></div>';
            });
            document.getElementById('searchResults').innerHTML=html;
        },'json');
    },300);
}

function selectMedicine(m){ openUnitModal(m); }

/* ---- MODAL ĐƠN VỊ ---- */
function openUnitModal(m){
    document.getElementById('unitMedicineName').textContent=m.tenThuoc;
    var opts='<button onclick="addToCart('+JSON.stringify(m).replace(/"/g,'&quot;')+',\''+m.donViTinh+'\','+m.giaBan+')" style="width:100%;padding:12px 16px;border-radius:10px;border:1.5px solid #bfdbfe;background:#eff6ff;cursor:pointer;display:flex;justify-content:space-between;align-items:center;font-size:13px;"><span style="font-weight:700;color:#1e40af;">'+m.donViTinh+'</span><span style="font-weight:800;color:#1d4ed8;">'+fmt(m.giaBan)+'</span></button>';
    document.getElementById('unitOptions').innerHTML=opts;
    document.getElementById('unitModal').style.display='flex';
}
function closeUnitModal(){ document.getElementById('unitModal').style.display='none'; }
document.getElementById('unitModal').addEventListener('click',function(e){ if(e.target===this) closeUnitModal(); });

function addToCart(m,unit,price){
    closeUnitModal();
    var existing=cart.find(function(i){ return i.maThuoc==m.maThuoc&&i.donViTinh==unit; });
    if(existing){
        if(existing.soLuong>=parseInt(m.soLuongTon)){ alert('Không đủ tồn kho'); return; }
        existing.soLuong++; existing.thanhTien=existing.soLuong*existing.donGia;
    } else {
        cart.push({maThuoc:m.maThuoc,tenThuoc:m.tenThuoc,donViTinh:unit,soLuong:1,donGia:parseFloat(price),thanhTien:parseFloat(price),soLuongTon:parseInt(m.soLuongTon)});
    }
    renderCart();
    document.getElementById('searchInput').value='';
    document.getElementById('searchResults').innerHTML='<div style="padding:18px;text-align:center;color:#94a3b8;font-size:13px;">Nhập tên thuốc để tìm kiếm</div>';
    document.getElementById('searchInput').focus();
}

function renderCart(){
    if(cart.length===0){
        document.getElementById('cartBody').innerHTML='<tr><td colspan="6" style="padding:20px;text-align:center;color:#94a3b8;font-size:13px;">Chưa có sản phẩm</td></tr>';
        document.getElementById('cartCount').textContent='0 sản phẩm';
        document.getElementById('cartTotal').textContent='0đ';
        document.getElementById('goPayBtn').disabled=true;
        document.getElementById('goPayBtn').style.opacity='.5';
        return;
    }
    var total=0,html='';
    cart.forEach(function(item,i){
        total+=item.thanhTien;
        var bg=i%2===0?'#fff':'#f0f7ff';
        html+='<tr style="background:'+bg+';">';
        html+='<td style="padding:8px 12px;font-size:13px;font-weight:600;color:#1e293b;">'+item.tenThuoc+'</td>';
        html+='<td style="padding:8px 12px;font-size:12px;color:#64748b;text-align:center;">'+item.donViTinh+'</td>';
        html+='<td style="padding:8px 12px;text-align:center;"><div style="display:flex;align-items:center;justify-content:center;gap:4px;"><button onclick="changeQty('+i+',-1)" style="width:22px;height:22px;border-radius:5px;border:1px solid #e2e8f0;background:#f1f5f9;cursor:pointer;font-size:12px;font-weight:700;">-</button><span style="min-width:24px;text-align:center;font-size:13px;font-weight:700;">'+item.soLuong+'</span><button onclick="changeQty('+i+',1)" style="width:22px;height:22px;border-radius:5px;border:1px solid #e2e8f0;background:#f1f5f9;cursor:pointer;font-size:12px;font-weight:700;">+</button></div></td>';
        html+='<td style="padding:8px 12px;text-align:right;font-size:13px;white-space:nowrap;">'+fmt(item.donGia)+'</td>';
        html+='<td style="padding:8px 12px;text-align:right;font-size:13px;font-weight:700;color:#15803d;white-space:nowrap;">'+fmt(item.thanhTien)+'</td>';
        html+='<td style="padding:8px 6px;text-align:center;"><button onclick="removeFromCart('+i+')" style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;width:24px;height:24px;border-radius:6px;cursor:pointer;font-size:11px;">✕</button></td>';
        html+='</tr>';
    });
    document.getElementById('cartBody').innerHTML=html;
    document.getElementById('cartCount').textContent=cart.length+' sản phẩm';
    document.getElementById('cartTotal').textContent=fmt(total);
    document.getElementById('goPayBtn').disabled=false;
    document.getElementById('goPayBtn').style.opacity='1';
}

function changeQty(i,delta){
    cart[i].soLuong+=delta;
    if(cart[i].soLuong<=0){ cart.splice(i,1); }
    else { if(cart[i].soLuong>cart[i].soLuongTon){ cart[i].soLuong=cart[i].soLuongTon; alert('Không đủ tồn kho'); } cart[i].thanhTien=cart[i].soLuong*cart[i].donGia; }
    renderCart();
}
function removeFromCart(i){ cart.splice(i,1); renderCart(); }

/* ---- THANH TOÁN ---- */
function updatePayCalc(){
    var total=cart.reduce(function(s,i){ return s+i.thanhTien; },0);
    var disc=parseFloat(document.getElementById('discountInput').value)||0;
    if(disc>total) disc=total;
    var final=total-disc;
    document.getElementById('payTotal').textContent=fmt(total);
    document.getElementById('payDiscount').textContent='-'+fmt(disc);
    document.getElementById('payFinal').textContent=fmt(final);
    var method=document.getElementById('paymentMethod').value;
    document.getElementById('cashSection').style.display=method==='TienMat'?'block':'none';
    buildQuickCash(final); calcChange();
}

function buildQuickCash(final){
    var amounts=[10000,20000,50000,100000,200000,500000],html='';
    amounts.forEach(function(a){ if(a>=final) html+='<button onclick="document.getElementById(\'cashGiven\').value='+a+';calcChange();" style="padding:5px 10px;border-radius:6px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:12px;font-weight:700;cursor:pointer;">'+fmt(a)+'</button>'; });
    var rounded=Math.ceil(final/1000)*1000;
    if(rounded!==final&&rounded<=500000) html='<button onclick="document.getElementById(\'cashGiven\').value='+rounded+';calcChange();" style="padding:5px 10px;border-radius:6px;border:1.5px solid #d1fae5;background:#f0fdf4;color:#15803d;font-size:12px;font-weight:700;cursor:pointer;">'+fmt(rounded)+'</button>'+html;
    document.getElementById('quickCash').innerHTML=html;
}

function calcChange(){
    var total=cart.reduce(function(s,i){ return s+i.thanhTien; },0);
    var disc=parseFloat(document.getElementById('discountInput').value)||0;
    var final=total-disc;
    var given=parseFloat(document.getElementById('cashGiven').value)||0;
    var changeRow=document.getElementById('changeRow');
    if(given>0){
        var change=given-final; changeRow.style.display='flex';
        if(change>=0){ changeRow.style.background='#f0fdf4'; changeRow.style.border='1.5px solid #bbf7d0'; document.getElementById('changeAmount').textContent=fmt(change); document.getElementById('changeAmount').style.color='#15803d'; }
        else { changeRow.style.background='#fef2f2'; changeRow.style.border='1.5px solid #fecaca'; document.getElementById('changeAmount').textContent='Thiếu '+fmt(Math.abs(change)); document.getElementById('changeAmount').style.color='#dc2626'; }
    } else { changeRow.style.display='none'; }
}

/* ---- KHÁCH HÀNG ---- */
function findCustomer(){
    var phone=document.getElementById('customerPhone').value.trim();
    if(!phone){ alert('Nhập số điện thoại'); return; }
    $.get('<?php echo BASE_URL; ?>customer/search',{phone:phone},function(res){
        if(res.success&&res.customer){ selectedCustomer=res.customer; document.getElementById('customerInfo').innerHTML='<div style="padding:8px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#15803d;display:flex;align-items:center;gap:8px;"><i class="fas fa-check-circle"></i><b>'+res.customer.hoTen+'</b> &nbsp;·&nbsp; Điểm: '+res.customer.diemTichLuy+'</div>'; }
        else { selectedCustomer=null; document.getElementById('customerInfo').innerHTML='<div style="padding:8px 12px;background:#fef2f2;border:1px solid #fecaca;border-radius:8px;font-size:13px;color:#dc2626;"><i class="fas fa-times-circle"></i> Không tìm thấy khách hàng</div>'; }
    },'json');
}
function openAddCustomerModal(){ document.getElementById('addCustomerModal').style.display='flex'; }
function closeAddCustomerModal(){ document.getElementById('addCustomerModal').style.display='none'; }
document.getElementById('addCustomerModal').addEventListener('click',function(e){ if(e.target===this) closeAddCustomerModal(); });

function saveNewCustomer(){
    var hoTen=document.getElementById('newHoTen').value.trim(), sdt=document.getElementById('newSoDienThoai').value.trim();
    if(!hoTen||!sdt){ alert('Vui lòng nhập họ tên và số điện thoại'); return; }
    $.ajax({ url:'<?php echo BASE_URL; ?>customer/add', type:'POST', headers:{'X-Requested-With':'XMLHttpRequest'},
        data:{hoTen:hoTen,soDienThoai:sdt,diaChi:document.getElementById('newDiaChi').value,email:document.getElementById('newEmail').value}, dataType:'json',
        success:function(res){
            if(res.success){ selectedCustomer={maKhachHang:res.customer.maKhachHang,hoTen:hoTen,diemTichLuy:0}; document.getElementById('customerPhone').value=sdt; document.getElementById('customerInfo').innerHTML='<div style="padding:8px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#15803d;"><i class="fas fa-check-circle"></i> <b>'+hoTen+'</b> đã được thêm</div>'; closeAddCustomerModal(); document.getElementById('newHoTen').value=''; document.getElementById('newSoDienThoai').value=''; document.getElementById('newDiaChi').value=''; document.getElementById('newEmail').value=''; }
            else { alert('Lỗi: '+(res.message||'Không thể thêm khách hàng')); }
        }
    });
}

/* ---- CHECKOUT ---- */
function doCheckout(){
    if(cart.length===0){ alert('Giỏ hàng trống'); return; }
    var method=document.getElementById('paymentMethod').value;
    if(method==='TienMat'){
        var total=cart.reduce(function(s,i){ return s+i.thanhTien; },0);
        var disc=parseFloat(document.getElementById('discountInput').value)||0;
        var final=total-disc;
        var given=parseFloat(document.getElementById('cashGiven').value)||0;
        if(given<final){ alert('Tiền khách đưa chưa đủ'); return; }
    }
    var btn=document.getElementById('confirmPayBtn');
    btn.disabled=true; btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    var total=cart.reduce(function(s,i){ return s+i.thanhTien; },0);
    var disc=parseFloat(document.getElementById('discountInput').value)||0;
    $.post('<?php echo BASE_URL; ?>sale/create',{
        cart:JSON.stringify(cart), maKhachHang:selectedCustomer?selectedCustomer.maKhachHang:'',
        tongTien:total-disc, tienGiam:disc, phuongThucThanhToan:method
    },function(res){
        btn.disabled=false; btn.innerHTML='<i class="fas fa-check-circle"></i> Xác nhận thanh toán';
        if(res.success){
            lastInvoiceId=res.invoice_id; closePayModal();
            var given=parseFloat(document.getElementById('cashGiven').value)||0;
            var change=given-(total-disc);
            document.getElementById('successMsg').textContent='Hóa đơn #'+res.invoice_id+' — Tổng: '+fmt(total-disc);
            document.getElementById('successChange').innerHTML=method==='TienMat'&&change>0?'<span style="color:#15803d;font-weight:700;">Tiền thối: '+fmt(change)+'</span>':'';
            document.getElementById('successModal').style.display='flex';
        } else { alert('Lỗi: '+(res.message||'Không thể tạo hóa đơn')); }
    },'json');
}

function printInvoice(){ if(lastInvoiceId) window.open('<?php echo BASE_URL; ?>sale/print/'+lastInvoiceId,'_blank'); }
function resetSale(){
    cart=[]; selectedCustomer=null; lastInvoiceId=null;
    document.getElementById('successModal').style.display='none';
    renderCart(); openSaleModal();
}
document.getElementById('successModal').addEventListener('click',function(e){ if(e.target===this) this.style.display='none'; });
function fmt(n){ return new Intl.NumberFormat('vi-VN').format(n)+'đ'; }
</script>
