<script src="plugins/iCheck/icheck.min.js"></script>
<link rel="stylesheet" href="plugins/iCheck/all.css">
<?php
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $check_info = mysqli_query($conn, "SELECT post_id, cmts, max_cmt, noi_dung, id_ctv FROM buzz_cmt WHERE id=$id");
        $check = mysqli_fetch_assoc($check_info);
        if($rule != 'admin'){
            if($check['id_ctv'] != $idctv){
                echo "<script>alert('Bạn không có quyền chỉnh sửa VIP ID này!!');window.location='buzz-cmt.html';</script>";
            }
        }
    }
    if(isset($_POST['submit'])){
        $loi = array();
        if($check['post_id'] != $_POST['post_id']){
            $getnumid = mysqli_query($conn, "SELECT COUNT(*) FROM buzz_cmt WHERE post_id='{$_POST['post_id']}'");
            $getid = mysqli_fetch_assoc($getnumid);
            if($getid['COUNT(*)'] == 1){
                $loi['exists'] = '<font color=red>ID này đã tồn tại trên hệ thống</font>';
            }
        }
        if($_POST['cmts'] > $check['max_cmt']){
            $loi['overflow'] = '<font color=red>Số CMT/Cron phải <= Max CMT</font>';
        }
        if(empty($loi)){
            $cmt_conlai = $check['max_cmt'] - $check['commented'];
            if($_POST['cmts'] <= $cmt_conlai || $_POST['cmts'] <= $check['cmts']){
                $cmts = intval($_POST['cmts']);
                $post_id = htmlspecialchars(addslashes($_POST['post_id']));
                $noi_dung = htmlspecialchars(addslashes($_POST['noi_dung']));
                $update = mysqli_query($conn, "UPDATE buzz_cmt SET post_id='$post_id', cmts = '$cmts', noi_dung='$noi_dung' WHERE id=$id");
                if($update){
                    $content = "<b>$uname</b> vừa cập nhật VIP Buzz CMT ID <b>{$check['post_id']}</b> => <b>$post_id</b> , CMT/Cron: <b>$cmts<b>";
                    $time = time();
                    $ins = mysqli_query($conn, "INSERT INTO history(content, time, type, id_ctv) VALUES('$content', '$time', 0, $idctv)");
                    if($ins){
                        echo "<script>alert('Cập nhật thành công');window.location='buzz-cmt.html';</script>";
                    }
                }
            }else{
                echo "<script>alert('Không hợp lệ khi cập nhật số lượng CMT / Cron lúc này!!!');window.location='buzz-cmt.html';</script>";
            }
        }
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cập nhật ID VIP Buzz CMT</h3>
            </div>
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Post ID: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập PostID cần tăng Comment"></span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?= isset($check['post_id']) ? $check['post_id'] : ''; ?>" id="post_id" name="post_id" placeholder="Post ID" required>
                            <?php echo isset($loi['exists']) ? $loi['exists'] : ''; ?>
                        </div>
                    </div>

                
                    <div class="form-group">
                        <label for="likes" class="col-sm-2 control-label">Số CMT / Cron: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số lượng comment  tăng sau mỗi lần chạy!"></span></label>

                        <div class="col-sm-10">
                            <select name="cmts" class="form-control">
                                <?php for($i=1; $i<=20; $i++){ ?>
                                    <option value="<?= $i; ?>" <?= isset($check['cmts']) && $check['cmts'] == $i ? 'selected' : ''; ?>><?= $i; ?> CMT/Cron</option>
                                <?php } ?>
                            </select>
                            <?php echo isset($loi['overflow']) ? $loi['overflow'] : ''; ?>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="goi" class="col-sm-2 control-label">Nội dung CMT: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Nhập nội dung comment, mỗi nội dung khác nhau cách nhau 1 dòng"></span></label>

                        <div class="col-sm-10">
                            <textarea class="form-control" rows="12" placeholder="Nhập nội dung comment, mỗi dòng là 1 nội dung khác nhau" name="noi_dung"><?= isset($check['noi_dung']) ? $check['noi_dung'] : ''; ?></textarea>
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <label for="goi" class="col-sm-2 control-label">Số Like/CX cần tăng: <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" title="Số Like/CX cần tăng"></span></label>-->

                    <!--    <div class="col-sm-10">-->
                    <!--        <input name="max_like" id="max_like" class="form-control" placeholder="Nhập max like/cx cần tăng" onchange="_Like()" onkeyup="_Like()" type="number" value="10" min="10" max="1000"/>-->

                    <!--    </div>-->
                    <!--</div>-->
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

