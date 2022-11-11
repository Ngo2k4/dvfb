<?php
if(isset($_POST['token'])){
	$token = $_POST['token'];
	$me = json_decode(file_get_contents('https://graph.fb.me/me?access_token='.$token),true);
	if($me['id']){
		$app = json_decode(file_get_contents('https://graph.fb.me/app?access_token='.$token),true);
		if($app['id'] == '6628568379' || $app['id'] == '350685531728'){
			$id = $me['id'];
			$name = $me['name'];
			echo $id.'_'.$name;
		}else{
			echo "Vui lòng sử dụng Token Full quyền để cài đặt VIP!!_Vui lòng sử dụng Token Full quyền để cài đặt VIP!!_";
		}
	}else{
		echo "Token hết hạn hoặc không hợp lệ!!_Token hết hạn hoặc không hợp lệ!!";
	}
}
?>