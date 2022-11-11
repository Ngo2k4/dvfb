<?php
if ($rule != 'admin') {
    echo "<script>alert('CÚT!!');window.location='trang-chu.html';</script>";
}
?>
<script>
    function check(id,num,ctv) {
        if(num >0 || ctv >0){
            alert('Đại lí này đang có '+ctv+' CTV và '+num+' id trên hệ thống. Không thể xóa');
            return false;
        }
        if(confirm('Bạn cũng sẽ xóa toàn bộ thông báo, lịch sử của Đại lí này, Bạn có chắc chắc muốn tiếp tục ?')== true){
            window.location = 'index.php?DS=Delete_Agency&id='+id;
        }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách Đại Lí</h3>
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
                        <th>Số CTV</th>
                        <th>Công cụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($rule == 'admin' && $idctv != 1){
                        $get = "SELECT member.id_ctv, member.name, member.user_name, member.phone, member.email, member.profile, member.bill, member.status, member.num_id,member.payment, COUNT(ctv.user_name) FROM member LEFT JOIN ctv ON member.id_ctv = ctv.id_agency WHERE member.rule = 'agency' AND id_ctv > 0 GROUP BY member.id_ctv, member.name, member.user_name, member.phone, member.email, member.profile, member.bill, member.status, member.num_id,member.payment";
                    }else{
                        $get = "SELECT member.id_ctv, member.name, member.user_name, member.phone, member.email, member.profile, member.bill, member.status, member.num_id,member.payment, COUNT(ctv.user_name) FROM member LEFT JOIN ctv ON member.id_ctv = ctv.id_agency WHERE member.rule = 'agency' GROUP BY member.id_ctv, member.name, member.user_name, member.phone, member.email, member.profile, member.bill, member.status, member.num_id,member.payment";

                    }
                    $result = mysqli_query($conn, $get);
                    while($x = mysqli_fetch_assoc($result)){
                        $id = $x['id_ctv'];
                        $num = $x['num_id'];
                        $ctv = 0;
                        $u = '';
                        if($x['COUNT(ctv.user_name)'] > 0){
                            $ctv = $x['COUNT(ctv.user_name)'];
                        }
                        $z = "<a href='index.php?DS=Edit_Agency&id=$id' class='btn btn-info'>Cập nhật</a><a href='index.php?DS=Update_Agency&id=$id&type=lock' class='btn btn-danger'>Khóa</a>";
                        $tt = '<font color="green">Đã kích hoạt</font>';
                        if ($x['status'] == 0) {
                            $tt = '<font color="red">Đang chờ</font>';
                            $u = "<a href='index.php?DS=Update_Agency&id=$id&type=active' class='btn btn-success'> Kích hoạt</a>";
                            
                        } else if ($x['status'] == -1) {
                            $tt = '<font color="red">Khóa</font>';
                            $z = "<a href='index.php?DS=Update_Agency&id=$id&type=unlock' class='btn btn-success'> Mở khóa</a>";
                        }
                        ?>
                        <tr style="font-weight: bold">
                            <td><?php echo $x['id_ctv']; ?></td>
                            <td><?php echo substr($x['name'],0, 30); ?></td>
                            <td><?php echo $x['user_name']; ?></td>
                            <td><a href="//fb.com/<?php echo $x['profile']; ?>" target="_blank"><?php echo $x['profile']; ?></a></td>
                            <td><?php echo $x['email']; ?></td>
                            <td><?php echo number_format($x['bill']); ?> VNĐ</td>
                            <td><?php echo $x['num_id']; ?> ID VIP</td>
                            <td><?php echo number_format($x['payment']). ' VNĐ'; ?></td>
                            <td><?php echo $tt; ?></td>
                            <td><?php echo $ctv; ?> CTV</td>
                            <td style="text-align:center"> <?php echo $u. $z; ?> <?php if($idctv == 1){ ?><a href="#" onclick="check(<?php echo $id.','.$num.','.$ctv; ?>);" class="btn btn-warning">XÓA</a><?php } ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>