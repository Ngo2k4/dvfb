<?php
    if(isset($_POST['submit'])){
        $old_pass = md5($_POST['old_pass']);
        $new_pass1 = md5($_POST['new_pass1']);
        $new_pass2 = md5($_POST['new_pass2']);
        $loi = array();
        if($rule != 'freelancer'){
            $get = "SELECT password FROM member WHERE id_ctv = $idctv";
        }else{
            $get = "SELECT password FROM ctv WHERE id_ctvs = $idctv";
        }
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        if($x['password'] != $old_pass){
            $loi['old_pass'] = '<font color="red">Mật khẩu cũ không đúng</font>';
        }
        if(strcmp($new_pass1, $new_pass2) != 0){
            $loi['new_pass'] = '<font color="red">Nhập lại mật khẩu không đúng</font>';
        }
        if(($old_pass == $new_pass1) && ($old_pass == $new_pass2)){
            $loi['vl'] = 'Mật khẩu mới không được trùng với mật khẩu hiện tại';
        }
        if(empty($loi)){
            if($rule != 'freelancer'){
                $sql  = "UPDATE member SET password='$new_pass1' WHERE id_ctv=$idctv";
            }else{
                $sql  = "UPDATE ctv SET password='$new_pass1' WHERE id_ctvs=$idctv";
            }
            if(mysqli_query($conn, $sql)){
                $content = "<b>$uname</b> vừa thay đổi mật khẩu của mình.";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',1)";
                if(mysqli_query($conn, $his)){
                    echo "<script>alert('Đổi mật khẩu thành công.');window.location='trang-chu.html';</script>";
                }
            }
        }
        
    }
?><div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Đổi mật khẩu</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="oldpass" class="col-sm-2 control-label">Mật khẩu cũ:</label>

                        <div class="col-sm-10">
                            <input type="text" minlength="6" class="form-control" value="<?php echo isset($_POST['old_pass']) ? $_POST['old_pass'] : ''; ?>"id="old_pass" name="old_pass" placeholder="Mật khẩu cũ" required>
                            <?php echo isset($loi['old_pass']) ? $loi['old_pass'] : ''; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_pass1" class="col-sm-2 control-label">Mật khẩu mới:</label>

                        <div class="col-sm-10">
                            <input type="password" minlength="6" class="form-control" id="new_pass1" name="new_pass1" placeholder="Mật khẩu mới" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_pass2" class="col-sm-2 control-label">Nhập lại Mật khẩu mới:</label>
                        <div class="col-sm-10">
                            <input type="password" minlength="6" class="form-control" id="new_pass2" name="new_pass2" placeholder="Nhập lại mật khẩu mới" required>
                            <?php echo isset($loi['new_pass']) ? $loi['new_pass'] : ''; ?>
                            <?php echo isset($loi['vl']) ? $loi['vl'] : ''; ?>
                        </div>
                    </div>
                    
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Đổi mật khẩu</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
</div>
