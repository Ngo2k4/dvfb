<?php
include '../_config.php';
header('Content-Type: text/html; charset=utf-8');
define('CORE_API_HTTP_USR', 'merchant_19002');
define('CORE_API_HTTP_PWD', '19002mQ2L8ifR11axUuCN9PMqJrlAHFS04o');
$bk = 'https://www.baokim.vn/the-cao/restFul/send';
$seri = isset($_POST['txtseri']) ? $_POST['txtseri'] : '';
$sopin = isset($_POST['txtpin']) ? $_POST['txtpin'] : '';
$type = isset($_POST['rule']) ? $_POST['rule'] : '';
//Loai the cao (VINA, MOBI, VIETEL, VTC, GATE)
$mang = isset($_POST['chonmang']) ? $_POST['chonmang'] : '';
$user = isset($_POST['txtuser']) ? $_POST['txtuser'] : '';
$km = 50;
	if($mang=='MOBI'){
			$ten = "Mobifone";
		}
	else if($mang=='VIETEL'){
			$ten = "Viettel";
		}
	else if($mang=='GATE'){
			$ten = "Gate";
		}
	else if($mang=='VNM'){
			$ten = "VietNam Mobile";
		}
	else $ten ="Vinaphone";

//Mã MerchantID dang kí trên Bảo Kim
$merchant_id = '30392';
//Api username 
$api_username = 'vipbestautopro';
//Api Pwd d
$api_password = 'rxZW9PG6gDEr39er5A7R';
//Mã TransactionId 
$transaction_id = time();
//mat khau di kem ma website dang kí trên B?o Kim
$secure_code = '6a1af9ba963c94d6';

$arrayPost = array(
	'merchant_id'=>$merchant_id,
	'api_username'=>$api_username,
	'api_password'=>$api_password,
	'transaction_id'=>$transaction_id,
	'card_id'=>$mang,
	'pin_field'=>$sopin,
	'seri_field'=>$seri,
	'algo_mode'=>'hmac'
);

ksort($arrayPost);

$data_sign = hash_hmac('SHA1',implode('',$arrayPost),$secure_code);

$arrayPost['data_sign'] = $data_sign;

$curl = curl_init($bk);

curl_setopt_array($curl, array(
	CURLOPT_POST=>true,
	CURLOPT_HEADER=>false,
	CURLINFO_HEADER_OUT=>true,
	CURLOPT_TIMEOUT=>30,
	CURLOPT_RETURNTRANSFER=>true,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_HTTPAUTH=>CURLAUTH_DIGEST|CURLAUTH_BASIC,
	CURLOPT_USERPWD=>CORE_API_HTTP_USR.':'.CORE_API_HTTP_PWD,
	CURLOPT_POSTFIELDS=>http_build_query($arrayPost)
));

$data = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

$result = json_decode($data,true);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$time = time();
//$time = time();
if($status==200){
	$xu = 0;
    $amount = $result['amount'];
	switch($amount) {
		case 10000: $xu += 10000; break;
		case 20000: $xu += 20000; break;
		case 30000: $xu += 30000; break;
		case 50000: $xu += 50000; break;
		case 100000: $xu += 100000; break;
		case 200000: $xu += 200000; break;
		case 300000: $xu += 300000; break;
		case 500000: $xu += 500000; break;
		case 1000000: $xu += 1000000; break;
	}

	if($mang == 'GATE'){
		$xu -= $xu * 18 / 100;
	}else if($mang == 'VNM'){
		$xu -= $xu * 22 / 100;
	}else{
		$xu -= $xu * 24.5 / 100;
	}

	if($km > 0){
		$xu += $xu * $km / 100;	
	}else{
		if($type == 'agency'){
			$xu += $xu * 50 / 100;
		}else if($type == 'ctv'){
			$xu += $xu * 50 / 100;	
		}
	}
	
    if($type == 'member' || $type == 'agency'){
        $get = "SELECT id_ctv, name FROM member WHERE user_name='$user'";
    }else{
        $get = "SELECT id_ctvs, name FROM ctv WHERE user_name='$user'";
    }
	$result = mysqli_query($conn, $get);
	$x = mysqli_fetch_assoc($result);
	if(isset($x['id_ctvs'])){
		$id = $x['id_ctvs'];
	}else{
		$id = $x['id_ctv'];
	}
	$name = $x['name'];
        if($type == 'agency' || $type == 'member'){
            $add = "UPDATE member SET bill = bill + $xu WHERE user_name='$user'";
        }else{
            $add = "UPDATE ctv SET bill = bill + $xu WHERE user_name='$user'";
        }
	if(mysqli_query($conn, $add)){
		$content = "<b>$user</b> ( <b>$name</b> ) vừa nạp thành công thẻ <b>$mang</b> mệnh giá <b>".number_format($xu)."</b> VNĐ thành công và được cộng  <b>".number_format($xu)." </b> VNĐ vào tài khoản vip";
		$time = time();
		$his = "INSERT INTO history(content, time, id_ctv,type) VALUES('$content','$time','$id',2)";
		if(mysqli_query($conn, $his)){
			$noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time','$id')";
			if(mysqli_query($conn, $noti)){
				echo "<script>alert('Nạp tiền thành công!!');window.location='http://vip.bestauto.pro/index.php';</script>";
			}
		}
	}
	$file = "success.log";
	$fh = fopen($file,'a') or die("cant open file");
	fwrite($fh,"Tai khoan: ".$user.", Loai the: ".$ten.", Menh gia: ".$amount.", Ma the: ".$sopin.", Seri: ".$seri.", Thoi gian: ".$time);
	fwrite($fh,"\r\n");
	fclose($fh);

}
else{   
    $error = $result['errorMessage'];
    $file = "fail.log";
	$fh = fopen($file,'a') or die("cant open file");
	fwrite($fh,"Tai khoan: ".$user.", Ma the: ".$sopin.", Seri: ".$seri.", Noi dung loi: ".$error.", Thoi gian: ".$time);
	fwrite($fh,"\r\n");
	fclose($fh);
	echo "<script>alert('Nạp tiền thất bại, vui lòng kiểm tra lại!!');window.location = 'http://vip.bestauto.pro/index.php?DS=Charge_Money';</script>";
}

