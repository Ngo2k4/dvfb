<?php defined('COPYRIGHT') OR exit('hihi'); ?>
<?php
if ($rule != 'admin') {
    echo "<script>alert('CÚT!!');window.location='index.php';</script>";
}
if(isset($_POST['xoa'])){
    mysqli_query($conn, "DELETE FROM member WHERE payment = 0 and bill = 1000");
    echo "<script>alert('Thành công !!');location.href='thanh-vien.html';</script>";
}
?>
<script>
    function check(id, me, num,rule) {
        if (id == me) {
            alert('Ngu à mà xóa mày??!!!');
            return false;
        } else if(id == 1){
            alert('Không thể xóa trùm!!!');
            return false;
        } else if(rule == 'admin' && me != 1){
            alert('Không thể xóa admin này!!!');
            return false;
        } else if (num > 0) {
            alert('Member này đang cài ' + num + ' ID VIP trên hệ thống. Không thể xóa!!');
            return false;
        } else {
            if (confirm('Bạn cũng sẽ xóa toàn bộ thông báo và lịch sử hoạt động của Member này. Tiếp tục ?') == true) {
                window.location = 'index.php?DS=Delete_Member&id_ctv=' + id;
            } else {
                return false;
            }
        }
    }

    function check1(me,id, type,rule) {
        if(type == 'lock'){
            if (id == me) {
            alert('Ngu à mà khóa mày??!!!');
            return false;
        } else if(id == 1){
            alert('Không thể khóa trùm!!!');
            return false;
        } else if(rule == 'admin' && me != 1){
            alert('Không thể khóa admin này!!!');
            return false;
            }else{
            if (confirm('Bạn có muốn khóa Member này?') == true) {
                window.location = 'index.php?DS=Update_Member&id_ctv=' + id + '&type=lock';
            }
        }
    }
}
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách Member</h3><?php if($rule == 'admin' && $idctv == 1){ ?> <form method="post"><button type="submit" name="xoa" class="btn btn-danger">Xóa Member Ko Hoạt động</button></form> <?php } ?>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Usernane</th>
                        <th>IDFB</th>
                        <th>Email</th>
                        <th>Số dư</th>
                        <th>Doanh thu</th>
                        <th>IDs VIP</th>
                        <th>Trạng thái</th>
                        <th>Rule</th>
                        <th>Công cụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get = "SELECT id_ctv, name, rule, user_name, phone, email, profile, bill, status,num_id,payment FROM member WHERE rule !='agency'";
                    $result = mysqli_query($conn, $get);
                    while ($x = mysqli_fetch_assoc($result)) {
                        $rl = '';
                        $id = $x['id_ctv'];
                        $num = $x['num_id'];
                        $rulex = $x['rule'];
                        $rl = '';
                        if($x['rule'] == 'admin'){
                            $rl = '<font color=red>Admin</font>';
                        }else{
                            $rl = '<font color=blue>Memb</font>';
                        }
                        $z = '<a onClick="check1('.$idctv.','.$id.','."'lock'".','. "'$rulex'".')" class="btn btn-danger">Khóa</a>';
                        $active = '';
                        $tt = '<font color="green">Đã kích hoạt</font>';
                        if ($x['status'] == 0) {
                            $active = "<a href='index.php?DS=Update_Member&id_ctv=$id&type=active' class='btn btn-success'> Kích hoạt</a>";
                            $tt = '<font color="red">Đang chờ</font>';
                        } else if ($x['status'] == -1) {
                            $tt = '<font color="red">Khóa</font>';
                            $z = "<a href='index.php?DS=Update_Member&id_ctv=$id&type=unlock' class='btn btn-success'> Mở Khóa</a>";
                        }
                        $hi = '';
                        if($x['rule'] != 'admin' && $x['status'] == 1){
                            $hi = "<a href='index.php?DS=Update_Member&id_ctv=$id&type=up' class='btn btn-info'> Set Admin</a>";
                        }else if($x['rule'] == 'admin' && $x['status'] == 1){
                            $hi = "<a href='index.php?DS=Update_Member&id_ctv=$id&type=down' class='btn btn-success'> Remove AD</a>";
                        }
                        $set_agency = "<a href='index.php?DS=Update_Member&id_ctv=$id&type=up_agency' class='btn btn-info'> Set Agency</a>";
                        ?>
                        <tr style="font-weight: bold">
                            <td><?php echo $x['id_ctv']; ?></td>
                            <td><?php echo substr($x['name'],0, 30); ?></td>
                            <td><?php echo $x['user_name']; ?></td>
                            <td><a href="//fb.com/<?php echo $x['profile']; ?>" target="_blank"><?php echo $x['profile']; ?></a></td>
                             <td><?php echo $x['email']; ?></td>
                            <td><?php echo number_format($x['bill']); ?> VNĐ</td>
                            <td><?php echo number_format($x['payment']); ?> VNĐ </td>
                            <td><?php echo $x['num_id']; ?> ID VIP</td>     
                            <td><?php echo $tt; ?></td>
                            <td><?php echo $rl; ?></td>
                            <td style="text-align:center">
                                <?php if($rule == 'admin' && $idctv == 1) echo $hi. ' '. $set_agency; ?> <?php echo $z; ?> <a href="#" onclick="check(<?php echo $id . ',' . $idctv . ',' . $num . ','. "'$rulex'" ?>);" class="btn btn-warning">Xóa</a> <?php echo $active; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>