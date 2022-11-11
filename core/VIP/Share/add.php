<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<script>
    var _0x79bc=["\x76\x61\x6C","\x23\x67\x6F\x69","\x64\x69\x73\x70\x6C\x61\x79","\x6E\x6F\x6E\x65","\x63\x73\x73","\x6F\x70\x74\x69\x6F\x6E\x5B\x76\x61\x6C\x75\x65\x3D\x33\x30\x5D\x2C\x20\x6F\x70\x74\x69\x6F\x6E\x5B\x76\x61\x6C\x75\x65\x3D\x33\x35\x5D\x2C\x20\x6F\x70\x74\x69\x6F\x6E\x5B\x76\x61\x6C\x75\x65\x3D\x34\x30\x5D\x2C\x20\x6F\x70\x74\x69\x6F\x6E\x5B\x76\x61\x6C\x75\x65\x3D\x34\x35\x5D\x2C\x20\x6F\x70\x74\x69\x6F\x6E\x5B\x76\x61\x6C\x75\x65\x3D\x35\x30\x5D","\x69\x6E\x6C\x69\x6E\x65\x2D\x62\x6C\x6F\x63\x6B","\x63\x6F\x72\x65\x2F\x56\x49\x50\x2F\x70\x72\x69\x63\x65\x2E\x70\x68\x70","\x23\x68\x61\x6E","\x23\x72\x75\x6C\x65","\x68\x74\x6D\x6C","\x23\x72\x65\x73\x75\x6C\x74","\x70\x6F\x73\x74","\u0110\x61\x6E\x67\x20\x6B\x69\u1EC3\x6D\x20\x74\x72\x61\x2E\x2E\x2E\x2E","\x23\x6E\x61\x6D\x65","\x63\x6F\x72\x65\x2F\x56\x49\x50\x2F\x63\x68\x65\x63\x6B\x69\x64\x2E\x70\x68\x70","\x23\x75\x73\x65\x72\x5F\x69\x64"];function tinh(){$(function(){if($(_0x79bc[1])[_0x79bc[0]]()< 25000){$(_0x79bc[5])[_0x79bc[4]](_0x79bc[2],_0x79bc[3])}else {$(_0x79bc[5])[_0x79bc[4]](_0x79bc[2],_0x79bc[6])};$[_0x79bc[12]](_0x79bc[7],{han:$(_0x79bc[8])[_0x79bc[0]](),goi:$(_0x79bc[1])[_0x79bc[0]](),rule:$(_0x79bc[9])[_0x79bc[0]]()},function(_0xa9c0x2){$(_0x79bc[11])[_0x79bc[10]](_0xa9c0x2)})})}function checkid(){$(function(){$(_0x79bc[14])[_0x79bc[0]](_0x79bc[13]);$[_0x79bc[12]](_0x79bc[15],{user_id:$(_0x79bc[16])[_0x79bc[0]]()},function(_0xa9c0x4){$(_0x79bc[14])[_0x79bc[0]](_0xa9c0x4)})})}
</script>
<?php
    $get_pack = mysqli_query($conn, "SELECT COUNT(*), MIN(price) FROM package WHERE type='SHARE'");
$package = mysqli_fetch_assoc($get_pack);
if ($package['COUNT(*)'] == 0) {
    echo "<script>alert('Chưa có package nào, Thêm ngay?');window.location='index.php?DS=Add_Package_Share';</script>";
}
?>
<?php
if (isset($_POST['submit'])) {
    if(($_POST['han'] <= 0 || $_POST['han'] > 12) || $_POST['goi'] < $package['MIN(price)']){
        echo "<script>alert('Địt con mẹ mày luôn, bug tiếp hộ bố mày cái ?'); window.location='trang-chu.html';</script>";
    }else{
        $loi = array();
        $uid = $_POST['user_id'];
        $get = "SELECT COUNT(user_id) FROM vipshare WHERE user_id = $uid";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if ($x['COUNT(user_id)'] > 0) {
            $loi['err'] = '<font color="red">User ID này đã tồn tại trên hệ thống</font>';
        }
        if (empty($loi)) {
            $name = $_POST['name'];
            $han = $_POST['han'];
            $shares = $_POST['shares'];
            $goi = $_POST['goi'];
            $start = time();
            $end = $start + $han * 30 * 86400;
            $price = $han * $goi;
            if($rule == 'agency'){
                $price -= $price * 20 / 100;
            }else if($rule == 'freelancer'){
                $price -= $price * 10 / 100;
            }
            $get_max = "SELECT max FROM package WHERE type='SHARE' AND price='$goi'";
            $r_max = mysqli_query($conn, $get_max);
            $max_share = mysqli_fetch_assoc($r_max)['max'];
            if($shares <= $max_share){
                if($rule != 'freelancer'){
                 $get = "SELECT bill FROM member WHERE id_ctv = $idctv";
                }else{
                    $get = "SELECT bill FROM ctv WHERE id_ctvs = $idctv";
                }
                $result = mysqli_query($conn, $get);
                $x = mysqli_fetch_assoc($result);
                if ($x['bill'] - $price >= 0) {
                    $sql = "INSERT INTO vipshare(user_id, name, han, start, end, shares, max_share, id_ctv, pay) VALUES('$uid','$name','$han','$start','$end','$shares','$max_share','$idctv','$price')";
                    if (mysqli_query($conn, $sql)) {
                        if($rule != 'freelancer'){
                            $up = "UPDATE member SET num_id = num_id + 1, payment = payment + $price WHERE id_ctv=$idctv";
                        }else{
                            $up = "UPDATE ctv SET num_id = num_id + 1, payment = payment + $price WHERE id_ctvs=$idctv";
                        }
                        if(mysqli_query($conn, $up)){
                        if($rule != 'freelancer'){
                            $minus = "UPDATE member SET bill = bill - $price WHERE id_ctv = $idctv";
                        }else{
                            $minus = "UPDATE ctv SET bill = bill - $price WHERE id_ctvs = $idctv";
                        }
                            if (mysqli_query($conn, $minus)) {
                                $content = "<b>$uname</b> vừa thêm VIP Share cho ID <b>$uid</b>. Thời hạn <b>$han</b> tháng, gói <b>$max_share</b> Share, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                                $time = time();
                                $his = "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)";
                                if (mysqli_query($conn, $his)) {
                                    echo '<script>alert("Thêm thành công"); window.location="vip-chia-se.html";</script>';
                                }
                            }
                        }
                    }
                } else {
                    echo '<script>alert("Số dư tài khoản của bạn không đủ !!! Vui lòng nạp thêm tiền đi nha!1");location.reload();</script>';
                }
            }else{
                echo "<script>alert('Vui lòng chọn số Share/cron nhỏ hơn hoặc bằng gói Share');window.location='them-vip-chia-se.html';</script>";
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
                <h3 class="box-title">Thêm ID VIP Share</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <input type="hidden" id="rule" value="<?php echo $rule; ?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="ID Nick Facebook được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" onkeyup="checkid()" id="user_id" value="<?php echo isset($_POST['user_id']) ? $_POST['user_id'] : ''; ?>" name="user_id" placeholder="User ID" required>
                            <p id="duysex"></p>
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
                        <label for="shares" class="col-sm-2 control-label">Số Shares / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng Share tăng sau mỗi lần VIP được chạy!"></span></label>
                        <div class="col-sm-10">
                            <select name="shares" class="form-control">
                                <option value="9">10 Share/Cron</option>
                                <option value="18">20 Share/Cron</option>
                                <option value="47">50 Share/Cron</option>
                                <?php
                                // for ($i = 10; $i <= 50; $i += 10) {
                                //     echo "<option value='$i'>$i Share/Cron</option>";
                                // }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Gói Share (Package): <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Giới hạn tối đa số Share của gói VIP!"></span></label>

                        <div class="col-sm-10">
                            <select id="goi" name="goi" class="form-control" onchange="tinh()">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='SHARE' AND max <= 500 ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    echo "<option value='" . $ok['price'] . "'>{$ok['max']} Share - ".number_format($ok['price'])." VNĐ / tháng</option>";
                                }
                                ?>
                            </select>
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
                    <?php if($rule == 'agency'){ ?> <font color="red">Bạn là <b>Đại lí</b> nên được giảm 20% giá gói VIP này</font><?php }else if($rule == 'freelancer'){ ?> <font color="red">Bạn là <b>Cộng tác viên</b> được giảm 10% giá gói VIP này</font>  <?php  } ?>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>

