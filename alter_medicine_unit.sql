-- Thêm hỗ trợ bán lẻ theo viên/vỉ cho bảng thuoc
-- Chạy file này một lần trên database

ALTER TABLE thuoc
    ADD COLUMN donViLe VARCHAR(50) NULL COMMENT 'Đơn vị lẻ: Viên, Vỉ, Gói...' AFTER donViTinh,
    ADD COLUMN soLuongQuyDoi INT NOT NULL DEFAULT 1 COMMENT 'Số đơn vị lẻ trong 1 đơn vị tính (VD: 1 hộp = 14 viên)' AFTER donViLe,
    ADD COLUMN giaBanLe DECIMAL(15,2) NOT NULL DEFAULT 0 COMMENT 'Giá bán lẻ theo đơn vị lẻ' AFTER soLuongQuyDoi;
