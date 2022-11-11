<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php
if ($rule != 'admin' || $idctv != 1) {
    header('Location: index.php');
} else {
    if (isset($_GET['id_ctv'])) {
        $id = intval($_GET['id_ctv']);
        $get = "SELECT user_name, name, rule FROM member WHERE id_ctv = $id";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        $name = $x['name'];
        $u_name = $x['user_name'];
        $rl = $x['rule'];
        if($id == 1){
            echo "<script>alert('CÚT!!');window.location='index.php';</script>";
        }else if($rl == 'admin' && $idctv !=1){
            echo "<script>alert('CÚT!!');window.location='index.php';</script>";
        }else{
            $xoanoti = "DELETE FROM noti WHERE id_ctv = $id";
            mysqli_query($conn, $xoanoti);
            $xoahis = "DELETE FROM history WHERE id_ctv = $id";
            mysqli_query($conn, $xoahis);
            $xoa = "DELETE FROM member WHERE id_ctv = $id";
            if (mysqli_query($conn, $xoa)) {
                $content = "<b>$uname</b> vừa xóa Member <b>$name ( $u_name )</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    header('Location: index.php?DS=List_Member');
                }
            }
        }
    }
}
?>