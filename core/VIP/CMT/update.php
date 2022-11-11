<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_GET['id'])) {
    $id_cmt = intval($_GET['id']);
    $get = "SELECT user_id , name, cmts, id_ctv, noi_dung, max_cmt,gender,hash_tag FROM vipcmt WHERE id=$id_cmt";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $uid = $x['user_id'];
    if ($rule != 'admin') {
        if ($x['id_ctv'] != $idctv) {
            echo "<script>alert('CÚT'); window.location='vip-binh-luan.html';</script>";
        }
    }
}
if (isset($_POST['submit'])) {
    $gender = $_POST['gender'];
    $hashtag = '#'.$_POST['hashtag'];
    $name = $_POST['name'];
    $cmt = $_POST['cmt'];
    $noidung = $_POST['noi_dung'];
    $user_id = $_POST['user_id'];
    $max_cmt = $_POST['max_cmt'];
    if($cmt <= $x['max_cmt']){
        if($rule != 'admin' || $idctv != 1){
           $sql = "UPDATE vipcmt SET user_id='$user_id', name='$name', cmts='$cmt', noi_dung='$noidung', gender='$gender',hash_tag='$hashtag' WHERE id='$id_cmt'";
        }else{
            $sql = "UPDATE vipcmt SET user_id='$user_id', name='$name', cmts='$cmt', noi_dung='$noidung',max_cmt='$max_cmt', gender='$gender',hash_tag='$hashtag' WHERE id='$id_cmt'";
        }
        if (mysqli_query($conn, $sql)) {
            $time = time();
            if($rule != 'admin' || $idctv != 1){
                $content = "<b>$uname</b> vừa cập nhật VIP CMT ID <b>$uid</b>, Tên: <b>$name</b>, Số CMT / Cron: <b>$cmt</b> CMTs, Giới tính: <b>$gender</b>, Hashtag: <b>$hashtag</b>";
            }else{
                $content = "<b>$uname</b> vừa cập nhật VIP CMT ID <b>$uid</b> = > <b> $user_id</b>, Tên: <b>$name</b>, Số CMT / Cron: <b>$cmt</b> CMTs,  Giới tính: <b>$gender</b>, Hashtag: <b>$hashtag</b>";
            }
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',0)";
            if (mysqli_query($conn, $his)) {
                header('Location: vip-binh-luan.html');
            }
        }
    }else{
        // ko update
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật ID VIP CMT</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="ID Nick Facebook được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" name="user_id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Họ và tên người được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($x['name']) ? $x['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cmt" class="col-sm-2 control-label">Số CMT / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng CMT tăng sau mỗi lần VIP được chạy!"></span></label>

                        <div class="col-sm-10">
                            <select name="cmt" class="form-control">
                                <?php
                                for ($i = 2; $i <= 10; $i++) {
                                    $check = '';
                                    if ($i == $x['cmts']) {
                                        $check = 'selected';
                                    }
                                    echo "<option value='$i' $check>$i CMT/Cron</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php if($rule == 'admin' && $idctv == 1){ ?>
                    <div class="form-group">
                        <label for="max_cmt" class="col-sm-2 control-label">Gói CMT (Package): <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Giới hạn tối đa số CMT của gói VIP!"></span></label>

                        <div class="col-sm-10">
                           <select id="max_cmt" name="max_cmt" class="form-control">
                                <?php
                                    $ds = "SELECT max, price FROM package WHERE type='CMT' ORDER BY price ASC";
                                    $ds_x = mysqli_query($conn, $ds);
                                    while ($ok = mysqli_fetch_assoc($ds_x)) {
                                        $check = '';
                                        if($x['max_cmt'] == $ok['max']){
                                            $check = 'selected';
                                        }
                                        echo "<option value='" . $ok['max'] . "' $check>{$ok['max']} CMTs - ".number_format($ok['price'])." VNĐ / tháng</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                     <div class="form-group">
                        <label for="noi_dung" class="col-sm-2 control-label">Nội dung: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Danh sách các nội dung bình luận, mỗi dòng 1 nội dung khác nhau!"></span></label>
                        

                        <div class="col-sm-10">
                            <textarea class="form-control" name="noi_dung" rows="10" required><?php echo isset($x['noi_dung']) ? $x['noi_dung'] : ''; ?></textarea>
                            
                        </div>
                    </div>
                </div>
                <div class="form-group">
                        <label for="gender" class="col-sm-2 control-label">Giới tính CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Chọn giới tính để VIP lọc khi CMT!"></span></label>

                        <div class="col-sm-10">
                           <select name="gender" class="form-control">
                                <option value="both" <?php if($x['gender'] == 'both') { echo 'selected'; }?>>Cả Nam và Nữ</option>
                                <option value="male" <?php if($x['gender'] == 'male') { echo 'selected'; }?>>Chỉ Nam</option>
                                <option value="female" <?php if($x['gender'] == 'female') { echo 'selected'; } ?>>Chỉ Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hashtag" class="col-sm-2 control-label">HashTag vô hiệu CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập hashtag để vô hiệu hóa VIP ở 1 status nào đó, chú ý không chứa dấu # khi nhập! Chi tiết xem ở dưới!"></span></label>

                        <div class="col-sm-10">
                           <input type="text" name="hashtag" value="<?php echo substr($x['hash_tag'],1,strlen($x['hash_tag'])); ?>" placeholder="Nhập hashtag ( không chứa dấu # )" class="form-control" required="" />
                        </div>
                    </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php if($rule != 'admin'){ ?>
                         <font color="red"><b>Nếu muốn thay đổi ID VIP, Nâng cấp lên gói cao hơn, yêu cầu xóa, tăng lượng CMT / Cron,  vui lòng liên hệ Admin hoặc trang Fanpage tại trang chủ.!</b></font>
                    <?php } ?>
                    
                   <span class="h4" style="background:red; color:yellow" id="help">Hashtag vô hiệu hóa CMT là gì?</span>
                    <br /><span class="h4" id="hash" style="display:none">
                        - Được sử dụng khi bạn không muốn VIP CMT hoạt động ở 1 status/ảnh nào đó<br />
                        - Để hashtag hoạt động bạn chỉ cần thêm vào nội dung của status, caption của ảnh hashtag mà bạn đã cài đặt ( chú ý có dấu <code>#</code> ở đằng trước )<br />
                        - Ví dụ: bạn cài đặt VIP và để nội dung hashtag là <code>no</code> ( khi cài thì không cần thêm dấu <code>#</code> nhé). Sau đó bạn đăng status có nội dung <code>Anh DuySexy đẹp chai quá</code> , và nếu bạn không muốn VIP CMT hoạt động ở status này, thì bạn phải để nội dung là <code>Anh DuySexy đẹp chai quá #no</code> ( có dấu <code>#</code> trước hashtag khi đăng nội dung nhé ).<br/>
                        - Nhắc lại: Khi cài VIP thì hashtag không có dấu <code>#</code> , còn khi đăng status thì có thêm dấu <code>#</code> đằng trước ! (Ex: <code>no</code> khi cài và <code>#no</code> khi đăng status<br />
                        <span  style="background:red; color:yellow" id="ok">Đã hiểu?</span>
                        </span>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
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