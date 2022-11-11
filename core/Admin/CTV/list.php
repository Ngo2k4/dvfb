<?php
if ($rule != 'admin' && $rule !='agency') {
    echo "<script>alert('CÚT!!');window.location='trang-chu.html';</script>";
}
?>
<script>
    function check(id,num) {
        if(num > 0){
            alert('CTV này đang có '+num+' id vip trên hệ thống. Không thể xóa!');
            return false;
        }else{
            if(confirm('Bạn có chắc chắc muốn xóa CTV này ?')== true){
                window.location = 'index.php?DS=Delete_CTV&id_ctv='+id;
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
            if (confirm('Bạn cũng sẽ xóa toàn bộ thông báo, lịch sử, Bạn có muốn tiếp tục?') == true) {
                window.location = 'index.php?DS=Update_CTV&id_ctv=' + id + '&type=lock';
            }
        }
    }
}
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách Cộng Tác Viên</h3>
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
                        <th>IDs VIP</th>
                        <th>Doanh thu</th>
                        <th>Trạng thái</th>
                        <?php if($rule == 'admin'){ ?><th>Đại lí</th><?php } ?>
                        <th>Công cụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($rule == 'admin' && $idctv !=1){
                        $get = "SELECT id_ctvs, name, user_name, phone, email, profile, bill, status,num_id,id_agency,payment FROM ctv WHERE ctv.id_ctvs > 0";
                    }else if($rule == 'admin' && $idctv ==1){
                        $get = "SELECT id_ctvs, name, user_name, phone, email, profile, bill, status,num_id,id_agency,payment FROM ctv";
                    }else if($rule == 'agency'){
                        $get = "SELECT id_ctvs, name, user_name, phone, email, profile, bill, status,num_id,payment FROM ctv WHERE id_agency=$idctv";
                    }
                    $result = mysqli_query($conn, $get);
                    while($x = mysqli_fetch_assoc($result)){
                        $id = $x['id_ctvs'];
                        $num = $x['num_id'];
                        $rl = '';
                        $agency = 'BestAuto System';
                        $payment = $x['payment'];
                        $ida = isset($x['id_agency']) ? $x['id_agency'] : '';
                        $u = '';
                        if($ida != 0){
                            $sql = "SELECT user_name, name, rule FROM member WHERE id_ctv=$ida";
                            $r1 = mysqli_query($conn, $sql);
                            $agen = mysqli_fetch_assoc($r1);
                            if($agen['rule'] == 'agency'){
                                $agency = $agen['name']. '( '. $agen['user_name']. ' )';
                            }
                        }
                        $z = "<a href='index.php?DS=Update_CTV&id_ctv=$id&type=lock' class='btn btn-danger'>Khóa</a>";
                        $tt = '<font color="green">Đã kích hoạt</font>';
                        if ($x['status'] == 0) {
                            $tt = '<font color="red">Đang chờ</font>';
                            $u = "<a href='index.php?DS=Update_CTV&id_ctv=$id&type=active' class='btn btn-info'> Kích hoạt</a>";
                            
                        } else if ($x['status'] == -1) {
                            $tt = '<font color="red">Khóa</font>';
                            $z = "<a href='index.php?DS=Update_CTV&id_ctv=$id&type=unlock' class='btn btn-info'> Mở khóa</a>";
                        }
                        $edit = "<a href='index.php?DS=Edit_CTV&id=$id' class='btn btn-success'>Cập nhật</a>";
                        ?>
                        <tr style="font-weight: bold">
                            <td><?php echo $x['id_ctvs']; ?></td>
                            <td><?php echo substr($x['name'],0, 30); ?></td>
                            <td><?php echo $x['user_name']; ?></td>
                            <td><a href="//fb.com/<?php echo $x['profile']; ?>" target="_blank"><?php echo $x['profile']; ?></a></td>
                            <td><?php echo $x['email']; ?></td>
                            <td><?php echo number_format($x['bill']); ?> VNĐ</td>
                            <td><?php echo $x['num_id']; ?> ID VIP</td>
                            <td><?php echo number_format($payment). 'VNĐ'; ?>
                            <td><?php echo $tt; ?></td>
                            <?php if($rule == 'admin'){ ?><td><?php echo $agency; ?></td><?php }?>
                            <td style="text-align:center"><?php echo $edit. $u. $z; ?> <a href="#" onclick="check(<?php echo $id.','.$num; ?>);" class="btn btn-warning">XÓA</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>