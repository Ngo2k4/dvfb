<?php
if ($rule != 'admin' && $rule != 'agency') {
    echo "<script>alert('CÚT!!');window.location='trang-chu.html'';</script>";
} else {
    if (isset($_GET['id_ctv'], $_GET['type'])) {
        $id = $_GET['id_ctv'];
        $get = "SELECT name, user_name,id_agency FROM ctv WHERE id_ctvs=$id";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if ($rule != 'admin' && $rule !='agency') {
            if ($x['id_agency'] != $idctv) {
                echo "<script>alert('CÚT');window.location='trang-chu.html';</script>";
            }
        } else {
            if ($_GET['type'] == 'lock') {
                $sql = "UPDATE ctv SET status = -1 WHERE id_ctvs = $id";
                if (mysqli_query($conn, $sql)) {
                    $content = "<b>$uname</b> đã <b>  Khóa</b> tài khoản của CTV <b>{$x['name']} ({$x['user_name']})</b>";
                    $time = time();
                    $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                    if (mysqli_query($conn, $his)) {
                        echo "<script>alert('Thành công'); window.location='cong-tac-vien.html';</script>";
                    }
                }
            } else if ($_GET['type'] == 'unlock') {
                $sql = "UPDATE ctv SET status = 1 WHERE id_ctvs = $id";
                if (mysqli_query($conn, $sql)) {
                    $content = "<b>$uname</b> đã <b> Mở Khóa</b> tài khoản của CTV <b>{$x['name']} ({$x['user_name']})</b>";
                    $time = time();
                    $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                    if (mysqli_query($conn, $his)) {
                        $cnt = "CTV <b>{$x['name']} ({$x['user_name']})</b> vừa được <b>$uname</b> mở khóa!!";
                        $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                        if (mysqli_query($conn, $noti)) {
                            echo "<script>alert('Thành công'); window.location='cong-tac-vien.html';</script>";
                        }
                    }
                }
            } else {
                $sql = "UPDATE ctv SET status = 1 WHERE id_ctvs = $id";
                if (mysqli_query($conn, $sql)) {
                    $content = "<b>$uname</b> đã <b> Kích hoạt</b> tài khoản của CTV <b>{$x['name']} ({$x['user_name']})</b>";
                    $time = time();
                    $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                    if (mysqli_query($conn, $his)) {
                        $cnt = "CTV <b>{$x['name']} ({$x['user_name']})</b> vừa được <b>$uname</b> kích hoạt!!";
                        $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                        if (mysqli_query($conn, $noti)) {
                            echo "<script>alert('Thành công'); window.location='cong-tac-vien.html';</script>";
                        }
                    }
                }
            }
        }
    }
}
?>