<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php
if (!isset($rule) || $rule != 'admin' || $idctv !=1) {
    header('Location: /trang-chu.html');
}else{
    if (isset($_POST['submit'])) {
        if($_POST['money'] < 0){
            echo "<script>alert('Không hợp lệ');window.location='trang-chu.html';</script>";
        }else{
            $user_name = $_POST['user_name'];
            $get = "SELECT id_ctv FROM member WHERE user_name='$user_name'";
            $result = mysqli_query($conn, $get);
            $x = mysqli_fetch_assoc($result);
            $id = $x['id_ctv'];
            $money = $_POST['money'];
            $time = time();
            $sql = "UPDATE member SET bill = bill + $money WHERE user_name = '$user_name'";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> vừa cộng <b>".number_format($money)." VNĐ</b> cho tài khoản <b>$user_name</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',2)";
                if (mysqli_query($conn, $his)) {
                    $c = "<b>$user_name</b> vừa được <b>$uname</b> cộng <b>".number_format($money)." VNĐ vào tài khoản";
                    $t = time();
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time', '$id')";
                    if(mysqli_query($conn, $noti)){
                        echo "<script>alert('Cộng tiền thành công'); window.location='cong-tien.html';</script>";
                    }
                }
            }
        }
    }else if(isset($_POST['ctv'])){
        if($_POST['money'] < 0){
            echo "<script>alert('Không hợp lệ');window.location='trang-chu.html';</script>";
        }else{
            $user_name = $_POST['user_ctv'];
            $get = "SELECT id_ctvs FROM ctv WHERE user_name='$user_name'";
            $result = mysqli_query($conn, $get);
            $x = mysqli_fetch_assoc($result);
            $id = $x['id_ctvs'];
            $money = $_POST['money'];
            $time = time();
            $sql = "UPDATE ctv SET bill = bill + $money WHERE user_name = '$user_name'";
            if (mysqli_query($conn, $sql)) {
                $content = "<b>$uname</b> vừa cộng cho CTV <b>".number_format($money)." VNĐ</b> cho tài khoản <b>$user_name</b>";
                $time = time();
                $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',2)";
                if (mysqli_query($conn, $his)) {
                    $c = "CTV <b>$user_name</b> vừa được <b>$uname</b> cộng <b>".number_format($money)." VNĐ vào tài khoản";
                    $t = time();
                    $noti = "INSERT INTO noti(content, time, id_ctv) VALUES('$content','$time', '$id')";
                    if(mysqli_query($conn, $noti)){
                        echo "<script>alert('Cộng tiền thành công'); window.location='cong-tien.html';</script>";
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
                <h3 class="box-title">Cộng tiền cho Member & Đại lí</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">UserName:</label>

                        <div class="col-sm-10">
                        <input list="user_name" name="user_name">
                            <datalist id="user_name">
                            <?php
                                $get = "SELECT user_name, name, bill,rule FROM member ORDER BY user_name ASC";
                                $result = mysqli_query($conn, $get);
                                while ($x = mysqli_fetch_assoc($result)) {
                                    $user_name = $x['user_name'];
                                    $name1 = $x['name'];
                                    $bill1 = number_format($x['bill']);
                                    $rl = '';
                                    if($x['rule'] == 'agency'){
                                        $rl = 'Đại lí - ';
                                    }else{
                                        $rl = 'Member - ';
                                    }
                                    echo "<option value='$user_name'>$rl $name1 ( $user_name ) - $bill1 VNĐ";
                                }
                                ?>
                                </datalist>
            
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Số tiền (VNĐ):</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" min="1" max="100000000" name="money" placeholder="Nhập số tiền" required=""/>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info pull-right">Thực hiện</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info wow fadeIn">
            <div class="box-header with-border">
                <h3 class="box-title">Cộng tiền cho CTV</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="#" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_id" class="col-sm-2 control-label">UserName:</label>

                        <div class="col-sm-10">
                        <input list="user_ctv" name="user_ctv">
                            <datalist id="user_ctv">
                            <?php
                             
                                $get = "SELECT user_name, name, bill FROM ctv ORDER BY user_name ASC";
                                $result = mysqli_query($conn, $get);
                                while ($x = mysqli_fetch_assoc($result)) {
                                    $user_name = $x['user_name'];
                                    $name2 = $x['name'];
                                    $bill2 = number_format($x['bill']);
                                    echo "<option value='$user_name'>Cộng tác viên - $name2 ( $user_name ) - $bill2 VNĐ";
                                }
                                ?>
                                </datalist>
                            <!-- <select name="user_name" class="form-control">
                                <?php
                                // $get = "SELECT user_name, name, bill FROM member ORDER BY user_name ASC";
                                // $result = mysqli_query($conn, $get);
                                // while ($x = mysqli_fetch_assoc($result)) {
                                //     $user_name = $x['user_name'];
                                //     $name = $x['name'];
                                //     $bill = number_format($x['bill']);
                                //     echo "<option value='$user_name'>$name ($user_name) - $bill VNĐ</option>";
                                // }
                                ?>

                            </select> -->
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Số tiền (VNĐ):</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" min="1" max="100000000" name="money" placeholder="Nhập số tiền" required=""/>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="ctv" class="btn btn-info pull-right">Thực hiện</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>
