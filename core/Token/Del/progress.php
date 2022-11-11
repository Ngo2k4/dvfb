<?php
include '../../../_config.php';
if(isset($_GET['token'], $_GET['table'])){
	$token = trim($_GET['token']);
	$table = trim($_GET['table']);
}else{
	header('location: index.php');
}
$sql = "DELETE FROM $table WHERE access_token = '$token'";
if(mysqli_query($conn, $sql)){
	echo 'Success';
}else{
	echo 'Failed';
}
?>