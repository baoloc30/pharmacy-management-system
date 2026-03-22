<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-truck" style="color:#fff;font-size:18px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Danh sách nhà cung cấp</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Quản lý thông tin nhà cung cấp</div>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <form method="GET" action="" style="display:flex;gap:0;">
                <input type="text" name="search" placeholder="Tìm theo tên, SĐT, địa chỉ..."
                       value="<?php echo htmlspecialchars($search ?? ''); ?>"
                       style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-right:none;border-radius:9px 0 0 9px;font-size:13px;background:rgba(255,255,255,.9);color:#1e293b;outline:none;width:220px;">
                <button type="submit"
                        style="padding:9px 14px;border:1.5px solid rgba(255,255,255,.4);border-left:none;border-radius:0 9px 9px 0;background:rgba(255,255,255,.2);color:#fff;cursor:pointer;font-size:13px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a href="<?php echo BASE_URL; ?>supplier/add"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 2px 8px rgba(21,128,61,.35);">
                <i class="fas fa-plus"></i> Thêm NCC
            </a>
        </div>
    </div>

    <div style="padding:16px 24px 24px;overflow-x:auto;">
        <?php if (empty($suppliers)): ?>
        <div style="padding:32px;text-align:center;color:#64748b;font-size:14px;">
            <i class="fas fa-truck" style="font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block;"></i>
            Không tìm thấy nhà cung cấp phù hợp.
        </div>
        <?php else: ?>
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
            <thead>
                <tr style="background:linear-gradient(135deg,#172554,#1d4ed8);">
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Mã NCC</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Tên nhà cung cấp</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Địa chỉ</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Số điện thoại</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Email</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:left;font-size:11px;letter-spacing:.4px;">Người liên hệ</th>
                    <th style="padding:11px 14px;color:#fff;font-weight:700;text-transform:uppercase;white-space:nowrap;text-align:center;font-size:11px;letter-spacing:.4px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $i => $s): ?>
                <tr style="background:<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>;transition:background .15s;"
                    onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='<?php echo $i % 2 === 0 ? '#fff' : '#f0f7ff'; ?>'">
                    <td style="padding:10px 14px;color:#64748b;"><?php echo $s['maNhaCC']; ?></td>
                    <td style="padding:10px 14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($s['tenNhaCC']); ?></td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($s['diaChi'] ?? ''); ?></td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($s['soDienThoai'] ?? ''); ?></td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($s['email'] ?? ''); ?></td>
                    <td style="padding:10px 14px;color:#475569;"><?php echo htmlspecialchars($s['nguoiLienHe'] ?? ''); ?></td>
                    <td style="padding:10px 14px;text-align:center;">
                        <a href="<?php echo BASE_URL; ?>supplier/edit/<?php echo $s['maNhaCC']; ?>"
                           style="display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:7px;background:#fefce8;color:#ca8a04;border:1px solid #fde68a;text-decoration:none;" title="Chỉnh sửa">
                            <i class="fas fa-edit" style="font-size:12px;"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</div>
