<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<script>
    var _0xa57e = ["\x63\x6F\x72\x65\x2F\x56\x49\x50\x2F\x70\x72\x69\x63\x65\x2E\x70\x68\x70", "\x76\x61\x6C", "\x23\x68\x61\x6E", "\x23\x67\x6F\x69", "\x23\x72\x75\x6C\x65", "\x68\x74\x6D\x6C", "\x23\x72\x65\x73\x75\x6C\x74", "\x70\x6F\x73\x74", "\u0110\x61\x6E\x67\x20\x6B\x69\u1EC3\x6D\x20\x74\x72\x61\x2E\x2E\x2E", "\x23\x6E\x61\x6D\x65", "\x23\x75\x73\x65\x72\x5F\x69\x64", "\x63\x6F\x72\x65\x2F\x56\x49\x50\x2F\x52\x65\x61\x63\x74\x69\x6F\x6E\x2F\x63\x68\x65\x63\x6B\x2E\x70\x68\x70", "\x23\x74\x6F\x6B\x65\x6E", "\x5F", "\x73\x70\x6C\x69\x74"]; function tinh(){$(function(){$[_0xa57e[7]](_0xa57e[0], {han:$(_0xa57e[2])[_0xa57e[1]](), goi:$(_0xa57e[3])[_0xa57e[1]](), rule:$(_0xa57e[4])[_0xa57e[1]]()}, function(_0x3030x2){$(_0xa57e[6])[_0xa57e[5]](_0x3030x2)})})}function checkToken(){$(function(){$(_0xa57e[9])[_0xa57e[1]](_0xa57e[8]); $(_0xa57e[10])[_0xa57e[1]](_0xa57e[8]); $[_0xa57e[7]](_0xa57e[11], {token:$(_0xa57e[12])[_0xa57e[1]]()}, function(_0x3030x2){var _0x3030x4 = _0x3030x2[_0xa57e[14]](_0xa57e[13]); $(_0xa57e[10])[_0xa57e[1]](_0x3030x4[0]); $(_0xa57e[9])[_0xa57e[1]](_0x3030x4[1])})})}
</script>
<?php
$get_pack = mysqli_query($conn, "SELECT COUNT(*), MIN(price) FROM package WHERE type='REACTION'");
$package = mysqli_fetch_assoc($get_pack);
if ($package['COUNT(*)'] == 0) {
    echo "<script>alert('Chưa có package nào, Thêm ngay?');window.location='index.php?DS=Add_Package_Reaction';</script>";
}
?>
<?php
if (isset($_POST['submit'])) {
    if ($_POST['han'] < 0 || $_POST['han'] > 12 || $_POST['goi'] < $package['MIN(price)']) {
        echo "<script>alert('Địt con mẹ mày luôn, bug tiếp hộ bố mày cái ?'); window.location='trang-chu.html';</script>";
    } else {
        $loi = array();
        $uid = $_POST['user_id'];
        $get = "SELECT COUNT(user_id) FROM vipreaction WHERE user_id = $uid";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if ($x['COUNT(user_id)'] > 0) {
            $loi['err'] = '<font color="red">User ID này đã tồn tại trên hệ thống</font>';
        }
        if (empty($loi)) {
            $name = $_POST['name'];
            $han = $_POST['han'];
            $goi = $_POST['goi'];
            $cus = $_POST['custom'];
            $start = time();
            $end = $start + $han * 30 * 86400;
            $price = $han * $goi;
            if ($rule == 'agency') {
                $price -= $price * 10 / 100;
            } else if ($rule == 'freelancer') {
                $price -= $price * 5 / 100;
            }
            $type = $_POST['type'];
            $token = $_POST['token'];
            $botcmt = $_POST['botcmt'];
            if($botcmt == 'yes'){
                $noi_dung = $_POST['noi_dung'];
                $sticker = $_POST['sticker'];
                $link_img = empty(trim($_POST['link_img'])) ? 'empty' : $_POST['link_img'];
            }else{
                $noi_dung = 'empty';
                $sticker = 'no';
                $link_img = 'empty';
            }
            $get_max = "SELECT max FROM package WHERE type='REACTION' AND price='$goi'";
            $r_max = mysqli_query($conn, $get_max);
            $max_reactions = mysqli_fetch_assoc($r_max)['max'];
            if ($rule != 'freelancer') {
                $get = "SELECT bill FROM member WHERE id_ctv = $idctv";
            } else {
                $get = "SELECT bill FROM ctv WHERE id_ctvs = $idctv";
            }
            $result = mysqli_query($conn, $get);
            $x = mysqli_fetch_assoc($result);
            if ($x['bill'] - $price >= 0) {
                $sql = "INSERT INTO vipreaction(user_id, name, han, start, end, limit_react, id_ctv, pay, type,access_token,custom,botcmt,noi_dung,sticker,link_img) VALUES('$uid','$name','$han','$start','$end','$max_reactions','$idctv','$price','$type','$token',$cus,'$botcmt','$noi_dung','$sticker','$link_img')";
                if (mysqli_query($conn, $sql)) {
                    if ($rule != 'freelancer') {
                        $up = "UPDATE member SET num_id = num_id + 1, payment = payment + $price WHERE id_ctv=$idctv";
                    } else {
                        $up = "UPDATE ctv SET num_id = num_id + 1, payment = payment + $price WHERE id_ctvs=$idctv";
                    }
                    if (mysqli_query($conn, $up)) {
                        if ($rule != 'freelancer') {
                            $minus = "UPDATE member SET bill = bill - $price WHERE id_ctv = $idctv";
                        } else {
                            $minus = "UPDATE ctv SET bill = bill - $price WHERE id_ctvs = $idctv";
                        }
                        if (mysqli_query($conn, $minus)) {
                            $content = "<b>$uname</b> vừa thêm VIP REACTION cho ID <b>$uid</b>. Thời hạn <b>$han</b> tháng, MAX <b>$max_reactions</b> Reactions / Cron, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                            $time = time();
                            $his = "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)";
                            if (mysqli_query($conn, $his)) {
                                if ($price >= 20000) {
                                    mysqli_query($conn, "UPDATE event SET turn = turn + 1 WHERE user_name='$uname' AND rule = '$rule'");
                                }
                                echo '<script>alert("Thêm thành công"); window.location="vip-bot-cam-xuc.html";</script>';
                            }
                        }
                    }
                }
            } else {
                echo '<script>alert("Số dư tài khoản của bạn không đủ !!! Vui lòng nạp thêm tiền đi nha!1");location.href="them-vip-bot-cam-xuc.html";</script>';
            }
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm ID VIP BOT Cảm xúc bài viết của bạn bè</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <input type="hidden" id="rule" value="<?php echo $rule; ?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Mã Access Token: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Mã Access Token của Nick được cài VIP. Chú ý mã token phải Live và là mã của nick được cài VIP nếu không VIP sẽ không thể hoạt động đúng được!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" onpaste="checkToken()" value="<?php echo isset($_POST['token']) ? $_POST['token'] : ''; ?>"  onkeyup="checkToken()" id="token" name="token" placeholder="Mã access token của id vip" required>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="ID Nick Facebook được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="user_id" value="<?php echo isset($_POST['user_id']) ? $_POST['user_id'] : ''; ?>" name="user_id" placeholder="User ID" required>
                            <?php echo isset($loi['err']) ? $loi['err'] : ''; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Họ và tên người được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Thời Hạn: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Thời hạn mua VIP"></span></label>

                        <div class="col-sm-10">
                            <select id="han" name="han" class="form-control" required="" onchange="tinh()">
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<option value='$i'>$i Tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Loại Cảm Xúc: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Chọn 1 loại cảm xúc để VIP hoạt động!"></span></label>

                        <div class="col-sm-10">
                            <select id="name" name="type" class="form-control">
                                <!--<option value="RANDOM">RANDOM - Ngẫu nhiên</option>-->
                                <option value="LOVE">LOVE - Thả tim</option>
                                <option value="HAHA">HAHA - Cười hihi</option>
                                <option value="WOW">WOW - Ngạc nhiên</option>
                                <option value="SAD">SAD - Buồn</option>
                                <option value="ANGRY">ANGRY - Phẫn nộ</option>
                                <option value="LIKE">LIKE - Thích</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="custom" class="col-sm-2 control-label">Tùy chỉnh đối tượng thả cảm xúc: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Bot cảm xúc cho những đối tượng nào trên bảng tin?"></span></label>

                        <div class="col-sm-10">
                            <select id="custom" name="custom" class="form-control">
                                <option value="0" selected>Bạn bè & những người bạn đang theo dõi</option>
                                <option value="1">Toàn bộ bảng tin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="goi" class="col-sm-2 control-label">Gói Bot  Cảm xúc (Package): <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Giới hạn tối đa số Cảm Xúc của gói VIP sẽ Reaction!"></span></label>

                        <div class="col-sm-10">
                            <select id="goi" name="goi" class="form-control" onchange="tinh()">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='REACTION' ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    echo "<option value='" . $ok['price'] . "'>{$ok['max']} Cảm xúc/Cron - " . number_format($ok['price']) . " VNĐ/Tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Bot CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Bật/Tắt Bot CMT"></span></label>

                        <div class="col-sm-10">
                            <select name="botcmt" class="form-control" id="botcmt">
                                <option value="no">Tắt</option>
                                <option value="yes">Bật</option>
                            </select>
                        </div>
                    </div>
                    <div id="botcmt_option" style="display:none">
                        <div class="form-group">
                            <label for="goi" class="col-sm-2 control-label">Nội dung CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nội dung CMT"></span></label>

                            <div class="col-sm-10">
                                <textarea name="noi_dung" id="noi_dung" class="form-control" rows="6" placeholder="Nội dung comment, mỗi nội dung 1 dòng"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Link Ảnh: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Link Ảnh Comment"></span></label>

                        <div class="col-sm-10">
                            <input type="text" name="link_img" class="form-control" placeholder="Nhập link ảnh" />
                        </div>
                    </div>
                        
                        <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Sticker: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Bật/Tắt Stickeer"></span></label>

                        <div class="col-sm-10">
                            <select name="sticker" class="form-control" id="botcmt">
                                <option value="no">Tắt</option>
                                <option value="yes">Bật</option>
                            </select>
                        </div>
                    </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Thành tiền: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Tổng số tiền cần thanh toán!"></span></label>

                        <div class="col-sm-10">
                            <span style="background:red; color:yellow" class="h4" id="result"><script>tinh();</script></span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php if ($rule == 'agency') { ?> <font color="red">Bạn là <b>Đại lí</b> nên được giảm 10% giá gói VIP này</font><?php } else if ($rule == 'freelancer') { ?> <font color="red">Bạn là <b>Cộng tác viên</b> được giảm 5% giá gói VIP này</font>  <?php } ?>
                    <button type="button" class="btn btn-warning"><a href="index.php?DS=Get_Token" target="_blank" style="color: white; font-weight: bold">Lấy Token</a></button>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
<script>
    $('#botcmt').change(function(){
       if($('#botcmt').val() == 'yes'){
           $('#botcmt_option').fadeIn();
           $('#noi_dung').attr('required', 'required');
       } else{
           $('#botcmt_option').fadeOut();
           $('#noi_dung').removeAttr('required');
       }
    });
</script>