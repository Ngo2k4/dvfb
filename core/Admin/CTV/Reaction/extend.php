<script>
    function tinh(){
        $(function(){
             $.post('core/VIP/price.php', { han: $('#han').val(), goi: $('#goi').val(), rule: $('#rule').val()}, function(result){$('#result').html(result);});
        });
    }
</script>
<?php
if (isset($_GET['id'])) {
    $id_react = $_GET['id'];
    $get = "SELECT user_id , name, type, limit_react, end, id_ctv,access_token FROM vipreaction WHERE id=$id_react";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $uid = $x['user_id'];
    if ($rule != 'admin') {
        if ($x['id_ctv'] != $idctv) {
            echo "<script>alert('CÚT');window.location='index.php';</script>";
        } else if ($x['end'] > time()) {
            echo "<script>alert('Không thể gia hạn khi chưa hết hạn');window.location='index.php';</script>";
        }
    }else{
        if ($x['end'] > time()) {
            echo "<script>alert('Không thể gia hạn khi chưa hết hạn');window.location='index.php';</script>";
        }
    }
}
if (isset($_POST['submit'])) {
    $han = $_POST['han'];
    $type = $_POST['type'];
    $goi = $_POST['goi'];
    $start = time();
    $token = $_POST['token'];
    $end = $start + $han * 30 * 86400;
    $price = $han * $goi;
    if($rule == 'agency'){
    $price -= $price * 20 / 100;
    }else if($rule == 'freelancer'){
        $price -= $price * 10 / 100;
    }
    $get = "SELECT bill FROM member WHERE id_ctv = $idctv";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $get_max = "SELECT max FROM package WHERE type='REACTION' AND price='$goi'";
    $r_max = mysqli_query($conn, $get_max);
    $limit_react = mysqli_fetch_assoc($r_max)['max'];
    if ($x['bill'] - $price >= 0) {
        $sql = "UPDATE vipreaction SET type='$type', han='$han', limit_react='$limit_react', start='$start', end='$end', pay = '$price',access_token='$token' WHERE id=$id_react";
        if (mysqli_query($conn, $sql)) {
                $minus = "UPDATE member SET bill = bill - $price, payment = payment + $price WHERE id_ctv = $idctv";
            if (mysqli_query($conn, $minus)) {
                $content = "<b>$uname</b> vừa gia hạn VIP Reaction cho ID <b>$uid</b> thêm <b>$han</b> tháng, gói <b>$limit_react</b> Reaction/ Cron, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                $time = time();
                $his = "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)";
                if (mysqli_query($conn, $his)) {
                    echo '<script>alert("Gia hạn thành công"); window.location="index.php?DS=CTV_Reaction";</script>';
                }
            }
        }
    } else {
        echo '<script>alert("Số dư tài khoản của bạn không đủ !!! Vui lòng nạp thêm tiền đi nha!1"); window.location="index.php?DS=CTV_Reaction";</script>';
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Gia hạn VIP BOT Reaction</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
            <input type="hidden" id="rule" value="<?php echo $rule; ?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="user_id" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($x['name']) ? $x['name'] : ''; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Thời Hạn:</label>

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
                        <label for="goi" class="col-sm-2 control-label">Loại Cảm Xúc:</label>

                        <div class="col-sm-10">
                            <select id="name" name="type" class="form-control">
                                <option value="RANDOM">RANDOM</option>
                                <option value="LOVE">LOVE</option>
                                <option value="HAHA">HAHA</option>
                                <option value="WOW">WOW</option>
                                <option value="SAD">SAD</option>
                                <option value="ANGRY">ANGRY</option>
                                <option value="LIKE">LIKE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Gói Reaction (Package):</label>

                        <div class="col-sm-10">
                            <select id="goi" name="goi" class="form-control" onchange="tinh()">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='REACTION' ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    echo "<option value='" . $ok['price'] . "'>{$ok['max']} Reaction/Cron - ".number_format($ok['price'])." VNĐ</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Mã Access Token:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo isset($_POST['token']) ? $_POST['token'] : ''; ?>" id="token" name="token" placeholder="Mã access token của id vip" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Thành tiền:</label>

                        <div class="col-sm-10">
                            <span style="background:red; color:yellow" class="h4" id="result"><script>tinh();</script></span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                <?php if($rule == 'agency'){ ?> <font color="red">Bạn là <b>Đại lí</b> nên được giảm 20% giá gói VIP này</font><?php }else if($rule == 'freelancer'){ ?> <font color="red">Bạn là <b>Cộng tác viên</b> được giảm 10% giá gói VIP này</font>  <?php  } ?>
                <button type="button" class="btn btn-warning"><a href="index.php?DS=Get_Token" target="_blank" style="color: white; font-weight: bold">Lấy Token</a></button>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Gia hạn</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>