<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_GET['id_react'])) {
    $id_react = intval($_GET['id_react']);
    $get = "SELECT id_ctv,user_id, end FROM vipreaction WHERE id = $id_react";
    $result = mysqli_query($conn, $get);
    $check = mysqli_fetch_assoc($result);
    $ctv = $check['id_ctv'];
    $user_id = $check['user_id'];
    $end = $check['end'];
    if ($rule != 'admin') {
        if ($check['id_ctv'] != $idctv) {
            echo "<script>alert('Địt con mẹ mày định làm gì con chó con này???'); window.location='trang-chu.html';</script>";
        } else if ($end > time()) {
            echo "<script>alert('ID này vẫn chưa hết hạn'); window.location='vip-bot-cam-xuc.html';</script>";
        } else {
            $sql = "DELETE FROM vipreaction WHERE id = $id_react";
            if (mysqli_query($conn, $sql)) {
                if($rule != 'freelancer'){
                    $up = "UPDATE member SET num_id = num_id - 1 WHERE id_ctv=$idctv";
                }else{
                    $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$idctv";
                }
                if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP REACTION ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: vip-bot-cam-xuc.html');
                    }
                }
            }
        }
    } else if($rule == 'admin' && $idctv != 1){
        // if ($end > time()) {
        //     echo "<script>alert('ID này vẫn chưa hết hạn'); window.location='index.php?DS=Manager_VIP_Reaction';</script>";
        // }else{
            $sql = "DELETE FROM vipreaction WHERE id = $id_react";
            if (mysqli_query($conn, $sql)) {
                if($rule != 'freelancer'){
                    $up = "UPDATE member SET num_id = num_id - 1 WHERE id_ctv=$idctv";
                }else{
                    $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$idctv";
                }
                if(mysqli_query($conn, $up)){
                    $content = "<b> $uname </b>vừa xóa VIP Reaction ID <b> $user_id </b>";
                    $time = time();
                    $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: vip-bot-cam-xuc.html');
                    }
                }
            }
        // }
    }else{
        $sql = "DELETE FROM vipreaction WHERE id = $id_react";
        if (mysqli_query($conn, $sql)) {
            if($rule != 'freelancer'){
                $up = "UPDATE member SET num_id = num_id - 1 WHERE id_ctv=$ctv";
            }else{
                $up = "UPDATE ctv SET num_id = num_id - 1 WHERE id_ctvs=$ctv";
            }
            if(mysqli_query($conn, $up)){
                $content = "<b> $uname </b>vừa xóa VIP Reaction ID <b> $user_id </b>";
                $time = time();
                $his = "INSERT INTO history(content, id_ctv, time, type) VALUES('$content','$idctv','$time',0)";
                if (mysqli_query($conn, $his)) {
                    header('Location: vip-bot-cam-xuc.html');
                }
            }
        }
    }
}
?>