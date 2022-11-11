<script>
    function tinh(){
        $(function(){
             $.post('core/VIP/price.php', { han: $('#han').val(), goi: $('#goi').val(), rule: $('#rule').val()}, function(result){$('#result').html(result);});
        });
    }
</script>
<?php
if (isset($_GET['id'])) {
    $id_share = $_GET['id'];
    $get = "SELECT user_id , name, shares, end, id_ctv FROM vipshare WHERE id=$id_share";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $uid = $x['user_id'];
    if ($rule != 'admin' && $id !='agency') {
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
    $get = "SELECT bill FROM member WHERE id_ctv = $idctv";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $get_max = "SELECT max FROM package WHERE type='SHARE' AND price='$goi'";
    $r_max = mysqli_query($conn, $get_max);
    $max_share = mysqli_fetch_assoc($r_max)['max'];
    if ($x['bill'] - $price >= 0) {
        $sql = "UPDATE vipshare SET shares='$shares', han='$han', max_share='$max_share', start='$start', end='$end', pay = '$price' WHERE id=$id_share";
        if (mysqli_query($conn, $sql)) {
                $minus = "UPDATE member SET bill = bill - $price, payment = payment + $price WHERE id_ctv = $idctv";
            if (mysqli_query($conn, $minus)) {
                $content = "<b>$uname</b> vừa gia hạn VIP Share cho ID <b>$uid</b> thêm <b>$han</b> tháng, gói <b>$max_share</b> Share, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                $time = time();
                $his = "INSERT INTO history(content,id_ctv,time, type) VALUES('$content','$idctv', '$time',0)";
                if (mysqli_query($conn, $his)) {
                    echo '<script>alert("Gia hạn thành công"); window.location="index.php?DS=CTV_Share";</script>';
                }
            }
        }
    } else {
        echo '<script>alert("Số dư tài khoản của bạn không đủ !!! Vui lòng nạp thêm tiền đi nha!1"); window.location="index.php?DS=CTV_Share";</script>';
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Gia Hạn VIP LIKE</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                    <input type="hidden" id="rule" value="<?php echo $rule; ?>" />
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
                        <label for="shares" class="col-sm-2 control-label">Số Shares / Cron:</label>

                        <div class="col-sm-10">
                            <select name="shares" class="form-control">
                                <option value="9">10 Share/Cron</option>
                                <option value="18">20 Share/Cron</option>
                                <option value="47">50 Share/Cron</option>
                                <?php
                                // for ($i = 10; $i <= 100; $i += 10) {
                                //     echo "<option value='$i'>$i Likes/Cron</option>";
                                // }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Gói Share (Package):</label>

                        <div class="col-sm-10">
                            <select id="goi" name="goi" class="form-control" onchange="tinh()">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='SHARE' ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    echo "<option value='" . $ok['price'] . "'>{$ok['max']} Shares - ".number_format($ok['price'])." VNĐ</option>";
                                }
                                ?>
                            </select>
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
                <div class="box-footer">
                    <?php if($rule == 'agency'){ ?> <font color="red">Bạn là <b>Đại lí</b> nên được giảm 20% giá gói VIP này</font><?php }else if($rule == 'freelancer'){ ?> <font color="red">Bạn là <b>Cộng tác viên</b> được giảm 10% giá gói VIP này</font>  <?php  } ?>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Gia hạn</button>
                </div>
                    
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
