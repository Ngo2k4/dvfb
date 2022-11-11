<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<script>
    $(document).ready(function(){
        $(".form-control, .rule").tooltip();
    });
</script>
<?php
 function get_curl($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        $str = curl_exec($curl);
        if(empty($str)) $str = $this->curl_exec_follow($curl);
        curl_close($curl);
        return $str;
    }
 function signature_hash($parnerID, $secreckey,$telco,$serial,$mathe,$tranid)
    {
        return md5($parnerID.'-'.$secreckey.'-'.$telco.'-'.$serial.'-'.$mathe.'-'.$tranid);
    }
if(isset($_POST['napthe'])){
    if($_POST['card_type_id'] == 'VIP'){
        $code = $_POST['pin'];
        $seri= $_POST['seri'];
        $sql = mysqli_query($conn,"SELECT billing,id_use, COUNT(*) FROM card WHERE code='$code' AND seri='$seri' AND status = 0 GROUP BY billing,id_use");
        $tien = mysqli_fetch_assoc($sql);
        if($tien['COUNT(*)'] == 1){
            if($tien['id_use'] == $idctv){
                $price = $tien['billing'];
                if($rule == 'member' || $rule == 'agency'){
                    $update = "UPDATE member SET bill = bill + $price WHERE id_ctv=$idctv";
                }else{
                    $update = "UPDATE ctv SET bill = bill + $price WHERE id_ctvs=$idctv";
                }
                if(mysqli_query($conn, $update)){
                    mysqli_query($conn,"UPDATE card SET status = 1 WHERE code='$code' AND seri='$seri'");
                    $content = "<b>{$_POST['user']}</b> đã nạp thành công thẻ <b>BestAuto VIP Card</b> Mệnh giá <b>".number_format($price)." VNĐ </b>";
                    $time = time();
                    $noti = "INSERT INTO noti(id_ctv,content,time) VALUES('$idctv','$content','$time')";
                    if(mysqli_query($conn, $noti)){
                        $his = "INSERT INTO history(id_ctv,content,time,type) VALUES('$idctv','$content','$time',2)";
                        if(mysqli_query($conn, $his)){
                            echo "<script>alert('Nạp thẻ thành công!!!');window.location='nap-tien.html';</script>";
                        }
                    }
                }
            }else{
                echo "<script>alert('Thẻ này không thuộc sở hữu của bạn. Tham gia sự kiện Trung thu 2017 để nhận thẻ miễn phí!!!!').window.location='nap-tien.html';</script>";
            }
        }else{
            echo "<script>alert('Thẻ sai hoặc đã được sử dụng!!!').window.location='nap-tien.html';</script>";
        }
    }else{
        $event = false;
        $km = 69;
        $TxtCard = $_POST['card_type_id'];
        $TxtMaThe = $_POST['pin'];
        $TxtSeri= $_POST['seri'];
        $user = $_POST['user'];
        $type = $_POST['rulex'];
        $url = 'http://api.banthe247.com/CardCharge.ashx';
        $url .= '?partnerId=16862';
        $url .= '&telco='.$TxtCard;
        $url .= '&serial='.$TxtSeri;
        $url .= '&cardcode='.$TxtMaThe;
        $transid = rand().'_16862';
        $url .= '&transId='.$transid;
        $url .= '&key='.signature_hash('16862','518529757_89037_D247',$TxtCard,$TxtSeri,$TxtMaThe,$transid);
        $response = get_curl($url);
        $duysex = json_decode($response,true);
        $code =  $duysex['ResCode'];
        $magiaodich = $duysex['TransId'];
        $message = $duysex['Message'];
        if($code == 1){
            $timex = date('d/m/Y - H:i:s', time());
            $menhgia = $duysex['Amount'];
            $xu = 0;
            switch($menhgia){
                case '10,000':
                    $xu += 10000;
                    break;
                case '20,000':
                    $xu += 20000;
                    break;
                case '30,000':
                    $xu += 30000;
                    break;
                case '40,000':
                    $xu += 40000;
                    break;
                case '50,000':
                    $xu += 50000;
                    break;
                case '60,000':
                    $xu += 60000;
                    break;
                case '70,000':
                    $xu += 70000;
                    break;
                case '80,000':
                    $xu += 80000;
                    break;
                case '90,000':
                    $xu += 90000;
                    break;
                case '100,000':
                    $xu += 100000;
                    break;
                case '200,000':
                    $xu += 200000;
                    break;
                case '300,000':
                    $xu += 300000;
                    break;
                case '400,000':
                    $xu += 400000;
                    break;
                case '500,000':
                    $xu += 500000;
                    break;
                case '1,000,000':
                case '1000,000':
                    $xu += 1000000;
                    break;
            }
           // $xu -= $xu * 3 / 100;
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
            if($TxtCard == 'VTT'){
                //$xu -= $xu * 20 / 100;
                $mang = 'Viettel';
            }else if($TxtCard == 'VMS'){
                //$xu -= $xu * 20 / 100;
                $mang = 'Mobifone';
            }else if($TxtCard == 'VNP'){
                //$xu -= $xu * 21 / 100;
                $mang = 'Vinaphone';
            }else if($TxtCard == 'FPT'){
                //$xu -= $xu * 16 / 100;
                $mang = 'GATE';
            }else if($TxtCard == 'VNM'){
                //$xu -= $xu * 21 / 100;
                $mang = 'Vietnammobile';
            }else if($TxtCard == 'MGC'){
                //$xu -= $xu * 15 / 100;
                $mang = 'MegaCard';
            }else if($TxtCard == 'ONC'){
                //$xu -= $xu * 22 / 100;
                $mang = 'OnCash';
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
                $content = "<b>$user</b> ( <b>$name</b> ) vừa nạp thành công thẻ <b>$mang</b> mệnh giá <b>".$menhgia."</b> VNĐ thành công và được cộng  <b>".number_format($xu)." </b> VNĐ vào tài khoản vip. Mã giao dịch <b>$magiaodich</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv,type) VALUES('$content','$time','$id',2)";
                if(mysqli_query($conn, $his)){
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time','$id')";
                    if(mysqli_query($conn, $noti)){
                        echo "<script>alert('$name đã nạp thành công thẻ $mang mệnh giá $menhgia VNĐ thành công và được cộng $xu VNĐ vào tài khoản!!!');window.location='trang-chu.html';</script>";
                    }
                }
            }
            $fp = fopen("Card/napthethanhcong.txt","a+");
            $noidung = "Ma the: $TxtMaThe, Seri: $TxtSeri, Username: $user, Menh gia: $menhgia, So du duoc cong: $xu, Ma giao dich: $magiaodich, Message: $message, Thoi gian: $timex \n";
            fwrite($fp, $noidung);
            fclose($fp);
        }else{
            $fp = fopen("Card/napthethatbai.txt","a+");
            $noidung = "Ma the: $TxtMaThe, Seri: $TxtSeri, Username: $user\n";
            fwrite($fp, $noidung);
            fclose($fp);
            echo "<script>alert('Mã thẻ không hợp lệ hoặc đã được sử dụng. Vui lòng thử lại hoặc liên hệ Admin nếu có nhầm lẫn!!!!');window.location = 'nap-tien.html'</script>";
        }
    }      
}
$k = 69;
?> 
<form class="form-horizontal" role="form" method="post" action="#">
<div class="form-group">
    <label for="card_type_id" class="col-lg-2 control-label">Loại thẻ</label>
    <div class="col-lg-10">
      <select name="card_type_id" class="form-control" data-toggle="tooltip" title="Chọn loại thẻ" <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
        
        <option value="VTT">Viettel</option>
        <option value="VMS">Mobiphone</option>
        <option value="VNP">Vinaphone</option>
        <option value="FPT">Gate</option>
        <option value="VNM">Vietnammobile</option>
        <option value="MGC">Megacard</option>
        <option value="ONC">OnCash</option>
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
      <input type="text" style="width: 400px"class="form-control" id="pin" name="pin" placeholder="Mã thẻ" data-toggle="tooltip" data-title="Mã số sau lớp bạc mỏng" required <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
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
     if($('input[name=rulex]').val() && $('#user').val() && $('#pin').val() && $('#seri').val()){
        $(this).addClass('btn btn-info').html('<i class="fa fa-spin fa-spinner"></i>Đang xử lí thẻ....');
     }
 });
 function check(){
  if($('#user').val() != ''){
    $.get('Card/check.php', { user: $('#user').val(), rule: $('input[name=rulex]:checked').val() }, function(result){ $('#check').html(result); });
    }
  }
</script>