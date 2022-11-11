<?php
if($rule != 'freelancer'){
    $get = mysqli_query($conn, 'select num_sub from member where id_ctv=' . $idctv);
}else{
    $get = mysqli_query($conn, 'select num_sub from ctv where id_ctvs=' . $idctv);
}
$x = mysqli_fetch_assoc($get);

if (isset($_POST['submit'])) {
        $loi = array();
        $user_id = $_POST['user_id'];
        $check = mysqli_query($conn, "select COUNT(*) from vipsub where user_id='$user_id'");
        $c = mysqli_fetch_assoc($check);
        if ($c['COUNT(*)'] == 1) {
            $loi['exists'] = 'UID này đã tồn tại';
        }
        if (empty($loi)) {
            $name = $_POST['name'];
            $sub = $_POST['subs'];
            $max_sub = $_POST['max_sub'];
            if($sub <= $max_sub){
                if ($max_sub <= $x['num_sub'] && $max_sub >= 10) {
                    if($rule != 'freelancer'){
                        $update = mysqli_query($conn, "update member set num_sub = num_sub-$max_sub where id_ctv = $idctv");
                    }else{
                        $update = mysqli_query($conn, "update ctv set num_sub = num_sub-$max_sub where id_ctvs = $idctv");
                    }
                    if ($update) {
                        $insert = mysqli_query($conn, "insert into vipsub(user_id,name,subs,max_sub,delay,id_ctv) values('$user_id','$name','0','$max_sub','$sub','$idctv')");
                        if ($insert) {
                            $content = "<b>$uname</b> đã thêm VIP <b>$max_sub</b> Sub cho UID <b>$user_id</b>";
                            $time = time();
                            $his = mysqli_query($conn, "insert into history(content, time, id_ctv, type) values('$content','$time','$idctv','$type')");
                            if ($his) {
                                echo "<script>alert('Thêm thành công');window.location='sub.html';</script>";
                            }
                        }
                    }
                } else {
                    echo "<script>alert('Số sub bạn đang có đéo đủ hoặc số sub mua không hợp lệ (tối thiểu >= 10).');window.location='them-sub.html';</script>";
                }
            }else{
                 echo "<script>alert('Số sub/cron phải <= Max Sub');window.location='them-sub.html';</script>";
            }
        }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm ID Sub</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" onkeyup="checksub()" onchange="checksub();" id="user_id" value="<?php echo isset($_POST['user_id']) ? $_POST['user_id'] : ''; ?>" name="user_id" placeholder="User ID" required>
                            <p id="getsub"></p>
                            <?php echo isset($loi['err']) ? $loi['err'] : ''; ?>
                            <?php echo isset($loi['exists']) ? $loi['exists'] : ''; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="likes" class="col-sm-2 control-label">Số Sub / Cron:</label>

                        <div class="col-sm-10">
                            <select name="subs" class="form-control">
                                <?php
                                for ($i = 10; $i <= 100; $i += 10) {
                                    echo "<option value='$i'>$i Sub/Cron</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Max sub (tăng tối đa 4K / UserID - Bạn còn <code><?= $x['num_sub']; ?> Sub</code>)</label>

                        <div class="col-sm-10">
                            <input type="number" min="10" max="4000" class="form-control" placeholder="Nhập max sub" name="max_sub"/>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function checksub() {
        if ($('#user_id').val().trim()) {
            $('#getsub').text('Đang check...');
            $.post('core/VIP/Sub/check.php', {uid: $('#user_id').val()}, function (ds) {
                var duy = JSON.parse(ds);
                if (duy.status == 'OK') {
                    $('#getsub').html(duy.sub);
                    $('#name').val(duy.name);
                }else{
                    $('#getsub').html(duy.sub);
                    $('#name').val(duy.name);
                }
            });
        }
    }
</script>