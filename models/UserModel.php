<?php
require_once 'core/Model.php';

class UserModel extends Model {
    protected $table = 'taikhoan';
    protected $primaryKey = 'idTaiKhoan';

    public function login($username, $password) {
        $sql = "SELECT t.*, n.hoTen FROM taikhoan t 
                JOIN nhanvien n ON t.maNhanVien = n.maNhanVien 
                WHERE t.tenDangNhap = ? OR n.email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            if (password_verify($password, $user['matKhau'])) {
                return $user;
            }
            if ($user['matKhau'] === $password) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $upd = $this->db->prepare("UPDATE taikhoan SET matKhau=? WHERE idTaiKhoan=?");
                $upd->bind_param("si", $newHash, $user['idTaiKhoan']);
                $upd->execute();
                return $user;
            }
        }
        return false;
    }

    public function getProfile($userId) {
        $sql = "SELECT t.*, n.* FROM taikhoan t 
                JOIN nhanvien n ON t.maNhanVien = n.maNhanVien 
                WHERE t.idTaiKhoan = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($userId, $data) {
        $sql = "UPDATE nhanvien SET hoTen=?, email=?, soDienThoai=?, diaChi=?, ngaySinh=?, gioiTinh=?
                WHERE maNhanVien = (SELECT maNhanVien FROM taikhoan WHERE idTaiKhoan = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssi",
            $data['hoTen'], $data['email'], $data['soDienThoai'],
            $data['diaChi'], $data['ngaySinh'], $data['gioiTinh'], $userId
        );
        return $stmt->execute();
    }

    public function changePassword($userId, $oldPass, $newPass) {
        $sql = "SELECT matKhau FROM taikhoan WHERE idTaiKhoan = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            $valid = password_verify($oldPass, $user['matKhau'])
                  || $user['matKhau'] === $oldPass; // plain text fallback
            if ($valid) {
                $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                $sql = "UPDATE taikhoan SET matKhau = ? WHERE idTaiKhoan = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("si", $newHash, $userId);
                return $stmt->execute();
            }
        }
        return false;
    }

    public function resetPassword($username, $soDienThoai) {
        $sql = "SELECT t.idTaiKhoan FROM taikhoan t
                JOIN nhanvien n ON t.maNhanVien = n.maNhanVien
                WHERE t.tenDangNhap = ? AND n.soDienThoai = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $soDienThoai);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) return false;

        $row     = $result->fetch_assoc();
        $newHash = password_hash('123456', PASSWORD_DEFAULT);
        $upd     = $this->db->prepare("UPDATE taikhoan SET matKhau = ? WHERE idTaiKhoan = ?");
        $upd->bind_param("si", $newHash, $row['idTaiKhoan']);
        return $upd->execute();
    }

    public function usernameExists($username) {
        $sql = "SELECT idTaiKhoan FROM taikhoan WHERE tenDangNhap = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function emailExists($email) {
        $sql = "SELECT maNhanVien FROM nhanvien WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function phoneExists($phone) {
        $sql = "SELECT maNhanVien FROM nhanvien WHERE soDienThoai = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function findByUsername($username) {
        $sql = "SELECT t.idTaiKhoan, t.tenDangNhap, t.matKhau, t.trangThai, n.email 
                FROM taikhoan t JOIN nhanvien n ON t.maNhanVien = n.maNhanVien
                WHERE t.tenDangNhap = ? OR n.email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createEmployee($employeeData, $accountData) {
        $this->db->begin_transaction();
        try {
            $sql = "INSERT INTO nhanvien (hoTen, soDienThoai, email, diaChi, ngaySinh, gioiTinh) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssss",
                $employeeData['hoTen'], $employeeData['soDienThoai'],
                $employeeData['email'], $employeeData['diaChi'],
                $employeeData['ngaySinh'], $employeeData['gioiTinh']);

            $stmt->execute();
            $maNhanVien = $stmt->insert_id;

            $hashedPass = password_hash($accountData['matKhau'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO taikhoan (maNhanVien, tenDangNhap, matKhau, vaiTro) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("isss", $maNhanVien, $accountData['tenDangNhap'], $hashedPass, $accountData['vaiTro']);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return $e->getMessage(); 
        }
    }

    public function getEmployeeById($id) {
        $sql = "SELECT t.*, n.* FROM taikhoan t 
                JOIN nhanvien n ON t.maNhanVien = n.maNhanVien 
                WHERE t.idTaiKhoan = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateEmployee($id, $data) {
        try {
            $sql = "UPDATE nhanvien n JOIN taikhoan t ON n.maNhanVien = t.maNhanVien
                    SET n.hoTen=?, n.soDienThoai=?, n.email=?, n.diaChi=?, n.ngaySinh=?, n.gioiTinh=?, t.vaiTro=?
                    WHERE t.idTaiKhoan=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssssssi",
                $data['hoTen'], $data['soDienThoai'], $data['email'],
                $data['diaChi'], $data['ngaySinh'], $data['gioiTinh'],
                $data['vaiTro'], $id
            );
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function emailExistsExclude($email, $idTaiKhoan) {
        $sql = "SELECT n.maNhanVien FROM nhanvien n JOIN taikhoan t ON n.maNhanVien = t.maNhanVien WHERE n.email = ? AND t.idTaiKhoan != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $email, $idTaiKhoan);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function phoneExistsExclude($phone, $idTaiKhoan) {
        $sql = "SELECT n.maNhanVien FROM nhanvien n JOIN taikhoan t ON n.maNhanVien = t.maNhanVien WHERE n.soDienThoai = ? AND t.idTaiKhoan != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $phone, $idTaiKhoan);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getAllEmployees() {
        $sql = "SELECT t.*, n.hoTen, n.soDienThoai, n.email FROM taikhoan t 
                JOIN nhanvien n ON t.maNhanVien = n.maNhanVien
                ORDER BY n.hoTen";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function deactivate($id) {
        $sql = "UPDATE taikhoan SET trangThai='NgungHoatDong' WHERE idTaiKhoan=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function activate($id) {
        $sql = "UPDATE taikhoan SET trangThai='HoatDong' WHERE idTaiKhoan=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAllPermissions() {
        $sql = "SELECT * FROM quyen";
        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmployeePermissions($maNhanVien) {
        $sql = "SELECT maQuyen FROM phanquyen WHERE maNhanVien = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $maNhanVien);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return array_column($result, 'maQuyen'); 
    }

    public function updateEmployeePermissions($maNhanVien, $permissions) {
        $this->db->begin_transaction();
        try {
            $sqlDel = "DELETE FROM phanquyen WHERE maNhanVien = ?";
            $stmtDel = $this->db->prepare($sqlDel);
            $stmtDel->bind_param("i", $maNhanVien);
            $stmtDel->execute();

            if (!empty($permissions)) {
                $sqlIns = "INSERT INTO phanquyen (maNhanVien, maQuyen) VALUES (?, ?)";
                $stmtIns = $this->db->prepare($sqlIns);
                foreach ($permissions as $maQuyen) {
                    $stmtIns->bind_param("ii", $maNhanVien, $maQuyen);
                    $stmtIns->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
