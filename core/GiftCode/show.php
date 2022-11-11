<?php
include '../../_config.php';
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT code, billing,COUNT(*) FROM gift WHERE id_ctv = $id AND status=0 GROUP BY code,billing";
	$result = mysqli_query($conn, $sql);
	while($x=mysqli_fetch_assoc($result)){
		if($x['COUNT(*)'] > 0){
			echo "Mã Gift: {$x['code']}\nMệnh giá: " .number_format($x['billing'])." VNĐ \n \n";
		}else{
			echo 'Chưa có GIFT Code nào !!!';
		}
	}
}