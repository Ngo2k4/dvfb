<?php
defined('COPYRIGHT') OR exit('hihi');
if ($rule != 'admin') {
    echo "<script>alert('CÚT!!');window.location='index.php';</script>";
} else {
    if (isset($_GET['id_ctv'], $_GET['type'])) {
        $id = intval($_GET['id_ctv']);
        $get = "SELECT name, user_name FROM member WHERE id_ctv=$id";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if ($_GET['type'] == 'lock') {
            $sql = "UPDATE member SET status = -1 WHERE id_ctv = $id";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> đã <b>Khóa</b> tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                $time = time();
                $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                }
            }
        } else if ($_GET['type'] == 'unlock') {
            $sql = "UPDATE member SET status = 1 WHERE id_ctv = $id";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> đã <b> Mở Khóa</b> tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                $time = time();
                $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                if (mysqli_query($conn, $his)) {
                    $cnt = "<b>{$x['name']} ({$x['user_name']})</b> vừa được <b>$uname</b> mở khóa!!";
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                    if (mysqli_query($conn, $noti)) {
                        echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                    }
                }
            }
        } else {
            if (($idctv == 1 && $rule == 'admin') && $id !=1) {
                if ($_GET['type'] == 'up') {
                    $sql = "UPDATE member SET rule = 'admin' WHERE id_ctv = $id";
                    if (mysqli_query($conn, $sql)) {
                        $content = "<b>$uname</b> đã <b> Set quyền Admin </b> cho tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                        $time = time();
                        $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                        if (mysqli_query($conn, $his)) {
                            $cnt = "<b>{$x['name']} ({$x['user_name']})</b> vừa được <b>$uname</b> chọn làm Admin!!!";
                            $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                            if (mysqli_query($conn, $noti)) {
                                echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                            }
                        }
                    }
                } else if($_GET['type'] == 'down'){
                    $sql = "UPDATE member SET rule = 'member' WHERE id_ctv = $id";
                    if (mysqli_query($conn, $sql)) {
                        $content = "<b>$uname</b> đã <b> Xóa quyền Admin </b> tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                        $time = time();
                        $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                        if (mysqli_query($conn, $his)) {
                            $cnt = "<b>{$x['name']} ({$x['user_name']})</b> vừa bị <b>$uname</b> xóa quyền Admin!!!";
                            $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                            if (mysqli_query($conn, $noti)) {
                                echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                            }
                        }
                    }
                }else if($_GET['type'] == 'up_agency' && $rule == 'admin'){
                    $sql = "UPDATE member SET rule = 'agency' WHERE id_ctv = $id";
                    if (mysqli_query($conn, $sql)) {
                        $content = "<b>$uname</b> đã set <b> Đại lí </b> cho tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                        $time = time();
                        $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                        if (mysqli_query($conn, $his)) {
                            $cnt = "<b>{$x['name']} ({$x['user_name']})</b> đã được <b>$uname</b> set <b>Đại lí</b>!!!";
                            $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                            if (mysqli_query($conn, $noti)) {
                                echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                            }
                        }
                    }
                }else if($_GET['type'] == 'active'){
                    $sql = "UPDATE member SET status = '1' WHERE id_ctv = $id";
                    if (mysqli_query($conn, $sql)) {
                        $content = "<b>$uname</b> đã đã <b> Kích hoạt </b>  tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                        $time = time();
                        $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                        if (mysqli_query($conn, $his)) {
                            $cnt = "<b>{$x['name']} ({$x['user_name']})</b> đã được <b>$uname</b> <b>Kích hoạt</b>!!!";
                            $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                            if (mysqli_query($conn, $noti)) {
                                echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                            }
                        }
                    }
                }else{
                    $sql = "UPDATE member SET rule = 'member' WHERE id_ctv = $id";
                    if (mysqli_query($conn, $sql)) {
                        $content = "<b>$uname</b> đã <b> gỡ bỏ Đại lí </b> tài khoản của <b>{$x['name']} ({$x['user_name']})</b>";
                        $time = time();
                        $his = "INSERT INTO history(content, time , id_ctv, type) VALUES('$content','$time', '$idctv',1)";
                        if (mysqli_query($conn, $his)) {
                            $cnt = "<b>{$x['name']} ({$x['user_name']})</b> đã bị <b>$uname</b> <b>gỡ bỏ Đại lí</b>!!!";
                            $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$cnt','$time','$id')";
                            if (mysqli_query($conn, $noti)) {
                                echo "<script>alert('Thành công'); window.location='index.php?DS=List_Member';</script>";
                            }
                        }
                    }
                }
            }else{
                echo "<script>alert('Cút'); window.location='index.php?DS=List_Member';</script>";
            }
        }
    }
}
?>