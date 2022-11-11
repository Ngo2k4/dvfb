<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_GET['id_cmt'])) {
    $id_cmt = intval($_GET['id_cmt']);
    $get = "SELECT id_ctv,user_id, end FROM vipcmt WHERE id = $id_cmt";
    $result = mysqli_query($conn, $get);
    $check = mysqli_fetch_assoc($result);
    $ctv = $check['id_ctv'];
    $user_id = $check['user_id'];
    $end = $check['end'];
    if ($rule != 'admin') {
        if ($check['id_ctv'] != $idctv) {
            echo "<script>alert('Địt con mẹ mày định làm gì con chó con này???'); window.location='trang-chu.html';</script>";
        } else if ($end > time()) {
            echo "<script>alert('ID này vẫn chưa hết hạn'); window.location='vip-binh-luan.html';</script>";
        } else {
            $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
            if (mysqli_query($conn, $sql)) {
                    $up = "UPDATE member SET num_id = num_id - 1 WHERE id_ctv=$ctv";
                if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time,type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: vip-binh-luan.html');
                    }
                }
            }
        }
    } else if($rule == 'admin' && $idctv != 1){
        // if ($end > time()) {
        //     echo "<script>alert('ID này vẫn chưa hết hạn'); window.location='index.php?DS=Manager_VIP_CMT';</script>";
        // }else{
            $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
            if (mysqli_query($conn, $sql)) {
                    $up = "UPDATE member SET num_id = num_id - 1 WHERE id_ctv=$ctv";
                    if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: vip-binh-luan.html');
                    }
                }
            }
        // }
    }else{
        $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
        if (mysqli_query($conn, $sql)) {
                    $up = "UPDATE member SET num_id = num_id - 1 WHERE id_ctv=$ctv";
            if(mysqli_query($conn, $up)){
                $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                $time = time();
                $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                if (mysqli_query($conn, $his)) {
                    header('Location: vip-binh-luan.html');
                }
            }
        }
    }
}
?>