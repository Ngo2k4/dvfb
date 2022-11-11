<?php
if($rule !='admin'){
    header('Location: trang-chu.html');
}
?>
<?php
if (isset($_POST['submit'])) {
    $loi = array();
    $get = "SELECT user_name, email,profile FROM member";
    $result = mysqli_query($conn, $get);
    while ($x = mysqli_fetch_assoc($result)) {
        if ($x['user_name'] == $_POST['user_name']) {
            $loi['user_name'] = "<font color='red'>Đã có người sử dụng username này!</font>";
        }
        if ($x['email'] == $_POST['email']) {
            $loi['email'] = "<font color='red'>Đã có người sử dụng email này!</font>";
        }
        if($x['profile'] == $_POST['profile']){
            $loi['profile'] = '<font color=red>Đã có người sử dụng UserID này!</font>';
        }
    }
    if (strcmp($_POST['password'], $_POST['password2']) != 0) {
        $loi['pass'] = "<font color='red'>2 mật khẩu không trùng nhau!</font>";
    }
    if (empty($loi)) {
        if($_POST['money'] < 0){
            echo "<script>alert('Không hợp lệ');window.location='trang-chu.html';</script>";
        }else{
            $pass = $_POST['password'];
            $user_name = htmlspecialchars(addslashes($_POST['user_name']));
            $password = htmlspecialchars(addslashes(md5($_POST['password'])));
            $hoten = htmlspecialchars(addslashes($_POST['name']));
            $sdt = htmlspecialchars(addslashes($_POST['sdt']));
            $email = htmlspecialchars(addslashes($_POST['email']));
            $profile = htmlspecialchars(addslashes($_POST['profile']));
            $bill = $_POST['money'];
            $status = '0';
            $code = substr(md5(time() + rand(0, 9)), 0, 8);
            $sql = "INSERT INTO member(user_name, password, name, phone, email, profile, bill, status, code,rule) VALUES('$user_name','$password','$hoten','$sdt','$email','$profile','$bill','$status','$code','agency')";
            if (mysqli_query($conn, $sql)) {
                $payment = "UPDATE member SET payment = payment + $bill WHERE id_ctv=$idctv";
                if(mysqli_query($conn, $payment)){
                    $minus = "UPDATE member SET bill = bill - $bill WHERE id_ctv=$idctv";
                    if (mysqli_query($conn, $minus)) {
                            $content = "<b>$uname</b> vừa tạo tài khoản <b>Đại Lí: $hoten ( $user_name )</b>. Số dư tài khoản <b>".number_format($bill)." </b> VNĐ";
                        $time = time();
                        $his = "INSERT INTO history(content, id_ctv, time , type) VALUES('$content','$idctv','$time','1')";
                        if(mysqli_query($conn, $his)){
                            echo "<script>alert('Đăng kí thành công, tài khoản này chưa đươc kích hoạt, quản lí lại mục Quản lí Đại Lí!');window.location='dai-li.html';</script>";
                        }
                    }
                }
            }
        }
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Tạo tài khoản Đại Lí</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Tài khoản:</label>

                        <div class="col-sm-10">
                            <input type="text" minlength="4" class="form-control" id="user_name" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" name="user_name" placeholder="Tài khoản" required>
                            <?php echo isset($loi['user_name']) ? $loi['user_name'] : ''; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Mật khẩu:</label>

                        <div class="col-sm-10">
                            <input type="password" minlength="6" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password2" class="col-sm-2 control-label">Nhập lại Mật khẩu:</label>
                        <div class="col-sm-10">
                            <input type="password" minlength="6" class="form-control" id="password2" name="password2" placeholder="Nhập lại password" required>
                            <?php echo isset($loi['pass']) ? $loi['pass'] : ''; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Họ tên:</label>

                        <div class="col-sm-10">
                            <input type="text" minlength="2" class="form-control" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" id="name" name="name" placeholder="Họ và tên" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Số điện thoại:</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="sdt" value="<?php echo isset($_POST['sdt']) ? $_POST['sdt'] : ''; ?>" name="sdt" placeholder="Số điện thoại" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email:</label>

                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" name="email" placeholder="Địa chỉ Email" required>
                            <?php echo isset($loi['email']) ? $loi['email'] : ''; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">ID Facebook:</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="profile" value="<?php echo isset($_POST['profile']) ? $_POST['profile'] : ''; ?>" name="profile" placeholder="Nhập user id facebook" required>
                            <?php echo isset($loi['profile']) ? $loi['profile'] : ''; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Số tiền (trừ vào số dư của bạn):</label>

                        <div class="col-sm-10">
                            <input type="number" class="form-control" min="1" id="money" value="<?php echo isset($_POST['money']) ? $_POST['money'] : ''; ?>" name="money" placeholder="Nhập số dư của tài khoản sau khi tạo thành công" required>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    
                    <button type="submit" name="submit" class="btn btn-info pull-right">Tạo tài khoản</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
