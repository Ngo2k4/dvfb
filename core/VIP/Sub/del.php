<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $check  = mysqli_query($conn, 'select id_ctv from vipsub where id = '.$id);
    $info = mysqli_fetch_assoc($check);
    if($rule == 'admin'){
        $del = mysqli_query($conn, 'delete from vipsub where id='.$id);
        if($del){
            echo "<script>alert('Xóa thành công');window.location='sub.html';</script>";
        }
    }else{
        if($info['id_ctv'] == $idctv){
            $del = mysqli_query($conn, 'delete from vipsub where id='.$id);
            if($del){
                echo "<script>alert('Xóa thành công');window.location='sub.html';</script>";
            }
        }else{
            echo "<script>alert('Xóa được cặc');window.location='sub.html';</script>";
        }
    }
}