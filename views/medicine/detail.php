<div class="content-wrapper">
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;max-width:900px;margin:0 auto;">

    <!-- Header -->
    <div style="padding:18px 24px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-eye" style="color:#fff;font-size:17px;"></i>
            </div>
            <div>
                <div style="font-size:17px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.5px;">Chi tiết thuốc</div>
                <div style="font-size:12px;color:rgba(255,255,255,.75);margin-top:2px;">Thông tin đầy đủ về thuốc</div>
            </div>
        </div>
        <a href="javascript:history.back()"
           style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:9px;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div style="padding:24px;">
        <?php if (!$medicine): ?>
        <div style="padding:20px;background:#fef2f2;border:1.5px solid #fecaca;border-radius:9px;color:#b91c1c;font-size:13px;">
            <i class="fas fa-exclamation-triangle"></i> Không thể tải thông tin chi tiết lúc này. Vui lòng thử lại.
        </div>
        <?php else: ?>

        <div style="display:grid;grid-template-columns:240px 1fr;gap:24px;">
            <!-- Ảnh -->
            <div style="text-align:center;">
                <?php if (!empty($medicine['hinhAnh'])): ?>
                <img src="<?php echo BASE_URL . 'uploads/medicines/' . $medicine['hinhAnh']; ?>"
                     style="width:100%;max-height:220px;object-fit:contain;border-radius:12px;border:1.5px solid #e2e8f0;" alt="Hình thuốc">
                <?php else: ?>
                <div style="width:100%;height:200px;background:#f0f7ff;border-radius:12px;border:1.5px solid #bfdbfe;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-pills" style="font-size:48px;color:#93c5fd;"></i>
                </div>
                <?php endif; ?>

                <?php if (isAdmin()): ?>
                <div style="margin-top:16px;">
                    <a href="<?php echo BASE_URL; ?>medicine/edit/<?php echo $medicine['maThuoc']; ?>"
                       style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:9px;background:#fefce8;color:#ca8a04;border:1px solid #fde68a;font-size:13px;font-weight:600;text-decoration:none;">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Thông tin -->
            <div>
                <h2 style="font-size:20px;font-weight:800;color:#1e293b;margin:0 0 4px;"><?php echo htmlspecialchars($medicine['tenThuoc']); ?></h2>
                <div style="font-size:13px;color:#64748b;margin-bottom:16px;">Mã thuốc: <strong><?php echo $medicine['maThuoc']; ?></strong></div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
                    <div style="padding:12px 14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:4px;">Danh mục</div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($medicine['tenDanhMuc']); ?></div>
                    </div>
                    <div style="padding:12px 14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:4px;">Đơn vị tính</div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($medicine['donViTinh']); ?></div>
                    </div>
                    <div style="padding:12px 14px;background:#eff6ff;border-radius:10px;border:1px solid #bfdbfe;">
                        <div style="font-size:11px;color:#3b82f6;font-weight:600;text-transform:uppercase;margin-bottom:4px;">Giá bán</div>
                        <div style="font-size:18px;font-weight:800;color:#1d4ed8;"><?php echo formatCurrency($medicine['giaBan']); ?></div>
                    </div>
                    <div style="padding:12px 14px;background:<?php echo $medicine['soLuongTon'] <= 10 ? '#fef2f2' : '#f0fdf4'; ?>;border-radius:10px;border:1px solid <?php echo $medicine['soLuongTon'] <= 10 ? '#fecaca' : '#bbf7d0'; ?>;">
                        <div style="font-size:11px;color:<?php echo $medicine['soLuongTon'] <= 10 ? '#dc2626' : '#16a34a'; ?>;font-weight:600;text-transform:uppercase;margin-bottom:4px;">Tồn kho</div>
                        <div style="font-size:18px;font-weight:800;color:<?php echo $medicine['soLuongTon'] <= 10 ? '#dc2626' : '#15803d'; ?>;"><?php echo $medicine['soLuongTon']; ?></div>
                    </div>
                    <div style="padding:12px 14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:4px;">Hạn sử dụng</div>
                        <div style="font-size:14px;font-weight:600;color:<?php echo strtotime($medicine['hanSuDung']) < time() ? '#dc2626' : '#1e293b'; ?>;">
                            <?php echo date('d/m/Y', strtotime($medicine['hanSuDung'])); ?>
                        </div>
                    </div>
                    <div style="padding:12px 14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;margin-bottom:4px;">Xuất xứ</div>
                        <div style="font-size:14px;font-weight:600;color:#1e293b;"><?php echo htmlspecialchars($medicine['xuatXu'] ?? '--'); ?></div>
                    </div>
                </div>

                <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:700;
                    background:<?php echo $medicine['trangThai'] == 'DangBan' ? '#f0fdf4' : '#f8fafc'; ?>;
                    color:<?php echo $medicine['trangThai'] == 'DangBan' ? '#15803d' : '#64748b'; ?>;
                    border:1px solid <?php echo $medicine['trangThai'] == 'DangBan' ? '#bbf7d0' : '#e2e8f0'; ?>;">
                    <i class="fas <?php echo $medicine['trangThai'] == 'DangBan' ? 'fa-check-circle' : 'fa-ban'; ?>"></i>
                    <?php echo $medicine['trangThai'] == 'DangBan' ? 'Đang bán' : 'Ngừng bán'; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($medicine['thanhPhan']) || !empty($medicine['congDung']) || !empty($medicine['cachDung'])): ?>
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid #e2e8f0;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;">
            <?php if (!empty($medicine['thanhPhan'])): ?>
            <div style="padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                <div style="font-size:12px;font-weight:700;color:#475569;text-transform:uppercase;margin-bottom:8px;"><i class="fas fa-flask" style="color:#2563eb;margin-right:6px;"></i>Thành phần</div>
                <p style="font-size:13px;color:#64748b;margin:0;line-height:1.6;"><?php echo nl2br(htmlspecialchars($medicine['thanhPhan'])); ?></p>
            </div>
            <?php endif; ?>
            <?php if (!empty($medicine['congDung'])): ?>
            <div style="padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                <div style="font-size:12px;font-weight:700;color:#475569;text-transform:uppercase;margin-bottom:8px;"><i class="fas fa-heartbeat" style="color:#16a34a;margin-right:6px;"></i>Công dụng</div>
                <p style="font-size:13px;color:#64748b;margin:0;line-height:1.6;"><?php echo nl2br(htmlspecialchars($medicine['congDung'])); ?></p>
            </div>
            <?php endif; ?>
            <?php if (!empty($medicine['cachDung'])): ?>
            <div style="padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
                <div style="font-size:12px;font-weight:700;color:#475569;text-transform:uppercase;margin-bottom:8px;"><i class="fas fa-info-circle" style="color:#d97706;margin-right:6px;"></i>Cách dùng</div>
                <p style="font-size:13px;color:#64748b;margin:0;line-height:1.6;"><?php echo nl2br(htmlspecialchars($medicine['cachDung'])); ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</div>
</div>