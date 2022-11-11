<?php
if (isset($_GET['id'])) {
    $id_react = $_GET['id'];
    $get = "SELECT user_id , name, type, id_ctv,limit_react,access_token FROM vipreaction WHERE id=$id_react";
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
    $name = $_POST['name'];
    $type = $_POST['type'];
    $user_id = $_POST['user_id'];
    $token = $_POST['token'];
    $limit = $_POST['limit_react'];
    if(($rule != 'admin' && $rule !='agency') || ($rule == 'admin' && $idctv !=1)){
        $sql = "UPDATE vipreaction SET name='$name',access_token='$token', type='$type' WHERE id='$id_react'";
    }else{
        $sql = "UPDATE vipreaction SET user_id='$user_id', name='$name', type='$type',access_token='$token' WHERE id='$id_react'";
    }
    if (mysqli_query($conn, $sql)) {
        $time = time();
       if($rule == 'agency' || ($rule == 'admin' && $idctv == 1)){
            $content = "<b>$uname</b> vừa cập nhật VIP Reaction ID <b>$uid</b> => <b>$user_id</b>, Tên: <b>$name</b>, Loại cảm xúc: <b>$type</b>";
        }else{
            $content = "<b>$uname</b> vừa cập nhật VIP Reaction ID <b>$uid</b>, Tên: <b>$name</b>, Loại cảm xúc: <b>$type</b>";
        }
        $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',0)";
        if (mysqli_query($conn, $his)) {
            header('Location: ctv-vipid-bot-cam-xuc.html');
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật ID VIP Reaction</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">User ID</label>

                        <div class="col-sm-10">
                            <?php if($rule == 'agency' || ($rule == 'admin' && $idctv == 1)){ ?>
                                <input type="number" class="form-control" value="<?php echo isset($x['user_id']) ? $x['user_id'] : ''; ?>" name="user_id">
                            <?php }else{ ?>
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
                        <label for="goi" class="col-sm-2 control-label">Loại Cảm Xúc:</label>

                        <div class="col-sm-10">
                            <select id="name" name="type" class="form-control">
                                
                                <option value="RANDOM" <?php if($x['type'] == 'RANDOM') echo 'selected'; ?>>RANDOM</option>
                                <option value="LOVE" <?php if($x['type'] == 'LOVE') echo 'selected'; ?>>LOVE</option>
                                <option value="HAHA" <?php if($x['type'] == 'HAHA') echo 'selected'; ?>>HAHA</option>
                                <option value="WOW" <?php if($x['type'] == 'WOW') echo 'selected'; ?>>WOW</option>
                                <option value="SAD" <?php if($x['type'] == 'SAD') echo 'selected'; ?>>SAD</option>
                                <option value="ANGRY" <?php if($x['type'] == 'ANGRY') echo 'selected'; ?>>ANGRY</option>
                                <option value="LIKE" <?php if($x['type'] == 'LIKE') echo 'selected'; ?>>LIKE</option>
                            </select>
                        </div>
                    </div>
                    <?php if($rule == 'admin' && $idctv == 1){ ?>
                    <div class="form-group">
                        <label for="limit_react" class="col-sm-2 control-label">Gói Reaction (Package):</label>

                        <div class="col-sm-10">
                            <select id="limit_react" name="limit_react" class="form-control">
                                <?php
                                $ds = "SELECT max, price FROM package WHERE type='REACTION' ORDER BY price ASC";
                                $ds_x = mysqli_query($conn, $ds);
                                while ($ok = mysqli_fetch_assoc($ds_x)) {
                                    $check  = '';
                                    if($x['limit_react'] == $ok['max']){
                                        $check = 'selected';
                                    }
                                    echo "<option value='" . $ok['max'] . "' $check>{$ok['max']} Reaction/Cron - ".number_format($ok['price'])." VNĐ / tháng</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="token" class="col-sm-2 control-label">Mã Access Token:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo isset($x['access_token']) ? $x['access_token'] : ''; ?>" id="token" name="token" placeholder="Mã access token của id vip" required>
                        </div>
                    </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" class="btn btn-warning"><a href="index.php?DS=Get_Token" target="_blank" style="color: white; font-weight: bold">Lấy Token</a></button>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
</div>