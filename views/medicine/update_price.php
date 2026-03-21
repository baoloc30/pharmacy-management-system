<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
        <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-tag" style="color:#fff;font-size:18px;"></i>
        </div>
        <div>
            <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Cập nhật giá thuốc</div>
            <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Nhập giá mới vào ô tương ứng rồi nhấn Cập nhật</div>
        </div>
    </div>

    <div style="padding:16px 24px 24px;">
        <?php if (isset($success)): ?>
        <div style="margin-bottom:14px;padding:11px 16px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:9px;color:#15803d;font-size:13px;font-weight:600;">
            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
        </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <div style="margin-bottom:14px;padding:11px 16px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;font-weight:600;">
            <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="" id="priceForm">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Mã</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Tên thuốc</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Danh mục</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">ĐVT</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:right;font-size:11px;letter-spacing:.4px;">Giá hiện tại</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Giá mới</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:right;font-size:11px;letter-spacing:.4px;">Tồn kho</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">HSD</th>
                            <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicines as $i => $m): ?>
                        <tr style="background:<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>;transition:background .15s;"
                            onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>'">
                            <td style="padding:9px 14px;color:#64748b;"><?php echo $m['maThuoc']; ?></td>
                            <td style="padding:9px 14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($m['tenThuoc']); ?></td>
                            <td style="padding:9px 14px;color:#475569;"><?php echo htmlspecialchars($m['tenDanhMuc']); ?></td>
                            <td style="padding:9px 14px;color:#475569;"><?php echo htmlspecialchars($m['donViTinh']); ?></td>
                            <td style="padding:9px 14px;text-align:right;font-weight:600;color:#1e293b;"><?php echo formatCurrency($m['giaBan']); ?></td>
                            <td style="padding:9px 14px;">
                                <input type="number" class="price-input"
                                    name="giaMoi[<?php echo $m['maThuoc']; ?>]"
                                    placeholder="Nhập giá mới" min="1"
                                    style="width:130px;padding:7px 10px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13px;outline:none;transition:all .2s;"
                                    onfocus="this.style.borderColor='#2563eb';this.style.boxShadow='0 0 0 3px rgba(37,99,235,.1)'"
                                    onblur="this.style.borderColor='#cbd5e1';this.style.boxShadow='none'">
                            </td>
                            <td style="padding:9px 14px;text-align:right;color:#475569;"><?php echo $m['soLuongTon']; ?></td>
                            <td style="padding:9px 14px;color:#475569;"><?php echo date('d/m/Y', strtotime($m['hanSuDung'])); ?></td>
                            <td style="padding:9px 14px;">
                                <?php if ($m['trangThai'] == 'DangBan'): ?>
                                <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Đang bán
                                </span>
                                <?php else: ?>
                                <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;">
                                    <i class="fas fa-circle" style="font-size:7px;"></i> Ngừng KD
                                </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="display:flex;justify-content:flex-end;margin-top:16px;">
                <button type="button" onclick="confirmUpdate()"
                    style="padding:10px 26px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 12px rgba(21,128,61,.3);">
                    <i class="fas fa-save"></i> Cập nhật giá
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Overlay xác nhận -->
<div id="confirmOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;box-shadow:0 8px 40px rgba(0,0,0,.2);width:100%;max-width:460px;overflow:hidden;">
        <div style="padding:16px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:10px;">
            <i class="fas fa-tag" style="color:#fff;"></i>
            <span style="font-size:15px;font-weight:700;color:#fff;">Xác nhận cập nhật giá</span>
        </div>
        <div style="padding:20px 24px;max-height:300px;overflow-y:auto;">
            <div id="confirmBody" style="font-size:13px;color:#374151;"></div>
        </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;">
            <button onclick="document.getElementById('confirmOverlay').style.display='none'"
                    style="padding:9px 20px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-size:13px;font-weight:600;cursor:pointer;">
                Từ chối
            </button>
            <button onclick="document.getElementById('priceForm').submit()"
                    style="padding:9px 20px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;cursor:pointer;">
                Đồng ý
            </button>
        </div>
    </div>
</div>

<script>
function confirmUpdate() {
    const inputs = document.querySelectorAll('.price-input');
    let changes = [], hasError = false;
    inputs.forEach(input => {
        if (input.value !== '') {
            const val = parseFloat(input.value);
            if (isNaN(val) || val <= 0) {
                hasError = true;
                input.style.borderColor = '#ef4444';
                input.style.boxShadow = '0 0 0 3px rgba(239,68,68,.1)';
            } else {
                input.style.borderColor = '#cbd5e1';
                input.style.boxShadow = 'none';
                const row = input.closest('tr');
                changes.push('<li style="margin-bottom:4px;">' + row.cells[1].textContent.trim() + ': ' + row.cells[4].textContent.trim() + ' &rarr; <strong>' + new Intl.NumberFormat('vi-VN').format(val) + 'đ</strong></li>');
            }
        }
    });
    if (hasError) { alert('Giá không hợp lệ, vui lòng kiểm tra lại!'); return; }
    if (changes.length === 0) { alert('Vui lòng nhập ít nhất một giá mới'); return; }
    document.getElementById('confirmBody').innerHTML = '<p style="margin-bottom:10px;">Các thuốc sẽ thay đổi giá:</p><ul style="padding-left:18px;">' + changes.join('') + '</ul>';
    document.getElementById('confirmOverlay').style.display = 'flex';
}
document.getElementById('confirmOverlay').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
