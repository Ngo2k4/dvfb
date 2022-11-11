<?php
include '../_config.php';
if(isset($_GET['user'], $_GET['rule'])){
	$user = $_GET['user'];
    $type= $_GET['rule'];
    $rule = 'Thành viên';
    if($type == 'member'){
        $get = "SELECT COUNT(*), name, email, bill FROM member WHERE user_name='$user' AND rule = 'member' GROUP BY name, email, bill";
    }else if($type == 'agency'){
    	$rule = 'Đại lí';
        $get = "SELECT COUNT(*), name, email, bill FROM member WHERE user_name='$user' AND rule = 'agency' GROUP BY name, email, bill";
    }else{
    	$rule = 'Cộng tác viên';
    	$get = "SELECT COUNT(*), name, email,bill FROM ctv WHERE user_name='$user' GROUP BY name, email,bill";
    }
	$result = mysqli_query($conn, $get);
	$x = mysqli_fetch_assoc($result);
	$c = $x['COUNT(*)'];
	$name = $x['name'];
	$xemail = str_replace(substr($x['email'],2,2), '**', $x['email']);
	$yemail = str_replace(substr($xemail,-5,4), '****', $xemail);
	$email = str_replace(substr($yemail,stripos($yemail,'@')-2,2), '**', $yemail);
	$bill = number_format($x['bill']);
	if($c == 1){
		echo "Username: <font color='red'><b>$user</b></font><br /> Name: <font color='red'><b>$name</b></font><br /> Email: <font color='red'><b>$email</b></font><br />Loại tài khoản: <font color='red'><b>$rule</b></font><br />Số dư hiện tại: <font color='red'><b>$bill</b> VNĐ</font><br /><font color='red'>Bạn có thể nạp tiền cho tài khoản này</font>";
	}else{
		echo "<code>Không tìm thấy tài khoản này hoặc bạn đã chọn loại tài khoản không chính xác. Chú ý phải nhập đúng tên tài khoản và chọn đúng loại tài khoản để được cộng tiền khi nạp thành công. Chúng tôi không giải quyết các vấn đề lỗi nạp tiền khi bạn làm không đúng hướng dẫn từ hệ thống!</code>";
	}
}else{
	echo '<code>Vui lòng chọn đầy đủ thông tin <b>Loại tài khoản</b> và <b> Tên tài khoản </b> chính xác!!!</code>';
}
?>