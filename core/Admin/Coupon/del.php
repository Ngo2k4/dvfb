<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php if($rule != 'admin') header('Location: trang-chu.html'); ?>
<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $del = "DELETE FROM coupon WHERE id=$id";
        if(mysqli_query($conn, $del)){
             echo "<script>alert('Xóa thành công');window.location='coupon.html';</script>";
        }
    }
?>