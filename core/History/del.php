<?php
if (isset($_GET['id_his'])) {
    $id_his = intval($_GET['id_his']);
    $get = "SELECT id_ctv FROM history WHERE id = $id_his";
    $result = mysqli_query($conn, $get);
    $check = mysqli_fetch_assoc($result);
    if ($rule == 'admin' && $idctv == 1) {
        $sql = "DELETE FROM history WHERE id = $id_his";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php?DS=History');
        }
    } else {
        echo "<script>alert('Địt con mẹ mày định làm gì con chó con này???'); window.location='index.php';</script>";
    }
} else if(isset($_GET['type'])){
    $type = $_GET['type'];
    $sql = "DELETE FROM history WHERE type = $type";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php?DS=History');
        }
}else{
    if ($rule == 'admin' && $idctv == 1) {
        $sql = "DELETE FROM history";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php?DS=History');
        }
    }else{
        echo "<script>alert('Địt con mẹ mày định làm gì con chó con này???'); window.location='index.php';</script>";
    }
}
?>