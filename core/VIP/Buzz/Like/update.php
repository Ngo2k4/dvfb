<script src="plugins/iCheck/icheck.min.js"></script>
<link rel="stylesheet" href="plugins/iCheck/all.css">
<?php
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $check_info = mysqli_query($conn, "SELECT post_id, likes, liked, max_like, type, id_ctv FROM buzz_like WHERE id=$id");
        $check = mysqli_fetch_assoc($check_info);
        $type = explode("\n", $check['type']);
        if($rule != 'admin'){
            if($check['id_ctv'] != $idctv){
                echo "<script>alert('Bạn không có quyền chỉnh sửa VIP ID này!!');window.location='buzz-like.html';</script>";
            }
        }
    }
    if(isset($_POST['submit'])){
        $loi = array();
        if($check['post_id'] != $_POST['post_id']){
            $getnumid = mysqli_query($conn, "SELECT COUNT(*) FROM buzz_like WHERE post_id='{$_POST['post_id']}'");
            $getid = mysqli_fetch_assoc($getnumid);
            if($getid['COUNT(*)'] == 1){
                $loi['exists'] = '<font color=red>ID này đã tồn tại trên hệ thống</font>';
            }
        }
        $checkne = json_decode(file_get_contents('https://graph.fb.me/'.$_POST['post_id'].'?access_token='.$tokenx),true);
        if($checkne['likes']){
            $loi['page'] = 'Không thể sử dụng ID Page';
        }
        if(!isset($_POST['type'])){
            $loi['empty'] = '<font color=red>Vui lòng chọn ít nhất 1 loại cảm xúc!!!</font>';
        }
        if($_POST['likes'] > $check['max_like']){
            $loi['overflow'] = '<font color=red>Số Likes/Cron phải <= Max Like</font>';
        }
        if(empty($loi)){
            $likes = intval($_POST['likes']);
            $post_id = htmlspecialchars(addslashes($_POST['post_id']));
            $list_type = $_POST['type'];
            $typex = implode("\n", $list_type);
            $update = mysqli_query($conn, "UPDATE buzz_like SET post_id='$post_id', likes = '$likes', type='$typex' WHERE id=$id");
            if($update){
                $content = "<b>$uname</b> vừa cập nhật VIP Buzz Like ID <b>{$check['post_id']}</b> => <b>$post_id</b> , CX/Cron: <b>$likes<b> , Loại: <b>$typex</b>";
                $time = time();
                $ins = mysqli_query($conn, "INSERT INTO history(content, time, type, id_ctv) VALUES('$content', '$time', 0, $idctv)");
                if($ins){
                    echo "<script>alert('Cập nhật thành công');window.location='buzz-like.html';</script>";
                }
            }
        }
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật ID VIP Buzz Like</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Post ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập PostID cần tăng Like/Cảm xúc"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= isset($check['post_id']) ? $check['post_id'] : ''; ?>" id="post_id" name="post_id" placeholder="Post ID" required>
                            <?php echo isset($loi['exists']) ? $loi['exists'] : ''; ?>
                            <?php echo isset($loi['page']) ? $loi['page'] : ''; ?>
                        </div>
                    </div>

                
                    <div class="form-group">
                        <label for="likes" class="col-sm-2 control-label">Số CX / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng cảm xúc tăng sau mỗi lần chạy!"></span></label>

                        <div class="col-sm-10">
                            <select name="likes" class="form-control">
                                <option value="10" <?= isset($check['likes']) && $check['likes'] == '10' ? 'selected' : ''; ?>>10 CX/Cron</option>
                                <option value="30" <?= isset($check['likes']) && $check['likes'] == '30' ? 'selected' : ''; ?>>30 CX/Cron</option>
                                <option value="50" <?= isset($check['likes']) && $check['likes'] == '50' ? 'selected' : ''; ?>>50 CX/Cron</option>
                                <option value="100" <?= isset($check['likes']) && $check['likes'] == '100' ? 'selected' : ''; ?>>100 CX/Cron</option>
                            </select>
                            <?php echo isset($loi['overflow']) ? $loi['overflow'] : ''; ?>
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <label for="goi" class="col-sm-2 control-label">Số Like/CX cần tăng: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số Like/CX cần tăng"></span></label>-->

                    <!--    <div class="col-sm-10">-->
                    <!--        <input name="max_like" id="max_like" class="form-control" placeholder="Nhập max like/cx cần tăng" onchange="_Like()" onkeyup="_Like()" type="number" value="10" min="10" max="1000"/>-->

                    <!--    </div>-->
                    <!--</div>-->
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label">Loại: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Chọn các loại cảm xúc cần tăng ch bài viết của bạn"></span></label>
                        <div class="col-sm-10">
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="LIKE" class="flat-red" <?= in_array('LIKE',$type) ? 'checked' : ''; ?>> <img src="core/VIP/LIKE/icon/like.png" style="width:24px" data-toggle="tooltip" title="Thích"/>
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="LOVE" class="flat-red" <?= in_array('LOVE',$type) ? 'checked' : ''; ?>> <img src="core/VIP/LIKE/icon/love.png" style="width:24px" data-toggle="tooltip" title="Yêu Thích" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="HAHA" class="flat-red" <?= in_array('HAHA',$type) ? 'checked' : ''; ?>> <img src="core/VIP/LIKE/icon/haha.png" style="width:24px" data-toggle="tooltip" title="Cười lớn" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="WOW" class="flat-red" <?= in_array('WOW',$type) ? 'checked' : ''; ?>> <img src="core/VIP/LIKE/icon/wow.png" style="width:24px" data-toggle="tooltip" title="Ngạc nhiên" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="SAD" class="flat-red" <?= in_array('SAD',$type) ? 'checked' : ''; ?>> <img src="core/VIP/LIKE/icon/sad.png" style="width:24px" data-toggle="tooltip" title="Buồn" />
                            </label>
                            <label style="padding-right: 10px">
                                <input type="checkbox" name="type[]" value="ANGRY" class="flat-red" <?= in_array('ANGRY',$type) ? 'checked' : ''; ?>> <img src="core/VIP/LIKE/icon/angry.png" style="width:24px" data-toggle="tooltip" title="Phẫn nộ" />
                            </label><br />
                            <?php echo isset($loi['type']) ? $loi['type'] : ''; ?>
                        </div>
                    </div>


                  
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('input[type="checkbox"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
    });
</script>

