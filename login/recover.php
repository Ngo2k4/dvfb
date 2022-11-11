<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_POST['recoverpass'])) {
    $loi = array();
    $email = $_POST['email'];
    $get = "SELECT COUNT(*) FROM member WHERE email='$email' OR user_name='$email'";
    $result = mysqli_query($conn, $get);
    $check = mysqli_fetch_assoc($result);
    if ($check['COUNT(*)'] == 0) {
        $loi['404'] = '<font color="red">Email bạn vừa nhập không tồn tại trên hệ thống!</font>';
    }if (empty($loi)) {
        $get = "SELECT code, name, email FROM member WHERE email = '$email' OR user_name='$email'";
        $result = mysqli_query($conn, $get);
        $x = mysqli_fetch_assoc($result);
        $code = $x['code'];
        $name = $x['name'];
        $e = $x['email'];
        $subject = "Liên kết đặt lại mật khẩu cho tài khoản của bạn";
        $bcc = 'Vip.BestAuto.Pro - Recover Password';
        $noi_dung = "Xin chào <b>$name</b><br /><br />Chúng tôi gửi liên kết để đặt lại mật khẩu cho tài khoản của bạn.<br /><br /> <a href='https://Vip.BestAuto.Pro/index.php?DS=Recover&email=$e&code=$code' target='_blank'><span style='background:yellow; color:red'>https://Vip.BestAuto.Pro/index.php?DS=Recover&email=$e&code=$code</span></a><br /><br />Nếu đây không phải yêu cầu do bạn thực hiện, vui lòng xóa Email này. Xin cảm ơn!<br /><br />Đội ngũ <b>https://BestAuto.Pro</b>";
        if (sendDS($e, $name, $subject, $noi_dung, $bcc)) {
            echo "<script>alert('Chúng tôi đã gửi 1 email với liên kết đặt lại mật khẩu cho tài khoản của bạn. Vui lòng kiểm tra Email!!!');window.location='trang-chu.html';</script>";
        }
    }
}
if (isset($_POST['changepass'])) {
    $email = $_GET['email'];
    $new_pass = md5($_POST['password']);
    $new_code = substr(md5(time() + rand(0, 9)), 0, 8);
    $sql = "UPDATE member SET password = '$new_pass', code = '$new_code' WHERE email='$email'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Đổi mật khẩu thành công. Vui lòng đăng nhập!');window.location='dang-nhap.html';</script>";
    }
}
else if (isset($_GET['code'], $_GET['email'])) {
    $email = $_GET['email'];
    $code = $_GET['code'];
    $sql = "SELECT COUNT(*) FROM member WHERE email='$email' AND code='$code'";
    $result = mysqli_query($conn, $sql);
    $x = mysqli_fetch_assoc($result);
    if ($x['COUNT(*)'] == 1) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info wow fadeIn">
                    <div class="box-header with-border">
                        <h3 class="box-title">Đặt lại mật khẩu mới</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post" action="#">

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Mật khẩu:</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password" id="password" placeholder="Mật khẩu mới" required>
                            </div>
                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer">

                            <button type="submit" name="changepass" class="btn btn-info pull-right">Đổi mật khẩu</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>

    <?php } else {
        echo "<script>alert('Liên kết không hợp lệ hoặc đã hết hạn'); window.location='index.php';</script>";
    }
} else { ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Quên mật khẩu</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="#">

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Nhập địa chỉ Email hoặc UserName:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" name="email" id="email" placeholder="Nhập địa chỉ Email hoặc Username" required>
                            <?php echo isset($loi['404']) ? $loi['404'] : ''; ?>
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">

                        <button type="submit" name="recoverpass" class="btn btn-info pull-right">Đặt lại mật khẩu</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
<?php } ?>



