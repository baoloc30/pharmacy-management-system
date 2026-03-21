<div class="content-wrapper">

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-warehouse" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">T&#7841;o Phi&#7871;u Nh&#7853;p Kho</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">Nh&#7853;p thu&#7889;c t&#7915; nh&#224; cung c&#7845;p</div>
    </div>
  </div>
</div>

<!-- STEP 1: Thêm thuốc -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:12px 20px;background:linear-gradient(135deg,#172554,#1d4ed8);display:flex;align-items:center;gap:8px;">
    <i class="fas fa-pills" style="color:#fff;font-size:13px;"></i>
    <span style="font-size:13px;font-weight:700;color:#fff;">B&#432;&#7899;c 1 &mdash; Ch&#7885;n thu&#7889;c nh&#7853;p</span>
  </div>
  <div style="padding:18px 20px;">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:12px;align-items:flex-end;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Ch&#7885;n thu&#7889;c</label>
        <select id="medicineSelect" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;color:#1e293b;">
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
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">S&#7889; l&#432;&#7907;ng</label>
        <input type="number" id="importQty" min="1" placeholder="0"
          style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">&#272;&#417;n gi&#225; (&#273;)</label>
        <input type="number" id="importPrice" min="0" placeholder="0"
          style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">H&#7841;n s&#7917; d&#7909;ng</label>
        <input type="date" id="importExpiry"
          style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div>
        <button onclick="addImportItem()"
          style="padding:9px 20px;border-radius:8px;border:none;background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;box-shadow:0 2px 8px rgba(30,64,175,.3);">
          <i class="fas fa-plus"></i> Th&#234;m
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
      <span style="font-size:13px;font-weight:700;color:#fff;">B&#432;&#7899;c 2 &mdash; Danh s&#225;ch thu&#7889;c nh&#7853;p</span>
    </div>
    <span id="importCount" style="font-size:12px;color:rgba(255,255,255,.8);">0 m&#7863;t h&#224;ng</span>
  </div>
  <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:left;">T&#234;n thu&#7889;c</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">&#272;VT</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">SL</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">&#272;&#417;n gi&#225;</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:center;">HSD</th>
          <th style="padding:10px 14px;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;white-space:nowrap;text-align:right;">Th&#224;nh ti&#7873;n</th>
          <th style="padding:10px 14px;"></th>
        </tr>
      </thead>
      <tbody id="importBody">
        <tr id="importEmpty">
          <td colspan="7" style="padding:30px;text-align:center;color:#94a3b8;font-size:13px;">Ch&#432;a c&#243; m&#7863;t h&#224;ng n&#224;o</td>
        </tr>
      </tbody>
      <tfoot>
        <tr style="background:#f0f7ff;border-top:2px solid #dbeafe;">
          <td colspan="5" style="padding:12px 14px;font-size:13px;font-weight:700;color:#374151;text-align:right;">T&#7893;ng ti&#7873;n:</td>
          <td style="padding:12px 14px;font-size:16px;font-weight:900;color:#15803d;text-align:right;" id="importTotal">0&#273;</td>
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
    <span style="font-size:13px;font-weight:700;color:#fff;">B&#432;&#7899;c 3 &mdash; Th&#244;ng tin nh&#7853;p kho</span>
  </div>
  <div style="padding:18px 20px;">
    <div style="display:grid;grid-template-columns:1fr 2fr auto;gap:16px;align-items:flex-end;">
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Nh&#224; cung c&#7845;p <span style="color:#dc2626;">*</span></label>
        <select id="supplierSelect" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;color:#1e293b;">
          <option value="">-- Ch&#7885;n nh&#224; cung c&#7845;p --</option>
          <?php foreach($suppliers as $s): ?>
          <option value="<?php echo $s['maNhaCC']; ?>"><?php echo htmlspecialchars($s['tenNhaCC']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Ghi ch&#250;</label>
        <input type="text" id="importNote" placeholder="Ghi ch&#250; th&#234;m..."
          style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;">
      </div>
      <div>
        <button onclick="saveImport()"
          style="padding:10px 28px;border-radius:8px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;box-shadow:0 4px 10px rgba(21,128,61,.3);">
          <i class="fas fa-save"></i> L&#432;u phi&#7871;u nh&#7853;p kho
        </button>
      </div>
    </div>
  </div>
</div>

</div>

<script>
let importItems = [];

function addImportItem() {
    let sel = document.getElementById('medicineSelect');
    let id = sel.value;
    let name = sel.options[sel.selectedIndex].dataset.name;
    let unit = sel.options[sel.selectedIndex].dataset.unit;
    let qty = parseInt(document.getElementById('importQty').value);
    let price = parseFloat(document.getElementById('importPrice').value);
    let expiry = document.getElementById('importExpiry').value;
    if(!id||!qty||!price||!expiry){ alert('Vui lòng nhập đầy đủ thông tin'); return; }
    importItems.push({ maThuoc:id, tenThuoc:name, donViTinh:unit, soLuong:qty, donGia:price, hanSuDung:expiry, thanhTien:qty*price });
    renderImport();
    sel.value='';
    document.getElementById('importQty').value='';
    document.getElementById('importPrice').value='';
    document.getElementById('importExpiry').value='';
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

function removeImportItem(i){ importItems.splice(i,1); renderImport(); }

function saveImport(){
    if(importItems.length===0){ alert('Vui lòng thêm thuốc vào phiếu nhập'); return; }
    let supplier=document.getElementById('supplierSelect').value;
    if(!supplier){ alert('Vui lòng chọn nhà cung cấp'); return; }
    let total=importItems.reduce(function(s,i){ return s+parseFloat(i.thanhTien); },0);
    $.post('<?php echo BASE_URL; ?>warehouse/import',{
        maNhaCC:supplier,
        tongTien:total,
        ghiChu:document.getElementById('importNote').value,
        items:JSON.stringify(importItems)
    },function(res){
        if(res.success){ alert('Nhập kho thành công'); location.reload(); }
        else{ alert('Có lỗi xảy ra: '+(res.message||'')); }
    },'json');
}

function fmt(n){ return new Intl.NumberFormat('vi-VN').format(n)+'đ'; }
</script>
