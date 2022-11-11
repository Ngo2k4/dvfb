<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_POST['submit'])) {
    // if (!strpos($_SERVER['HTTP_REFERER'], 'vba.local')) {
    //     echo "<script>alert('Biến');window.location='trang-chu.html';</script>";
    // }else{
        $user_name = htmlspecialchars(addslashes($_POST['user_name']));
        $password = htmlspecialchars(addslashes(md5($_POST['password'])));
        $sql = "SELECT COUNT(*), status, id_ctvs, rule, password FROM ctv WHERE (user_name = " . "'$user_name'" . " OR email = " . "'$user_name'" . ") AND password = " . "'$password' GROUP BY status, id_ctvs, rule, password";
        $c = mysqli_query($conn, $sql);
        $check = mysqli_fetch_assoc($c);
        if ($check['COUNT(*)'] == 1) {
            if ($check['status'] == -1) {
                echo "<script>alert('Tài khoản của bạn đã bị khóa. Liên hệ Admin để được hỗ trợ!'); window.location = 'index.php';</script>";
            } else {
                if ($check['status'] == 1) {
                    $id_ctv = $check['id_ctvs'];
                    $rule = $check['rule'];
                    $pass = $check['password'];
                    $status = $check['status'];
                    // if (isset($_POST['duydeptrai'])) {
                    //     setcookie('login', 'ok', time() + 690000000);
                    //     setcookie("id_ctv", "$id_ctv", time() + 690000000);
                    //     setcookie("rule", "$rule", time() + 690000000);
                    //     setcookie("pass", "$pass", time() + 690000000);
                    //     setcookie("status", "$status", time() + 690000000);
                    //     setcookie("user_name", "$user_name", time() + 690000000);
                    //     echo "<script>alert('Đăng nhập thành công rùi nha hjhj'); window.location='index.php';</script>";
                    // } else if (!isset($_POST['duydeptrai'])) {
                        $_SESSION['login'] = 'ok';
                        $_SESSION['id_ctv'] = $id_ctv;
                        $_SESSION['rule'] = $rule;
                        $_SESSION['pass'] = $pass;
                        $_SESSION['status'] = $status;
                        $_SESSION['user_name'] = $user_name;
                        echo "<script>alert('Đăng nhập thành công rùi nha hjhj'); window.location='trang-chu.html';</script>";
                    // }
                } else if ($check['status'] == 0) {
                    echo "<p class='alert alert-danger'> Tài khoản của bạn chưa được kích hoạt. Vui lòng liên hệ <a href='//fb.com/duysexyz' target='_blank'>Admin</a> để nạp tiền CTV và kích hoạt tài khoản!!</p>";
                }
            }
        } else {
            echo "<script>alert('Tài khoản hoặc mật khẩu không chính xác!!!');</script>";
        }
    //}
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Panel đăng nhập cho Cộng tác viên</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="#">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_name" class="col-sm-2 control-label">Tài khoản hoặc địa chỉ Email:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" placeholder="Tài khoản hoặc địa chỉ Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Mật khẩu:</label>

                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <br />
                            <p style="text-align:center">
                                <code>Chưa có tài khoản? <a href='dang-ki.html'><b>Đăng kí ngay</b></a></code>
                            </p>
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <div class="col-sm-offset-2 col-sm-10">-->
                    <!--        <div class="checkbox">-->
                    <!--            <label>-->
                    <!--                <input name="duydeptrai" type="checkbox"> Ghi nhớ mật khẩu-->
                    <!--            </label>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a class="btn btn-danger" href="dang-nhap.html">ĐĂNG NHẬP CHO ĐẠI LÍ, THÀNH VIÊN</a>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Đăng nhập</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
