<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php
if (!isset($rule) || $rule != 'admin' || $idctv != 1) {
    header('Location: /trang-chu.html');
} else {
    if (isset($_POST['submit'])) {
        $user_name = $_POST['user_name'];
        $money  = $_POST['money'];
        $change = "UPDATE member SET bill = '$money' WHERE user_name = '$user_name'";
        if(mysqli_query($conn,$change)){
            $content = "<b>$uname</b> vừa cập nhật số dư của <b>$user_name</b> thành <b>".number_format($money)." </b>VNĐ";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',2)";
            if(mysqli_query($conn, $his)){
                echo "<script>alert('Thành công'); window.location='cap-nhat-tien.html';</script>";
            }
        }
    }else if(isset($_POST['ctv'])) {
        $user_name = $_POST['user_ctv'];
        $money  = $_POST['money'];
        $change = "UPDATE ctv SET bill = '$money' WHERE user_name = '$user_name'";
        if(mysqli_query($conn,$change)){
            $content = "<b>$uname</b> vừa cập nhật số dư của CTV <b>$user_name</b> thành <b>".number_format($money)." </b>VNĐ";
            $time = time();
            $his = "INSERT INTO history(content, time, id_ctv, type) VALUES('$content', '$time', '$idctv',2)";
            if(mysqli_query($conn, $his)){
                echo "<script>alert('Thành công'); window.location='cap-nhat-tien.html';</script>";
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
                <h3 class="box-title">Cập nhật tiền cho Member & Đại lí</h3>
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
                            <input  type="number" class="form-control" max="100000000" name="money" placeholder="Nhập số tiền" required=""/>
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
                <h3 class="box-title">Cập nhật tiền cho CTV</h3>
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
                            
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="profile" class="col-sm-2 control-label">Số tiền (VNĐ):</label>

                        <div class="col-sm-10">
                            <input  type="number" class="form-control" max="100000000" name="money" placeholder="Nhập số tiền" required=""/>
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
