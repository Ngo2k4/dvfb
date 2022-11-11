<?php
defined('COPYRIGHT') OR exit('hihi');
if (isset($_POST['submit'])) {
    if(!empty(trim($_POST['captcha']))){
        $captcha = $_POST['captcha'];
        if($captcha == $_SESSION['captcha']){
            $user_name = htmlspecialchars(addslashes($_POST['user_name']));
            $get = "SELECT email, code FROM member WHERE user_name='$user_name'";
            $result = mysqli_query($conn, $get);
            $x = mysqli_fetch_assoc($result);
            $email = $x['email'];
            $code = $x['code'];
            $password = htmlspecialchars(addslashes(md5($_POST['password'])));
            $sql_check = "SELECT COUNT(*) FROM ctv WHERE (user_name = " . "'$user_name'" . " OR email = " . "'$user_name'" . ") AND password = " . "'$password'";
            $check_ctv = mysqli_query($conn, $sql_check);
            $ok_ctv = mysqli_fetch_assoc($check_ctv)['COUNT(*)'];
            if($ok_ctv == 1){
                echo "<p class='alert alert-danger'> Bạn là 1 Cộng tác viên ? Có vẻ như bạn đã nhầm lẫn khi đăng nhập. Cộng tác viên vui lòng đăng nhập <a href='ctv-dang-nhap.html'> <b>Tại đây</b></a> . Xin cảm ơn!</p>";
            }else{
                $sql = "SELECT COUNT(*), status, id_ctv, rule, password FROM member WHERE (user_name = " . "'$user_name'" . " OR email = " . "'$user_name'" . ") AND password = " . "'$password' GROUP BY status, id_ctv, rule, password";
                $c = mysqli_query($conn, $sql);
                $check = mysqli_fetch_assoc($c);
                if ($check['COUNT(*)'] == 1) {
                    if ($check['status'] == -1) {
                        echo "<script>alert('Tài khoản của bạn đã bị khóa. Liên hệ Admin để được hỗ trợ!'); window.location = 'trang-chu.html';</script>";
                    } else {
                        if ($check['status'] == 1) {
                            $id_ctv = $check['id_ctv'];
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
                            //     echo "<script>alert('Đăng nhập thành công rùi nha hjhj'); window.location='trang-chu.html';</script>";
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
                            if($check['rule'] == 'member'){
                            echo "<p class='alert alert-danger'> Tài khoản của bạn chưa được kích hoạt. Vui lòng click vào liên kết chúng tôi gửi vào Email đăng kí của bạn của bạn để kích hoạt. Chưa nhận được Email ? <a href='https://vip.bestauto.pro/index.php?DS=ResendEmail&email=$email&code=$code'> <b>Gửi lại Email kích hoạt</b></a></p>";
                            }else{
                              echo "<p class='alert alert-danger'> Tài khoản của bạn chưa được kích hoạt. Vui lòng liên hệ <a href='//fb.com/duysexyz' target='_blank'>Admin</a> để nạp tiền Đại Lí và kích hoạt tài khoản!!</p>";  
                            }
                        }
                    }
                }else {
                    echo "<script>alert('Tài khoản hoặc mật khẩu không chính xác!!!');</script>";
                }
            }
        }else{
             echo "<script>alert('Captcha không đúng');</script>";
        }
    }else{
        echo "<script>alert('Nhập captcha đê');</script>";
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Panel đăng nhập cho Đại lí và Thành viên</h3>
            </div>
            <form class="form-horizontal" method="post" action="#">
                <div class="box-body">
                    <div class="input-group">
                        <span class="input-group-addon">Tài khoản</span>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" placeholder="Tài khoản hoặc địa chỉ Email" data-toggle="tooltip" title="Tài khoản hoặc địa chỉ email" required autofocus>
                    </div>
                    <br />
                    
                    <div class="input-group">
                        <span class="input-group-addon">Mật khẩu</span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-toggle="tooltip" title="Nhập mật khẩu" required>
                    </div>
                    
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><img src="login/captcha.php" alt="Captcha" /></span>
                        <input type="text" class="form-control" name="captcha" id="password" placeholder="Nhập mã xác nhận" data-toggle="tooltip" title="Nhập mã xác nhận vào đây" required>
                    </div>
                    
                    
                    
                    <!--<center>-->
                    <!--    <div class="g-recaptcha" data-sitekey="6LcoK0AUAAAAAJihVxbt6YlNKlwSwXDo6rblNiI6" title="Bấm vào đây để xác nhận, có thể phải xác nhận hình ảnh, ✔ là thành công" data-toggle="tooltip"></div>-->
                        
                    <!--</center>-->
                </div>
                <div class="box-footer">
                    <a class="btn btn-danger pull-left" href="ctv-dang-nhap.html">ĐĂNG NHẬP CHO CTV</a>
                    <button type="submit" name="submit" class="btn btn-info pull-right">Đăng nhập</button>
                    
                </div>

            </form>
        </div>
    </div>
</div>
