<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_GET['email'], $_GET['code'])) {
    $email = $_GET['email'];
    $code = $_GET['code'];
    $new_code = substr(md5(time() + rand(0, 9)), 0, 8);
    $sql = "SELECT status,id_ctv,name FROM member WHERE email='$email' AND code='$code'";
    $result = mysqli_query($conn, $sql);
    $s = mysqli_fetch_assoc($result);
    if (isset($s['status']) && $s['status'] == 0) {
        $active = "UPDATE member SET status = 1, code='$new_code' WHERE email='$email' AND code='$code'";
        if (mysqli_query($conn, $active)) {
            $cont = "Chào mừng <b>{$s['name']}</b> đến với hệ thống VIP Like <b>Vip.BestAuto.Pro</b> Bạn nhận được <b>1000 VNĐ từ hệ thống.</b>, vui lòng nạp tiền vào tài khoản để cài đặt VIP. Nếu muốn làm <b>Cộng tác viên, Đại lí</b> vui lòng liên hệ <b>Admin</b>";
            $time = time();
            $id = $s['id_ctv'];
            $noti = "INSERT INTO noti(content, id_ctv, time, status) VALUES('$cont','$id','$time', 0)";
            if (mysqli_query($conn, $noti)) {
                echo "<script>alert('Xác nhận thành công. Vui lòng đăng nhập!'); window.location='dang-nhap.html';</script>";
            }
        }
    } else {
        echo "<script>alert('Liên kết không hợp lệ hoặc đã hết hạn'); window.location='index.php';</script>";
    }
} else {
   header('Location: index.php');
}
?>