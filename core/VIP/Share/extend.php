<?php
defined('COPYRIGHT') OR exit('hihi');
    if(isset($_GET['id_share'])){
        $id_share = intval($_GET['id_share']);
        $layinfo = mysqli_query($conn,"SELECT user_id,name,end,id_ctv FROM vipshare WHERE id=$id_share");
        $info = mysqli_fetch_assoc($layinfo);
        $uid = $info['user_id'];
        if($rule != 'admin'){
            if($idctv != $info['id_ctv']){
                echo "<script>alert('Bạn không có quyền gia hạn VIP ID này!');window.location='vip-chia-se.html';</script>";
            }else if($info['end'] > time()){
                echo "<script>alert('VIP ID này chưa hết hạn');window.location='vip-chia-se.html';</script>";
            }
        }else{
            if($info['end'] > time()){
                echo "<script>alert('VIP ID này chưa hết hạn');window.location='vip-chia-se.html';</script>";
            }
        }
    }
?>
<script>
    function tinh(){
        $(function(){
             $.post('core/VIP/price.php', { han: $('#han').val(), goi: $('#goi').val(), rule: $('#rule').val() }, function(result){$('#result').html(result);});
        });
    }
    function checkid(){
        $(function(){
            $.post('core/VIP/checkid.php', { user_id: $('#user_id').val()}, function(r){$('#duysex').html(r);});
        });
    }
</script>
<?php
    $get = "SELECT COUNT(*) FROM package WHERE type='SHARE'";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    if($x['COUNT(*)'] == 0){
        echo "<script>alert('Chưa có package nào?');window.location='index.php?DS=Add_Package_Share';</script>";
    }
?>
<?php
if (isset($_POST['submit'])) {
    if(($_POST['han'] <= 0 || $_POST['han'] > 12) || $_POST['goi'] < 10000){
        echo "<script>alert('Địt con mẹ mày luôn, bug tiếp hộ bố mày cái ?'); window.location='logout.php';</script>";
    }else{
        $name = $_POST['name'];
        $han = $_POST['han'];
        $shares = $_POST['shares'];
        $goi = $_POST['goi'];
        $start = time();
        $end = $start + $han * 30 * 86400 - 28800;
        $price = $han * $goi;
        if($rule == 'agency'){
            $price -= $price * 20 / 100;
        }else if($rule == 'freelancer'){
            $price -= $price * 10 / 100;
        }
        $get_max = "SELECT max FROM package WHERE type='SHARE' AND price='$goi'";
        $r_max = mysqli_query($conn, $get_max);
        $max_share = mysqli_fetch_assoc($r_max)['max'];
        if($rule != 'freelancer'){
         $get = "SELECT bill FROM member WHERE id_ctv = $idctv";
        }else{
            $get = "SELECT bill FROM ctv WHERE id_ctvs = $idctv";
        }
        if($shares <= $max_share){
            $result = mysqli_query($conn, $get);
            $x = mysqli_fetch_assoc($result);
            if ($x['bill'] - $price >= 0) {
                //$sql = "INSERT INTO vipshare(user_id, name, han, start, end, shares, max_share, id_ctv, pay) VALUES('$uid','$name','$han','$start','$end','$shares','$max_share','$idctv','$price')";
                $sql = "UPDATE vipshare SET han='$han', start='$start', end='$end', shares='$shares', max_share='$max_share',pay='$price' WHERE id=$id_share";
                if (mysqli_query($conn, $sql)) {
                    if($rule != 'freelancer'){
                        $up = "UPDATE member SET payment = payment + $price WHERE id_ctv=$idctv";
                    }else{
                        $up = "UPDATE ctv SET payment = payment + $price WHERE id_ctvs=$idctv";
                    }
                    if(mysqli_query($conn, $up)){
                    if($rule != 'freelancer'){
                        $minus = "UPDATE member SET bill = bill - $price WHERE id_ctv = $idctv";
                    }else{
                        $minus = "UPDATE ctv SET bill = bill - $price WHERE id_ctvs = $idctv";
                    }
                        if (mysqli_query($conn, $minus)) {
                            $content = "<b>$uname</b> vừa gia hạn VIP Share cho ID <b>$uid</b>. Thời hạn <b>$han</b> tháng, gói <b>$max_share</b> Share, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                            $time = time();
                            $his = "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)";
                            if (mysqli_query($conn, $his)) {
                                echo '<script>alert("Gia hạn thành công"); window.location="vip-chia-se.html";</script>';
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
                            <input type="number" class="form-control" onkeyup="checkid()" onchange="checkid();" id="user_id" value="<?php echo isset($info['user_id']) ? $info['user_id'] : ''; ?>" name="user_id" placeholder="User ID" required disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Họ và tên người được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($info['name']) ? $info['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required disabled>
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
                    <button type="submit" name="submit" class="btn btn-info pull-right">Gia hạn</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>

