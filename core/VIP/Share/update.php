<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_GET['id'])) {
    $id_share = intval($_GET['id']);
    $get = "SELECT user_id , name, shares, id_ctv, max_share FROM vipshare WHERE id=$id_share";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
    $uid = $x['user_id'];
    if ($rule != 'admin') {
        if ($x['id_ctv'] != $idctv) {
            header('Location: trang-chu.html');
        }
    }
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $shares = $_POST['shares'];
    $max_share = $_POST['max_share'];
    $user_id = $_POST['user_id'];
    if($rule != 'admin' || $idctv != 1){
        $sql = "UPDATE vipshare SET name='$name', shares='$shares' WHERE id='$id_share'";
    }else{
        $sql = "UPDATE vipshare SET user_id = '$user_id', name='$name', shares='$shares',max_share='$max_share' WHERE id='$id_share'";
    }
    if (mysqli_query($conn, $sql)) {
        $time = time();
        if($rule != 'admin' || $idctv != 1){
            $content = "<b>$uname</b> vừa cập nhật VIP Share ID <b>$uid</b>, Tên: <b>$name</b>, Số Share / Cron: <b>$shares</b> Shares";
        }else{
            $content = "<b>$uname</b> vừa cập nhật VIP Share ID <b>$uid</b> = > <b>$user_id</b>, Tên: <b>$name</b>, Số Share / Cron: <b>$shares</b> Share, Max Share: <b>$max_share</b> Share";
        }
        $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',0)";
        if (mysqli_query($conn, $his)) {
            echo "<script>alert('Thành công');window.location='vip-chia-se.html';</script>";
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật ID VIP Share</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="ID Nick Facebook được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <?php if($rule == 'admin' && $idctv == 1){
                            ?>
                            <input type="number" class="form-control" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" name="user_id">
                        <?php }else { ?>
                            <input type="number" class="form-control" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" disabled>
                        <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Họ và tên người được cài VIP!"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" maxlength="50" value="<?php echo isset($x['name']) ? $x['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
                        </div>
                    </div>
                    <?php if($idctv == 1){ ?>
                    <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Gói Share (Package): <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Giới hạn tối đa số Share của gói VIP!"></span></label>

                        <div class="col-sm-10">
                            <select id="goi" name="max_share" class="form-control">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='SHARE' AND max <= 500 ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    $check = '';
                                    if($x['max_share'] == $ok['max']) $check = 'selected';
                                    echo "<option value='" . $ok['max'] . "' $check>{$ok['max']} Share - ".number_format($ok['price'])." VNĐ / tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="likes" class="col-sm-2 control-label">Số Share / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng Share tăng sau mỗi lần VIP được chạy!"></span></label>

                        <div class="col-sm-10">
                            <select name="shares" class="form-control">
                                <option value="9">10 Share/Cron</option>
                                <option value="18">20 Share/Cron</option>
                                <option value="47">50 Share/Cron</option>
                                <?php
                                // for ($i = 10; $i <= 50; $i += 10) {
                                //     $check = '';
                                //     if($i == $x['shares']) $check = 'selected';
                                //     echo "<option value='$i' $check>$i Share/Cron</option>";
                                // }
                                ?>
                            </select>
                        </div>
                    </div>

                    </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php if($rule != 'admin'){ ?>
                         <font color="red"><b>Nếu muốn thay đổi ID VIP, Nâng cấp lên gói cao hơn, hoặc yêu cầu xóa, tăng lượng Share / Cron, vui lòng liên hệ Admin hoặc trang Fanpage tại trang chủ.!</b></font>
                    <?php } ?>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>