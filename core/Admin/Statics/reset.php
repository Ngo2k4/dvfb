<?php
if(isset($_GET['id'])){
	$id = $_GET['id'];
    $sql = "UPDATE member SET payment = 0, num_id=0 WHERE id_ctv=$id";
    if(mysqli_query($conn, $sql)){
        header('Location: index.php?DS=Statics');
    }
}else if(isset($_GET['id_ctv'])){
	$id_ctv = $_GET['id_ctv'];
    $sql = "UPDATE ctv SET payment = 0, num_id=0 WHERE id_ctvs=$id_ctv";
    if(mysqli_query($conn, $sql)){
        header('Location: index.php?DS=Statics');
    }
}
?>