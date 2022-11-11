<?php

 define("MERCHANT_ID","42238"); // merchant id
 define("CLIENT_ID","47e098fea82d16"); // client id cua ban
 define("CLIENT_SECRET","2cbfa76c312d9b03742a24da9613b186"); // clien secret cua ban

 function exec_curl($type,$serial,$code,$logId,$note)
 {        
        $hash = sign_hash($type,$serial,$code,$logId,$note);
        $url = 'https://thecaoplus.com/api/paycardv2';
        $postdata = 'merchantId='.MERCHANT_ID
                    .'&clientId='.CLIENT_ID
                    .'&type='.$type
                    .'&serial='.urlencode($serial)
                    .'&code='.urlencode($code)
                    .'&logId='.urlencode($logId)
                    .'&note='.urlencode($note)
                    .'&hash='.$hash;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);      
        curl_close($ch);
        return $response;
    }

 function sign_hash($type,$serial,$code,$logId,$note)
    {        
        return md5(MERCHANT_ID.'|'.CLIENT_ID.'|'.$type.'|'.$serial.'|'.$code.'|'.$logId.'|'.$note.'|'.CLIENT_SECRET);
    }

if(isset($_POST['napthe'])){
    $km = 69; // % khuyen mai
    $card       = $_POST['type'];
    $serial     = trim($_POST['seri']);
    $code       = trim($_POST['code']);
    $logId      = time();
    $user       = $_POST['user'];
    $type       = $_POST['rulex'];
    $note       = $user.' nap the';
    $response   = exec_curl($card,$serial,$code,$logId,$note);
    
    /*KẾT QUẢ NẠP THẺ Ở ĐÂY*/
    $response = json_decode($response,true);
    if($response['Code'] > 0){
        $event = false; // trang thai su kien
        $money = (int)$response['Data']['Money'];
        $transId = $response['Data']['TransId'];
        $timex = date('d/m/Y - H:i:s', time());
        //$xu = $money - $money * 2 / 100;
        if($event == true){ // neu co su kien
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
        if($card == 'VTT'){
            //$xu -= $xu * 20 / 100;
            $card = 'Viettel';
        }else if($card == 'VMS'){
            //$xu -= $xu * 20 / 100;
            $card = 'Mobifone';
        }else if($card == 'VNP'){
            //$xu -= $xu * 21 / 100;
            $card = 'Vinaphone';
        }else if($card == 'FPT'){
            //$xu -= $xu * 16 / 100;
            $card = 'FPT GATE';
        }else if($card == 'ZING'){
            //$xu -= $xu * 21 / 100;
            $card = 'Zing VinaGame';
        }else if($card == 'MGC'){
            //$xu -= $xu * 15 / 100;
            $card = 'MegaCard';
        }else if($card == 'ONC'){
            //$xu -= $xu * 22 / 100;
            $card = 'OnCash';
        }else if($card == 'VCARD'){
            //$xu -= $xu * 22 / 100;
            $card = 'VCard';
        }else if($card == 'GC'){
            //$xu -= $xu * 22 / 100;
            $card = 'GCard';
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
            $content = "<b>$user</b> ( <b>$name</b> ) vừa nạp thành công thẻ <b>$card</b> mệnh giá <b>".number_format($money)."</b> VNĐ thành công và được cộng  <b>".number_format($xu)." </b> VNĐ vào tài khoản vip. Mã giao dịch <b>$transId</b>";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv,type) VALUES('$content','$time','$id',2)";
            if(mysqli_query($conn, $his)){
                $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time','$id')";
                if(mysqli_query($conn, $noti)){
                    echo "<script>alert('$name đã nạp thành công thẻ $card mệnh giá ".number_format($money)." VNĐ thành công và được cộng $xu VNĐ vào tài khoản!!!');window.location='nap-tien.html';</script>";
                }
            }
        }
        $fp = fopen("Card/napthethanhcong.txt","a+");
        $noidung = "Ma the: $code, Seri: $seri, Username: $user, Menh gia: $money, So du duoc cong: $xu, Ma giao dich: $transId, Thoi gian: $timex \n";
        fwrite($fp, $noidung);
        fclose($fp);
    }else{
        $fp = fopen("Card/napthethatbai.txt","a+");
        $noidung = "Ma the: $code, Seri: $seri, Username: $user\n";
        fwrite($fp, $noidung);
        fclose($fp);
        echo "<script>alert('Mã thẻ không hợp lệ hoặc đã được sử dụng. Vui lòng thử lại hoặc liên hệ Admin nếu có nhầm lẫn!!!!');window.location = 'nap-tien.html'</script>";
    }
    /*object trả về*/
    //var_dump($response);die();
}
$k = 69;
?>
<form class="form-horizontal" role="form" method="post" action="#">
<div class="form-group">
    <label for="card_type_id" class="col-lg-2 control-label">Loại thẻ</label>
    <div class="col-lg-10">
      <select name="type" class="form-control" data-toggle="tooltip" title="Chọn loại thẻ" <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
        <option value="VTT">Viettel</option>
        <option value="VMS">Mobiphone</option>
        <option value="VNP">Vinaphone</option>
        <option value="FPT">Gate</option>
        <option value="ZING">Zing</option>
        <option value="MGC">Megacard</option>
        <option value="ONC">OnCash</option>
        <option value="VCARD">VCard</option>
        <option value="GC">GCard</option>
    </select>
    </div>
  </div>
    <div class="form-group">
    <label for="rule" class="col-lg-2 control-label">Bạn là ? (Chọn đúng)</label>
    <div class="col-lg-10">
        <input type="radio" class="rule" name="rulex" value="agency" data-toggle="tooltip" data-title="Click chọn nếu bạn là đại lí" onchange="check()" onmouseleave="check()" <?php if(isset($rule) && $rule == 'agency') echo 'checked'; ?> required> Đại lí <?php if($k>0){?><code>+ <?php echo $k; ?>%</code><?php }else{ ?><code>+10 %</code><?php } ?><br />
      <input type="radio" class="rule" name="rulex" value="freelancer" data-toggle="tooltip" data-title="Click chọn nếu bạn là cộng tác viên" onchange="check()" onmouseleave="check()" <?php if(isset($rule) && $rule == 'freelancer') echo 'checked'; ?> required> Cộng tác viên <?php if($k>0){?><code>+ <?php echo $k; ?>%</code><?php }else{ ?><code>+5 % </code> <?php } ?><br />
      <input type="radio" class="rule" name="rulex" value="member" data-toggle="tooltip" data-title="Click chọn nếu bạn là thành viên" onchange="check()" onmouseleave="check()" <?php if(isset($rule) && $rule == 'member') echo 'checked'; ?> required>Thành viên <?php if($k>0){?><code>+ <?php echo $k; ?>%</code><?php } ?>
    </div>
  </div>
  <div class="form-group">
    <label for="user" class="col-lg-2 control-label"><font color="red">Tài khoản: </font></label>
    <div class="col-lg-10">
      <input type="text" onchange="check();"  onkeyup="check();" id="user" style="width: 400px" class="form-control"  name="user" value="<?php echo isset($uname) ? $uname : ''; ?>" placeholder="Nhập chính xác tên tài khoản" data-toggle="tooltip" data-title="Nhập chính xác tên tài khoản" required <?php echo isset($uname) ? 'readonly' : ''; ?>/>
      <span id="check"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="txtpin" class="col-lg-2 control-label">Mã thẻ</label>
    <div class="col-lg-10">
      <input type="text" style="width: 400px"class="form-control" id="code" name="code" placeholder="Mã thẻ" data-toggle="tooltip" data-title="Mã số sau lớp bạc mỏng" required <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
    </div>
  </div>
  <div class="form-group">
    <label for="txtseri" class="col-lg-2 control-label">Số seri</label>
    <div class="col-lg-10">
      <input type="text" style="width: 400px"class="form-control" id="seri" name="seri" placeholder="Số seri" data-toggle="tooltip" data-title="Mã seri nằm sau thẻ" required <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
    </div>
  </div>

  <div class="form-group">
    <div style="text-align:center">
      <button type="submit" class="btn btn-primary" id="submit" name="napthe"<?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>><?php echo isset($rule) && $rule == 'admin' ? 'Không khả dụng' : 'Nạp thẻ'; ?></button>
    </div>
  </div> 
</form>
<script>
 $('#submit').click(function(){
     if($('input[name=rulex]').val() && $('#user').val() && $('#code').val() && $('#seri').val()){
        $(this).addClass('btn btn-info').html('<i class="fa fa-spin fa-spinner"></i>Đang xử lí thẻ....');
     }
 });
 function check(){
  if($('#user').val() != ''){
    $.get('Card/check.php', { user: $('#user').val(), rule: $('input[name=rulex]:checked').val() }, function(result){ $('#check').html(result); });
    }
  }
</script>