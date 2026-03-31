<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-warehouse" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Tạo Phiếu Nhập Kho</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Nhập thuốc từ nhà cung cấp</div>
    </div>
  </div>
</div>

<!-- STEP 1: Thêm thuốc -->
<div id="banner_err_importTable" style="display:none; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:9px; color:#b91c1c; font-size:13px; font-weight:600; transition: opacity 0.5s ease; opacity:0;">
  <i class="fas fa-exclamation-triangle" style="margin-right:5px;"></i> <span id="text_err_importTable"></span>
</div>
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-pills" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">Bước 1 &mdash; Chọn thuốc nhập</span>
  </div>
  <div style="padding:18px 20px;">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:12px;align-items:flex-start;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Chọn thuốc</label>
        <select id="medicineSelect" onchange="clearError('medicineSelect')" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;color:#1e293b;">
          <option value="">-- Chọn thuốc --</option>
          <?php foreach($medicines as $m): ?>
          <option value="<?php echo $m['maThuoc']; ?>" data-name="<?php echo htmlspecialchars($m['tenThuoc']); ?>" data-unit="<?php echo htmlspecialchars($m['donViTinh']); ?>">
            <?php echo htmlspecialchars($m['tenThuoc']); ?>
          </option>
          <?php endforeach; ?>
        </select>
        <span id="err_medicineSelect" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Số lượng</label>
        <input type="number" id="importQty" min="1" placeholder="0" oninput="clearError('importQty')" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        <span id="err_importQty" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Đơn giá (đ)</label>
        <input type="number" id="importPrice" min="0" placeholder="0" oninput="clearError('importPrice')" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        <span id="err_importPrice" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Hạn sử dụng</label>
        <input type="date" id="importExpiry" onchange="clearError('importExpiry')" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
        <span id="err_importExpiry" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
      </div>
      <div style="padding-top:24px;">
        <button onclick="addImportItem()" style="padding:9px 20px;border-radius:8px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;box-shadow:0 2px 8px rgba(30,64,175,.3);">
          <i class="fas fa-plus"></i> Thêm
        </button>
      </div>
    </div>
  </div>
</div>

<!-- STEP 2: Danh sách thuốc nhập -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fas fa-list" style="color:#fff;font-size:13px;"></i>
      <span style="font-size:13px;font-weight:700;color:#fff;">Bước 2 &mdash; Danh sách thuốc nhập</span>
    </div>
    <span id="importCount" style="font-size:12px;color:rgba(255,255,255,.8);">0 mặt hàng</span>
  </div>
  <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">Tên thuốc</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">ĐVT</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">SL</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Đơn giá</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">HSD</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Thành tiền</th>
          <th style="padding:10px 14px;"></th>
        </tr>
      </thead>
      <tbody id="importBody">
        <tr id="importEmpty">
          <td colspan="7" style="padding:30px;text-align:center;color:#94a3b8;font-size:13px;">Chưa có mặt hàng nào</td>
        </tr>
      </tbody>
      <tfoot>
        <tr style="background:#f0f7ff;border-top:2px solid #dbeafe;">
          <td colspan="5" style="padding:12px 14px;font-size:13px;font-weight:700;color:#374151;text-align:right;">Tổng tiền:</td>
          <td style="padding:12px 14px;font-size:16px;font-weight:900;color:#15803d;text-align:right;" id="importTotal">0đ</td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<!-- STEP 3: Thông tin NCC + Lưu -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#15803d,#16a34a);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-truck" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">Bước 3 &mdash; Thông tin nhập kho</span>
  </div>
  <div style="padding:18px 20px;">
    <div style="display:grid;grid-template-columns:1fr 2fr auto;gap:16px;align-items:flex-start;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Nhà cung cấp <span style="color:#dc2626;">*</span></label>
        <select id="supplierSelect" onchange="clearError('supplierSelect')" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;color:#1e293b;">
          <option value="">-- Chọn nhà cung cấp --</option>
          <?php foreach($suppliers as $s): ?>
          <option value="<?php echo $s['maNhaCC']; ?>"><?php echo htmlspecialchars($s['tenNhaCC']); ?></option>
          <?php endforeach; ?>
        </select>
        <span id="err_supplierSelect" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Ghi chú</label>
        <input type="text" id="importNote" placeholder="Ghi chú thêm..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div style="padding-top:24px;">
        <button onclick="saveImport(this)" style="padding:10px 28px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;box-shadow:0 4px 10px rgba(21,128,61,.3);">
          <i class="fas fa-save"></i> Lưu phiếu nhập kho
        </button>
      </div>
    </div>
  </div>
</div>

</div>

<script>
let importItems = [];

function clearError(id) {
    document.getElementById(id).style.borderColor = '#e2e8f0';
    let errSpan = document.getElementById('err_' + id);
    if(errSpan) errSpan.textContent = '';
    
    if(id !== 'supplierSelect') {
        let banner = document.getElementById('banner_err_importTable');
        if(banner) { banner.style.opacity = '0'; setTimeout(() => { banner.style.display = 'none'; }, 300); }
    }
}

function displayInlineErr(errId, inputId, msg) {
    let errSpan = document.getElementById(errId);
    let inputEl = document.getElementById(inputId);
    
    if(errSpan) errSpan.textContent = msg;
    if(inputEl) inputEl.style.borderColor = '#dc2626';
    
    setTimeout(() => {
        if(errSpan) errSpan.textContent = '';
        if(inputEl) inputEl.style.borderColor = '#e2e8f0';
    }, 3000);
}

function showToast(message, type = 'success') {
    if (!document.getElementById('toast-styles-sys')) {
        const style = document.createElement('style');
        style.id = 'toast-styles-sys';
        style.innerHTML = `
            .glass-toast-sys { position: fixed; top: 64px; right: 24px; width: max-content; max-width: 420px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 16px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); padding: 18px 24px; display: flex; align-items: flex-start; gap: 16px; z-index: 9999999; font-family: sans-serif; transform: translateX(120%); transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); overflow: hidden; }
            .glass-toast-sys.show { transform: translateX(0); }
            .toast-icon-wrapper-sys { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
            .toast-icon-wrapper-sys i { color: #ffffff; font-size: 16px; }
            .toast-text-title-sys { font-size: 15px; font-weight: 800; color: #1f2937; }
            .toast-text-msg-sys { font-size: 13.5px; color: #4b5563; margin-top: 4px; }
            .toast-progress-sys { position: absolute; bottom: 0; left: 0; height: 4px; width: 100%; transform-origin: left; animation: progressShrinkSys 3s linear forwards; }
            @keyframes progressShrinkSys { 0% { transform: scaleX(1); } 100% { transform: scaleX(0); } }
        `;
        document.head.appendChild(style);
    }
    const toast = document.createElement('div');
    toast.className = 'glass-toast-sys';
    let title = type === 'success' ? 'Thành công!' : 'Có lỗi xảy ra!';
    let icon = type === 'success' ? 'fa-check' : 'fa-exclamation-triangle';
    let colors = type === 'success' ? ['#34d399', '#10b981'] : ['#f87171', '#ef4444'];
    toast.innerHTML = `
        <div class="toast-icon-wrapper-sys" style="background: linear-gradient(135deg, ${colors[0]}, ${colors[1]});">
            <i class="fas ${icon}"></i>
        </div>
        <div>
            <div class="toast-text-title-sys">${title}</div>
            <div class="toast-text-msg-sys">${message}</div>
        </div>
        <div class="toast-progress-sys" style="background: linear-gradient(90deg, ${colors[0]}, ${colors[1]});"></div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 50);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 600);
    }, 3000);
}

function addImportItem() {
    let sel = document.getElementById('medicineSelect');
    let id = sel.value;
    let name = sel.options[sel.selectedIndex]?.dataset.name;
    let unit = sel.options[sel.selectedIndex]?.dataset.unit;
    let qtyInput = document.getElementById('importQty');
    let priceInput = document.getElementById('importPrice');
    let expiryInput = document.getElementById('importExpiry');
    let qty = parseInt(qtyInput.value);
    let price = parseFloat(priceInput.value);
    let expiry = expiryInput.value;
    let hasError = false;
    if(!id) { displayInlineErr('err_medicineSelect', 'medicineSelect', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(!qty || isNaN(qty)) { displayInlineErr('err_importQty', 'importQty', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(isNaN(price) || priceInput.value === '') { displayInlineErr('err_importPrice', 'importPrice', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(!expiry) { displayInlineErr('err_importExpiry', 'importExpiry', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(hasError) return;
    let hsdDate = new Date(expiry);
    let today = new Date();
    today.setHours(0,0,0,0);
    if(hsdDate <= today) {
        displayInlineErr('err_importExpiry', 'importExpiry', 'Hạn sử dụng phải lớn hơn ngày hiện tại');
        return;
    }
    importItems.push({ maThuoc:id, tenThuoc:name, donViTinh:unit, soLuong:qty, donGia:price, hanSuDung:expiry, thanhTien:qty*price });
    renderImport();
    sel.value=''; qtyInput.value=''; priceInput.value=''; expiryInput.value='';
    clearError('medicineSelect'); clearError('importQty'); clearError('importPrice'); clearError('importExpiry');
}

function renderImport() {
    if(importItems.length===0){
        document.getElementById('importBody').innerHTML='<tr id="importEmpty"><td colspan="7" style="padding:30px;text-align:center;color:#94a3b8;font-size:13px;">Chưa có mặt hàng nào</td></tr>';
        document.getElementById('importTotal').textContent='0đ';
        document.getElementById('importCount').textContent='0 mặt hàng';
        return;
    }
    let total=0, html='';
    importItems.forEach(function(item,i){
        total+=item.thanhTien;
        let bg=i%2===0?'#fff':'#f0f7ff';
        html+=`<tr style="background:${bg};transition:background .15s;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='${bg}'">
            <td style="padding:10px 14px;font-size:13px;font-weight:600;color:#1e293b;">${item.tenThuoc}</td>
            <td style="padding:10px 14px;font-size:12px;color:#64748b;text-align:center;">${item.donViTinh}</td>
            <td style="padding:10px 14px;font-size:13px;color:#374151;text-align:center;">${item.soLuong}</td>
            <td style="padding:10px 14px;font-size:13px;color:#374151;text-align:right;white-space:nowrap;">${fmt(item.donGia)}</td>
            <td style="padding:10px 14px;font-size:12px;color:#374151;text-align:center;white-space:nowrap;">${item.hanSuDung}</td>
            <td style="padding:10px 14px;font-size:13px;font-weight:700;color:#15803d;text-align:right;white-space:nowrap;">${fmt(item.thanhTien)}</td>
            <td style="padding:10px 14px;text-align:center;">
                <button onclick="removeImportItem(${i})" style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;width:28px;height:28px;border-radius:7px;cursor:pointer;font-size:12px;">✕</button>
            </td>
        </tr>`;
    });
    document.getElementById('importBody').innerHTML=html;
    document.getElementById('importTotal').textContent=fmt(total);
    document.getElementById('importCount').textContent=importItems.length+' mặt hàng';
}

function removeImportItem(i){ 
    importItems.splice(i,1); 
    renderImport(); 
    let banner = document.getElementById('banner_err_importTable');
    if(banner) { banner.style.opacity = '0'; setTimeout(() => { banner.style.display = 'none'; }, 300); }
}

function saveImport(btn){
    if(importItems.length === 0){ 
        let banner = document.getElementById('banner_err_importTable');
        document.getElementById('text_err_importTable').textContent = 'Vui lòng thêm thuốc vào phiếu nhập';
        banner.style.display = 'block';
        setTimeout(() => { banner.style.opacity = '1'; }, 10);
        setTimeout(() => { banner.style.opacity = '0'; setTimeout(() => { banner.style.display = 'none'; }, 500); }, 3000);
        return;
    }
    let supplierSel = document.getElementById('supplierSelect');
    let supplier = supplierSel.value;
    if(!supplier){ 
        displayInlineErr('err_supplierSelect', 'supplierSelect', 'Vui lòng chọn nhà cung cấp'); 
        return; 
    }
    let total=importItems.reduce(function(s,i){ return s+parseFloat(i.thanhTien); },0);
    let originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    btn.disabled = true;
    $.post('<?php echo BASE_URL; ?>warehouse/import',{
        maNhaCC:supplier,
        tongTien:total,
        ghiChu:document.getElementById('importNote').value,
        items:JSON.stringify(importItems)
    },function(res){
        if(res.success){ 
            showToast('Tạo phiếu nhập kho thành công', 'success'); 
            setTimeout(() => { location.reload(); }, 3000); 
        }
        else{ 
            showToast('Có lỗi xảy ra: '+(res.message||''), 'error'); 
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    },'json').fail(function() {
        showToast('Lỗi kết nối internet hoặc máy chủ', 'error'); 
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function fmt(n){ return new Intl.NumberFormat('vi-VN').format(n)+'đ'; }
</script>
