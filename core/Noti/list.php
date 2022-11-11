<script>
    function check(id) {
    	if(id == 0){
    		if (confirm('Bạn có chắc chắn muốn xóa tất cả thông báo ?') == true) {
                 window.location = 'index.php?DS=Delete_Noti';
            }
        }else{
	        if (confirm('Bạn có chắc chắn muốn xóa thông báo này ?') == true) {
	            window.location = 'index.php?DS=Delete_Noti&id_noti=' + id;
	        } else {
	            return false;
	        }
	    }
    }
</script>
<div class="box wow fadeIn">
    <div class="box-header">
        <h3 class="box-title">Danh sách thông báo <?php if($rule == 'admin' && $idctv==1){ ?> <a onclick="check(0)" class="btn btn-danger">Xóa tất cả </a><?php } ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nội dung</th>
                        <th>Thời gian</th>
                        <th>Người gửi</th>
                        <?php if($rule == 'admin') echo '<th>Người nhận</th>'; ?>
                        <th>Công cụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($rule != 'admin' || ($rule == 'admin' && $idctv !=1)){
                        $get = "SELECT id, content, time, status FROM noti WHERE id_ctv=$idctv";
                    }
                    // }else if($rule == 'admin' && $idctv !=1){
                    //     $get = "SELECT noti.id, noti.content, noti.time, noti.status, member.name,member.user_name FROM noti INNER JOIN member ON noti.id_ctv = member.id_ctv WHERE noti.id_ctv > 0";
                    // }
                    else {
                        $get = "SELECT noti.id, noti.content, noti.time, noti.status, member.name,member.user_name FROM noti LEFT JOIN member ON noti.id_ctv = member.id_ctv LEFT JOIN ctv ON ctv.id_ctvs=noti.id_ctv";
                    }
                    $result = mysqli_query($conn, $get);
                    while ($x = mysqli_fetch_assoc($result)) {
                        $id = $x['id'];
                        $t = $x['time'];
                        $time = date("d/m/Y - H:i:s", $t);
                        $status = $x['status'];
                        $z = '';
                        if(isset($x['name'], $x['user_name'])){
                            $name = $x['name'];
                            $u_name = $x['user_name'];
                        }
                        if ($status == 0 && $rule !='admin') {
                            $z = "<a href='index.php?DS=Seen_Noti&id_noti=$id' class='btn btn-info'>Seen</a>";
                        }
                        ?>
                        <tr>
                            <td><?php echo $x['id']; ?></td>
                            <td><?php echo $x['content']; ?></td>
                            <td><?php echo $time; ?></td>
                            <td><?php echo "<font color='red'>Hệ thống</font>"?></td>
                            <?php echo isset($u_name, $name) ?  "<td>$name ($u_name)</td>" : ''; ?>
                            <td style="text-align:center"><?php echo $z; ?> <a href="#" onclick="check(<?php echo $id; ?>);" class="btn btn-danger">Xóa</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>