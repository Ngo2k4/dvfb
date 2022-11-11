<?php
if (isset($_GET['id_cmt'])) {
    $id_cmt = $_GET['id_cmt'];
    $get = "SELECT id_ctv,user_id, end FROM vipcmt WHERE id = $id_cmt";
    $result = mysqli_query($conn, $get);
    $check = mysqli_fetch_assoc($result);
    $ctv = $check['id_ctv'];
    $user_id = $check['user_id'];
    $end = $check['end'];
    if ($rule != 'admin' && $rule != 'agency') {
        if ($check['id_ctv'] != $idctv) {
            echo "<script>alert('Địt con mẹ mày định làm gì con chó con này???'); window.location='trang-chu.html';</script>";
        } else if ($end > time()) {
            echo "<script>alert('ID này vẫn chưa hết hạn'); window.location='ctv-vipid-binh-luan.html';</script>";
        } else {
            $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
            if (mysqli_query($conn, $sql)) {
                $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$ctv";
                if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time,type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: ctv-vipid-binh-luan.html');
                    }
                }
            }
        }
    } else if($rule == 'admin' && $idctv != 1){
        if ($end > time()) {
            echo "<script>alert('ID này vẫn chưa hết hạn'); window.location='index.php?DS=CTV_CMT';</script>";
        }else{
            $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
            if (mysqli_query($conn, $sql)) {
                    $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$ctv";
                    if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: ctv-vipid-binh-luan.html');
                    }
                }
            }
        }
    }else if($rule == 'agency'){
        $layidagency = mysqli_query($conn,"SELECT id_agency FROM ctv WHERE id_ctvs = $ctv");
        $idagency = mysqli_fetch_assoc($layidagency)['id_agency'];
        if($idagency != $idctv){
            echo "<script>alert('CÚT'); window.location='trang-chu.html';</script>";
        }else{
            $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
            if (mysqli_query($conn, $sql)) {
                    $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$ctv";
                if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: ctv-vipid-binh-luan.html');
                    }
                }
            }
         }
    }else{
            $sql = "DELETE FROM vipcmt WHERE id = $id_cmt";
            if (mysqli_query($conn, $sql)) {
                    $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$ctv";
                if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP CMT ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: ctv-vipid-binh-luan.html');
                    }
                }
            }
         }
     }
?>