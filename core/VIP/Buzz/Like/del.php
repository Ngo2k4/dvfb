<?php
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $check_id = mysqli_query($conn, "SELECT id_ctv,post_id FROM buzz_like WHERE id = $id");
        $check = mysqli_fetch_assoc($check_id);
        switch($rule){
            case 'admin':
                $del = mysqli_query($conn, "DELETE FROM buzz_like WHERE id = $id");
                if($del){
                    $content = "<b>$uname</b> vừa xóa VIP Buzz Like ID <b>{$check['post_id']}</b>";
                    $time = time();
                    $ins = mysqli_query($conn, "INSERT INTO history(content, time, type, id_ctv) VALUES(
                            '$content','$time', 0, $idctv)");
                    if($ins){
                        echo "<script>alert('Xóa thành công');window.location='buzz-like.html';</script>";
                    }
                }
                break;
            case 'member':
            case 'agency':
            case 'freelancer':
                if($check['id_ctv'] == $idctv){
                    $del = mysqli_query($conn, "DELETE FROM buzz_like WHERE id = $id");
                    if($del){
                        $content = "<b>$uname</b> vừa xóa VIP Buzz Like ID <b>{$check['post_id']}</b>";
                        $time = time();
                        $ins = mysqli_query($conn, "INSERT INTO history(content, time, type, id_ctv) VALUES('
                            $content','$time', 0, $idctv)");
                        if($ins){
                            echo "<script>alert('Xóa thành công');window.location='buzz-like.html';</script>";
                        }
                    }
                }else{
                    echo "<script>alert('Bạn không có quyền xóa ID này !!!');window.location='buzz-like.html';</script>";
                }
                break;
        }
    }
?>