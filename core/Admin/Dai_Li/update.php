<?php

if ($rule != 'admin') {
    echo "<script>alert('CÚT!!');window.location='trang-chu.html';</script>";
} else {
    if (isset($_GET['id'], $_GET['type'])) {
        $id = $_GET['id'];
        $get = "SELECT name, user_name FROM member WHERE id_ctv=$id";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if ($_GET['type'] == 'lock') {
            $sql = "UPDATE member SET status = -1 WHERE id_ctv = $id";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> đã <b> Khóa</b> tài khoản của Đại lí <b>{$x['name']} ({$x['user_name']})</b>";
                $time = time();
                $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    echo "<script>alert('Thành công'); window.location='dai-li.html';</script>";
                }
            }
        } else if ($_GET['type'] == 'unlock') {
            $sql = "UPDATE member SET status = 1 WHERE id_ctv = $id";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> đã <b> Mở Khóa</b> tài khoản của Đại lí <b>{$x['name']} ({$x['user_name']})</b>";
                $time = time();
                $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    $cnt = "Đại lí <b>{$x['name']} ({$x['user_name']})</b> vừa được <b>$uname</b> mở khóa!!";
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                    if (mysqli_query($conn, $noti)) {
                        echo "<script>alert('Thành công'); window.location='dai-li.html';</script>";
                    }
                }
            }
        } else {
            $sql = "UPDATE member SET status = 1 WHERE id_ctv = $id";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> đã <b> Kích hoạt</b> tài khoản của Đại lí <b>{$x['name']} ({$x['user_name']})</b>";
                $time = time();
                $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    $cnt = "CTV <b>{$x['name']} ({$x['user_name']})</b> vừa được <b>$uname</b> kích hoạt!!";
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                    if (mysqli_query($conn, $noti)) {
                        echo "<script>alert('Thành công'); window.location='dai-li.html';</script>";
                    }
                }
            }
        }
    }
}
?>