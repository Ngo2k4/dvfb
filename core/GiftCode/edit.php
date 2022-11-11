<?php
    if($rule != 'admin' && $rule !='agency'){
        header('Location: /trang-chu.html');
    }
?>
<?php
if(isset($_GET['id_gift'])){
    $id_gift = $_GET['id_gift'];
    $get = "SELECT code, billing FROM gift WHERE id = $id_gift";
    $result = mysqli_query($conn, $get);
    $x = mysqli_fetch_assoc($result);
}
?>
<?php
if (isset($_POST['submit'])) {
    $loi = array();
    $code = $_POST['code'];
    $get = "SELECT code FROM gift";
    $result = mysqli_query($conn, $get);
    while ($x = mysqli_fetch_assoc($result)) {
        if ($x['code'] == $code) {
            $loi['err'] = "<font color='red'> Code này đã tồn tại trên hệ thống</font>";
        }
    }
    if (empty($loi)) {
        $sql = "UPDATE gift SET code = '$code' WHERE id = $id_gift";
        if (mysqli_query($conn, $sql)) {
            $content = "<b>$uname</b> vừa cập nhật Gift Code <b>".$x['code']."</b> thành code mới là <b>$code</b>";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content','$time', '$idctv',3)";
            if(mysqli_query($conn, $his)){
                echo "<script>alert('Cập nhật code thành công'); window.location='gift-code.html';</script>";
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
                <h3 class="box-title">Sửa GIFT CODE</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Code:</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="code" value="<?php echo isset($x['code']) ? $x['code'] : ''; ?>" name="code" placeholder="Nhập gift code" required>
                            <?php echo isset($loi['err']) ? $loi['err'] : ''; ?>
                        </div>
                    </div>

                    

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="submit" class="btn btn-info pull-right">Sửa Gift Code</button>
                    </div>
                    <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
</div>
