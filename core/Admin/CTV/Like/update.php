<script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>
<link rel="stylesheet" href="plugins/iCheck/all.css">
<link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
<?php
if (isset($_GET['id'])) {
    $id_like = $_GET['id'];
    $get = "SELECT user_id , name, likes, id_ctv, max_like FROM vip WHERE id=$id_like";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $uid = $x['user_id'];
    if ($rule != 'admin' && $rule !='agency') {
        if ($x['id_ctv'] != $idctv) {
            header('Location: trang-chu.html');
        }
    }
}
if (isset($_POST['submit'])) {
    $list_type = $_POST['type'];
    $type = implode("\n", $list_type);
    $name = $_POST['name'];
    $likes = $_POST['likes'];
    $user_id = $_POST['user_id'];
    $max_like = $_POST['max_like'];
    if(($rule != 'admin' && $rule !='agency') || ($rule == 'admin' && $idctv !=1)){
        $sql = "UPDATE vip SET name='$name', likes='$likes',type='$type' WHERE id='$id_like'";
    }else if($rule == 'agency' || ($rule == 'admin' && $idctv == 1)){
        $sql = "UPDATE vip SET user_id = '$user_id', max_like='$max_like', name='$name', likes='$likes',type='$type' WHERE id='$id_like'";
    }
    if (mysqli_query($conn, $sql)) {
        $time = time();
        if($rule == 'agency' || ($rule == 'admin' && $idctv == 1)){
            $content = "<b>$uname</b> vừa cập nhật VIP CTV Like ID <b>$uid</b> = > <b>$user_id</b>, Tên: <b>$name</b>, Số Like / Cron: <b>$likes</b> Likes";
        }else{
            $content = "<b>$uname</b> vừa cập nhật VIP CTV Like ID <b>$uid</b>, Tên: <b>$name</b>, Số Like / Cron: <b>$likes</b> Likes";
        }
        $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',0)";
        if (mysqli_query($conn, $his)) {
            header('Location: ctv-vipid-cam-xuc.html');
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật ID VIP LIKE</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID</label>

                        <div class="col-sm-10">
                            <?php if($rule == 'agency' || ($rule == 'admin' && $idctv == 1)){
                            ?>
                            <input type="number" class="form-control" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" name="user_id">
                        <?php }else { ?>
                            <input type="number" class="form-control" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" disabled>
                        <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($x['name']) ? $x['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="likes" class="col-sm-2 control-label">Số Like / Cron:</label>

                        <div class="col-sm-10">
                            <select name="likes" class="form-control">
                                <?php
                                for ($i = 10; $i <= 100; $i += 10) {
                                    $check = '';
                                    if ($i == $x['likes']) {
                                        $check = 'selected';
                                    }
                                    echo "<option value='$i' $check>$i Likes/Cron</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <?php if($idctv == 1){ ?>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Gói Like (Package):</label>

                        <div class="col-sm-10">
                            <select id="goi" name="max_like" class="form-control">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='LIKE' ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    $check = '';
                                    if($x['max_like'] == $ok['max']) $check = 'selected';
                                    echo "<option value='" . $ok['max'] . "' $check>{$ok['max']} Likes - ".number_format($ok['price'])." VNĐ / tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Loại: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Các loại cảm xúc được chạy khi VIP hoạt động. Chú ý nếu  chọn nhiều loại cảm xúc, mỗi lần chạy VIP sẽ chọn ngẫu nhiên cảm xúc trong danh sách bạn đã chọn, hãy chọn số lượng CX/Cron cho phù hợp với gói VIP!"></span></label>
                        <div class="col-sm-10">
                        <label style="padding-right: 10px">
                          <input type="checkbox" name="type[]" value="LIKE" class="flat-red"> <img src="core/VIP/LIKE/icon/like.png" style="width:24px" data-toggle="tooltip" title="Thích"/>
                        </label>
                        <label style="padding-right: 10px">
                          <input type="checkbox" name="type[]" value="LOVE" class="flat-red"> <img src="core/VIP/LIKE/icon/love.png" style="width:24px" data-toggle="tooltip" title="Yêu Thích" />
                        </label>
                        <label style="padding-right: 10px">
                          <input type="checkbox" name="type[]" value="HAHA" class="flat-red"> <img src="core/VIP/LIKE/icon/haha.png" style="width:24px" data-toggle="tooltip" title="Cười lớn" />
                        </label>
                        <label style="padding-right: 10px">
                          <input type="checkbox" name="type[]" value="WOW" class="flat-red"> <img src="core/VIP/LIKE/icon/wow.png" style="width:24px" data-toggle="tooltip" title="Ngạc nhiên" />
                        </label>
                        <label style="padding-right: 10px">
                          <input type="checkbox" name="type[]" value="SAD" class="flat-red"> <img src="core/VIP/LIKE/icon/sad.png" style="width:24px" data-toggle="tooltip" title="Buồn" />
                        </label>
                        <label style="padding-right: 10px">
                          <input type="checkbox" name="type[]" value="ANGRY" class="flat-red"> <img src="core/VIP/LIKE/icon/angry.png" style="width:24px" data-toggle="tooltip" title="Phẫn nộ" />
                        </label><br />
                        <?php echo isset($loi['type']) ? $loi['type'] : ''; ?>
            </div>
              </div>

                    </div>

                    </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php if($rule != 'admin'){ ?>
                         <font color="red"><b>Nếu muốn thay đổi ID VIP, liên hệ Admin. ID mới sẽ không được bù ngày mà ID cũ đã chạy nhé!</b></font>
                    <?php } ?>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
</script>