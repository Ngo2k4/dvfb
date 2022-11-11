<?php
include '../../../_config.php';
if(isset($_POST['tb'], $_POST['t'], $_POST['uid'], $_POST['name'])){
	$tb = $_POST['tb'];
	$token = $_POST['t'];
	$uid = $_POST['uid'];
	$gender = isset($_POST['gender']) ? $_POST['gender'] : 'undefined';
	$name = urldecode($_POST['name']);
	$get_uid = mysqli_query($conn, "SELECT COUNT(*) FROM $tb WHERE user_id = '$uid'");
	$check = mysqli_fetch_assoc($get_uid);
	if($check['COUNT(*)'] > 0){
		echo 'fail';
	}else{
		if($tb == 'autocmt'){
			$sql = mysqli_query($conn, "INSERT INTO $tb(user_id,name,access_token,gender) VALUES('$uid','$name','$token','$gender')");
		}else{
			$sql = mysqli_query($conn, "INSERT INTO $tb(user_id,name,access_token) VALUES('$uid','$name','$token')");
		}
		if($sql){
			echo 'success';
		}
	}
}
?>