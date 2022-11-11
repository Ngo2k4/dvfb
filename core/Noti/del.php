<?php
if (isset($_GET['id_noti'])) {
    $id_noti = intval($_GET['id_noti']);
    $get = "SELECT id_ctv FROM noti WHERE id = $id_noti";
    $result = mysqli_query($conn, $get);
    $check = mysqli_fetch_assoc($result);
    if ($rule != 'admin') {
        if ($check['id_ctv'] != $idctv) {
            echo "<script>alert('Địt con mẹ mày định làm gì con chó con này???'); window.location='index.php';</script>";
        } else {
            $sql = "DELETE FROM noti WHERE id = $id_noti";
            if (mysqli_query($conn, $sql)) {
                header('Location: index.php?DS=Notify');
            }
        }
    } else {
        $sql = "DELETE FROM noti WHERE id = $id_noti";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php?DS=Notify');
        }
    }
}else{
    if($idctv == 1 && $rule == 'admin'){
        $sql = "DELETE FROM noti";
        if(mysqli_query($conn, $sql)){
            header('Location: index.php?DS=Notify');
        }
    }else{
        header('Location: index.php');
    }
}
?>