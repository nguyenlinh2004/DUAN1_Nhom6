<?php
class AdminDonHang
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getAllDonHang()
    {
        try {
            $sql = "SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getAllTrangThaiDonHang()
    {
        try {
            $sql = "SELECT * FROM trang_thai_don_hangs";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
     public function getChiTietDonHangId($id)
    {
        try {
            $sql = "SELECT don_hangs.*, 
            trang_thai_don_hangs.ten_trang_thai,
            tai_khoans.ho_ten,
            tai_khoans.email,
            tai_khoans.so_dien_thoai,
            phuong_thuc_thanh_toans.ten_phuong_thuc
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
            INNER JOIN tai_khoans ON don_hangs.tai_khoan_id = tai_khoans.id
            INNER JOIN phuong_thuc_thanh_toans ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
             WHERE don_hangs.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
     public function getlistSanPhamDonHang($id)
    {
        try {
            $sql = "SELECT chi_tiet_don_hangs.*,san_phams.ten_san_pham 
            FROM chi_tiet_don_hangs
            INNER JOIN san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
            WHERE chi_tiet_don_hangs.don_hang_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getDonHangFromKhachHang($id)
    {
        try {
            $sql = "SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai
            FROM don_hangs
            INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
            where don_hangs.tai_khoan_id = :id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(
                [
                    ':id' => $id
]
            );
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function updateDonHang($don_hang_id, $ten_nguoi_nhan, $sdt_nguoi_nhan, $email_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu)
    {
        try {
            $sql = 'UPDATE don_hangs
            SET ten_nguoi_nhan = :ten_nguoi_nhan,
            sdt_nguoi_nhan = :sdt_nguoi_nhan,
            email_nguoi_nhan = :email_nguoi_nhan,
            dia_chi_nguoi_nhan = :dia_chi_nguoi_nhan,
            ghi_chu = :ghi_chu
            WHERE id = :id
            ';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(
                [

                    ':ten_nguoi_nhan' => $ten_nguoi_nhan,
                    ':sdt_nguoi_nhan' => $sdt_nguoi_nhan,
                    ':email_nguoi_nhan' => $email_nguoi_nhan,
                    ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan,
                    ':ghi_chu' => $ghi_chu,
                    ':id' => $don_hang_id
                    
                ]
            );
            // var_dump('đã lưu');die();

            //lấy id sau khi insert
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function updateHuyDonHang($don_hang_id,$trang_thai_id){
        try {
            $sql='UPDATE don_hangs SET trang_thai_id = :trang_thai_id WHERE id = :id ';
            $stmt=$this->conn->prepare($sql);
            $stmt->execute([
                ':trang_thai_id' => $trang_thai_id,
                ':id' => $don_hang_id
            ]);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>