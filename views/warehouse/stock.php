<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-boxes" style="color:#fff;font-size:18px;"></i>
      </div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Tồn Kho Hiện Tại</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Cập nhật số lượng tồn kho</div>
      </div>
    </div>
    <button onclick="document.getElementById('importModal').style.display='flex'"
      style="display:inline-flex;align-items:center;gap:8px;padding:9px 20px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(21,128,61,.35);">
      <i class="fas fa-file-import"></i> Nhập kho
    </button>
  </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
<script>document.addEventListener('DOMContentLoaded', () => showToast('<?php echo $_SESSION['success']; ?>', 'success'));</script>
<?php unset($_SESSION['success']); endif; ?> <?php if (isset($error)): ?>
<script>document.addEventListener('DOMContentLoaded', () => showToast('<?php echo $error; ?>', 'error'));</script>
<?php endif; ?>
<?php if (isset($error)): ?>
<div id="phpStockError" style="margin-bottom:14px; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:9px; color:#b91c1c; font-size:13px; font-weight:600; transition: opacity 0.5s ease;">
    <i class="fas fa-exclamation-triangle" style="margin-right:5px;"></i> <?php echo $error; ?>
</div>
<script>
    setTimeout(() => {
        let err = document.getElementById('phpStockError');
        if(err) { err.style.opacity = '0'; setTimeout(() => err.style.display = 'none', 500); }
    }, 3000);
</script>
<?php endif; ?>

<div id="inlineStockError" style="display:none; margin-bottom:14px; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:9px; color:#b91c1c; font-size:13px; font-weight:600; transition: opacity 0.5s ease;">
    <i class="fas fa-exclamation-triangle" style="margin-right:5px;"></i> <span id="inlineStockErrorMsg"></span>
</div>

<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách tồn kho</span>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($medicines ?? []); ?> mặt hàng</span>
  </div>
  <form method="POST" action="<?php echo BASE_URL; ?>warehouse/updateStock" id="stockForm">    <div style="overflow-x:auto;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Mã</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Tên thuốc</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">ĐVT</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">HSD</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Tồn hiện tại</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">Số lượng mới</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;">Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($medicines as $i => $m): ?>
          <?php
            $expired = strtotime($m['hanSuDung']) < time();
            $lowStock = $m['soLuongTon'] <= 10;
            $rowBg = $i%2===0?'#fff':'#f0f7ff';
          ?>
          <tr style="background:<?php echo $rowBg; ?>;" onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $rowBg; ?>'">
            <td style="padding:9px 16px;font-size:13px;color:#64748b;"><?php echo $m['maThuoc']; ?></td>
            <td style="padding:9px 16px;font-size:13px;font-weight:600;color:#374151;"><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
            <td style="padding:9px 16px;font-size:13px;color:#374151;"><?php echo htmlspecialchars($m['donViTinh']); ?></td>
            <td style="padding:9px 16px;font-size:13px;<?php echo $expired?'color:#dc2626;font-weight:700;':'color:#374151;'; ?>">
              <?php echo date('d/m/Y', strtotime($m['hanSuDung'])); ?>
              <?php if($expired): ?><span style="font-size:10px;background:#fef2f2;color:#dc2626;padding:1px 6px;border-radius:10px;margin-left:4px;">Hết hạn</span><?php endif; ?>
            </td>
            <td style="padding:9px 16px;text-align:center;">
              <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;background:<?php echo $lowStock?'#fef2f2':'#f0fdf4'; ?>;color:<?php echo $lowStock?'#dc2626':'#15803d'; ?>;">
                <?php echo $m['soLuongTon']; ?>
              </span>
            </td>
            <td style="padding:9px 16px;text-align:center;">
              <input type="number" class="qty-input" name="soLuong[<?php echo $m['maThuoc']; ?>]"
                placeholder="Nhập SL mới" min="0" step="any"
                style="width:110px;padding:6px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:13px;text-align:center;outline:none;">
            </td>
            <td style="padding:9px 16px;">
              <?php if($m['trangThai']==='DangBan'): ?>
                <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f0fdf4;color:#15803d;">Đang bán</span>
              <?php else: ?>
                <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f8fafc;color:#64748b;">Ngừng KD</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div style="padding:14px 20px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;">
      <button type="button" onclick="confirmUpdate()"
        style="padding:9px 24px;border-radius:9px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 10px rgba(30,64,175,.3);">
        <i class="fas fa-save"></i> Cập nhật tồn kho
      </button>
    </div>
  </form>
</div>

</div>

<!-- Overlay xác nhận -->
<div id="confirmOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:440px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);">
    <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:10px;">
      <i class="fas fa-save" style="color:#fff;font-size:15px;"></i>
      <span style="font-size:14px;font-weight:700;color:#fff;">Xác nhận cập nhật tồn kho</span>
    </div>
    <div style="padding:18px 22px;font-size:13px;color:#374151;" id="confirmBody"></div>
    <div style="padding:10px 22px 18px;display:flex;gap:10px;justify-content:flex-end;">
      <button onclick="document.getElementById('confirmOverlay').style.display='none'" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Hủy</button>
      <button onclick="document.getElementById('stockForm').submit()" style="padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border:none;cursor:pointer;">
        <i class="fas fa-check"></i> Xác nhận
      </button>
    </div>
  </div>
</div>

<script>
function showInlineStockError(msg) {
    const errDiv = document.getElementById('inlineStockError');
    document.getElementById('inlineStockErrorMsg').textContent = msg;
    errDiv.style.display = 'block';
    setTimeout(() => { errDiv.style.opacity = '1'; }, 10);
    setTimeout(() => {
        errDiv.style.opacity = '0';
        setTimeout(() => { errDiv.style.display = 'none'; }, 500);
    }, 3000);
}

function confirmUpdate() {
    const inputs = document.querySelectorAll('.qty-input');
    let changes = [], hasError = false, hasValue = false;
    inputs.forEach(function(input) {
        let rawVal = input.value.trim();
        if(rawVal !== '') {
            hasValue = true;
            let val = Number(rawVal);
            if(isNaN(val) || val < 0) { 
                hasError = true; 
                input.style.borderColor = '#dc2626'; 
            }
            else {
                input.style.borderColor = '#e2e8f0';
                const row = input.closest('tr');
                const name = row.cells[1].textContent.trim();
                const old = row.cells[4].querySelector('span').textContent.trim();
                changes.push(`<li style="margin-bottom:4px;">${name}: <b>${old}</b> → <b style="color:#1d4ed8;">${val}</b></li>`);
            }
        } else {
            input.style.borderColor = '#e2e8f0';
        }
    });
    if(hasError) { showInlineStockError('Số lượng không hợp lệ, vui lòng chọn lại.'); return; }
    if(!hasValue) { showInlineStockError('Vui lòng nhập ít nhất một số lượng mới'); return; }    
    document.getElementById('confirmBody').innerHTML = '<p style="margin-bottom:8px;">Các thuốc sẽ thay đổi tồn kho:</p><ul style="padding-left:18px;">' + changes.join('') + '</ul>';
    document.getElementById('confirmOverlay').style.display = 'flex';
}
document.getElementById('confirmOverlay').addEventListener('click', function(e){ if(e.target===this) this.style.display='none'; });
</script>

<!-- ===== MODAL NHẬP KHO ===== -->
<div id="importModal" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px;">
  <div style="background:#fff;border-radius:16px;width:100%;max-width:820px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 24px 64px rgba(0,0,0,.3);">

    <!-- Modal header -->
    <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
      <div style="display:flex;align-items:center;gap:10px;">
        <i class="fas fa-warehouse" style="color:#fff;font-size:16px;"></i>
        <span style="font-size:15px;font-weight:800;color:#fff;">Tạo phiếu nhập kho</span>
      </div>
      <button onclick="closeImportModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>

    <!-- Modal body scroll -->
    <div style="overflow-y:auto;flex:1;padding:18px 22px;display:flex;flex-direction:column;gap:16px;">

      <!-- Bước 1: Chọn thuốc -->
      <div id="banner_err_m_importTable" style="display:none; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:9px; color:#b91c1c; font-size:13px; font-weight:600; transition: opacity 0.5s ease; opacity:0;">
          <i class="fas fa-exclamation-triangle" style="margin-right:5px;"></i> <span id="text_err_m_importTable"></span>
      </div>
      <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;overflow:hidden;">
        <div style="padding:10px 16px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
          <i class="fas fa-pills" style="color:#fff;font-size:12px;"></i>
          <span style="font-size:12.5px;font-weight:700;color:#fff;">Chọn thuốc nhập</span>
        </div>
        <div style="padding:14px 16px;">
          <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:10px;align-items:flex-start;">
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Thuốc</label>
              <select id="m_medicineSelect" onchange="mClearError('m_medicineSelect')" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
                <option value="">-- Chọn thuốc --</option>
                <?php foreach($medicines as $m): ?>
                <option value="<?php echo $m['maThuoc']; ?>" data-name="<?php echo htmlspecialchars($m['tenThuoc']); ?>" data-unit="<?php echo htmlspecialchars($m['donViTinh']); ?>">
                  <?php echo htmlspecialchars($m['tenThuoc']); ?>
                </option>
                <?php endforeach; ?>
              </select>
              <span id="err_m_medicineSelect" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Số lượng</label>
              <input type="number" id="m_importQty" min="1" placeholder="0" oninput="mClearError('m_importQty')" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
              <span id="err_m_importQty" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Đơn giá (đ)</label>
              <input type="number" id="m_importPrice" min="0" placeholder="0" oninput="mClearError('m_importPrice')" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
              <span id="err_m_importPrice" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Hạn sử dụng</label>
              <input type="date" id="m_importExpiry" onchange="mClearError('m_importExpiry')" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
              <span id="err_m_importExpiry" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
            </div>
            <div style="padding-top:22px;">
              <button onclick="mAddItem()" style="padding:8px 16px;border-radius:7px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:12.5px;font-weight:700;cursor:pointer;white-space:nowrap;">
                <i class="fas fa-plus"></i> Thêm
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Bước 2: Danh sách -->
      <div style="background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;overflow:hidden;">
        <div style="padding:10px 16px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
          <div style="display:flex;align-items:center;gap:8px;">
            <i class="fas fa-list" style="color:#fff;font-size:12px;"></i>
            <span style="font-size:12.5px;font-weight:700;color:#fff;">Danh sách thuốc nhập</span>
          </div>
          <span id="m_importCount" style="font-size:11px;color:rgba(255,255,255,.8);">0 mặt hàng</span>
        </div>
        <div style="overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;font-size:12.5px;">
            <thead>
              <tr style="background:#f1f5f9;">
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:left;white-space:nowrap;">Tên thuốc</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:center;white-space:nowrap;">ĐVT</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:center;white-space:nowrap;">SL</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:right;white-space:nowrap;">Đơn giá</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:center;white-space:nowrap;">HSD</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:right;white-space:nowrap;">Thành tiền</th>
                <th style="padding:9px 12px;"></th>
              </tr>
            </thead>
            <tbody id="m_importBody">
              <tr><td colspan="7" style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">Chưa có mặt hàng nào</td></tr>
            </tbody>
            <tfoot>
              <tr style="background:#f0f7ff;border-top:2px solid #dbeafe;">
                <td colspan="5" style="padding:10px 12px;font-size:12.5px;font-weight:700;color:#374151;text-align:right;">Tổng tiền:</td>
                <td style="padding:10px 12px;font-size:15px;font-weight:900;color:#15803d;text-align:right;" id="m_importTotal">0đ</td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Bước 3: NCC + Lưu -->
      <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;overflow:hidden;">
        <div style="padding:10px 16px;background:linear-gradient(135deg,#15803d,#16a34a);display:flex;align-items:center;gap:8px;">
          <i class="fas fa-truck" style="color:#fff;font-size:12px;"></i>
          <span style="font-size:12.5px;font-weight:700;color:#fff;">Thông tin nhập kho</span>
        </div>
        <div style="padding:14px 16px;">
          <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;align-items:flex-start;">
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Nhà cung cấp <span style="color:#dc2626;">*</span></label>
              <select id="m_supplierSelect" onchange="mClearError('m_supplierSelect')" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
                <option value="">-- Chọn nhà cung cấp --</option>
                <?php foreach($suppliers as $s): ?>
                <option value="<?php echo $s['maNhaCC']; ?>"><?php echo htmlspecialchars($s['tenNhaCC']); ?></option>
                <?php endforeach; ?>
              </select>
              <span id="err_m_supplierSelect" style="color:#dc2626;font-size:11px;margin-top:4px;display:block;min-height:14px;font-weight:600;"></span>
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Ghi chú</label>
              <input type="text" id="m_importNote" placeholder="Ghi chú thêm..." style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Modal footer -->
    <div style="padding:14px 22px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;background:#fff;">
      <button onclick="closeImportModal()" style="padding:9px 20px;border-radius:9px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">Hủy</button>
      <button onclick="mSaveImport(this)" style="padding:9px 24px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 10px rgba(21,128,61,.3);">
        <i class="fas fa-save"></i> Lưu phiếu nhập kho
      </button>
    </div>
  </div>
</div>

<script>
let mImportItems = [];

function mClearError(id) {
    document.getElementById(id).style.borderColor = '#e2e8f0';
    let errSpan = document.getElementById('err_' + id);
    if(errSpan) errSpan.textContent = '';
    if(id !== 'm_supplierSelect') {
        let banner = document.getElementById('banner_err_m_importTable');
        if(banner) { banner.style.opacity = '0'; setTimeout(() => { banner.style.display = 'none'; }, 300); }
    }
}

function mDisplayInlineErr(errId, inputId, msg) {
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

function closeImportModal(){
    document.getElementById('importModal').style.display='none';
}
document.getElementById('importModal').addEventListener('click',function(e){ if(e.target===this) closeImportModal(); });

function mAddItem(){
    let sel = document.getElementById('m_medicineSelect');
    let id = sel.value;
    let name = sel.options[sel.selectedIndex]?.dataset.name;
    let unit = sel.options[sel.selectedIndex]?.dataset.unit;
    let qtyInput = document.getElementById('m_importQty');
    let priceInput = document.getElementById('m_importPrice');
    let expiryInput = document.getElementById('m_importExpiry');
    let qty = parseInt(qtyInput.value);
    let price = parseFloat(priceInput.value);
    let expiry = expiryInput.value;
    let hasError = false;
    if(!id) { mDisplayInlineErr('err_m_medicineSelect', 'm_medicineSelect', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(!qty || isNaN(qty)) { mDisplayInlineErr('err_m_importQty', 'm_importQty', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(isNaN(price) || priceInput.value === '') { mDisplayInlineErr('err_m_importPrice', 'm_importPrice', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(!expiry) { mDisplayInlineErr('err_m_importExpiry', 'm_importExpiry', 'Vui lòng chọn đầy đủ thông tin'); hasError = true; }
    if(hasError) return;
    let hsdDate = new Date(expiry);
    let today = new Date();
    today.setHours(0,0,0,0);
    if(hsdDate <= today) {
        mDisplayInlineErr('err_m_importExpiry', 'm_importExpiry', 'Hạn sử dụng phải lớn hơn ngày hiện tại');
        return;
    }
    mImportItems.push({maThuoc:id,tenThuoc:name,donViTinh:unit,soLuong:qty,donGia:price,hanSuDung:expiry,thanhTien:qty*price});
    mRenderImport();
    sel.value=''; qtyInput.value=''; priceInput.value=''; expiryInput.value='';
    mClearError('m_medicineSelect'); mClearError('m_importQty'); mClearError('m_importPrice'); mClearError('m_importExpiry');
}

function mRenderImport(){
    if(mImportItems.length===0){
        document.getElementById('m_importBody').innerHTML='<tr><td colspan="7" style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">Chưa có mặt hàng nào</td></tr>';
        document.getElementById('m_importTotal').textContent='0đ';
        document.getElementById('m_importCount').textContent='0 mặt hàng';
        return;
    }
    let total=0,html='';
    mImportItems.forEach(function(item,i){
        total+=item.thanhTien;
        let bg=i%2===0?'#fff':'#f0f7ff';
        html+=`<tr style="background:${bg};">
            <td style="padding:8px 12px;font-weight:600;color:#1e293b;">${item.tenThuoc}</td>
            <td style="padding:8px 12px;color:#64748b;text-align:center;">${item.donViTinh}</td>
            <td style="padding:8px 12px;text-align:center;">${item.soLuong}</td>
            <td style="padding:8px 12px;text-align:right;white-space:nowrap;">${mFmt(item.donGia)}</td>
            <td style="padding:8px 12px;text-align:center;white-space:nowrap;">${item.hanSuDung}</td>
            <td style="padding:8px 12px;font-weight:700;color:#15803d;text-align:right;white-space:nowrap;">${mFmt(item.thanhTien)}</td>
            <td style="padding:8px 12px;text-align:center;">
                <button onclick="mRemoveItem(${i})" style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;width:26px;height:26px;border-radius:6px;cursor:pointer;font-size:11px;">✕</button>
            </td>
        </tr>`;
    });
    document.getElementById('m_importBody').innerHTML=html;
    document.getElementById('m_importTotal').textContent=mFmt(total);
    document.getElementById('m_importCount').textContent=mImportItems.length+' mặt hàng';
}

function mRemoveItem(i){ 
    mImportItems.splice(i,1); 
    mRenderImport(); 
    let banner = document.getElementById('banner_err_m_importTable');
    if(banner) { banner.style.opacity = '0'; setTimeout(() => { banner.style.display = 'none'; }, 300); }
}

function mSaveImport(btn){
    if(mImportItems.length === 0){ 
        let banner = document.getElementById('banner_err_m_importTable');
        document.getElementById('text_err_m_importTable').textContent = 'Vui lòng thêm thuốc vào phiếu nhập';
        banner.style.display = 'block';
        setTimeout(() => { banner.style.opacity = '1'; }, 10);
        setTimeout(() => { banner.style.opacity = '0'; setTimeout(() => { banner.style.display = 'none'; }, 500); }, 3000);
        return;
    }
    
    let supplierSel = document.getElementById('m_supplierSelect');
    let supplier = supplierSel.value;
    if(!supplier){ 
        mDisplayInlineErr('err_m_supplierSelect', 'm_supplierSelect', 'Vui lòng chọn nhà cung cấp'); 
        return; 
    }
    
    let total=mImportItems.reduce(function(s,i){ return s+parseFloat(i.thanhTien); },0);
    
    let originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    btn.disabled = true;

    $.post('<?php echo BASE_URL; ?>warehouse/import',{
        maNhaCC:supplier, tongTien:total,
        ghiChu:document.getElementById('m_importNote').value,
        items:JSON.stringify(mImportItems)
    },function(res){
        if(res.success){ 
            showToast('Tạo phiếu nhập kho thành công', 'success'); 
            setTimeout(() => { location.reload(); }, 3000); 
        }
        else{ 
            showToast('Có lỗi: '+(res.message||''), 'error'); 
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    },'json').fail(function() {
        showToast('Lỗi kết nối internet hoặc máy chủ', 'error'); 
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function mFmt(n){ return new Intl.NumberFormat('vi-VN').format(n)+'đ'; }
</script>
