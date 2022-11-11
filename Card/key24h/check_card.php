<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset($_POST['key'], $_POST['code'], $_POST['serial'], $_POST['user'], $_POST['rulex']))
{
    include 'config.php';
    include 'card_charging_api.php';
    include '../../_config.php';
    
    // Call lib
    try {
        $api = new Card_charging_api($config);
    }
    catch (Card_charging_Exception $e) {
        exit($e->getMessage());
    }
    $timex = date('d/m/Y - H:i:s', time());
    $user = $_POST['user'];
    $key	    = $_POST['key']; //loai the cua nha mang
    $code	    = $_POST['code']; // ma the
    $serial		= $_POST['serial']; //serial the
    $request_id = time(); //Mã tự sinh trong mỗi giao dịch và không giống nhau (Chúng tôi sẽ lưu lại mã này để đối chiếu khi có khiếu nại)
    
    $res = $api->check_card($key, $code, $serial, $request_id);
    //var_dump($res);
    
    //echo '<pre>';
    //print_r($res);
    
    //thành công
    if(isset($res->status) && $res->status == '0')
    {
        $amount     = $res->amount; //mệnh giá thẻ
        $key        = $res->key; //Loại thẻ
        $serial     = $res->serial; //serial
        $code       = $res->code; //mã thẻ
        $request_id =  $res->amount; //request_id ma đối tác gửi sang
        $transid    = $res->transid; //mã giao dịch bên key24h.com
        $xu = $amount - $amount * 2 / 100;
        $event = false;
        $km = 0;
        $type = $_POST['rulex'];
        if($event == true){
            if($xu >= 20000 && $xu <= 50000){
                mysqli_query($conn, "UPDATE event SET turn = turn + 1, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            }else if($xu > 50000 && $xu <= 100000){
                mysqli_query($conn, "UPDATE event SET turn = turn + 2, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            }else if($xu > 100000 && $xu <= 300000){
                mysqli_query($conn, "UPDATE event SET turn = turn + 3, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            }else if($xu > 300000 && $xu <= 500000){
                mysqli_query($conn, "UPDATE event SET turn = turn + 5, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            }else if($xu > 500000){
                mysqli_query($conn, "UPDATE event SET turn = turn + 7, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            }
        }
        if($type == 'member' || $type == 'agency'){
                $get = "SELECT id_ctv, name,rule FROM member WHERE user_name='$user'";
                $result = mysqli_query($conn, $get);
                $x = mysqli_fetch_assoc($result);
                $id = $x['id_ctv'];
                $name = $x['name'];
            }else if($type == 'freelancer'){
                $get = "SELECT id_ctvs, name FROM ctv WHERE user_name='$user'";
                $result = mysqli_query($conn, $get);
                $x = mysqli_fetch_assoc($result);
                $id = $x['id_ctvs'];
                $name = $x['name'];
            }
            if($km > 0){
                $xu += $xu * $km / 100;
            }else{
                if($type == 'freelancer'){
                    $xu += $xu * 5 / 100; 
                }else if($type == 'agency'){
                    $xu += $xu * 10 / 100; 
                }
            }
            if($type == 'agency' || $type == 'member'){
                $add = "UPDATE member SET bill = bill + $xu WHERE user_name='$user'";
            }else{
                $add = "UPDATE ctv SET bill = bill + $xu WHERE user_name='$user'";
            }
            if(mysqli_query($conn, $add)){
                $content = "<b>$user</b> ( <b>$name</b> ) vừa nạp thành công thẻ <b>$mang</b> mệnh giá <b>".number_format($amount)."</b> VNĐ thành công và được cộng  <b>".number_format($xu)." </b> VNĐ vào tài khoản vip. Mã giao dịch <b>$transid</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv,type) VALUES('$content','$time','$id',2)";
                if(mysqli_query($conn, $his)){
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time','$id')";
                    if(mysqli_query($conn, $noti)){
                        echo "<script>alert('Nạp tiền thành công!!! Cảm ơn $name đã sử dụng dịch vụ tại VIP.BestAuto.Pro!!!');window.location='/nap-tien.html';</script>";
                    }
                }
            }
            $fp = fopen("napthethanhcong.txt","a+");
            $noidung = "Ma the: $code, Seri: $serial, Username: $user, Menh gia: $amount, So du duoc cong: $xu, Ma giao dich: $transid, Thoi gian: $timex \n";
            fwrite($fp, $noidung);
            fclose($fp);
        }
       // echo "<script>alert('Nạp thẻ thành công!!!');window.location='nap-tien.html';</script>";
    //có lỗi
    else
    {
        $fp = fopen("napthethatbai.txt","a+");
        $noidung = "Ma the: $code, Seri: $serial, Username: $user, Thoi gian: $timex \n";
        fwrite($fp, $noidung);
        fclose($fp);
        echo "<script>alert('Thẻ sai hoặc đã được sử dụng.Vui lòng thử lại!!!');window.location='/nap-tien.html';</script>";
    }
}else{
    echo "<script>alert('Vui lòng nhập đầy đủ dữ liệu');window.location='/nap-tien.html';</script>";
}
      
		