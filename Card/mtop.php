<?php
include 'Card/curl.php';
if (isset($_POST['napthe'])) {
    $event = false; // on/off event
    $km = 0; // % khuyến mại
    $card = $_POST['type']; // loại thẻ
    /* get tên thẻ */
    if ($card == 'VTT') {
        $card_name = 'Viettel';
    }  else if ($card == 'VNP') {
        $card_name = 'Vinaphone';
    } else if ($card == 'GATE') {
        $card_name = 'FPT GATE';
    }
    
    $accNo = ''; // số tk mtop của bạn
    $serial = trim($_POST['seri']); //seri thẻ
    $code = trim($_POST['code']); // mã thẻ
    $user = $_POST['user']; // username
    $type = $_POST['rulex']; // quyền hạn
    $timex = date('d/m/Y - H:i:s', time()); //thời gian giao dịch
    
    /* step login */ 
    $username = ''; // sdt đăng nhập mtop
    $pass = ''; // mật khẩu mtop
    $password = md5($pass); // md5 hoy
    login('https://my.mtop.vn/login', "username=$username&password=$password", 'mtop.txt');
    
    /* nạp thẻ */
    $list_fields = array(
        "issuer" => $card,
        "cardSerial" => $serial,
        "cardCode" => $code,
        "accountNo" => $accNo
        );
    $post_fields = json_encode($list_fields);
    
    $api =  postData('https://my.mtop.vn/giao-dich/nap-tien-bang-the-cao', $post_fields, 'mtop.txt');
    $response = json_decode($api,true);
    if ($response['code'] == "01") { // nếu thành công
        $money = $response['data']['price']; //mệnh giá thẻ
        $xu = $response['data']['amount']; // số tiền nhận đc
        $transId = $response['data']['requestId']; // mã giao dịch
        if ($event == true) { // nếu có sự kiện
            // if ($xu >= 20000 && $xu <= 49000) {
            //     mysqli_query($conn, "UPDATE event SET turn = turn + 1, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            // } else if ($xu >= 50000 && $xu <= 99000) {
            //     mysqli_query($conn, "UPDATE event SET turn = turn + 2, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            // } else if ($xu >= 100000 && $xu <= 299000) {
            //     mysqli_query($conn, "UPDATE event SET turn = turn + 3, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            // } else if ($xu >= 300000 && $xu < 499000) {
            //     mysqli_query($conn, "UPDATE event SET turn = turn + 5, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            // } else if ($xu >= 500000) {
            //     mysqli_query($conn, "UPDATE event SET turn = turn + 7, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
            // }
            $turn = floor($money/20000);
            mysqli_query($conn, "UPDATE event SET turn = turn + $turn, payment = payment + $xu WHERE user_name='$user' AND rule = '$type'");
        }
        
        /* xử lí cộng tiền */
        if($type != 'freelancer'){
            $get_info = mysqli_query($conn, "SELECT id_ctv, name, rule, COUNT(*) FROM member WHERE user_name='$user' AND rule='$type' GROUP BY id_ctv, name, rule");
        }else{
            $get_info = mysqli_query($conn, "SELECT id_ctvs, name, rule, COUNT(*) FROM ctv WHERE user_name='$user' AND rule='$type' GROUP BY id_ctvs, name, rule");
        }
        $x = mysqli_fetch_assoc($get_info);
        if ($x['COUNT(*)'] == 1) {
            $id = isset($x['id_ctv']) ? $x['id_ctv'] : $x['id_ctvs'];
            $name = $x['name'];
            if ($km > 0) {
                $xu += $xu * $km / 100;
            } else {
                if ($type == 'freelancer') {
                    $xu += $xu * 5 / 100;
                } else if ($type == 'agency') {
                    $xu += $xu * 10 / 100;
                }
            }
            if($rule != 'freelancer'){
                $add = "UPDATE member SET bill = bill + $xu WHERE user_name='$user'";
            }else{
                $add = "UPDATE ctv SET bill = bill + $xu WHERE user_name='$user'";
            }
            if (mysqli_query($conn, $add)) {
                $content = "<b>$user</b> ( <b>$name</b> ) vừa nạp thành công thẻ <b>$card_name</b> mệnh giá <b>" . number_format($money) . "</b> VNĐ thành công và được cộng  <b>" . number_format($xu) . " </b> VNĐ vào tài khoản vip. Mã giao dịch <b>$transId</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv,type) VALUES('$content','$time','$id',2)";
                if (mysqli_query($conn, $his)) {
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time','$id')";
                    if (mysqli_query($conn, $noti)) {
                        echo "<script>alert('$name đã nạp thành công thẻ $card_name mệnh giá " . number_format($money) . " VNĐ thành công và được cộng ".number_format($xu)." VNĐ vào tài khoản!!!');window.location='nap-tien.html';</script>";
                    }
                }
            }
            $fp = fopen("Card/success.txt", "a+");
            $noidung = "Loai the: $card_name, Ma the: $code, Seri: $serial, Username: $user, Menh gia: ".number_format($money)." VNĐ, So du duoc cong: ".number_format($xu)." VNĐ, Ma giao dich: $transId, Thoi gian: $timex \n";
            fwrite($fp, $noidung);
            fclose($fp);
        } else {
          echo "<script>alert('Dữ liệu tài khoản và loại tài khoản của bạn nhập chưa đúng, vui lòng thử lại!!!');window.location='nap-tien.html';</script>";
        }
    } else {
        // $err_code = isset($response['code']) ? $response['code'] : '-69';
        // $err_mess = $response['message'];
        $fp = fopen("Card/failed.txt", "a+");
        $noidung = "Loai the: $card_name, Ma the: $code, Seri: $serial, Username: $user, Thoi gian: $timex \n";
        fwrite($fp, $noidung);
        fclose($fp);
        // if($err_code != '-69'){
        //     echo "<script>alert('Đã có lỗi xảy ra. Mã lỗi: $err_code. Nội dung lỗi: $err_mess');window.location = 'nap-tien.html'</script>";
        // }else{
            echo "<script>alert('Đã có lỗi xảy ra. Vui lòng kiểm tra lại các thông tin đã nhập');window.location='nap-tien.html';</script>";
        // }
    }
    unlink('Card/mtop.txt');
}
$k = 0;
?>
<form class="form-horizontal" role="form" method="post" action="#">
    <div class="form-group">
        <label for="card_type_id" class="col-lg-2 control-label">Loại thẻ</label>
        <div class="col-lg-10">
            <select name="type" class="form-control" data-toggle="tooltip" title="Chọn loại thẻ" <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
                <option value="VTT">Viettel</option>
                <option value="VNP">Vinaphone</option>
                <option value="GATE">FPT Gate</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="rule" class="col-lg-2 control-label">Bạn là ? (Chọn đúng)</label>
        <div class="col-lg-10">
            <input type="radio" class="rule" name="rulex" value="agency" data-toggle="tooltip" data-title="Click chọn nếu bạn là đại lí" onchange="check()" onmouseleave="check()" <?php if (isset($rule) && $rule == 'agency') echo 'checked'; ?> required> Đại lí <?php if ($k > 0) { ?><code>+ <?php echo $k; ?>%</code><?php } else { ?><code>+10 %</code><?php } ?><br />
            <input type="radio" class="rule" name="rulex" value="freelancer" data-toggle="tooltip" data-title="Click chọn nếu bạn là cộng tác viên" onchange="check()" onmouseleave="check()" <?php if (isset($rule) && $rule == 'freelancer') echo 'checked'; ?> required> Cộng tác viên <?php if ($k > 0) { ?><code>+ <?php echo $k; ?>%</code><?php } else { ?><code>+5 % </code> <?php } ?><br />
            <input type="radio" class="rule" name="rulex" value="member" data-toggle="tooltip" data-title="Click chọn nếu bạn là thành viên" onchange="check()" onmouseleave="check()" <?php if (isset($rule) && $rule == 'member') echo 'checked'; ?> required>Thành viên <?php if ($k > 0) { ?><code>+ <?php echo $k; ?>%</code><?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label for="user" class="col-lg-2 control-label"><font color="red">Tài khoản: </font></label>
        <div class="col-lg-10">
            <input type="text" onchange="check();"  onkeyup="check();" id="user"  class="form-control"  name="user" value="<?php echo isset($uname) ? $uname : ''; ?>" placeholder="Nhập chính xác tên tài khoản" data-toggle="tooltip" data-title="Nhập chính xác tên tài khoản" required <?php echo isset($uname) ? 'readonly' : ''; ?>/>
            <span id="check"></span>
        </div>
    </div>
    <div class="form-group">
        <label for="txtpin" class="col-lg-2 control-label">Mã thẻ</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="code" name="code" placeholder="Mã thẻ" data-toggle="tooltip" data-title="Mã số sau lớp bạc mỏng" required <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
        </div>
    </div>
    <div class="form-group">
        <label for="txtseri" class="col-lg-2 control-label">Số seri</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" id="seri" name="seri" placeholder="Số seri" data-toggle="tooltip" data-title="Mã seri nằm sau thẻ" required <?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>>
        </div>
    </div>

    <div class="form-group">
        <div style="text-align:center">
            <button type="submit" class="btn btn-primary" id="submit" name="napthe"<?php echo isset($rule) && $rule == 'admin' ? 'disabled' : ''; ?>><?php echo isset($rule) && $rule == 'admin' ? 'Không khả dụng' : 'Nạp thẻ'; ?></button>
        </div>
    </div> 
</form>
<script>
    $('#submit').click(function () {
        if ($('input[name=rulex]').val() && $('#user').val() && $('#code').val() && $('#seri').val()) {
            $(this).addClass('btn btn-info').html('<i class="fa fa-spin fa-spinner"></i>Đang xử lí thẻ....');
        }
    });
    function check() {
        if ($('#user').val() != '') {
            $.get('Card/check.php', {user: $('#user').val(), rule: $('input[name=rulex]:checked').val()}, function (result) {
                $('#check').html(result);
            });
        }
    }
</script>