<?php
    if($rule != 'admin' || $rule != 'agency'){
        header('Location: /trang-chu.html');
    }
?>
<?php
if (isset($_GET['id_gift'])) {
    $id_gift = $_GET['id_gift'];
    $get = "SELECT code FROM gift WHERE id=$id_gift";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $code = $x['code'];
    $sql = "DELETE FROM gift WHERE id = $id_gift";
    if (mysqli_query($conn, $sql)) {
        $content = "<b>$uname</b> vừa xóa Gift Code <b>$name</b>";
        $time = time();
        $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',3)";
        if (mysqli_query($conn, $his)) {
            header('Location: gift-code.html');
        }
    }
}else{
    if($rule == 'admin'){
        $sql = "DELETE FROM gift";
        if (mysqli_query($conn, $sql)) {
            $content = "<b>$uname</b> vừa xóa toàn bộ Gift Code";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',3)";
            if (mysqli_query($conn, $his)) {
                header('Location: gift-code.html');
            }
        }
    }else if($rule == 'agency'){
        $sql = "DELETE FROM gift WHERE id_ctv=$idctv";
        if (mysqli_query($conn, $sql)) {
            $content = "<b>$uname</b> vừa xóa toàn bộ Gift Code";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',3)";
            if (mysqli_query($conn, $his)) {
                header('Location: gift-code.html');
            }
        }
    }
}
?>