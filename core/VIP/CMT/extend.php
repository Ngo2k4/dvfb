<?php
defined('COPYRIGHT') OR exit('hihi');
    if(isset($_GET['id_cmt'])){
        $id_cmt = intval($_GET['id_cmt']);
        $layinfo = mysqli_query($conn,"SELECT user_id, name, noi_dung, gender, hash_tag,end,id_ctv FROM vipcmt WHERE id=$id_cmt");
        $info = mysqli_fetch_assoc($layinfo);
        $uid = $info['user_id'];
        if($rule != 'admin'){
            if($idctv != $info['id_ctv']){
                echo "<script>alert('Bạn không có quyền gia hạn VIP ID này!');window.location='vip-binh-luan.html';</script>";
            }else if($info['end'] > time()){
                echo "<script>alert('VIP ID này chưa hết hạn');window.location='vip-bin-luan.html';</script>";
            }
        }else{
            if($info['end'] > time()){
                echo "<script>alert('VIP ID này chưa hết hạn');window.location='vip-binh-luan.html';</script>";
            }
        }
    }
?>
<script>
    function tinh(){
        $(function(){
            // if($('#han').val() == 'one' || $('#han').val() == 'three'){
            //     $('#goi').attr("disabled","disabled").val('40000');
            // }else{
            //     $('#goi').removeAttr('disabled');
            // }
            // if($('#han').val() == 'seven'){
            //     $('option[value=95000],option[value=110000],option[value=120000],option[value=140000],option[value=150000],option[value=165000],option[value=180000]').css('display','none');
            // }else{
            //     $('option[value=95000],option[value=110000],option[value=120000],option[value=140000],option[value=150000],option[value=165000],option[value=180000]').css('display','inline-block');
            // }
             $.post('core/VIP/price.php', { han: $('#han').val(), goi: $('#goi').val(), rule: $('#rule').val()}, function(result){$('#result').html(result);});
        });
    }
    function checkid(){
        $(function(){
            $.post('core/VIP/checkid.php', { user_id: $('#user_id').val()}, function(r){$('#duysex').html(r);});
        });
    }
</script>
<?php
    $get = "SELECT COUNT(*) FROM package WHERE type='CMT'";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    if($x['COUNT(*)'] == 0){
        echo "<script>alert('Bạn chưa thêm Package nào cho VIP CMT, thêm ngay để cài đặt ?');window.location='index.php?DS=Add_Package_CMT';</script>";
    }
?>
<?php
if (isset($_POST['submit'])) {
    // if ((($_POST['han'] != 'one' && $_POST['han'] != 'three') && $_POST['han'] !='seven') && (($_POST['han'] <= 0 || $_POST['han'] > 12) || $_POST['goi'] < 20000)) {
    if($_POST['han'] < 0 || $_POST['han'] > 12 || $_POST['goi'] < 25000){
            echo "<script>alert('Địt con mẹ mày luôn, bug tiếp hộ bố mày cái ?'); window.location='trang-chu.html';</script>";
    } else {
        $han = $_POST['han'];
        $cmt = $_POST['cmt'];
        $goi = $_POST['goi'];
        $hashtag = "#".$_POST['hashtag'];
        $gender = $_POST['gender'];
        $noidung = $_POST['noi_dung'];
        $start = time();
        // if ($han == 'one') {
        //     $price = 0;
        //     $end = $start + 86400;
        //     $max_cmt = 10;
        //     $han = 'one';
        //     mysqli_query($conn, "INSERT INTO free(uid, type, id_ctv) VALUES('$uid','CMT',$idctv)");
        // } else if ($han == 'three') {
        //     $price = 0;
        //     $end = $start + 86400 * 3;
        //     $max_cmt = 10;
        //     $han = 'three';
        // } else
        if ($han == 'seven') {
            if($_POST['goi'] > 150000){
                echo "<script>alert('7 ngày chỉ mua được gói VIP tối đa 30 Comment!!');window.location='them-vip-binh-luan.html';</script>";
                exit();
            }
            $price = ($goi/30)*10;
            $end = $start + 86400 * 7;
            $han = 'seven';
            $get_max = "SELECT max FROM package WHERE type='CMT' AND price='$goi'";
            $r_max = mysqli_query($conn, $get_max);
            $max_cmt = mysqli_fetch_assoc($r_max)['max'];
        }else {
            $end = $start + $han * 30 * 86400;
            $price = $han * $goi;
            if($rule == 'agency'){
                $price -= $price * 10 / 100;
            }else if($rule == 'freelancer'){
                $price -= $price * 5 / 100;
            }
            $get_max = "SELECT max FROM package WHERE type='CMT' AND price='$goi'";
            $r_max = mysqli_query($conn, $get_max);
            $max_cmt = mysqli_fetch_assoc($r_max)['max'];
        }
        if($cmt <= $max_cmt){
            if($rule != 'freelancer'){
                $get = "SELECT bill FROM member WHERE id_ctv = $idctv";
            }else{
                $get = "SELECT bill FROM ctv WHERE id_ctvs = $idctv";
            }
            
            $result = mysqli_query($conn, $get);
            $x = mysqli_fetch_assoc($result);
            if ($x['bill'] - $price >= 0) {
                //$sql = "INSERT INTO vipcmt(user_id, name, han, start, end, cmts, max_cmt, id_ctv, pay, noi_dung,hash_tag,gender) VALUES('$uid','$name','$han','$start','$end','$cmt','$max_cmt','$idctv','$price','$noidung','$hashtag','$gender')";
                $sql = "UPDATE vipcmt SET han='$han', start='$start', end='$end', cmts='$cmt', max_cmt='$max_cmt',pay='$price',noi_dung='$noidung',hash_tag='$hashtag',gender='$gender' WHERE id=$id_cmt";
                if (mysqli_query($conn, $sql)) {
                    if($rule !='freelancer'){
                        $up = "UPDATE member SET payment = payment + $price WHERE id_ctv=$idctv";
                    }else{
                        $up = "UPDATE ctv SET  payment = payment + $price WHERE id_ctvs=$idctv";
                    }
                    if(mysqli_query($conn, $up)){
                        if($rule !='freelancer'){
                            $minus = "UPDATE member SET bill = bill - $price WHERE id_ctv = $idctv";
                        }else{
                            $minus = "UPDATE ctv SET bill = bill - $price WHERE id_ctvs = $idctv";
                        }
                        if (mysqli_query($conn, $minus)) {
                            if($han == 'seven'){
                                $content = "<b>$uname</b> vừa gia hạn VIP CMT cho ID <b>$uid</b>. Thời hạn <b>7 ngày </b> tháng, gói <b>$max_cmt</b> CMT, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                            }else{
                                $content = "<b>$uname</b> vừa gia hạn VIP CMT cho ID <b>$uid</b>. Thời hạn <b>$han</b> tháng, gói <b>$max_cmt</b> CMT, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                            }
                            $time = time();
                            $his = "INSERT INTO history(content,id_ctv,time,type) VALUES('$content','$idctv', '$time',0)";
                            if (mysqli_query($conn, $his)) {
                                echo '<script>alert("Gia hạn thành công"); window.location="vip-binh-luan.html";</script>';
                            }
                        }
                    }
                }
            } else {
                echo '<script>alert("Số dư tài khoản của bạn không đủ !!! Vui lòng nạp thêm tiền đi nha!1");location.href="them-vip-binh-luan.html";</script>';
            }
        }else{
            echo "<script>alert('Vui lòng chọn số CMT/Cron <= Gói CMT'); window.location='vip-cam-xuc.html';</script>";
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Gia hạn ID VIP CMT</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                    <input type="hidden" id="rule" value="<?php echo $rule; ?>" />
                        <label for="user_id" class="col-sm-2 control-label">User ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="ID Nick Facebook được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="user_id" value="<?php echo isset($info['user_id']) ? $info['user_id'] : ''; ?>" name="user_id" placeholder="User ID" required disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Họ và tên người được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($info['name']) ? $info['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="han" class="col-sm-2 control-label">Thời Hạn: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Thời hạn mua VIP"></span></label>

                        <div class="col-sm-10">
                            <select id="han" name="han" class="form-control" required="" onchange="tinh()">
                                <!--<option value="seven">7 ngày</option>-->
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<option value='$i'>$i Tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="noidung" class="col-sm-2 control-label">Nội dung CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Danh sách các nội dung bình luận, mỗi dòng 1 nội dung khác nhau!"></span></label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="10" name="noi_dung" placeholder="Nội dung CMT, nội dung khác nhau cách nhau bởi dấu xuống dòng (Enter)" required><?php echo isset($info['noi_dung']) ? $info['noi_dung'] : ''; ?></textarea>
                            
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="cmt" class="col-sm-2 control-label">Số CMT / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng CMT tăng sau mỗi lần VIP được chạy!"></span></label>

                        <div class="col-sm-10">
                            <select id="cmt" name="cmt" class="form-control" required="">
                                <?php
                                for ($i = 2; $i <= 20; $i++) {
                                    echo "<option value='$i'>$i CMT/Cron</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Gói CMT (Package): <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Giới hạn tối đa số CMT của gói VIP!"></span></label>

                        <div class="col-sm-10">
                           <select id="goi" name="goi" class="form-control" onchange="tinh()">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='CMT' ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    echo "<option value='" . $ok['price'] . "'>{$ok['max']} CMTs - ".number_format($ok['price'])." VNĐ / tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="col-sm-2 control-label">Giới tính CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Chọn giới tính để VIP lọc khi CMT!"></span></label>

                        <div class="col-sm-10">
                           <select name="gender" class="form-control">
                                <option value="both" <?php echo isset($info['gender']) && $info['gender'] == 'both' ? 'selected' : ''; ?>>Cả Nam và Nữ</option>
                                <option value="male" <?php echo isset($info['gender']) && $info['male'] == 'both' ? 'selected' : ''; ?>>Chỉ Nam</option>
                                <option value="female" <?php echo isset($info['gender']) && $info['female'] == 'both' ? 'selected' : ''; ?>>Chỉ Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hashtag" class="col-sm-2 control-label">HashTag vô hiệu CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập hashtag để vô hiệu hóa VIP ở 1 status nào đó, chú ý không chứa dấu # khi nhập! Chi tiết xem ở dưới!"></span></label>

                        <div class="col-sm-10">
                           <input type="text" name="hashtag" value="<?php echo isset($info['hash_tag']) ? substr($info['hash_tag'],1,strlen($info['hash_tag'])) : ''; ?>" placeholder="Nhập hashtag ( không chứa dấu # )" class="form-control" required="" />
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
                <?php if($rule == 'agency'){ ?> <font color="red">Bạn là <b>Đại lí</b> nên được giảm 10% giá gói VIP này</font><?php }else if($rule == 'freelancer'){ ?> <font color="red">Bạn là <b>Cộng tác viên</b> được giảm 5% giá gói VIP này</font>  <?php  } ?><br />
                <hr />
                <span class="h4" style="background:red; color:yellow" id="help">Hashtag vô hiệu hóa CMT là gì?</span>
                    <br /><span class="h4" id="hash" style="display:none">Khi bạn không muốn VIP CMT hoạt động ở Status nào đó, thì nội dung Status bạn cần viết thêm hashtag này - hashtag bắt đầu là chữ, viết liền không dấu, không có kí tự đặc biệt ( viết ở bất kì đâu trong nội dung của status và phải riêng biệt - không dính liền với từ nào để VIP nhận dạng tốt nhất). Ví dụ, bạn để hashtag vô hiệu hóa CMT là <b style="color:red">no</b> ( không có dấu <b style="color:red">#</b> ở đằng trước khi thêm VIP ID) , thì khi đăng status, bạn không muốn VIP CMT hoạt động ở status này, bạn chỉ cần thêm <b style="color:red">#no</b> ( có dấu <b style="color:red">#</b> ở đằng trước khi đăng status ) vào nội dung của status đó ( ví dụ: hôm nay là 1 ngày đẹp trời <b  style="color:red">#no</b> ). <span  style="background:red; color:yellow" id="ok">Đã hiểu?</span></span>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Gia hạn</button>
                </div>
                <!-- /.box-footer -->
            </form>
            <p class="alert alert-danger" style="font-size:17px">Chú ý: Nếu mua gói nhiều CMT, các bạn nên nhập nội dung CMT nhiều 1 chút nên nhiều hơn số Max CMT của gói, mỗi CMT 1 dòng. Nội dung CMT không nên có  các kí tự đặc biệt như <b>'</b>, <b>"</b>, <b>\</b>, <b>/</b>,...<br /> Về <b>Hashtag</b> không nên chứa các kí tự đặc biệt như <b>@,#,$,!,%,^,&,*,(,),',",/,\,....</b>(chú ý không thêm dấu <b>#</b> khi cài VIP mà chỉ khi đăng tus mới thêm!) <br />Sau khi cài đặt xong, các bạn vào phần quản lí VIP CMT của mình ấn <b>Cập nhật</b> xem mọi thông tin đã đúng hết chưa để VIP hoạt động nhé!<br />Cần hỗ trợ liên hệ Admin hoặc  Fanpage tại trang chủ!</p>
        </div>
    </div>
</div>
<script>
    $('#help').click(function(){
        $('#hash').slideToggle();
    });
    $('#ok').click(function(){
        $('#hash').slideUp();
    });
</script>
