<?php
if (($rule != 'admin' || $idctv != 1) && $rule !='agency') {
    header('Location: index.php');
} else {
    if (isset($_GET['id_ctv'])) {
        $id = $_GET['id_ctv'];
        $get = "SELECT user_name, name, rule,id_agency FROM ctv WHERE id_ctvs = $id";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        $name = $x['name'];
        $u_name = $x['user_name'];
        $rl = $x['rule'];
        if($rule != 'admin'){
            if($x['id_agency'] != $idctv){
                echo "<script>alert('CÚT!!');window.location='trang-chu.html';</script>";
            }else{
                $xoanoti = "DELETE FROM noti WHERE id_ctv = $id";
                mysqli_query($conn, $xoanoti);
                $xoahis = "DELETE FROM history WHERE id_ctv = $id";
                mysqli_query($conn, $xoahis);
                $xoa = "DELETE FROM ctv WHERE id_ctvs = $id";
                if (mysqli_query($conn, $xoa)) {
                    $content = "<b>$uname</b> vừa xóa CTV <b>$name ( $u_name )</b>";
                    $time = time();
                    $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',1)";
                    if (mysqli_query($conn, $his)) {
                        header('Location: cong-tac-vien.html');
                    }
                }
            }
        }else{
            $xoanoti = "DELETE FROM noti WHERE id_ctv = $id";
            mysqli_query($conn, $xoanoti);
            $xoahis = "DELETE FROM history WHERE id_ctv = $id";
            mysqli_query($conn, $xoahis);
            $xoa = "DELETE FROM ctv WHERE id_ctvs = $id";
            if (mysqli_query($conn, $xoa)) {
                $content = "<b>$uname</b> vừa xóa CTV <b>$name ( $u_name )</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    header('Location: cong-tac-vien.html');
                }
            }
        }
    }
}
?>