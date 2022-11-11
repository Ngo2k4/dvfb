<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<script>
    function tinh(){
        $.post('core/VIP/price.php', { han: $('#han').val(), goi: $('#goi').val(), rule: $('#rule').val()}, function(result){$('#result').html(result);});
    }
    function checkid() {
        $(function () {
            $('#name').val('Đang kiểm tra....');
            $.post('core/VIP/checkid.php', {user_id: $('#user_id').val()}, function (r) {
                $('#name').val(r);
            });
        });
    }
     // function lay id tu link fb
    function getID() {
        var profile = $('#link_profile').val().trim();
        var type = $('#type').val().trim();
        if (profile != '' && type != '') {
            $('#check_uid').html('<i class="fa fa-spinner fa-spin"></i> Đang lấy ID...');
            $.post('core/VIP/checkid.php', {link: profile, type: type}, function (ds) {
                $('#result_uid').html(ds);
                $('#check_uid').html('Lấy ID');
            });
        } else {
            alert('Vui lòng nhập địa chỉ Facebook cần Get ID');
        }
    }
</script>
<?php
    $get_pack = mysqli_query($conn, "SELECT COUNT(*), MIN(price) FROM package WHERE type='CMT'");
$package = mysqli_fetch_assoc($get_pack);
if ($package['COUNT(*)'] == 0) {
    echo "<script>alert('Chưa có package nào, Thêm ngay?');window.location='index.php?DS=Add_Package_CMT';</script>";
}
?>
<?php
if (isset($_POST['submit'])) {
    if ($_POST['han'] < 0 || $_POST['han'] > 12 || $_POST['goi'] < $package['MIN(price)']) {
        echo "<script>alert('Địt con mẹ mày luôn, bug tiếp hộ bố mày cái ?'); window.location='trang-chu.html';</script>";
    } else {
        $loi = array();
        $uid = $_POST['user_id'];
        $get = "SELECT COUNT(user_id) FROM vipcmt WHERE user_id = $uid";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if ($x['COUNT(user_id)'] > 0) {
            $loi['err'] = '<font color="red">User ID này đã tồn tại trên hệ thống</font>';
        }
        // $checkne = mysqli_query($conn,"SELECT COUNT(*) FROM free WHERE uid = '$uid' AND type='CMT'");
        // $numm = mysqli_fetch_assoc($checkne)['COUNT(*)'];
        // if($_POST['han'] == 'one' && $numm == 1){
        //     $loi['exists'] = '<font color="red">ID này đã được Test!</font>';
        // }
        if (empty($loi)) {
            $name = $_POST['name'];
            $han = $_POST['han'];
            $cmt = $_POST['cmt'];
            $goi = $_POST['goi'];
            $hashtag = "#".$_POST['hashtag'];
            $gender = $_POST['gender'];
            $noidung = trim(htmlspecialchars($_POST['noi_dung']));
            $start = time();
            // if ($han == 'one') {
            //     if($rule == 'admin'){
            //         $price = 0;
            //         $end = $start + 86400;
            //         $max_cmt = 10;
            //         $han = 'one';
            //         mysqli_query($conn, "INSERT INTO free(uid, type, id_ctv) VALUES('$uid','CMT',$idctv)");
            //     }else{
            //          echo "<script>alert('Bug à em??');</script>";
            //     }
            // } else if ($han == 'three') {
            //     if($rule == 'admin'){
            //         $price = 0;
            //         $end = $start + 86400 * 3;
            //         $max_cmt = 10;
            //         $han = 'three';
            //     }else{
            //          echo "<script>alert('Bug à em??');</script>";
            //     }
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
                    $sql = "INSERT INTO vipcmt(user_id, name, han, start, end, cmts, max_cmt, id_ctv, pay, noi_dung,hash_tag,gender) VALUES('$uid','$name','$han','$start','$end','$cmt','$max_cmt','$idctv','$price','$noidung','$hashtag','$gender')";
                    if (mysqli_query($conn, $sql)) {
                        if($rule !='freelancer'){
                            $up = "UPDATE member SET num_id = num_id + 1, payment = payment + $price WHERE id_ctv=$idctv";
                        }else{
                            $up = "UPDATE ctv SET num_id = num_id + 1, payment = payment + $price WHERE id_ctvs=$idctv";
                        }
                        if(mysqli_query($conn, $up)){
                            if($rule !='freelancer'){
                                $minus = "UPDATE member SET bill = bill - $price WHERE id_ctv = $idctv";
                            }else{
                                $minus = "UPDATE ctv SET bill = bill - $price WHERE id_ctvs = $idctv";
                            }
                            if (mysqli_query($conn, $minus)) {
                                if($han == 'one'){
                                    $content = "<b>$uname</b> vừa thêm VIP CMT cho ID <b>$uid</b>. Thời hạn <b>1 ngày </b> tháng, gói <b>$max_cmt</b> CMT, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                                }else if($han == 'three'){
                                    $content = "<b>$uname</b> vừa thêm VIP CMT cho ID <b>$uid</b>. Thời hạn <b>3 ngày </b> tháng, gói <b>$max_cmt</b> CMT, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                                }else if($han == 'seven'){
                                    $content = "<b>$uname</b> vừa thêm VIP CMT cho ID <b>$uid</b>. Thời hạn <b>7 ngày </b> tháng, gói <b>$max_cmt</b> CMT, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                                }else{
                                    $content = "<b>$uname</b> vừa thêm VIP CMT cho ID <b>$uid</b>. Thời hạn <b>$han</b> tháng, gói <b>$max_cmt</b> CMT, tổng thanh toán <b>" . number_format($price) . " VNĐ </b>";
                                }
                                $time = time();
                                $his = "INSERT INTO history(content,id_ctv,time,type) VALUES('$content','$idctv', '$time',0)";
                                if (mysqli_query($conn, $his)) {
                                    if($price >= 20000){
                                        mysqli_query($conn, "UPDATE event SET turn = turn + 1 WHERE user_name='$uname' AND rule = '$rule'");
                                    }
                                    echo '<script>alert("Thêm thành công"); window.location="vip-binh-luan.html";</script>';
                                }
                            }
                        }
                    }
                } else {
                    echo '<script>alert("Số dư tài khoản của bạn không đủ !!! Vui lòng nạp thêm tiền đi nha!1");location.href="them-vip-binh-luan.html";</script>';
                }
            }else{
                echo "<script>alert('Vui lòng chọn số CMT/cron nhỏ hơn hoặc bằng gói CMT');window.location='them-vip-binh-luan.html';</script>";
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
                <h3 class="box-title">Thêm ID VIP CMT</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                    <input type="hidden" id="rule" value="<?php echo $rule; ?>" />
                        <label for="user_id" class="col-sm-2 control-label">User ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="ID Nick Facebook được cài VIP!"></span></label>

                          <div class="col-sm-10">
                            <div class="input-group">
                                <input type="number" class="form-control" onchange="checkid()" onkeyup="checkid()" id="user_id" value="<?php echo isset($_POST['user_id']) ? $_POST['user_id'] : ''; ?>" name="user_id" placeholder="User ID" required>
                            <p id="duysex"></p>
                            <?php echo isset($loi['err']) ? $loi['err'] : ''; ?>
                            <?php echo isset($loi['exists']) ? $loi['exists'] : ''; ?>
                                <span class="input-group-addon"><a href="#get_uid" data-toggle="modal" style="text-decoration:none; color:red;font-weight:bold; cursor:pointer">Lấy ID</a></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Họ và tên người được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
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
                            <textarea class="form-control" rows="10" name="noi_dung" placeholder="Nội dung CMT, nội dung khác nhau cách nhau bởi dấu xuống dòng (Enter)" required><?php echo isset($_POST['noi_dung']) ? $_POST['noi_dung'] : ''; ?></textarea>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="cmt" class="col-sm-2 control-label">Số CMT / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng CMT tăng sau mỗi lần VIP được chạy!"></span></label>

                        <div class="col-sm-10">
                            <select id="cmt" name="cmt" class="form-control" required="">
                                <?php
                                for ($i = 2; $i <= 10; $i++) {
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
                                <option value="both">Cả Nam và Nữ</option>
                                <option value="male">Chỉ Nam</option>
                                <option value="female">Chỉ Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hashtag" class="col-sm-2 control-label">HashTag vô hiệu CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập hashtag để vô hiệu hóa VIP ở 1 status nào đó, chú ý không chứa dấu # khi nhập! Chi tiết xem ở dưới!"></span></label>

                        <div class="col-sm-10">
                           <input type="text" name="hashtag" value="" placeholder="Nhập hashtag ( không chứa dấu # )" class="form-control" required="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Thành tiền: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Tổng số tiền cần thanh toán!"></span></label>

                        <div class="col-sm-10">
                            <span style="background:red; color:yellow" class="h4" id="result"><script>tinh();</script>.</span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                <?php if($rule == 'agency'){ ?> <font color="red">Bạn là <b>Đại lí</b> nên được giảm 10% giá gói VIP này</font><?php }else if($rule == 'freelancer'){ ?> <font color="red">Bạn là <b>Cộng tác viên</b> được giảm 5% giá gói VIP này</font>  <?php  } ?><br />
                <hr />
                <span class="h4" style="background:red; color:yellow" id="help">Hashtag vô hiệu hóa CMT là gì?</span>
                    <br /><span class="h4" id="hash" style="display:none">
                        - Được sử dụng khi bạn không muốn VIP CMT hoạt động ở 1 status/ảnh nào đó<br />
                        - Để hashtag hoạt động bạn chỉ cần thêm vào nội dung của status, caption của ảnh hashtag mà bạn đã cài đặt ( chú ý có dấu <code>#</code> ở đằng trước )<br />
                        - Ví dụ: bạn cài đặt VIP và để nội dung hashtag là <code>no</code> ( khi cài thì không cần thêm dấu <code>#</code> nhé). Sau đó bạn đăng status có nội dung <code>Anh DuySexy đẹp chai quá</code> , và nếu bạn không muốn VIP CMT hoạt động ở status này, thì bạn phải để nội dung là <code>Anh DuySexy đẹp chai quá #no</code> ( có dấu <code>#</code> trước hashtag khi đăng nội dung nhé ).<br/>
                       - Nhắc lại: Khi cài VIP thì hashtag không có dấu <code>#</code> , còn khi đăng status thì có thêm dấu <code>#</code> đằng trước ! (Ex: <code>no</code> khi cài và <code>#no</code> khi đăng status<br />
                        <span  style="background:red; color:yellow" id="ok">Đã hiểu?</span>
                        </span>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm</button>
                </div>
                <!-- /.box-footer -->
            </form>
            <p class="alert alert-danger" style="font-size:17px">
                - Không sử dụng các kí tự đặc biệt , biểu tượng icon, dấu <code>'</code> và dấu <code>"</code> vào nội dung comment nếu không VIP sẽ lỗi hoặc không hoạt động, chúng tôi không chịu trách nhiệm về vấn đề này!!<br />
                - Hệ thống lọc trùng nội dung nên các bạn chú ý luôn luôn nhập số lượng nội dung nhiều hơn <code>Max CMT</code>
            </p>
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
<!-- Modal get uid -->
<div id="get_uid" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align:center">Nhập địa chỉ Facebook cần lấy vào ô bên dưới. Ví dụ: <kbd>https://www.facebook.com/DuySexyZ</kbd></h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-lg">
                    <input type="text" class="form-control" id="link_profile" placeholder="Ví dụ: https://www.facebook.com/DuySexyZ"  />
                    <span class="input-group-addon" id="check_uid" onclick="getID()" style="color:red; font-weight:bold; cursor:pointer">Lấy  ID</span>
                    <select class="form-control" id="type">
                        <option value="person">Trang cá nhân</option>
                        <option value="page">Trang fanpage</option>
                    </select>
                </div>
                <div style="text-align:center">
                    <span id="result_uid" style="font-size:17px"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>

    </div>
</div>