<?php
require_once 'core/Model.php';

class CustomerModel extends Model {
    protected $table = 'khachhang';
    protected $primaryKey = 'maKhachHang';

    public function getAllCustomers($search = '') {
        if (!empty($search)) {
            $sql = "SELECT *, COALESCE(tongChiTieu, 0) as tongChiTieu 
                    FROM {$this->table} 
                    WHERE hoTen LIKE ? OR soDienThoai LIKE ? OR email LIKE ? 
                    ORDER BY maKhachHang DESC";
            $s = "%$search%";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $s, $s, $s);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }
        $result = $this->db->query("SELECT *, COALESCE(tongChiTieu, 0) as tongChiTieu FROM {$this->table} ORDER BY maKhachHang DESC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getCustomerById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE maKhachHang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createCustomer($data) {
        $sql = "INSERT INTO {$this->table} (hoTen, soDienThoai, email, diaChi, ngaySinh, gioiTinh) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssss", 
            $data['hoTen'], 
            $data['soDienThoai'], 
            $data['email'], 
            $data['diaChi'], 
            $data['ngaySinh'], 
            $data['gioiTinh']
        );
        return $stmt->execute();
    }

    public function updateCustomer($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                hoTen = ?, 
                soDienThoai = ?, 
                email = ?, 
                diaChi = ?, 
                ngaySinh = ?, 
                gioiTinh = ? 
                WHERE maKhachHang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssi", 
            $data['hoTen'], 
            $data['soDienThoai'], 
            $data['email'], 
            $data['diaChi'], 
            $data['ngaySinh'], 
            $data['gioiTinh'],
            $id
        );
        return $stmt->execute();
    }

    public function deleteCustomer($id) {
        // Check if customer has any orders
        $sql = "SELECT COUNT(*) as count FROM hoadon WHERE maKhachHang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if ($result['count'] > 0) {
            return false; // Cannot delete customer with orders
        }
        
        $sql = "DELETE FROM {$this->table} WHERE maKhachHang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getTotalCustomers($search = '') {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (hoTen LIKE ? OR soDienThoai LIKE ? OR email LIKE ?)";
            $searchParam = "%{$search}%";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc()['total'];
        }
        
        return $this->db->query($sql)->fetch_assoc()['total'];
    }

    public function searchCustomers($keyword) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE hoTen LIKE ? OR soDienThoai LIKE ? OR email LIKE ? 
                ORDER BY hoTen ASC LIMIT 10";
        $searchParam = "%{$keyword}%";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function phoneExists($phone) {
        $sql = "SELECT maKhachHang FROM {$this->table} WHERE soDienThoai=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function phoneExistsExcept($phone, $excludeId) {
        $sql = "SELECT maKhachHang FROM {$this->table} WHERE soDienThoai=? AND maKhachHang!=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $phone, $excludeId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function findByPhone($phone) {
        $sql = "SELECT * FROM {$this->table} WHERE soDienThoai=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function lastId() {
        return $this->db->insert_id;
    }
}
