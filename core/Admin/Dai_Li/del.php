<?php
if ($rule != 'admin' || $idctv != 1) {
    header('Location: index.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $get = "SELECT user_name, name, rule FROM member WHERE id_ctv = $id";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        $name = $x['name'];
        $u_name = $x['user_name'];
        $xoanoti = "DELETE FROM noti WHERE id_ctv = $id";
        mysqli_query($conn, $xoanoti);
        $xoahis = "DELETE FROM history WHERE id_ctv = $id";
        mysqli_query($conn, $xoahis);
        $xoa = "DELETE FROM member WHERE id_ctv = $id";
        if (mysqli_query($conn, $xoa)) {
            $content = "<b>$uname</b> vừa xóa CTV <b>$name ( $u_name )</b>";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',1)";
            if (mysqli_query($conn, $his)) {
                header('Location: dai-li.html');
            }
        }
    } 
}  
?>