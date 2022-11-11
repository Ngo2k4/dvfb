<?php
ob_start();
session_start();
if(isset($_SESSION['login'])){
    unset($_SESSION['id_ctv']);
    unset($_SESSION['rule']);
    unset($_SESSION['user_name']);
    unset($_SESSION['pass']);
    unset($_SESSION['status']);
    unset($_SESSION['login']);
}else{
	header('Location: trang-chu.html');
}
echo "<script>alert('Đăng xuất thành công');window.location='trang-chu.html';</script>";
?>