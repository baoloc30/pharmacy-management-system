<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-boxes" style="color:#fff;font-size:18px;"></i>
      </div>
      <div>
        <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">T&#7891;n Kho Hi&#7879;n T&#7841;i</div>
        <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">C&#7853;p nh&#7853;t s&#7889; l&#432;&#7907;ng t&#7891;n kho</div>
      </div>
    </div>
    <button onclick="document.getElementById('importModal').style.display='flex'"
      style="display:inline-flex;align-items:center;gap:8px;padding:9px 20px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(21,128,61,.35);">
      <i class="fas fa-file-import"></i> Nh&#7853;p kho
    </button>
  </div>
</div>

<?php if (isset($success)): ?>
<div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#15803d;font-size:13px;">
  <i class="fas fa-check-circle"></i> <?php echo $success; ?>
</div>
<?php endif; ?>
<?php if (isset($error)): ?>
<div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:14px;color:#dc2626;font-size:13px;">
  <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
</div>
<?php endif; ?>

<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;justify-content:space-between;">
    <span style="font-size:13px;font-weight:700;color:#fff;">Danh sách tồn kho</span>
    <span style="font-size:12px;color:rgba(255,255,255,.8);"><?php echo count($medicines ?? []); ?> mặt hàng</span>
  </div>
  <form method="POST" action="" id="stockForm">
    <div style="overflow-x:auto;">
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
                placeholder="Nhập SL mới" min="0"
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
function confirmUpdate() {
    const inputs = document.querySelectorAll('.qty-input');
    let changes = [], hasError = false;
    inputs.forEach(function(input) {
        if(input.value !== '') {
            const val = parseInt(input.value);
            if(isNaN(val)||val<0) { hasError=true; input.style.borderColor='#dc2626'; }
            else {
                input.style.borderColor='#e2e8f0';
                const row = input.closest('tr');
                const name = row.cells[1].textContent.trim();
                const old = row.cells[4].querySelector('span').textContent.trim();
                changes.push(`<li style="margin-bottom:4px;">${name}: <b>${old}</b> → <b style="color:#1d4ed8;">${val}</b></li>`);
            }
        }
    });
    if(hasError) { alert('Số lượng không hợp lệ'); return; }
    if(changes.length===0) { alert('Vui lòng nhập ít nhất một số lượng mới'); return; }
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
        <span style="font-size:15px;font-weight:800;color:#fff;">T&#7841;o phi&#7871;u nh&#7853;p kho</span>
      </div>
      <button onclick="closeImportModal()" style="background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>

    <!-- Modal body scroll -->
    <div style="overflow-y:auto;flex:1;padding:18px 22px;display:flex;flex-direction:column;gap:16px;">

      <!-- Bước 1: Chọn thuốc -->
      <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;overflow:hidden;">
        <div style="padding:10px 16px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
          <i class="fas fa-pills" style="color:#fff;font-size:12px;"></i>
          <span style="font-size:12.5px;font-weight:700;color:#fff;">Ch&#7885;n thu&#7889;c nh&#7853;p</span>
        </div>
        <div style="padding:14px 16px;">
          <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:10px;align-items:flex-end;">
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Thu&#7889;c</label>
              <select id="m_medicineSelect" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
                <option value="">-- Ch&#7885;n thu&#7889;c --</option>
                <?php foreach($medicines as $m): ?>
                <option value="<?php echo $m['maThuoc']; ?>"
                        data-name="<?php echo htmlspecialchars($m['tenThuoc']); ?>"
                        data-unit="<?php echo htmlspecialchars($m['donViTinh']); ?>">
                  <?php echo htmlspecialchars($m['tenThuoc']); ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">S&#7889; l&#432;&#7907;ng</label>
              <input type="number" id="m_importQty" min="1" placeholder="0"
                style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">&#272;&#417;n gi&#225; (&#273;)</label>
              <input type="number" id="m_importPrice" min="0" placeholder="0"
                style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">H&#7841;n s&#7917; d&#7909;ng</label>
              <input type="date" id="m_importExpiry"
                style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
            </div>
            <div>
              <button onclick="mAddItem()"
                style="padding:8px 16px;border-radius:7px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:12.5px;font-weight:700;cursor:pointer;white-space:nowrap;">
                <i class="fas fa-plus"></i> Th&#234;m
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
            <span style="font-size:12.5px;font-weight:700;color:#fff;">Danh s&#225;ch thu&#7889;c nh&#7853;p</span>
          </div>
          <span id="m_importCount" style="font-size:11px;color:rgba(255,255,255,.8);">0 m&#7863;t h&#224;ng</span>
        </div>
        <div style="overflow-x:auto;">
          <table style="width:100%;border-collapse:collapse;font-size:12.5px;">
            <thead>
              <tr style="background:#f1f5f9;">
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:left;white-space:nowrap;">T&#234;n thu&#7889;c</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:center;white-space:nowrap;">&#272;VT</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:center;white-space:nowrap;">SL</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:right;white-space:nowrap;">&#272;&#417;n gi&#225;</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:center;white-space:nowrap;">HSD</th>
                <th style="padding:9px 12px;font-size:10.5px;font-weight:700;color:#475569;text-transform:uppercase;text-align:right;white-space:nowrap;">Th&#224;nh ti&#7873;n</th>
                <th style="padding:9px 12px;"></th>
              </tr>
            </thead>
            <tbody id="m_importBody">
              <tr><td colspan="7" style="padding:24px;text-align:center;color:#94a3b8;font-size:12px;">Ch&#432;a c&#243; m&#7863;t h&#224;ng n&#224;o</td></tr>
            </tbody>
            <tfoot>
              <tr style="background:#f0f7ff;border-top:2px solid #dbeafe;">
                <td colspan="5" style="padding:10px 12px;font-size:12.5px;font-weight:700;color:#374151;text-align:right;">T&#7893;ng ti&#7873;n:</td>
                <td style="padding:10px 12px;font-size:15px;font-weight:900;color:#15803d;text-align:right;" id="m_importTotal">0&#273;</td>
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
          <span style="font-size:12.5px;font-weight:700;color:#fff;">Th&#244;ng tin nh&#7853;p kho</span>
        </div>
        <div style="padding:14px 16px;">
          <div style="display:grid;grid-template-columns:1fr 2fr;gap:12px;">
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Nh&#224; cung c&#7845;p <span style="color:#dc2626;">*</span></label>
              <select id="m_supplierSelect" style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
                <option value="">-- Ch&#7885;n nh&#224; cung c&#7845;p --</option>
                <?php foreach($suppliers as $s): ?>
                <option value="<?php echo $s['maNhaCC']; ?>"><?php echo htmlspecialchars($s['tenNhaCC']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label style="font-size:11px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Ghi ch&#250;</label>
              <input type="text" id="m_importNote" placeholder="Ghi ch&#250; th&#234;m..."
                style="width:100%;padding:8px 10px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:12.5px;outline:none;">
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Modal footer -->
    <div style="padding:14px 22px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;background:#fff;">
      <button onclick="closeImportModal()" style="padding:9px 20px;border-radius:9px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;">H&#7911;y</button>
      <button onclick="mSaveImport()" style="padding:9px 24px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 10px rgba(21,128,61,.3);">
        <i class="fas fa-save"></i> L&#432;u phi&#7871;u nh&#7853;p kho
      </button>
    </div>
  </div>
</div>

<script>
let mImportItems = [];

function closeImportModal(){
    document.getElementById('importModal').style.display='none';
}
document.getElementById('importModal').addEventListener('click',function(e){ if(e.target===this) closeImportModal(); });

function mAddItem(){
    let sel=document.getElementById('m_medicineSelect');
    let id=sel.value, name=sel.options[sel.selectedIndex].dataset.name, unit=sel.options[sel.selectedIndex].dataset.unit;
    let qty=parseInt(document.getElementById('m_importQty').value);
    let price=parseFloat(document.getElementById('m_importPrice').value);
    let expiry=document.getElementById('m_importExpiry').value;
    if(!id||!qty||!price||!expiry){ alert('Vui lòng nhập đầy đủ thông tin'); return; }
    mImportItems.push({maThuoc:id,tenThuoc:name,donViTinh:unit,soLuong:qty,donGia:price,hanSuDung:expiry,thanhTien:qty*price});
    mRenderImport();
    sel.value=''; document.getElementById('m_importQty').value=''; document.getElementById('m_importPrice').value=''; document.getElementById('m_importExpiry').value='';
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

function mRemoveItem(i){ mImportItems.splice(i,1); mRenderImport(); }

function mSaveImport(){
    if(mImportItems.length===0){ alert('Vui lòng thêm thuốc vào phiếu nhập'); return; }
    let supplier=document.getElementById('m_supplierSelect').value;
    if(!supplier){ alert('Vui lòng chọn nhà cung cấp'); return; }
    let total=mImportItems.reduce(function(s,i){ return s+parseFloat(i.thanhTien); },0);
    $.post('<?php echo BASE_URL; ?>warehouse/import',{
        maNhaCC:supplier, tongTien:total,
        ghiChu:document.getElementById('m_importNote').value,
        items:JSON.stringify(mImportItems)
    },function(res){
        if(res.success){ alert('Nhập kho thành công'); location.reload(); }
        else{ alert('Có lỗi: '+(res.message||'')); }
    },'json');
}

function mFmt(n){ return new Intl.NumberFormat('vi-VN').format(n)+'đ'; }
</script>
